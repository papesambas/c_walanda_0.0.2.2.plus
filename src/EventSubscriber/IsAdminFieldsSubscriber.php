<?php

namespace App\EventSubscriber;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class IsAdminFieldsSubscriber implements EventSubscriberInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        ];
    }

    public function onPreSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $user = $this->security->getUser();

        // Vérifier si l'utilisateur a le rôle requis
        $isAdmin = $this->security->isGranted('ROLE_ADMIN') || 
                   $this->security->isGranted('ROLE_SUPER_ADMIN') || 
                   $this->security->isGranted('ROLE_DIRECTION');

        if ($isAdmin) {
            $form->add('isAllowed', CheckboxType::class, [
                'label' => 'Autorisé(e)',
                //'disabled' => true, // Désactiver si l'utilisateur n'a pas les rôles requis
                //'help' => 'Cochez cette case si l\'élément est autorisé(e).',
                'attr' => ['class' => 'custom-checkbox'],
                'label_attr' => ['class' => 'custom-checkbox label'],
                'required' => false, // Ne pas forcer pour éviter des erreurs
            ])
            ->add('isAdmis', CheckboxType::class, [
                'label' => 'Admis(e)',
                //'disabled' => true, // Désactiver si l'utilisateur n'a pas les rôles requis
                //'help' => 'Cochez cette case si l\'élément est admis(e).',
                'attr' => ['class' => 'custom-checkbox'],
                'label_attr' => ['class' => 'custom-checkbox label'],
                'required' => false, // Ne pas forcer pour éviter des erreurs
            ]);
        }
    }
}
