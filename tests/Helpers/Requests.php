<?php

namespace Tests\Helpers;

trait Requests {

    protected function defaultHeaders() :array
    {
        return [
            'Accept' => 'application/json',
        ];

    }

    protected function getRequestHeaders($token)
    {
        (!$token) ? $headers = $this->defaultHeaders() : $headers =  array_merge($this->defaultHeaders(), [
            'Authorization' => "Bearer {$token}"
        ]);

        return $headers;

    }

    public function sendGetRequest(string $uri, string $token = null)
    {
        return $this->withHeaders($this->getRequestHeaders($token))
                    ->get($uri);

    }

    public function sendPostRequest(string $uri, array $data, string $token = null)
    {
        return $this->withHeaders($this->getRequestHeaders($token))
                    ->post($uri, $data);
    }

    public function sendPatchRequest(string $uri, array $data, string $token = null)
    {
        return $this->withHeaders($this->getRequestHeaders($token))
                    ->patch($uri, $data);
    }

    public function sendDeleteRequest(string $uri, string $token = null)
    {
        return $this->withHeaders($this->getRequestHeaders($token))
                    ->delete($uri);

    }

}
