<?php

namespace App\Form;

use App\Entity\Departs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DepartsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('dateDepart')
            ->add('motif', TextType::class, [
                'label' => 'Motif',
                'attr' => ['placeholder' => "Motif du départ"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le motif est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],

                'required' => true,
            ])
            ->add('ecoleDestination', TextType::class, [
                'label' => 'Ecole de destination',
                'attr' => ['placeholder' => "Adresse de l'établissement"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\école de destination est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],
                'required' => true,
            ])
            //->add('eleve')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Departs::class,
        ]);
    }
}
