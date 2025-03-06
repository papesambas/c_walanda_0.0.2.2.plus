<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GestFinController extends AbstractController
{
    #[Route('/gest/fin', name: 'app_gest_fin')]
    public function index(): Response
    {
        return $this->render('gest_fin/index.html.twig', [
            'controller_name' => 'GestFinController',
        ]);
    }
}
