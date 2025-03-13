<?php


namespace App\Service;

class DateConfigurationService
{
    public function getDateConfigurations(): array
    {
        return [
            'Petite Section' => [
                'dateNaissance' => ['min' => '-4 years', 'max' => '-3 years'],
                'dateExtrait' => ['min' => '-1 year', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-1 year', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-1 year', 'max' => '-1 day'],
            ],
            'Moyenne Section' => [
                'dateNaissance' => ['min' => '-5 years', 'max' => '-4 years'],
                'dateExtrait' => ['min' => '-2 years', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-2 years', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-2 years', 'max' => '-1 day'],
            ],
            'Grande Section' => [
                'dateNaissance' => ['min' => '-6 years', 'max' => '-5 years'],
                'dateExtrait' => ['min' => '-3 years', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-3 years', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-3 years', 'max' => '-1 day'],
            ],
            '1ère Année' => [
                'dateNaissance' => ['min' => '-9 years', 'max' => '-5 years'],
                'dateExtrait' => ['min' => '-9 years', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-4 years', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-4 years', 'max' => '-1 day'],
            ],
            '2ème Année' => [
                'dateNaissance' => ['min' => '-10 years', 'max' => '-6 years'],
                'dateExtrait' => ['min' => '-10 years', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-5 years', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-5 years', 'max' => '-1 year'],
            ],
            '3ème Année' => [
                'dateNaissance' => ['min' => '-11 years', 'max' => '-7 years'],
                'dateExtrait' => ['min' => '-11 years', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-6 years', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-6 years', 'max' => '-2 years'],
            ],
            '4ème Année' => [
                'dateNaissance' => ['min' => '-12 years', 'max' => '-8 years'],
                'dateExtrait' => ['min' => '-12 years', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-7 years', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-7 years', 'max' => '-3 years'],
            ],
            '5ème Année' => [
                'dateNaissance' => ['min' => '-13 years', 'max' => '-9 years'],
                'dateExtrait' => ['min' => '-13 years', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-8 years', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-8 years', 'max' => '-4 years'],
            ],
            '6ème Année' => [
                'dateNaissance' => ['min' => '-14 years', 'max' => '-10 years'],
                'dateExtrait' => ['min' => '-14 years', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-9 years', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-9 years', 'max' => '-5 years'],
            ],
            '7ème Année' => [
                'dateNaissance' => ['min' => '-15 years', 'max' => '-11 years'],
                'dateExtrait' => ['min' => '-15 years', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-10 years', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-10 years', 'max' => '-6 years'],
            ],
            '8ème Année' => [
                'dateNaissance' => ['min' => '-16 years', 'max' => '-12 years'],
                'dateExtrait' => ['min' => '-16 years', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-11 years', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-11 years', 'max' => '-7 years'],
            ],
            '9ème Année' => [
                'dateNaissance' => ['min' => '-17 years', 'max' => '-13 years'],
                'dateExtrait' => ['min' => '-17 years', 'max' => '-1 day'],
                'dateInscription' => ['min' => '-12 years', 'max' => 'now'],
                'dateRecrutement' => ['min' => '-12 years', 'max' => '-8 years'],
            ],
            // Ajoutez les autres niveaux ici...
        ];
    }
}
