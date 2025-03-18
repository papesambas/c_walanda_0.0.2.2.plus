<?php

namespace App\DataFixtures;

use App\Entity\Redoublements1;
use App\Entity\Redoublements2;
use App\Entity\Redoublements3;
use App\Repository\NiveauxRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\Scolarites1Repository;
use App\Repository\Scolarites2Repository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class Redoublements7emeFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private NiveauxRepository $niveauxRepository,
        private Scolarites1Repository $scolarites1Repository,
        private Scolarites2Repository $scolarites2Repository
    ) {}

    public function load(ObjectManager $manager): void
    {
        $niveaux = $this->niveauxRepository->findAll();
        foreach ($niveaux as $niveau) {
            $niveauDesignation = $niveau->getDesignation();
            $niveau1ere = $this->niveauxRepository->findOneBy(['designation' => '1ère Année']);
            $niveau2eme = $this->niveauxRepository->findOneBy(['designation' => '2ème Année']);
            $niveau3eme = $this->niveauxRepository->findOneBy(['designation' => '3ème Année']);
            $niveau4eme = $this->niveauxRepository->findOneBy(['designation' => '4ème Année']);
            $niveau5eme = $this->niveauxRepository->findOneBy(['designation' => '5ème Année']);
            $niveau6eme = $this->niveauxRepository->findOneBy(['designation' => '6ème Année']);
            $niveau7eme = $this->niveauxRepository->findOneBy(['designation' => '7ème Année']);
            $niveau8eme = $this->niveauxRepository->findOneBy(['designation' => '8ème Année']);
            $niveau9eme = $this->niveauxRepository->findOneBy(['designation' => '9ème Année']);
            $scolarites1 = $this->scolarites1Repository->findBy(['niveau' => $niveau]);
            foreach ($scolarites1 as $scolarite1) {
                $scolarites2 = $this->scolarites2Repository->findBy(['scolarite1' => $scolarite1]);
                $scolaritee1 = $scolarite1->getScolarite();
                foreach ($scolarites2 as $scolarite2) {
                    $scolaritee2 = $scolarite2->getScolarite();

                    // Niveau 7ème Année
                    if ($niveauDesignation === '7ème Année') {
                        if ($scolaritee1 == 6 && $scolaritee2 == 2) {
                            // 1er redoublement 7ème année
                            $redoublement1 = new Redoublements1();
                            $redoublement1->setNiveau($niveau7eme);
                            $redoublement1->setScolarite1($scolarite1);
                            $redoublement1->setScolarite2($scolarite2);
                            $manager->persist($redoublement1);
                        } elseif ($scolaritee1 == 6 && $scolaritee2 == 3) {
                            // 1er redoublement 7ème année
                            $redoublement1 = new Redoublements1();
                            $redoublement1->setNiveau($niveau7eme);
                            $redoublement1->setScolarite1($scolarite1);
                            $redoublement1->setScolarite2($scolarite2);
                            $manager->persist($redoublement1);
                            for ($a = 0; $a < 1; $a++) {
                                // 2ème redoublement 7ème année
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($niveau7eme);
                                $redoublement2->setRedoublement1($redoublement1);
                                $redoublement2->setScolarite1($scolarite1);
                                $redoublement2->setScolarite2($scolarite2);
                                $manager->persist($redoublement2);
                            }

                        } elseif ($scolaritee1 == 7 && $scolaritee2 == 2) {
                            $this->createRedoublementsForLevels($manager, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme, $niveau7eme, $scolarite1, $scolarite2, false);
                        } elseif ($scolaritee1 == 7 && $scolaritee2 == 3) {
                            $this->createRedoublementsForLevels($manager, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme, $niveau7eme, $scolarite1, $scolarite2, true);
                        } elseif ($scolaritee1 == 8 && $scolaritee2 == 2) {
                            $this->createRedoublementsForLevelsWithRedoublement3($manager, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme, $niveau7eme, $scolarite1, $scolarite2);
                        }
                    }
                }
            }
        }

        $manager->flush();
    }

    private function createRedoublementsForLevels(
        ObjectManager $manager,
        $niveau1ere,
        $niveau2eme,
        $niveau3eme,
        $niveau4eme,
        $niveau5eme,
        $niveau6eme,
        $niveau7eme,
        $scolarite1,
        $scolarite2,
        bool $withRedoublement3
    ): void {
        for ($i = 0; $i < 6; $i++) {
            $redoublement1 = new Redoublements1();
            $redoublement1->setNiveau($this->getNiveauByIndex($i, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme));
            $redoublement1->setScolarite1($scolarite1);
            $redoublement1->setScolarite2($scolarite2);
            $manager->persist($redoublement1);

            if ($withRedoublement3) {
                $redoublement2 = new Redoublements2();
                $redoublement2->setNiveau($niveau7eme);
                $redoublement2->setRedoublement1($redoublement1);
                $redoublement2->setScolarite1($scolarite1);
                $redoublement2->setScolarite2($scolarite2);
                $manager->persist($redoublement2);

                $redoublement3 = new Redoublements3();
                $redoublement3->setNiveau($niveau7eme);
                $redoublement3->setRedoublement2($redoublement2);
                $redoublement3->setScolarite1($scolarite1);
                $redoublement3->setScolarite2($scolarite2);
                $manager->persist($redoublement3);
            } else {
                $redoublement2 = new Redoublements2();
                $redoublement2->setNiveau($niveau7eme);
                $redoublement2->setRedoublement1($redoublement1);
                $redoublement2->setScolarite1($scolarite1);
                $redoublement2->setScolarite2($scolarite2);
                $manager->persist($redoublement2);
            }
        }
    }

    private function createRedoublementsForLevelsWithRedoublement3(
        ObjectManager $manager,
        $niveau1ere,
        $niveau2eme,
        $niveau3eme,
        $niveau4eme,
        $niveau5eme,
        $niveau6eme,
        $niveau7eme,
        $scolarite1,
        $scolarite2
    ): void {
        for ($i = 0; $i < 6; $i++) {
            $redoublement1 = new Redoublements1();
            $redoublement1->setNiveau($this->getNiveauByIndex($i, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme));
            $redoublement1->setScolarite1($scolarite1);
            $redoublement1->setScolarite2($scolarite2);
            $manager->persist($redoublement1);

            for ($a = 0; $a < 5 - $i; $a++) {
                $redoublement2 = new Redoublements2();
                $redoublement2->setNiveau($this->getNiveauByIndex($a + $i + 1, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme));
                $redoublement2->setRedoublement1($redoublement1);
                $redoublement2->setScolarite1($scolarite1);
                $redoublement2->setScolarite2($scolarite2);
                $manager->persist($redoublement2);

                $redoublement3 = new Redoublements3();
                $redoublement3->setNiveau($niveau7eme);
                $redoublement3->setRedoublement2($redoublement2);
                $redoublement3->setScolarite1($scolarite1);
                $redoublement3->setScolarite2($scolarite2);
                $manager->persist($redoublement3);
            }
        }
    }

    private function getNiveauByIndex(int $index, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme)
    {
        switch ($index) {
            case 0:
                return $niveau1ere;
            case 1:
                return $niveau2eme;
            case 2:
                return $niveau3eme;
            case 3:
                return $niveau4eme;
            case 4:
                return $niveau5eme;
            case 5:
                return $niveau6eme;
            default:
                throw new \InvalidArgumentException("Index de niveau invalide.");
        }
    }

    public function getDependencies(): array
    {
        return [
            Redoublements6emeFixtures::class
        ];
    }
}
