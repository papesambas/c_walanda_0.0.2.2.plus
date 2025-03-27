<?php

namespace App\Form;

use App\Entity\Noms;
use App\Entity\Users;
use App\Entity\Eleves;
use App\Entity\Cercles;
use App\Entity\Classes;
use App\Entity\Niveaux;
use App\Entity\Parents;
use App\Entity\Prenoms;
use App\Entity\Regions;
use App\Entity\Statuts;
use App\Entity\Communes;
use App\Entity\Scolarites1;
use App\Entity\Scolarites2;
use Psr\Log\LoggerInterface;
use App\Entity\LieuNaissances;
use App\Entity\Redoublements1;
use App\Entity\Redoublements2;
use App\Entity\Redoublements3;
use App\Entity\EcoleProvenances;
use Doctrine\ORM\EntityRepository;
use App\Repository\NiveauxRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use App\Repository\Scolarites2Repository;
use Symfony\Component\Form\FormInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Repository\Redoublements1Repository;
use App\EventSubscriber\IsAdminFieldsSubscriber;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


class ElevesType extends AbstractType
{
    private array $niveaux = [];
    public function __construct(
        private Scolarites2Repository $scolarites2Repository,
        private EntityManagerInterface $em,
        private Redoublements1Repository $redoublements1Repository,
        private IsAdminFieldsSubscriber $isAdminFieldsSubscriber,
        private Security $security,
        private NiveauxRepository $niveauxRepository,
        private LoggerInterface $logger,
    ) {
        $user = $this->security->getUser();
        if ($user instanceof Users) {
            $etablissement = $user->getEtablissement();
            $this->niveaux = $this->niveauxRepository->findByEtablissement($etablissement);
            $this->logger->info('Niveaux chargés', ['niveaux' => $this->niveaux]);
        }
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => "Photo d'identité",
                //'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/png',
                        ]
                    ])
                ],
                'allow_delete' => true,
                'delete_label' => 'supprimer',
                'download_uri' => true,
                'download_label' => 'Télécharger',
                'image_uri'         => false,
                'asset_helper' => true,
            ])
            ->add('document', FileType::class, [
                'label' => 'Télécharger Documents (Fichier PDF/Word)',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '2048k',
                                'mimeTypes' => [
                                    'application/pdf',
                                    'application/x-pdf',
                                    'application/msword',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                ],
                                'mimeTypesMessage' => 'Format valid valid PDF ou word',
                            ])
                        ]
                    ]),
                ]
            ])
            ->add('document', FileType::class, [
                'label' => 'Télécharger Documents (Fichier PDF/Word)',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '2048k',
                                'mimeTypes' => [
                                    'application/pdf',
                                    'application/x-pdf',
                                    'application/msword',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                ],
                                'mimeTypesMessage' => 'Format valid valid PDF ou word',
                            ])
                        ]
                    ]),
                ]
            ])
            ->add('nom', EntityType::class, [
                'class' => Noms::class,
                'placeholder' => 'Entrer ou Choisir un Nom',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select-nom'
                ],
                //'help' => 'Veuillez sélectionner ou entrer un prénom valide.', // Texte d'aide
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le prénom est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],
                'error_bubbling' => false,
            ])
            ->add('prenom', EntityType::class, [
                'class' => Prenoms::class,
                'placeholder' => 'Entrer ou Choisir un Prénom',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select-prenom'
                ],
                //'help' => 'Veuillez sélectionner ou entrer un prénom valide.', // Texte d'aide
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le prénom est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],
                'error_bubbling' => false,
            ])
            ->add('sexe', ChoiceType::class, [
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Masculin' => 'M',
                    'Féminin' => 'F'
                ],
                'label_attr' => [
                    'class' => 'radio-inline'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner votre genre.',
                    ]),
                ],
            ])
            ->add('numeroExtrait', TextType::class, [
                'attr' => [
                    'placeholder' => 'Numéro Extrait de Naissance',
                ],
                'error_bubbling' => false,
                //'help' => 'Le numéro officile tel sur l\'extrait d\'acte de naissance',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numéro d\'extrait de naissance est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Z0-9-\/]{5,20}$/',
                        'message' => 'Le numéro d\'extrait de naissance doit contenir uniquement des lettres majuscules, des chiffres, des tirets (-) et des barres obliques (/).',
                    ]),
                ],
            ])
            ->add('isActif', CheckboxType::class, [
                'label' => 'Actif',
                'data' => true, // Case cochée par défaut
                'attr' => [
                    'class' => 'custom-checkbox', // Classe CSS pour la case à cocher
                ],
                'label_attr' => [
                    'class' => 'custom-checkbox label', // Classe CSS pour le libellé
                ],
                'required' => true, // La case doit être cochée
                'constraints' => [
                    //new IsTrue([
                    //    'message' => 'Vous devez cocher cette case pour continuer.', // Message d'erreur personnalisé
                    //]),
                ],
            ])
            ->addEventSubscriber($this->isAdminFieldsSubscriber)
            ->add('isHandicap', CheckboxType::class, [
                'label' => 'Handicapé(e)',
                'attr' => [
                    'class' => 'custom-checkbox', // Classe CSS pour la case à cocher
                ],
                'label_attr' => [
                    'class' => 'custom-checkbox label', // Classe CSS pour le libellé
                ],
                'required' => false, // La case doit être cochée
                'constraints' => [
                    //new IsTrue([
                    //    'message' => 'Vous devez cocher cette case pour continuer.', // Message d'erreur personnalisé
                    //]),
                ],
            ])
            ->add('natureHandicape', TextType::class, [
                'label' => 'Nature du handicape', // Libellé personnalisé
                'attr' => [
                    'placeholder' => 'Nature handicape',
                    //'class' => 'input-handicap', // Classe CSS personnalisée
                ],
                'required' => false,
                'help' => 'Veuillez spécifier la nature du handicap, si applicable.', // Texte d'aide
                /*'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'La nature du handicap ne doit pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-zÀ-ÿ\s-]+$/',
                        'message' => 'La nature du handicap ne peut contenir que des lettres, des espaces et des tirets.',
                    ]),
                ],*/
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
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un statut Financier.',
                    ]),
                ],
            ])
            //->add('createdBy', EntityType::class, [
            //    'class' => Users::class,
            //    'choice_label' => 'id',
            //])
            //->add('updatedBy', EntityType::class, [
            //    'class' => Users::class,
            //    'choice_label' => 'id',
            //])
            ->add('region', EntityType::class, [
                'class' => Regions::class,
                'placeholder' => 'Entrer ou Choisir une région',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->orderBy('r.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select-region'
                ],
                //'help' => 'Veuillez saisir la région de naissance officielle de l\'élève ...', // Texte d'aide
                'constraints' => [
                    new NotBlank([
                        'message' => 'La région est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],
                'mapped' => false,
                'error_bubbling' => false,
            ])
            ->add('niveau', EntityType::class, [
                'class' => Niveaux::class,
                'placeholder' => 'Entrer ou Choisir un niveau',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.id', 'ASC')
                        ->setCacheable(true);
                },
                'choices' => $this->niveaux,
                'attr' => [
                    'class' => 'select-niveau'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le niveau est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],
                'mapped' => false,
                'error_bubbling' => false,
            ])
            ->add('santes', CollectionType::class, [
                'entry_type' => SantesType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'error_bubbling' => false,
            ])
            ->add('departs', CollectionType::class, [
                'entry_type' => DepartsType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'required' => false,
                'error_bubbling' => false,
            ])
            ->add('ecoleRecrutement', EntityType::class, [
                'class' => EcoleProvenances::class,
                'placeholder' => 'Entrer ou Choisir une école',
                'choice_label' => 'designation',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.designation', 'ASC');
                },
                'attr' => [
                    'class' => 'select-ecole'
                ],
                //'help' => 'Veuillez sélectionner ou entrer un prénom valide.', // Texte d'aide
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'école de Recrutement est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],
                'error_bubbling' => false,
            ])
            ->add('ecoleAnDernier', CollectionType::class, [
                'entry_type' => EcoleProvenancesType::class,
                //'entry_options' => ['label' => false],
                'label' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
                'required' => false,
            ])
        ;

        // Vérifier si l'utilisateur peut éditer le champ "admis"
        /*if (!$options['canEditAdmis']) {
            $builder->get('isAdmis')->setDisabled(true);
            $builder->get('isAllowed')->setDisabled(true);
        }*/

        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addCerclesField($form->getParent(), $form->getData());
            }
        );

        $builder->get('niveau')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addClassesField($form->getParent(), $form->getData());
                $this->addStatutsField($form->getParent(), $form->getData());
                $this->addScolarites1Field($form->getParent(), $form->getData());
                $this->addDateNaissanceField($form->getParent(), $form->getData());
                $this->addDateRecrutementField($form->getParent(), $form->getData());
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                /**LieuNaissances @lieuNaissances*/
                $lieuNaissances = $data->getLieuNaissance();
                $form = $event->getForm();
                if ($lieuNaissances) {
                    $commune = $lieuNaissances->getCommune();
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

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                /**Scolarites2 @scolarites2*/
                $scolarites2 = $data->getScolarite2();
                $form = $event->getForm();
                if ($scolarites2) {
                    $scolarite1 = $scolarites2->getScolarite1();
                    $niveau = $scolarite1->getNiveau();
                    $this->addScolarites1Field($form, $niveau);
                    $this->addScolarites2Field($form, $scolarite1);
                    $form->get('scolarite1')->setData($scolarite1);
                } else {
                    $this->addScolarites1Field($form, null);
                    $this->addScolarites2Field($form, null);
                }
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                /**Classes @classes*/
                $classes = $data->getClasse();
                $form = $event->getForm();
                if ($classes) {
                    $niveau = $classes->getNiveau();
                    $this->addStatutsField($form, $niveau);
                    $this->addClassesField($form, $niveau);
                    $this->addDateNaissanceField($form, $niveau);
                    $this->addDateRecrutementField($form, $niveau);
                    $form->get('niveau')->setData($niveau);
                } else {
                    $this->addStatutsField($form, null);
                    $this->addClassesField($form, null);
                    $this->addDateNaissanceField($form, null);
                    $this->addDateRecrutementField($form, null);
                }
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                /**Redoublements3 @redoublements3*/
                $redoublements3 = $data->getRedoublement3();
                $form = $event->getForm();
                if ($redoublements3) {
                    $redoublement2 = $redoublements3->getRedoublement2();
                    $redoublement1 = $redoublement2->getRedoublement1();
                    $scolarite2 = $redoublement1->getScolarite2();
                    $this->addRedoublements1Field($form, $scolarite2);
                    $this->addRedoublements2Field($form, $redoublement1);
                    $this->addRedoublement3Field($form, $redoublement2);
                    $form->get('scolarite2')->setData($scolarite2);
                    $form->get('redoublement1')->setData($redoublement1);
                    $form->get('redoublement2')->setData($redoublement2);
                } else {
                    $this->addRedoublements1Field($form, null);
                    $this->addRedoublements2Field($form, null);
                    $this->addRedoublement3Field($form, null);
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
                'placeholder' => 'Entrer ou Choisir un cercle',
                'choice_label' => 'designation',
                'auto_initialize' => false,
                'query_builder' => function (EntityRepository $er) use ($regions) {
                    $qb = $er->createQueryBuilder('c')
                        ->orderBy('c.designation', 'ASC');
                    // Filtrer par région si une région est spécifiée
                    if ($regions) {
                        $qb->where('c.region = :region')
                            ->setParameter('region', $regions);
                    }
                    return $qb;
                },
                'attr' => [
                    'class' => 'select-cercle'
                ],
                //'help' => 'Veuillez saisir le cercle de naissance officielle de l\'élève ...', // Texte d'aide
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le cercle est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],
                'mapped' => false,
                'required' => false,
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
                'placeholder' => 'Entrer ou Choisir une commune',
                'choice_label' => 'designation',
                'auto_initialize' => false,
                'query_builder' => function (EntityRepository $er) use ($cercles) {
                    $qb = $er->createQueryBuilder('c')
                        ->orderBy('c.designation', 'ASC');
                    // Filtrer par région si une région est spécifiée
                    if ($cercles) {
                        $qb->where('c.cercle = :cercle')
                            ->setParameter('cercle', $cercles);
                    }
                    return $qb;
                },
                'attr' => [
                    'class' => 'select-commune'
                ],
                //'help' => 'Veuillez saisir la commune de naissance officielle de l\'élève ...', // Texte d'aide
                'constraints' => [
                    new NotBlank([
                        'message' => 'La commune est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],
                'mapped' => false,
                'required' => false,
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
            'placeholder' => 'Entrer ou Choisir un lieu',
            'choice_label' => 'designation',
            'query_builder' => function (EntityRepository $er) use ($communes) {
                $qb = $er->createQueryBuilder('l')
                    ->orderBy('l.designation', 'ASC');
                // Filtrer par région si une région est spécifiée
                if ($communes) {
                    $qb->where('l.commune = :commune')
                        ->setParameter('commune', $communes);
                }
                return $qb;
            },
            'attr' => [
                'class' => 'select-lieu'
            ],
            //'help' => 'Saississez le lieu officiel tel sur l\'extrait de naissance.', // Texte d'aide
            'constraints' => [
                new NotBlank([
                    'message' => 'Le lieu de naissance est obligatoire.', // Message d'erreur personnalisé
                ]),
            ],
            'error_bubbling' => false,
        ]);
    }

    public function addClassesField(FormInterface $form, ?Niveaux $niveaux)
    {
        $form->add('classe', EntityType::class, [
            'class' => Classes::class,
            'placeholder' => 'Entrer ou Choisir une classe',
            'choice_label' => 'designation',
            'query_builder' => function (EntityRepository $er) use ($niveaux) {
                $qb = $er->createQueryBuilder('c')
                    ->orderBy('c.designation', 'ASC');
                // Filtrer par région si une région est spécifiée
                if ($niveaux) {
                    $qb->where('c.niveau = :niveau')
                        ->setParameter('niveau', $niveaux);
                }
                return $qb;
            },
            'attr' => [
                'class' => 'select-classe'
            ],
            //'help' => 'Veuillez spécifier la classe de l\'élève ...', // Texte d'aide
            'constraints' => [
                new NotBlank([
                    'message' => 'La classe est obligatoire.', // Message d'erreur personnalisé
                ]),
            ],
            'error_bubbling' => false,
        ]);
    }

    public function addStatutsField(FormInterface $form, ?Niveaux $niveaux)
    {
        $form->add('statut', EntityType::class, [
            'class' => Statuts::class,
            'placeholder' => 'Entrer ou Choisir un statut',
            'choice_label' => 'designation',
            'query_builder' => function (EntityRepository $er) use ($niveaux) {
                $qb = $er->createQueryBuilder('s')
                    ->orderBy('s.designation', 'ASC');
                // Filtrer par région si une région est spécifiée
                if ($niveaux) {
                    $qb->where('s.niveau = :niveau')
                        ->setParameter('niveau', $niveaux);
                }
                return $qb;
            },
            'attr' => [
                'class' => 'select-statut'
            ],
            //'help' => 'Veuillez spécifier le statut de l\'élève, si applicable.', // Texte d'aide
            'constraints' => [
                new NotBlank([
                    'message' => 'Le statut est obligatoire.', // Message d'erreur personnalisé
                ]),
            ],
            'error_bubbling' => false,
        ]);
    }

    public function addScolarites1Field(FormInterface $form, ?Niveaux $niveaux)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'scolarite1',
            EntityType::class,
            null,
            [
                'class' => Scolarites1::class,
                'placeholder' => 'Entrer ou Choisir une scolarite',
                'choice_label' => 'scolarite',
                'auto_initialize' => false,
                'query_builder' => function (EntityRepository $er) use ($niveaux) {
                    $qb = $er->createQueryBuilder('s')
                        ->where('s.niveau = :niveau')
                        ->setParameter('niveau', $niveaux)
                        ->orderBy('s.scolarite', 'ASC');
                    // Filtrer par région si une région est spécifiée
                    return $qb;
                },
                'attr' => [
                    'class' => 'select-scolarite'
                ],
                //'help' => 'Veuillez choisir le niveau de scolarité ...', // Texte d'aide
                'constraints' => [
                    new NotBlank([
                        'message' => 'La scolarité est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],
                'required' => false,
                'error_bubbling' => false,
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addScolarites2Field($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    public function addScolarites2Field(FormInterface $form, ?Scolarites1 $scolarites1 = null)
    {
        // Vérifier que scolarites1 et son niveau ne sont pas null
        $niveau = $scolarites1 ? $scolarites1->getNiveau() : null;

        // Créer le champ 'scolarite2'
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'scolarite2',
            EntityType::class,
            null,
            [
                'class' => Scolarites2::class,
                'placeholder' => 'Entrer ou Choisir une scolarité',
                'choice_label' => 'scolarite',
                'auto_initialize' => false,
                'query_builder' => function (EntityRepository $er) use ($scolarites1, $niveau) {
                    $qb = $er->createQueryBuilder('s')
                        ->where('s.scolarite1 = :scolarite1')
                        ->andWhere('s.niveau = :niveau')
                        ->setParameter('scolarite1', $scolarites1)
                        ->setParameter('niveau', $niveau)
                        ->orderBy('s.scolarite', 'ASC');

                    return $qb;
                },
                'attr' => [
                    'class' => 'select-scolarite'
                ],
                //'help' => 'Veuillez sélectionner le niveau de scolarité.', // Texte d'aide
                'constraints' => [
                    new NotBlank([
                        'message' => 'La scolarité est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],
                'required' => false,
                'error_bubbling' => false,
            ]
        );

        // Ajouter un écouteur d'événement pour gérer la soumission du formulaire
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();

                // Ajouter dynamiquement un autre champ (redoublements1)
                if ($data) {
                    $this->addRedoublements1Field($form->getParent(), $data);
                }
            }
        );

        // Ajouter le champ au formulaire parent
        $form->add($builder->getForm());
    }
    public function addRedoublements1Field(FormInterface $form, ?Scolarites2 $scolarites2)
    {
        $scolarite1 = $scolarites2 ? $scolarites2->getScolarite1() : [];
        $niveau = $scolarites2 ? $scolarites2->getNiveau() : [];

        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'redoublement1',
            EntityType::class,
            null,
            [
                'class' => Redoublements1::class,
                'label' => 'Redoublement 1',
                'placeholder' => '2ème Redoub',
                'choice_label' => 'niveau',
                'auto_initialize' => false,
                'query_builder' => function (EntityRepository $er) use ($scolarite1, $scolarites2) {
                    $qb = $er->createQueryBuilder('r')
                        ->orderBy('r.niveau', 'ASC');
                    // Filtrer par région si une région est spécifiée
                    if ($scolarites2 && $scolarite1) {
                        $qb->andWhere('r.scolarite1 = :scolarite1')
                            ->andWhere('r.scolarite2 = :scolarite2')
                            //->andWhere('s1.niveau = :niveau')

                            ->setParameter('scolarite1', $scolarite1)
                            ->setParameter('scolarite2', $scolarites2);
                        //->setParameter('niveau', $niveau);

                    }
                    return $qb;
                },
                'attr' => [
                    'class' => 'select-redoublement'
                ],
                //'help' => 'Veuillez choisir le niveau de redoublement ...', // Texte d'aide
                /*'constraints' => [
                    new NotBlank([
                        'message' => 'L  est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],*/
                'required' => false,
                'error_bubbling' => false,
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addRedoublements2Field($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    public function addRedoublements2Field(FormInterface $form, ?Redoublements1 $redoublement1)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'redoublement2',
            EntityType::class,
            null,
            [
                'class' => Redoublements2::class,
                'placeholder' => '2ème Redoub',
                'label' => 'Redoublement 2',
                'choice_label' => 'niveau',
                'auto_initialize' => false,
                'query_builder' => function (EntityRepository $er) use ($redoublement1) {
                    $qb = $er->createQueryBuilder('r')
                        ->orderBy('r.niveau', 'ASC');
                    // Filtrer par région si une région est spécifiée
                    if ($redoublement1) {
                        $qb->where('r.redoublement1 = :redoublement1')
                            ->setParameter('redoublement1', $redoublement1);
                    }
                    return $qb;
                },
                'attr' => [
                    'class' => 'select-redoublement'
                ],
                //'help' => 'Veuillez choisir le niveau de redoublement ...', // Texte d'aide
                /*'constraints' => [
                    new NotBlank([
                        'message' => 'L  est obligatoire.', // Message d'erreur personnalisé
                    ]),
                ],*/
                'required' => false,
                'error_bubbling' => false,
            ]
        );

        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $form->getData();
                $this->addRedoublement3Field($form->getParent(), $form->getData());
            }
        );

        $form->add($builder->getForm());
    }

    public function addRedoublement3Field(FormInterface $form, ?Redoublements2 $redoublements2 = null)
    {
        $form->add('redoublement3', EntityType::class, [
            'class' => Redoublements3::class,
            'placeholder' => '3ème Redoub',
            'label' => 'Redoublement 3',
            'choice_label' => 'niveau',
            'query_builder' => function (EntityRepository $er) use ($redoublements2) {
                $qb = $er->createQueryBuilder('r')
                    ->orderBy('r.niveau', 'ASC');

                // Filtrer par redoublements2 si spécifié
                if ($redoublements2) {
                    $qb->where('r.redoublement2 = :redoublements2')
                        ->setParameter('redoublements2', $redoublements2);
                }

                return $qb;
            },
            'attr' => [
                'class' => 'select-redoublement'
            ],
            //'help' => 'Veuillez choisir le niveau de redoublement ...', // Texte d'aide
            'required' => false, // Correction de 'require' à 'required'
            'error_bubbling' => false,
        ]);
    }

    public function addDateNaissanceField(FormInterface $form, ?Niveaux $niveaux)
    {
        // Récupération et validation des âges
        $minAge = $niveaux ? max(0, $niveaux->getMaxAge()) : 4; // Au moins 0
        $maxAge = $niveaux ? max($minAge + 1, $niveaux->getMinAge()) : $minAge + 1; // Toujours > minAge

        // Calcul des dates limites
        $now = new \DateTimeImmutable();
        $minDate = $now->modify("-{$maxAge} years");
        $maxDate = $now->modify("-{$minAge} years");

        $form->add('dateNaissance', DateType::class, [
            'label' => 'Date de Naissance',
            'input' => 'datetime_immutable',
            'widget' => 'single_text',
            'html5' => true,
            'format' => 'yyyy-MM-dd',
            'attr' => [
                'class' => 'form-control datepicker',
                'min' => $minDate->format('Y-m-d'), // Utilisation de la date calculée
                'max' => $maxDate->format('Y-m-d'), // Utilisation de la date calculée
                'data-min-age' => $minAge, // Pour validation JS supplémentaire
                'data-max-age' => $maxAge, // Pour validation JS supplémentaire
                'data-validation' => 'birthdate'
            ],
            'auto_initialize' => false,
            'constraints' => [
                new NotBlank([
                    'message' => 'La date de naissance est obligatoire.'
                ]),
                new LessThanOrEqual([
                    'value' => $maxDate,
                    'message' => sprintf('L\'enfant doit avoir au moins %d ans.', $minAge)
                ]),
                new GreaterThanOrEqual([
                    'value' => $minDate,
                    'message' => sprintf('L\'enfant doit avoir moins de %d ans.', $maxAge)
                ])
            ],
            'invalid_message' => 'Veuillez entrer une date valide (format: AAAA-MM-JJ)',
        ])
            ->add('dateExtrait', DateType::class, [
                'label' => 'Date / Extrait',
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datepicker',
                    'min' => $minDate->format('Y-m-d'), // Utilisation de la date calculée
                    'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                ],
                'auto_initialize' => false,
                'constraints' => [
                    new NotBlank,
                    //new Constraints\DateTime(),
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
        ;
    }

    public function addDateRecrutementField(FormInterface $form, ?Niveaux $niveaux)
    {
        // Récupération et validation des âges
        $minAge = $niveaux ? max(0, $niveaux->getMaxDate()) : 1; // Au moins 0
        $maxAge = $niveaux ? max($minAge + 1, $niveaux->getMinDate()) : $minAge + 1; // Toujours > minAge

        // Calcul des dates limites
        $now = new \DateTimeImmutable();
        $minDate = $now->modify("-{$maxAge} years");
        $maxDate = $now->modify("-{$minAge} years");

        $form->add('dateRecrutement', DateType::class, [
            'label' => 'Date de recrutement',
            'input' => 'datetime_immutable',
            'widget' => 'single_text',
            'html5' => true,
            'format' => 'yyyy-MM-dd',
            'attr' => [
                'class' => 'form-control datepicker',
                'min' => $minDate->format('Y-m-d'), // Utilisation de la date calculée
                'max' => $maxDate->format('Y-m-d'), // Utilisation de la date calculée
                'data-min-age' => $minAge, // Pour validation JS supplémentaire
                'data-max-age' => $maxAge, // Pour validation JS supplémentaire
                'data-validation' => 'birthdate'
            ],
            'auto_initialize' => false,
            'constraints' => [
                new NotBlank([
                    'message' => 'La date de naissance est obligatoire.'
                ]),
                new LessThanOrEqual([
                    'value' => $maxDate,
                    'message' => sprintf('L\'enfant doit avoir au moins %d ans.', $minAge)
                ]),
                new GreaterThanOrEqual([
                    'value' => $minDate,
                    'message' => sprintf('L\'enfant doit avoir moins de %d ans.', $maxAge)
                ])
            ],
            'invalid_message' => 'Veuillez entrer une date valide (format: AAAA-MM-JJ)',
        ])
            ->add('dateInscription', DateType::class, [
                'label' => 'Date d\'inscription',
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datepicker',
                    'min' => $minDate->format('Y-m-d'), // Utilisation de la date calculée
                    'max' => (new \DateTime('now -1 days'))->format('Y-m-d')
                ],
                'auto_initialize' => false,
                'constraints' => [
                    new NotBlank,
                    //new Constraints\DateTime(),
                    new Callback(function ($object, ExecutionContextInterface $context) {
                        $dateNaissance = $context->getRoot()->getData()->getDateNaissance();
                        $dateExtrait = $object;

                        if (is_a($dateNaissance, \DateTime::class) && is_a($dateExtrait, \DateTime::class)) {
                            if ($dateExtrait->format('U') - $dateNaissance->format('U') < 0) {
                                $context
                                    ->buildViolation("date d'inscription Incorrecte")
                                    ->addViolation();
                            }
                        }
                    }),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class
        ]);
    }
}
