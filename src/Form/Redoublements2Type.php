<?php

namespace App\Form;

use App\Entity\Niveaux;
use App\Entity\Redoublements1;
use App\Entity\Redoublements2;
use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Redoublements2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('redoublement1', EntityType::class, [
                'class' => Redoublements1::class,
                'choice_label' => 'id',
            ])
            ->add('scolarites1', EntityType::class, [
                'class' => Scolarites1::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('scolarites2', EntityType::class, [
                'class' => Scolarites2::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('niveau', EntityType::class, [
                'class' => Niveaux::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Redoublements2::class,
        ]);
    }
}
