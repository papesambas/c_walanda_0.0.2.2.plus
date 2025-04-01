<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Eleves;
use App\Entity\Absences;
use App\Entity\AnneeScolaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AbsencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour', null, [
                'widget' => 'single_text',
            ])
            ->add('isJustify', CheckboxType::class, [
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
                'label' => 'Motif de l\'absence',
                'required' => false,
                'attr' => ['placeholder' => 'Raison de l\'absence...']
            ])
            ->add('eleve', EntityType::class, [
                'class' => Eleves::class,
                //'choice_label' => 'id',
            ])
            ->add('anneeScolaire', EntityType::class, [
                'class' => AnneeScolaires::class,
                //'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Absences::class,
        ]);
    }
}
