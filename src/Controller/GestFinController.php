<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class GestFinController extends AbstractController
{
    #[Route('/gest/fin', name: 'app_gest_fin')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(): Response
    {
        return $this->render('gest_fin/index.html.twig', [
            'controller_name' => 'GestFinController',
        ]);
    }
}
