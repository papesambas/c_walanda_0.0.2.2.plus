<?php

namespace App\Form;

use App\Entity\Noms;
use App\Entity\Eleves;
use App\Entity\Cercles;
use App\Entity\Classes;
use App\Entity\Niveaux;
use App\Entity\Parents;
use App\Entity\Prenoms;
use App\Entity\Regions;
use App\Entity\Statuts;
use App\Entity\Communes;
use Psr\Log\LoggerInterface;
use App\Entity\LieuNaissances;
use Doctrine\ORM\EntityRepository;
use App\Repository\MeresRepository;
use App\Repository\PeresRepository;
use App\Repository\NiveauxRepository;
use App\Repository\StatutsRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ElevesType extends AbstractType
{
    private array $niveaux = [];

    public function __construct(
        private Security $security,
        private PeresRepository $peresRepository,
        private MeresRepository $meresRepository,
        private StatutsRepository $statutsRepository,
        private NiveauxRepository $niveauxRepository,
        private LoggerInterface $logger
    ) {
        $user = $this->security->getUser();
        if ($user && $user->getEtablissement()) {
            $this->niveaux = $this->niveauxRepository->findByEtablissement($user->getEtablissement());
            $this->logger->info('Niveaux chargés', ['niveaux' => $this->niveaux]);
        }
    }

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
            ->add('statutFinance', ChoiceType::class, [
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Privé(e)' => 'P',
                    'Boursier(ère)' => 'B',
                    'Exonoré(e)' => 'E'
                ],
                'label_attr' => [
                    'class' => 'radio-inline'
                ],
                'row_attr' => [
                    'class' => 'radio-inline-container'
                ],
            ])
            ->add('nom', EntityType::class, [
                'class' => Noms::class,
                'placeholder' => 'Entrer ou Choisir un Nom',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.designation', 'ASC')
                        ->setCacheable(true);
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
                        ->orderBy('p.designation', 'ASC')
                        ->setCacheable(true);
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
                'label' => 'Autorisé(e)',
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
            ->add('numeroExtrait', TextType::class, [
                'attr' => ['placeholder' => "Numéro Extrait de Naissance"],
                'error_bubbling' => false,
            ])
            ->add('region', EntityType::class, [
                'class' => Regions::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.designation', 'ASC')
                        ->setCacheable(true);
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
            ->add('niveau', EntityType::class, [
                'class' => Niveaux::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.designation', 'ASC')
                        ->setCacheable(true);
                },
                'choice_label' => 'designation',
                'label' => 'Niveau',
                'choices' => $this->niveaux,
                'placeholder' => 'Choisir le Niveau',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'select-niveau'
                ],
            ])
        ;

        // Écouteurs d'événements pour les champs dynamiques
        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addCerclesField($form->getParent(), $data);
            }
        );

        $builder->get('niveau')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                dump($form, $data);
                $this->addClassesField($form->getParent(), $data);
                $this->addStatutsField($form->getParent(), $data);
                $this->addDatesField($form->getParent(), $data);

            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                /**@LieuNaissances $lieuNaissance */
                $lieuNaissance = $data->getLieuNaissance();
                $form = $event->getForm();
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

    public function addClassesField(FormInterface $form, ?Niveaux $niveaux)
    {
        $form->add('classe', EntityType::class, [
            'class' => Classes::class,
            'choice_label' => 'designation',
            'choices' => $niveaux ? $niveaux->getClasses() : [],
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.designation', 'ASC');
            },
            'placeholder' => $niveaux ? 'Entrer ou Choisir la classe' : 'Entrer ou Choisir le niveau',
            'attr' => [
                'class' => 'select-classe'
            ],
            'required' => false,
            'error_bubbling' => false,
        ]);
    }

    public function addStatutsField(FormInterface $form, ?Niveaux $niveaux)
    {
        $form->add('statut', EntityType::class, [
            'class' => Statuts::class,
            'choice_label' => 'designation',
            'choices' => $niveaux ? $niveaux->getStatuts() : [],
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->orderBy('s.designation', 'ASC');
            },
            'placeholder' => $niveaux ? 'Entrer ou Choisir le Statut' : 'Entrer ou Choisir le niveau',
            'attr' => [
                'class' => 'select-statut'
            ],
            'required' => false,
            'error_bubbling' => false,
        ]);
    }

    public function addDatesField(FormInterface $form, ?Niveaux $niveaux)
    {
        if (!$niveaux) {
            $form->add('dateInscription', DateType::class, [
                'label' => 'Date d\'Inscription',
                'widget' => 'single_text',
                'auto_initialize' => false,
            ])
                ->add('dateRecrutement', DateType::class, [
                    'label' => 'Date de Recrutement',
                    'widget' => 'single_text',
                    'auto_initialize' => false,
                ])
                ->add('dateNaissance', DateType::class, [
                    'label' => 'Date de Naissance',
                    'widget' => 'single_text',
                    'auto_initialize' => false,
                ])
                ->add('dateExtrait', DateType::class, [
                    'label' => 'Date Extrait',
                    'widget' => 'single_text',
                    'auto_initialize' => false,
                ])
            ;
        } else {
            $designation = $niveaux ? $niveaux->getDesignation() : null;
            dump($designation);
            if ($designation == "Petite Section") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -4 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -3 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -1 year'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -1 year'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -1 year'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                           new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            } elseif ($designation == "Moyenne Section") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -5 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -4 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -2 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -2 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -2 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            } elseif ($designation == "Grande Section") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -6 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -5 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -3 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -3 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -3 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            } elseif ($designation == "1ère Année") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -9 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -5 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -9 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -4 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -4 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            } elseif ($designation == "2ème Année") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -10 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -6 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -10 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -5 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -5 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            } elseif ($designation == "3ème Année") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -11 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -7 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -11 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -6 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -6 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            } elseif ($designation == "4ème Année") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -12 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -8 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -12 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -7 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -7 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            } elseif ($designation == "5ème Année") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -13 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -9 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -13 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -8 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -8 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            } elseif ($designation == "6ème Année") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -14 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -10 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -14 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -9 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -9 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            } elseif ($designation == "7ème Année") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -15 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -11 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -15 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -10 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -10 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            } elseif ($designation == "8ème Année") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -16 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -12 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -16 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -11 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -11 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            } elseif ($designation == "9ème Année") {
                $form
                    ->add('dateNaissance', DateType::class, [
                        'label' => 'Date de Naissance',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -17 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -13 years'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateExtrait', DateType::class, [
                        'label' => 'Date Extrait',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -17 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -1 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de l\'extrait est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                                $dateExtrait = $object;

                                if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                                    if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'extrait Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                    ->add('dateInscription', DateType::class, [
                        'label' => 'Date d\'Inscription',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                        'attr' => [
                            'min' => (new \DateTime('now -12 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 days'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de naissance est obligatoire.',
                            ]),
                        ],
                    ])
                    ->add('dateRecrutement', DateType::class, [
                        'label' => 'Date de Recrutement',
                        'widget' => 'single_text',
                        'auto_initialize' => false,
                    'attr' => [
                            'min' => (new \DateTime('now -12 years'))->format('Y-m-d'),
                            'max' => (new \DateTime('now -0 day'))->format('Y-m-d'),
                        ],
                        'constraints' => [
                            new NotNull([
                                'message' => 'La date de Recrutement est obligatoire.',
                            ]),
                            new Callback(function ($object, ExecutionContextInterface $context) {
                                $recrutement = $context->getRoot()->getData()->getDateRecrutement();
                                $inscription = $object;

                                if (is_a($recrutement, \DateTime::class) && is_a($inscription, \DateTime::class)) {
                                    if ($inscription->format('U') - $recrutement->format('U') < 0) {
                                        $context
                                            ->buildViolation("date d'Inscription Incorrecte")
                                            ->addViolation();
                                    }
                                }
                            }),
                        ],
                    ])
                ;
            }
        }
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class,
        ]);
    }
}
