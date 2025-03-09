<?php

namespace App\Form;

use App\Entity\Noms;
use App\Entity\Meres;
use App\Entity\Ninas;
use App\Entity\Prenoms;
use App\Entity\Telephones;
use App\Entity\Professions;
use App\Entity\Telephones1;
use App\Entity\Telephones2;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', EntityType::class, [
                'label' => 'Nom de famille',
                'class' => Noms::class,
                'placeholder' => 'Sélectionnez le nom de la mère',
                'choice_label' => 'designation',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('n')
                    ->where('n.designation IS NOT NULL')
                    ->andWhere('n.designation != :empty')
                    ->setParameter('empty', '')
                    ->orderBy('n.designation', 'ASC'),
                'attr' => [
                    'class' => 'select-nomfamille',
                    'data-autocomplete' => 'true',
                    'autocomplete' => 'family-name'
                ],
                'constraints' => [new NotBlank(['message' => 'Le nom de famille est obligatoire'])],
                'error_bubbling' => false,
                'required' => true,
                'help' => 'Nom officiel tel que sur l\'extrait de naissance'
            ])
            ->add('prenom', EntityType::class, [
                'class' => Prenoms::class,
                'label' => 'Prénom',
                'placeholder' => 'Sélectionnez le prénom de la mère',
                'choice_label' => 'designation',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('p')
                    ->where('p.designation IS NOT NULL')
                    ->andWhere('p.designation != :empty')
                    ->setParameter('empty', '')
                    ->orderBy('p.designation', 'ASC'),
                'attr' => [
                    'class' => 'select-prenom',
                    'data-autocomplete' => 'true',
                    'autocomplete' => 'prenom'
                ],
                'constraints' => [new NotBlank(['message' => 'Le prénom de famille est obligatoire'])],
                'error_bubbling' => false,
                'required' => true,
                'help' => 'Prénom officiel tel que sur l\'extrait de naissance'
            ])
            ->add('profession', EntityType::class, [
                'class' => Professions::class,
                'label' => 'Profession',
                'placeholder' => 'Sélectionnez la profession de la mère',
                'choice_label' => 'designation',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('p')
                    ->where('p.designation IS NOT NULL')
                    ->andWhere('p.designation != :empty')
                    ->setParameter('empty', '')
                    ->orderBy('p.designation', 'ASC'),
                'attr' => [
                    'class' => 'select-profession',
                    'data-autocomplete' => 'true',
                    'autocomplete' => 'profession'
                ],
                'constraints' => [new NotBlank(['message' => 'La profession est obligatoire'])],
                'error_bubbling' => false,
                'required' => true,
                'help' => 'Profession officielle telle que sur l\'extrait de naissance'
            ])
            ->add('ninas', EntityType::class, [
                'class' => Ninas::class,
                'label' => '# Nina',
                'placeholder' => 'Sélectionnez le # nina de la mère',
                'choice_label' => 'designation',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('n')
                    ->where('n.designation IS NOT NULL')
                    ->andWhere('n.designation != :empty')
                    ->setParameter('empty', '')
                    ->orderBy('n.designation', 'ASC'),
                'attr' => [
                    'class' => 'select-nina',
                    'data-autocomplete' => 'true',
                    'autocomplete' => 'nina'
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => "/^(?=(?:\D*\d){9,13})(?=(?:\d*[A-Za-z]){1,3})[A-Za-z0-9 ]{15}$/",
                        'message' => 'numéro non conforme.',
                    ]),
                ],

                'error_bubbling' => false,
                'required' => false,
                'help' => 'le numéro Nina si disponible'
            ])
            ->add('telephone1', EntityType::class, [
                'class' => Telephones1::class,
                'label' => 'Téléphone',
                'placeholder' => 'Sélectionnez le # de téléphone de la mère',
                'choice_label' => 'numero',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('t')
                    ->where('t.numero IS NOT NULL')
                    ->andWhere('t.numero != :empty')
                    ->setParameter('empty', '')
                    ->orderBy('t.numero', 'ASC'),
                'attr' => [
                    'class' => 'select-telephone',
                    'data-autocomplete' => 'true',
                    'autocomplete' => 'telephone'
                ],
                /*'constraints' => [
                    new NotBlank(['message' => 'Le numéro de téléphone est obligatoire']),
                    new Regex([
                        'pattern' => '/^\+\d{3} \d{2} \d{2} \d{2} \d{2}$/',
                        'message' => 'Le numéro de téléphone doit être au format +xxx xx xx xx xx.',
                    ]),
                ],*/
                'error_bubbling' => false,
                'required' => true,
                'help' => 'Le numéro officiel de la mère'
            ])
            ->add('telephone2', EntityType::class, [
                'class' => Telephones2::class,
                'label' => 'Téléphone',
                'placeholder' => 'Sélectionnez le # de téléphone de la mère',
                'choice_label' => 'numero',
                'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('t')
                    ->where('t.numero IS NOT NULL')
                    ->andWhere('t.numero != :empty')
                    ->setParameter('empty', '')
                    ->orderBy('t.numero', 'ASC'),
                'attr' => [
                    'class' => 'select-telephone',
                    'data-autocomplete' => 'true',
                    'autocomplete' => 'telephone'
                ],
                /*'constraints' => [
                    new NotBlank(['message' => 'Le numéro de téléphone est obligatoire']),
                    new Regex([
                        'pattern' => '/^\+\d{3} \d{2} \d{2} \d{2} \d{2}$/',
                        'message' => 'Le numéro de téléphone doit être au format +xxx xx xx xx xx.',
                    ]),
                ],*/
                'error_bubbling' => false,
                'required' => true,
                'help' => 'Le numéro optionnel de la mère'
            ])
    
        ;

}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meres::class,
        ]);
    }
}
