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
use App\Entity\Etablissements;
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
            //throw new \Exception('Il doit y avoir exactement 10 statuts dans la base de données.');
        }

        if (count($classes) !== 36) {
            //throw new \Exception('Il doit y avoir exactement 10 statuts dans la base de données.');
        }


        for ($i = 1; $i <= 1500; $i++) {
            $ecole = $this->getReference('ecole_' . $faker->numberBetween(1, 100), EcoleProvenances::class);
            $etablissement = $this->getReference('etablissement_' . $faker->numberBetween(0, 2), Etablissements::class);
            if ($i <= 60) {

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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);

                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);
                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 60 && $i <= 120) {

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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 120 && $i <= 180) {

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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);

                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 180 && $i <= 240) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);

                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 240 && $i <= 300) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);

                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 300 && $i <= 360) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 360 && $i <= 420) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 420 && $i <= 480) {
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
            } elseif ($i > 480 && $i <= 540) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 540 && $i <= 600) {
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
            } elseif ($i > 600 && $i <= 660) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 660 && $i <= 720) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 720 && $i <= 780) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 780 && $i <= 840) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 840 && $i <= 900) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 900 && $i <= 960) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 960 && $i <= 1020) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 1020 && $i <= 1080) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 1080 && $i <= 1140) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 1140 && $i <= 1200) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 1200 && $i <= 1260) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 1260 && $i <= 1320) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 1320 && $i <= 1380) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);

                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 1380 && $i <= 1440) {
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
                $eleve->setEtablissement($etablissement);
                $randomStatut = $statuts[array_rand($statuts)];
                $eleve->setStatut($randomStatut);
                $eleve->addEcoleAnDernier($ecoleProvenance);
                $eleve->setIsAdmis($faker->randomElement([true, false]));
                $eleve->setIsActif($faker->randomElement([true, false]));
                $eleve->setEcoleRecrutement($ecole);
                $eleve->setParent($parent);


                $manager->persist($eleve);
                $this->addReference('eleve_' . $i, $eleve);
            } elseif ($i > 1440 && $i <= 1500) {

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
                //$eleve->setEtablissement($etablissement);
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
