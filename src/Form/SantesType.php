<?php

namespace App\Form;

use App\Entity\Santes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SantesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maladie', TextType::class, [
                'attr' => ['placeholder' => "il/elle souffre de quoi ?"],
                'required' => false,
            ])
            ->add('medecin', TextType::class, [
                'label' => 'Médecin traitant',
                'attr' => ['placeholder' => "exemple Dr xxxxxx xxxx"],
                'required' => false,
            ])
            ->add('numeroUrgence', TelType::class, [
                'label' => "Numéro d'urgence",
                'attr' => ['placeholder' => "exemple +223 xx xx xx xx"],
                'required' => false,
            ])
            ->add('centreSante', TextType::class, [
                'label' => 'Centre de Santé de :',
                'attr' => ['placeholder' => "Adresse du domicile"],
                'required' => false,
            ])
            //->add('eleve')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Santes::class,
        ]);
    }
}
