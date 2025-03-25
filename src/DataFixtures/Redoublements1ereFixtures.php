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

class Redoublements1ereFixtures extends Fixture implements DependentFixtureInterface
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
                    //niveau 1ère année 1er Redoublement
                    if ($niveauDesignation === '1ère Année' && $scolaritee1 == 2 && $scolaritee2 == 0) {
                        $redoublement1 = new Redoublements1();
                        $redoublement1->setNiveau($niveau1ere);
                        $redoublement1->setScolarite1($scolarite1);
                        $redoublement1->setScolarite2($scolarite2);

                        $manager->persist($redoublement1);

                        // niveau 1ère Annéé 2ème redoublement;
                    } elseif ($niveauDesignation === '1ère Année' && $scolaritee1 == 3 && $scolaritee2 == 0) {
                        //1er redoublement en 1ère année
                        $redoublement1 = new Redoublements1();
                        $redoublement1->setNiveau($niveau1ere);
                        $redoublement1->setScolarite1($scolarite1);
                        $redoublement1->setScolarite2($scolarite2);
                        for ($i = 0; $i < 1; $i++) {
                            //2ème redoublement en 1ère année
                            $redoublement2 = new Redoublements2();
                            $redoublement2->setNiveau($niveau1ere);
                            $redoublement2->setRedoublement1($redoublement1);
                            $redoublement2->setScolarite1($scolarite1);
                            $redoublement2->setScolarite2($scolarite2);
                            $manager->persist($redoublement2);
                        }
                        $manager->persist($redoublement1);
                    }
                }
            }
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EtablissementsFixtures::class
        ];
    }
}
