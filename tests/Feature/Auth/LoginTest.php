<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\Helpers\Assertions;
use Tests\TestCase;
use Tests\UserActions;

class LoginTest extends TestCase
{
    use RefreshDatabase, UserActions, Assertions;

    /** @test */
    public function user_can_successfully_login_with_valid_details ()
    {
        // Act
        $this->attempt_user_signup();
        $response = $this->attempt_user_login();

        // Assertions
        $response->assertStatus(Response::HTTP_OK);
        $this->assertNotNull(auth()->user());
        $this->AssertThatTokenWasReturned($response);
    }

    /** @test */
    public function user_cannot_successfully_login_with_invalid_details ()
    {
        $this->withoutExceptionHandling();

        // Act
        $this->attempt_user_signup();
        $response = $this->attempt_user_invalid_login();

        // Assertions
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $this->assertNull(auth()->user());
        $this->assertNotNull($response->getData()->error);
        $this->assertEquals($response->getData()->error, 'Unauthorized');
    }

}
