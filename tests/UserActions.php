<?php

namespace Tests;

trait UserActions {

    protected function requestHeaders () :array
    {
        return [
            'Accept' => 'application/json',
        ];

    }

    protected function sendPostRequest(string $uri, array $data)
    {
        return $this->withHeaders($this->requestHeaders())
                    ->post($uri, $data);
    }

    // protected function sendPatchRequest(string $uri, string $data)
    // {
    //     return $this->withHeaders($this->requestHeaders())
    //                 ->patch($uri, $data);

    // }

    public function attempt_user_signup()
    {
        return $this->sendPostRequest('/api/auth/signup', TestsData::user());
    }

    public function attempt_user_invalid_signup()
    {
        return $this->sendPostRequest('/api/auth/signup', array_merge(TestsData::user(), ['email' => '']));
    }
}
