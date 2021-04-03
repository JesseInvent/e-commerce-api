<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\Helpers\Assertions;
use Tests\TestCase;
use Tests\TestsData;
use Tests\UserActions;

class ProductsTest extends TestCase
{
    use RefreshDatabase, UserActions, Assertions;

   /** @test */
    public function an_authenticated_user_can_create_a_product_with_valid_fields ()
    {
        $this->withoutExceptionHandling();

        // Arrange
        $data = new TestsData;

        // Act
        $response = $this->attempt_to_signup_and_create_a_product_and_return_response_object();

        // Assertions
        $response->assertStatus(Response::HTTP_CREATED);
        $this->AssertThat_Model_WasCreated(Product::class);
    }


    /** @test */
    public function an_authenticated_user_cannot_create_a_product_with_invalid_fields ()
    {
        // Arrange
        $data = new TestsData;

        // Act
        $token = $this->attempt_to_signup_and_return_token();
        $response = $this->attempt_to_create_product_as_authenticated_user_with_missing_field($token);

        // Assertions
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->Assert_That_No_Model_Was_Created(Product::class);
        $this->AssertThatErrorExists($response);
    }


   /** @test */
   public function an_unAuthenticated_user_cannot_create_a_product ()
   {

       // Arrange
       $data = new TestsData;

       // Act
       $response = $this->attempt_to_create_product_as_authenticated_user('');

       // Assertions
       $response->assertStatus(Response::HTTP_UNAUTHORIZED);
       $this->Assert_That_No_Model_Was_Created(Product::class);
    }

    /** @test */
    public function an_authenticated_user_can_update_a_product_with_valid_fields ()
    {

        // Arrange
        $data = new TestsData;

        // Act
        $token = $this->attempt_to_signup_and_create_a_product_then_return_token();
        $response = $this->attempt_to_update_a_product($token);

        // Assertions
        $response->assertStatus(Response::HTTP_ACCEPTED);
        $this->AssertThat_Model_WasCreated(Product::class);
        $this->assertEquals($data::updatedProduct()['name'], Product::first()->name);

    }

    /** @test */
    public function user_can_get_all_products ()
    {

        // Arrange
        $data = new TestsData;

        // Act
        $this->attempt_to_signup_and_create_multiple_products();
        $response = $this->attempt_to_get_all_products();

        // Assertions
        $response->assertStatus(Response::HTTP_OK);
        $this->assertNotNull($response->getData());

    }

    /** @test */
    public function user_can_get_a_product ()
    {

        // Arrange
        $data = new TestsData;

        // Act
        $this->attempt_to_signup_and_create_multiple_products();
        $response = $this->attempt_to_get_a_product();

        // Assertions
        $response->assertStatus(Response::HTTP_OK);
        $this->assertNotNull($response->getData());

    }

    /** @test */
    public function an_authenticated_user_can_delete_a_product ()
    {
        // Arrange
        $data = new TestsData;

        // Act
        $token = $this->attempt_to_signup_and_create_a_product_then_return_token();
        $response = $this->attempt_to_delete_a_product($token);

        // Assertions
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertNull(Product::first());
    }


    /** @test */
    public function user_can_search_a_product ()
    {
        $this->withoutExceptionHandling();
        // Arrange
        $data = new TestsData;

        // Act
        $this->attempt_to_signup_and_create_a_product_and_return_response_object();
        $response = $this->attempt_product_search();

        // Assertions
        $response->assertStatus(Response::HTTP_ACCEPTED);
        $this->assertNotNull($response->getData());
    }

}

