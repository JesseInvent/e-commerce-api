<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\UserActions;

class UserTest extends TestCase
{
    use RefreshDatabase, UserActions;

    /** @test */
    public function an_authenticated_user_can_get_user_details()
    {
        // Act
        $this->attempt_user_signup();
        $response = $this->attempt_to_get_user();

        // Assertion
        $response->assertStatus(Response::HTTP_ACCEPTED);
        $this->assertNotNull($response->getData());

    }


    /** @test */
    public function an_unAuthenticated_user_cannot_get_user_details()
    {
        // Act
        $this->attempt_user_signup();
        $response = $this->attempt_to_get_user_without_token();

        // Assertion
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    }

    /** @test */
    public function an_authenticated_user_can_log_out_by_deleting_token()
    {
        // Act
        $this->attempt_user_signup();
        $response = $this->attempt_to_logout();

        // Assertion
        $response->assertStatus(Response::HTTP_NO_CONTENT);

    }
}
