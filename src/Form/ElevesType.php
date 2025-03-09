<?php

namespace App\Form;

use App\Entity\Noms;
use App\Entity\Eleves;
use App\Entity\Cercles;
use App\Entity\Parents;
use App\Entity\Prenoms;
use App\Entity\Regions;
use App\Entity\Communes;
use App\Entity\LieuNaissances;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ElevesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sexe', ChoiceType::class, [
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Masculin' => 'M',
                    'Féminin' => 'F',
                ],
                'label_attr' => [
                    'class' => 'radio-inline'
                ],
                'row_attr' => [
                    'class' => 'radio-inline-container'
                ],
            ])
            ->add('dateInscription', null, [
                'widget' => 'single_text',
            ])
            ->add('dateRecrutement', null, [
                'widget' => 'single_text',
            ])
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('dateExtrait', null, [
                'widget' => 'single_text',
            ])
            ->add('numeroExtrait', TextType::class, [
                'attr' => ['placeholder' => "Numéro Extrait de Naissance"],
                'error_bubbling' => false,
            ])
            ->add('nom', EntityType::class, [
                'label' => 'Nom',
                'class' => Noms::class,
                'placeholder' => 'Entrer ou Choisir un Nom',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select-nomfamille'
                ],
                'error_bubbling' => false,
            ])
            ->add('prenom', EntityType::class, [
                'class' => Prenoms::class,
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.designation', 'ASC');
                },
                'placeholder' => 'Entrer ou Choisir un prénom',
                'attr' => [
                    'class' => 'select-prenom'
                ],
                'error_bubbling' => false,
            ])
            ->add('isActif', CheckboxType::class, [
                'label' => 'Actif(ve)',
                'required' => false,
            ])
            ->add('isAllowed', CheckboxType::class, [
                'label' => 'AUtorisé(e)',
                'required' => false,
            ])
            ->add('isAdmin', CheckboxType::class, [
                'label' => 'Admis(e)',
                'required' => false,
            ])
            ->add('isHandicap', CheckboxType::class, [
                'label' => 'Handicapé(e)',
                'required' => false,
            ])
            ->add('natureHandicape', TextType::class, [
                'attr' => ['placeholder' => "Nature handicape"],
                'required' => false,
            ])
            ->add('parent', EntityType::class, [
                'class' => Parents::class,
                'choice_label' => 'id',
            ])
            ->add('region', EntityType::class, [
                'class' => Regions::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.designation', 'ASC');
                },
                'choice_label' => 'designation',
                'label' => 'Région',
                'placeholder' => 'Choisir la Région',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'select-region'
                ],
            ])
        ;
        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addCerclesField($form->getParent(), $data);
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function(FormEvent $event){
                $data = $event->getData();
                /**@LieuNaissances $lieuNaissance */
                $lieuNaissance = $data->getLieuNaissance();
                $form = $event->getForm();
                dump($data, $lieuNaissance, $form);
                if ($lieuNaissance) {
                    $commune = $lieuNaissance->getCommune();
                    $cercle = $commune->getCercle();
                    $region = $cercle->getRegion();
                    $this->addCerclesField($form, $region);
                    $this->addCommunesField($form, $cercle);
                    $this->addLieuNaissanceField($form, $commune);
                    $form->get('region')->setData($region);
                    $form->get('cercle')->setData($cercle);
                    $form->get('commune')->setData($commune);
                } else {
                    $this->addCerclesField($form, null);
                    $this->addCommunesField($form, null);
                    $this->addLieuNaissanceField($form, null);
                }
                
            }
        );
    }

    public function addCerclesField(FormInterface $form, ?Regions $regions)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'cercle',
            EntityType::class,
            null,
            [
                'class' => Cercles::class,
                'choice_label' => 'designation',
                'auto_initialize' => false,
                'label' => 'Cercle de :',
                'choices' => $regions ? $regions->getCercles() : [],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.designation', 'ASC');
                },
                'placeholder' => $regions ? 'Entrer ou Choisir un Cercle' : 'Entrer ou Choisir une Région',
                'attr' => [
                    'class' => 'select-cercle'
                ],
                /*'constraints' => [
                    new Assert\NotBlank(),
                ],*/
                'required' => false,
                'mapped' => false,
                'error_bubbling' => false,
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addCommunesField($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    public function addCommunesField(FormInterface $form, ?Cercles $cercles)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'commune',
            EntityType::class,
            null,
            [
                'class' => Communes::class,
                'choice_label' => 'designation',
                'label' => 'Commune de :',
                'auto_initialize' => false,
                'choices' => $cercles ? $cercles->getCommunes() : [],
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.designation', 'ASC');
                },
                'placeholder' => $cercles ? 'Entrer ou Choisir une Commune' : 'Entrer ou Choisir un Cercle',
                'attr' => [
                    'class' => 'select-commune'
                ],
                /*'constraints' => [
                    new Assert\NotBlank(),
                ],*/
                'required' => false,
                'mapped' => false,
                'error_bubbling' => false,
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addLieuNaissanceField($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    public function addLieuNaissanceField(FormInterface $form, ?Communes $communes)
    {
        $form->add('lieuNaissance', EntityType::class, [
            'class' => LieuNaissances::class,
            'choice_label' => 'designation',
            'choices' => $communes ? $communes->getLieuNaissances() : [],
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('l')
                    ->orderBy('l.designation', 'ASC');
            },
            'placeholder' => $communes ? 'Entrer ou Choisir le lieu de Naissance' : 'Entrer ou Choisir la Commune',
            'attr' => [
                'class' => 'select-lieu'
            ],
            'required' => false,
            'error_bubbling' => false,
        ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class,
        ]);
    }
}
