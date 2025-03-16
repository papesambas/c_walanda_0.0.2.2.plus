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

class Redoublements6emeFixtures extends Fixture implements DependentFixtureInterface
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

                    // Niveau 1ère année 1er Redoublement
                    if ($niveauDesignation === '6ème Année' && $scolaritee1 == 7 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 6; $i++) {
                            $redoublement1 = new Redoublements1();
                            $redoublement1->setNiveau($this->getNiveauByIndex($i, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme));
                            $redoublement1->addScolarites1($scolarite1);
                            $redoublement1->addScolarites2($scolarite2);
                            $manager->persist($redoublement1);

                            // Ajout du 1er redoublement 6ème année
                            if ($i == 5) { // 6ème année
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($niveau6eme);
                                $redoublement2->setRedoublement1($redoublement1);
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $manager->persist($redoublement2);
                            }
                        }
                    } elseif ($niveauDesignation === '6ème Année' && $scolaritee1 == 8 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 6; $i++) {
                            $redoublement1 = new Redoublements1();
                            $redoublement1->setNiveau($this->getNiveauByIndex($i, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme));
                            $redoublement1->addScolarites1($scolarite1);
                            $redoublement1->addScolarites2($scolarite2);
                            $manager->persist($redoublement1);

                            for ($a = 0; $a < 5 - $i; $a++) {
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($this->getNiveauByIndex($a + $i + 1, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme));
                                $redoublement2->setRedoublement1($redoublement1); // Lien avec Redoublements1
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $manager->persist($redoublement2);

                                // Ajout du 2ème redoublement 6ème année
                                if ($a + $i + 1 == 5) { // 6ème année
                                    $redoublement3 = new Redoublements3();
                                    $redoublement3->setNiveau($niveau6eme);
                                    $redoublement3->setRedoublement2($redoublement2);
                                    $redoublement3->addScolarites1($scolarite1);
                                    $redoublement3->addScolarites2($scolarite2);
                                    $manager->persist($redoublement3);
                                }
                            }
                        }
                    } elseif ($niveauDesignation === '6ème Année' && $scolaritee1 == 9 && $scolaritee2 == 0) {
                        for ($i = 0; $i < 6; $i++) {
                            $redoublement1 = new Redoublements1();
                            $redoublement1->setNiveau($this->getNiveauByIndex($i, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme));
                            $redoublement1->addScolarites1($scolarite1);
                            $redoublement1->addScolarites2($scolarite2);
                            $manager->persist($redoublement1);

                            for ($a = 0; $a < 5 - $i; $a++) {
                                $redoublement2 = new Redoublements2();
                                $redoublement2->setNiveau($this->getNiveauByIndex($a + $i + 1, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme));
                                $redoublement2->setRedoublement1($redoublement1); // Lien avec Redoublements1
                                $redoublement2->addScolarites1($scolarite1);
                                $redoublement2->addScolarites2($scolarite2);
                                $manager->persist($redoublement2);

                                // Ajout du 2ème redoublement 6ème année
                                if ($a + $i + 1 == 5) { // 6ème année
                                    $redoublement3 = new Redoublements3();
                                    $redoublement3->setNiveau($niveau6eme);
                                    $redoublement3->setRedoublement2($redoublement2);
                                    $redoublement3->addScolarites1($scolarite1);
                                    $redoublement3->addScolarites2($scolarite2);
                                    $manager->persist($redoublement3);
                                }
                            }
                        }
                    }
                }
            }
        }

        $manager->flush();
    }

    private function getNiveauByIndex(int $index, $niveau1ere, $niveau2eme, $niveau3eme, $niveau4eme, $niveau5eme, $niveau6eme)
    {
        switch ($index) {
            case 0: return $niveau1ere;
            case 1: return $niveau2eme;
            case 2: return $niveau3eme;
            case 3: return $niveau4eme;
            case 4: return $niveau5eme;
            case 5: return $niveau6eme;
            default: throw new \InvalidArgumentException("Index de niveau invalide.");
        }
    }

    public function getDependencies(): array
    {
        return [
            Redoublements5emeFixtures::class
        ];
    }
}