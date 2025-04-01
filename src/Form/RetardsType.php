<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Eleves;
use App\Entity\Retards;
use App\Entity\AnneeScolaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RetardsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        /*->add('jour', DateType::class, [
            'widget' => 'single_text',
            'html5' => true,
            'label' => 'Date du retard',
            'attr' => ['class' => 'js-datepicker',
            'readonly' => true]
        ])*/
        ->add('heureClasse', TimeType::class, [
            'widget' => 'single_text',
            'html5' => true,
            'label' => 'Heure de classe',
            'attr' => ['readonly' => true]
        ])
        ->add('heure', TimeType::class, [
            'widget' => 'single_text',
            'html5' => true,
            'label' => 'Heure d\'arrivée',
            'attr' => ['readonly' => true]
        ])
        ->add('duree', TimeType::class, [
            'widget' => 'single_text',
            'html5' => true,
            'label' => 'Durée du retard',
            'required' => false,
            'attr' => ['readonly' => true]
        ])
        ->add('isJustify', null, [
            'label' => 'Justifié ?',
            'attr' => [
                'class' => 'custom-checkbox', // Classe CSS pour la case à cocher
            ],
            'label_attr' => [
                'class' => 'custom-checkbox label', // Classe CSS pour le libellé
            ],
            'required' => false

        ])
        ->add('motif', TextType::class, [
            'label' => 'Motif du retard',
            'required' => false,
            'attr' => ['placeholder' => 'Raison du retard...']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Retards::class,
        ]);
    }
}
