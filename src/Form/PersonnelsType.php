<?php

namespace App\Form;

use App\Entity\LieuNaissances;
use App\Entity\Ninas;
use App\Entity\NiveauEtudes;
use App\Entity\Noms;
use App\Entity\Personnels;
use App\Entity\Postes;
use App\Entity\Prenoms;
use App\Entity\Specialites;
use App\Entity\Telephones1;
use App\Entity\Telephones2;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonnelsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageName')
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('sexe')
            ->add('referenceDiplome')
            ->add('isActif')
            ->add('isAllowed')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('slug')
            ->add('nom', EntityType::class, [
                'class' => Noms::class,
                'choice_label' => 'id',
            ])
            ->add('prenom', EntityType::class, [
                'class' => Prenoms::class,
                'choice_label' => 'id',
            ])
            ->add('lieuNaissance', EntityType::class, [
                'class' => LieuNaissances::class,
                'choice_label' => 'id',
            ])
            ->add('telephone1', EntityType::class, [
                'class' => Telephones1::class,
                'choice_label' => 'id',
            ])
            ->add('telephone2', EntityType::class, [
                'class' => Telephones2::class,
                'choice_label' => 'id',
            ])
            ->add('nina', EntityType::class, [
                'class' => Ninas::class,
                'choice_label' => 'id',
            ])
            ->add('specialites', EntityType::class, [
                'class' => Specialites::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('niveauEtudes', EntityType::class, [
                'class' => NiveauEtudes::class,
                'choice_label' => 'id',
            ])
            ->add('poste', EntityType::class, [
                'class' => Postes::class,
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
            'data_class' => Personnels::class,
        ]);
    }
}
