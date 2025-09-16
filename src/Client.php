<?php

declare(strict_types=1);

namespace Verbania\SDK;

class Client
{
    private string $apiKey;
    private string $baseUrl;

    public function __construct(string $apiKey, string $baseUrl = 'https://api.verbania.dev')
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function request(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
        
        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_POSTFIELDS => !empty($data) ? json_encode($data) : null,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false) {
            throw new \RuntimeException('Request failed');
        }

        $decodedResponse = json_decode($response, true);
        
        if ($httpCode >= 400) {
            throw new \RuntimeException('API Error: ' . ($decodedResponse['message'] ?? 'Unknown error'));
        }

        return $decodedResponse ?? [];
    }
}