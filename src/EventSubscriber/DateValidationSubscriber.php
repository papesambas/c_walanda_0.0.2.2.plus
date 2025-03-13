<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormError;

class DateValidationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            // L'événement POST_SUBMIT est déclenché après la soumission du formulaire
            FormEvents::POST_SUBMIT => 'validateDates',
        ];
    }

    public function validateDates(FormEvent $event): void
    {
        $form = $event->getForm();

        // Validation de la date d'extrait par rapport à la date de naissance
        if ($form->has('dateExtrait') && $form->has('dateNaissance')) {
            $dateExtrait = $form->get('dateExtrait')->getData();
            $dateNaissance = $form->get('dateNaissance')->getData();

            if ($dateExtrait instanceof \DateTime && $dateNaissance instanceof \DateTime) {
                if ($dateExtrait <= $dateNaissance) {
                    $form->get('dateExtrait')->addError(
                        new FormError("La date d'extrait doit être postérieure à la date de naissance.")
                    );
                }
            }
        }

        // Validation de la date d'inscription par rapport à la date de recrutement
        if ($form->has('dateInscription') && $form->has('dateRecrutement')) {
            $dateInscription = $form->get('dateInscription')->getData();
            $dateRecrutement = $form->get('dateRecrutement')->getData();

            if ($dateInscription instanceof \DateTime && $dateRecrutement instanceof \DateTime) {
                if ($dateInscription <= $dateRecrutement) {
                    $form->get('dateInscription')->addError(
                        new FormError("La date d'inscription doit être postérieure à la date de recrutement.")
                    );
                }
            }
        }
    }
}
