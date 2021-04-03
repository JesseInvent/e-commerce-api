<?php

namespace Tests\Feature\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\Helpers\Assertions;
use Tests\TestCase;
use Tests\UserActions;

class ProductsLikeTest extends TestCase
{
    use RefreshDatabase, UserActions, Assertions;

    protected function perform_product_like()
    {
        $this->attempt_to_signup_and_create_a_product();
        $response = $this->attempt_to_like_a_product();
        return $response;

    }

    protected function perform_product_unlike()
    {
        $this->attempt_to_signup_and_create_a_product();
        $response = $this->attempt_to_unlike_a_product();
        return $response;

    }

    /** @test */
    public function an_authenticated_user_can_like_a_product()
    {
        // Act
        $response = $this->perform_product_like();

        // Assertions
        $response->assertStatus(Response::HTTP_CREATED);
        $this->AssertThatPostWasLiked();

    }

    /** @test */
    public function user_cant_like_a_product_twice()
    {
        // Act
        $this->perform_product_like();
        $response = $this->attempt_to_like_a_product();

        // Assertions
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->AssertThatErrorExists($response);

    }

    /** @test */
    public function user_can_unlike_a_product_liked_by_user()
    {
        $this->withoutExceptionHandling();

        // Act
        $this->perform_product_like();
        $response = $this->attempt_to_unlike_a_product();

        // Assertions
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->AssertThatPostWasUnLiked();

    }

}
