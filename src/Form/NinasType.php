<?php

namespace App\Form;

use App\Entity\Meres;
use App\Entity\Ninas;
use App\Entity\Peres;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NinasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation')
            ->add('pere', EntityType::class, [
                'class' => Peres::class,
                'choice_label' => 'id',
            ])
            ->add('mere', EntityType::class, [
                'class' => Meres::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ninas::class,
        ]);
    }
}
