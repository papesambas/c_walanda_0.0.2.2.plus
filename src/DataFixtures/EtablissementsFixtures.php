<?php

namespace App\DataFixtures;

use App\Entity\Enseignements;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Entity\Etablissements;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EtablissementsFixtures extends Fixture implements DependentFixtureInterface
{
    private $counter = 1;
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 2; $i++) {
            if ($i == 0) {
                $etablissement = new Etablissements();
                $faker = Faker\Factory::create('fr_FR');
                $etablissement = new Etablissements();
                $etablissement->setDesignation('Mamadou TRAORE');
                $enseignement = $this->getReference('enseignement_' . $faker->numberBetween(1, 1), Enseignements::class);
                $etablissement->setEnseignement($enseignement);
                $etablissement->setFormeJuridique('Entreprise Personneles');
                $etablissement->setAdresse('Baco Djicoroni');
                $etablissement->setNumCpteBancaire($faker->creditCardNumber('Visa', true, '_'));
                $etablissement->setDateCreation(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-31 years', '-1 years')));
                $etablissement->setDateOuverture(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-31 years', '-5 years')));
                $etablissement->setEmail($faker->email());
                $etablissement->setNumDecisionCreation($faker->bothify('??-####-??-###'));
                $etablissement->setNumDecisionOuverture($faker->bothify('??-####-??-###'));
                $etablissement->setNumFiscal($faker->bothify('??-###-??##-?-###'));
                $etablissement->setNumSocial($faker->bothify('###-??###-??-####'));
                $etablissement->setTelephone($faker->phoneNumber());
                $etablissement->setTelephoneMobile($faker->phoneNumber());
                $this->setReference('etablissement_' . $i, $etablissement);
                $manager->persist($etablissement);
            } elseif ($i == 1) {
                $etablissement = new Etablissements();
                $faker = Faker\Factory::create('fr_FR');
                $etablissement = new Etablissements();
                $etablissement->setDesignation('Al Madina');
                $enseignement = $this->getReference('enseignement_' . $faker->numberBetween(2, 2), Enseignements::class);
                $etablissement->setEnseignement($enseignement);
                $etablissement->setFormeJuridique('Entreprise Communautaire');
                $etablissement->setAdresse('Baco Djicoroni');
                $etablissement->setNumCpteBancaire($faker->creditCardNumber('Visa', true, '_'));
                $etablissement->setDateCreation(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-31 years', '-1 years')));
                $etablissement->setDateOuverture(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-31 years', '-5 years')));
                $etablissement->setEmail($faker->email());
                $etablissement->setNumDecisionCreation($faker->bothify('??-####-??-###'));
                $etablissement->setNumDecisionOuverture($faker->bothify('??-####-??-###'));
                $etablissement->setNumFiscal($faker->bothify('??-###-??##-?-###'));
                $etablissement->setNumSocial($faker->bothify('###-??###-??-####'));
                $etablissement->setTelephone($faker->phoneNumber());
                $etablissement->setTelephoneMobile($faker->phoneNumber());
                $this->setReference('etablissement_' . $i, $etablissement);
                $manager->persist($etablissement);
            } elseif ($i == 2) {
                $etablissement = new Etablissements();
                $faker = Faker\Factory::create('fr_FR');
                $etablissement = new Etablissements();
                $etablissement->setDesignation('André DAVESNES');
                $enseignement = $this->getReference('enseignement_' . $faker->numberBetween(1, 1), Enseignements::class);
                $etablissement->setEnseignement($enseignement);
                $etablissement->setFormeJuridique('Entreprise Communautaire');
                $etablissement->setAdresse('Baco Djicoroni');
                $etablissement->setNumCpteBancaire($faker->creditCardNumber('Visa', true, '_'));
                $etablissement->setDateCreation(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-31 years', '-1 years')));
                $etablissement->setDateOuverture(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-31 years', '-5 years')));
                $etablissement->setEmail($faker->email());
                $etablissement->setNumDecisionCreation($faker->bothify('??-####-??-###'));
                $etablissement->setNumDecisionOuverture($faker->bothify('??-####-??-###'));
                $etablissement->setNumFiscal($faker->bothify('??-###-??##-?-###'));
                $etablissement->setNumSocial($faker->bothify('###-??###-??-####'));
                $etablissement->setTelephone($faker->phoneNumber());
                $etablissement->setTelephoneMobile($faker->phoneNumber());
                $this->setReference('etablissement_' . $i, $etablissement);
                $manager->persist($etablissement);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EnseignementsFixtures::class,
        ];
    }
}
