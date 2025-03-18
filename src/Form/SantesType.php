<?php

namespace App\Form;

use App\Entity\Eleves;
use App\Entity\Santes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SantesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maladie')
            ->add('medecin')
            ->add('numeroUrgence')
            ->add('centreSante')
            ->add('eleve', EntityType::class, [
                'class' => Eleves::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Santes::class,
        ]);
    }
}
