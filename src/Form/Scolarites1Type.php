<?php

namespace App\Form;

use App\Entity\Niveaux;
use App\Entity\Redoublements1;
use App\Entity\Redoublements2;
use App\Entity\Redoublements3;
use App\Entity\Scolarites1;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Scolarites1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('scolarite')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('niveau', EntityType::class, [
                'class' => Niveaux::class,
                'choice_label' => 'id',
            ])
            ->add('redoublements1s', EntityType::class, [
                'class' => Redoublements1::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('redoublements2s', EntityType::class, [
                'class' => Redoublements2::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('redoublements3s', EntityType::class, [
                'class' => Redoublements3::class,
                'choice_label' => 'id',
                'multiple' => true,
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
            'data_class' => Scolarites1::class,
        ]);
    }
}
