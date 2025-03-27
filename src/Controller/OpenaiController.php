<?php

namespace App\Controller;

use App\Service\OpenAIService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OpenaiController extends AbstractController
{
    private OpenAIService $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    

    #[Route('/openai', name: 'openai_index')]
    public function index(): Response
    {
        $message = "Qu'est-ce que Symfony ?";
        $response = $this->openAIService->sendRequest($message);

        return $this->json($response);
    }
}
