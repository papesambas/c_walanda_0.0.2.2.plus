<?php

namespace App\Form;

use App\Entity\AnneeScolaires;
use App\Entity\Personnels;
use App\Entity\RetardsPersonnel;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetardsPersonnelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour', null, [
                'widget' => 'single_text',
            ])
            ->add('heure', null, [
                'widget' => 'single_text',
            ])
            ->add('duree', null, [
                'widget' => 'single_text',
            ])
            ->add('motif')
            ->add('heureClasse', null, [
                'widget' => 'single_text',
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('slug')
            ->add('personnel', EntityType::class, [
                'class' => Personnels::class,
                'choice_label' => 'id',
            ])
            ->add('anneeScolaire', EntityType::class, [
                'class' => AnneeScolaires::class,
                'choice_label' => 'id',
            ])
            ->add('createdBy', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
            ->add('updatedBy', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RetardsPersonnel::class,
        ]);
    }
}
