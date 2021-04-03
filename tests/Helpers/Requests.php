<?php

namespace Tests\Helpers;

trait Requests {

    public $token;

    protected function defaultHeaders() :array
    {
        return [
            'Accept' => 'application/json',
        ];

    }

    protected function getRequestHeaders()
    {
        (!$this->token && $this->token !== '') ? $headers = $this->defaultHeaders() : $headers =  array_merge($this->defaultHeaders(), [
            'Authorization' => "Bearer {$this->token}"
        ]);

        return $headers;

    }

    public function sendGetRequest(string $uri)
    {
        return $this->withHeaders($this->getRequestHeaders())
                    ->get($uri);

    }

    public function sendPostRequest(string $uri, array $data)
    {
        return $this->withHeaders($this->getRequestHeaders())
                    ->post($uri, $data);
    }

    public function sendPatchRequest(string $uri, array $data)
    {
        return $this->withHeaders($this->getRequestHeaders())
                    ->patch($uri, $data);
    }

    public function sendDeleteRequest(string $uri)
    {
        return $this->withHeaders($this->getRequestHeaders())
                    ->delete($uri);

    }

}
