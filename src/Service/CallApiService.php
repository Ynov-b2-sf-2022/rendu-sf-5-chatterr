<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function callApi(): array
    {
        $response = $this->client->request(
            'GET',
            'https://random-username-generate.p.rapidapi.com/?locale=fr_FR&minAge=18&maxAge=50&domain=ugener.com',
            ['headers' => [
                'X-Rapidapi-Key' => '2cc2fb092dmsh6e2fabece3b1c10p1b6873jsnb6ca444b0ca2',
            ],]

        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }
}