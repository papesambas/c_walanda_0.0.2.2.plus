<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenAIService
{
    private string $apiKey;
    private HttpClientInterface $httpClient;

    /*public function __construct(string $apiKey, HttpClientInterface $httpClient)
    {
        #$this->apiKey = $apiKey; // Correction ici
        $this->httpClient = $httpClient;
    }*/

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function sendRequest(string $message): array
    {
        $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4', // Assurez-vous que ce modèle est disponible pour votre clé API
                'messages' => [['role' => 'user', 'content' => $message]],
                'temperature' => 0.7,
            ],
        ]);

        return $response->toArray();
    }
}