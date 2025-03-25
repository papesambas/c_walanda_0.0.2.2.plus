<?php

namespace App\Form;

use App\Entity\Departs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
                'required' => false,
            ])
            ->add('ecoleDestination', TextType::class, [
                'label' => 'Ecole de destination',
                'attr' => ['placeholder' => "Adresse du domicile"],
                'required' => false,
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
