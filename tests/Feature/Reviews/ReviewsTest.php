<?php

namespace Tests\Feature\Reviews;

use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\Helpers\Assertions;
use Tests\TestCase;
use Tests\TestsData;
use Tests\UserActions;

class ReviewsTest extends TestCase
{
    use RefreshDatabase, UserActions, Assertions;

   /** @test */
   public function an_authenticated_user_can_review_a_product()
   {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $response = $this->attempt_to_review_a_product();

        // Arrange
        $response->assertStatus(Response::HTTP_CREATED);
        $this->AssertThatModelWasCreated(Review::class);
   }

    /** @test */
    public function an_authenticated_user_cannot_review_a_product_without_a_review_message()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $response = $this->attempt_to_review_a_product_without_review_message();

        // Arrange
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->AssertThatNoModelWasCreated(Review::class);
    }

    /** @test */
    public function an_authenticated_user_and_owner_of_review_can_update_a_review_message()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_review_a_product();
        $response = $this->attempt_to_update_a_review();

        // Arrange
        $response->assertStatus(Response::HTTP_ACCEPTED);
        $this->AssertThatModelWasCreated(Review::class);
        $this->assertEquals(Review::first()->body, TestsData::updateReview()['body']);
    }

    /** @test */
    public function an_authenticated_user_and_owner_of_a_review_can_delete_a_review()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_review_a_product();
        $response = $this->attempt_to_delete_a_review();

        // Arrange
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->AssertThatNoModelWasCreated(Review::class);
    }

    /** @test */
    public function an_authenticated_user_can_get_all_product_reviews()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_review_a_product();
        $this->attempt_to_review_a_product();
        $this->attempt_to_review_a_product();
        $response = $this->attempt_to_get_all_reviews_of_a_product();

        // Arrange
        $response->assertStatus(Response::HTTP_OK);
        $this->assertNotNull($response->getData());
    }

    /** @test */
    public function an_authenticated_user_can_get_a_review()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_review_a_product();
        $response = $this->attempt_to_get_a_review();

        // Arrange
        $response->assertStatus(Response::HTTP_OK);
        $this->assertNotNull($response->getData());
    }

}
