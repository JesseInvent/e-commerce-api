<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Tests\UserActions;
use Tests\Helpers\Assertions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestsData;

class SignupTest extends TestCase
{
    use RefreshDatabase, UserActions, Assertions;

    protected function AssertThatPasswordWasHashed($userPassword)
    {
        return $this->assertNotEquals(User::first()->password, $userPassword);
    }

   /** @test */
   public function a_user_can_signup_successfully()
   {
       //Arrange
       $data = new TestsData;

        // Act
       $response = $this->attempt_user_signup();

       // Assertions
       $response->assertStatus(200);
       $this->AssertThatModelWasCreated(User::class);
       $this->AssertThatPasswordWasHashed($data::user()['password']);
       $this->AssertThatTokenWasReturned($response);
   }

   /** @test */
   public function a_user_cannot_signup_with_missing_details()
   {
       //Arrange
       $data = new TestsData;

       // Act
       $response = $this->attempt_user_invalid_signup();

       // Assertions
       $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
       $this->AssertThatNoModelWasCreated(User::class);
       $this->AssertThatErrorExists($response);
   }

}
