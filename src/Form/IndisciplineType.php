<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Eleves;
use App\Entity\Indiscipline;
use App\Entity\AnneeScolaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class IndisciplineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'label' => 'Date du forfait',
                'attr' => ['class' => 'js-datepicker',
                'readonly' => true]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description détaillée',
                'attr' => ['rows' => 5],
                'constraints' => [new NotBlank(['message' => 'la description du forfait est obligatoire'])],
                'error_bubbling' => false,
                'required' => true,

            ])
            ->add('isSanction', CheckboxType::class, [
                'label' => 'Sanctionné ?',
                'attr' => [
                    'class' => 'custom-checkbox', // Classe CSS pour la case à cocher
                ],
                'label_attr' => [
                    'class' => 'custom-checkbox label', // Classe CSS pour le libellé
                ],
                'required' => false
            ])
            ->add('sanction',TextType::class, [
                'label' => 'Description détaillée',
                'required'=> false
            ])
            ->add('eleve', EntityType::class, [
                'class' => Eleves::class,
                'choice_label' => 'id',
            ])
            ->add('anneeScolaire', EntityType::class, [
                'class' => AnneeScolaires::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Indiscipline::class,
        ]);
    }
}
