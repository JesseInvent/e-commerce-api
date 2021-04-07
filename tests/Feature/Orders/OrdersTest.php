<?php

namespace Tests\Feature\Orders;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\Helpers\Assertions;
use Tests\TestCase;
use Tests\UserActions;

class OrdersTest extends TestCase
{
    use RefreshDatabase, Assertions, UserActions;

    /** @test */
    public function a_user_can_order_a_product()
    {
        $this->withoutExceptionHandling();
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $response = $this->attempt_to_order_a_product();

        // Assertions
        $response->assertStatus(Response::HTTP_CREATED);
        $this->AssertThatModelWasCreated(Order::class);

    }

    /** @test */
    public function an_owner_of_a_product_or_order_creator_can_get_an_order_for_a_product()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_order_a_product();
        $response = $this->attempt_to_get_an_order();

        // Assertions
        $response->assertStatus(Response::HTTP_OK);
        $this->AssertThatResponseBodyWasReturned($response);

    }

    /** @test */
    public function an_owner_of_a_product_or_order_creator_can_delete_an_order()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_order_a_product();
        $response = $this->attempt_to_delete_an_order();

        // Assertions
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->AssertThatNoModelWasCreated(Order::class);
    }


    /** @test */
    public function an_owner_of_a_product_can_get_orders_for_a_product()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_order_a_product();
        $this->attempt_to_order_a_product();
        $response = $this->attempt_to_product_orders();

        // Assertions
        $response->assertStatus(Response::HTTP_OK);
        $this->AssertThatResponseBodyWasReturned($response);
    }


}
