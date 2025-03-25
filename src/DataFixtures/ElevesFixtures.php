<?php

namespace App\DataFixtures;

use Faker;
use Faker\Factory;
use App\Entity\Noms;
use App\Entity\Eleves;
use App\Entity\Classes;
use App\Entity\Parents;
use App\Entity\Prenoms;
use App\Entity\Statuts;
use App\Entity\Departements;
use App\Entity\LieuNaissances;
use App\Entity\EcoleProvenances;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\EcoleProvenancesFixtures;
use App\Repository\ClassesRepository;
use App\Repository\StatutsRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ElevesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private StatutsRepository $statutsRepository, private ClassesRepository $classesRepository) {}
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $statuts = $this->statutsRepository->findAll();
        $classes = $this->classesRepository->findAll();

        if (count($statuts) !== 10) {
            //dump($statuts);
            //throw new \Exception('Il doit y avoir exactement 10 statuts dans la base de données.');
        }

        if (count($classes) !== 36) {
            //dump($statuts);
            //throw new \Exception('Il doit y avoir exactement 10 statuts dans la base de données.');
        }


        for ($i = 1; $i <= 750; $i++) {
            $ecole = $this->getReference('ecole_' . $faker->numberBetween(1, 100), EcoleProvenances::class);
            if ($i <= 20) {

                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));


                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);

                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);
                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 20 && $i <= 40) {

                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));

                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 40 && $i <= 60) {

                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);

                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);

                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 60 && $i <= 80) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));

                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait($dateExtrait);
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);

                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 80 && $i <= 100) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));

                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);

                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);

                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 100 && $i <= 120) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));

                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 120 && $i <= 140) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 140 && $i <= 160) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                //$eleve->setNina($nina);
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 160 && $i <= 180) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 180 && $i <= 200) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                //$eleve->setNina($nina);
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 200 && $i <= 220) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 220 && $i <= 240) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);

                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 240 && $i <= 260) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);

                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 260 && $i <= 280) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 280 && $i <= 300) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 300 && $i <= 320) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 320 && $i <= 340) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 340 && $i <= 360) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 360 && $i <= 380) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 380 && $i <= 400) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 400 && $i <= 420) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 420 && $i <= 440) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 440 && $i <= 460) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 460 && $i <= 480) {
                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);
                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);


                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 480 && $i <= 500) {

                $lieu = $this->getReference('lieu_' . $faker->numberBetween(1, 100), LieuNaissances::class);
                $nom  = $this->getReference('nom_' . $faker->numberBetween(1, 50), Noms::class);
                $prenom  = $this->getReference('prenom_' . $faker->numberBetween(1, 100), Prenoms::class);
                //$user  = $this->getReference('user_' . $faker->numberBetween(1, 8));
                $parent = $this->getReference('parent_' . $faker->numberBetween(1, 80), Parents::class);


                $ecoleProvenance = $this->getReference('ecole_' . $faker->numberBetween(1, 20), EcoleProvenances::class);
                $eleve = new Eleves();
                $dateNaissance = \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-17 years', '-7 years'));
                $dateExtrait= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-16 years', '-6 years'));
                $dateInscription= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 months'));
                $dateRecrutement= \DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-12 years', '-5 years'));
                $eleve->setDateNaissance($dateNaissance);
                $eleve->setLieuNaissance($lieu);
                $eleve->setNom($nom);
                $eleve->setPrenom($prenom);
                $eleve->setSexe($faker->randomElement(['M', 'F']));
                $eleve->setNumeroExtrait($faker->randomNumber(9, true));
                $eleve->setDateExtrait(($dateExtrait));
                $randomClasse = $classes[array_rand($classes)];
                $eleve->setClasse($randomClasse);
                $eleve->setDateInscription($dateInscription);
                $eleve->setDateRecrutement($dateRecrutement);
                //$eleve->setUser($user);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);
                
                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            Redoublements9emeFixtures::class,
        ];
    }
}
