<?php

namespace App\Form;

use App\Entity\Departs;
use App\Entity\eleves;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepartsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDepart', null, [
                'widget' => 'single_text',
            ])
            ->add('ecoleDestination')
            ->add('eleve', EntityType::class, [
                'class' => eleves::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Departs::class,
        ]);
    }
}
