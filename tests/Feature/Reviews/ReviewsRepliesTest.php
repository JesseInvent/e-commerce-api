<?php

namespace Tests\Feature\Reviews;

use Tests\TestCase;
use Tests\TestsData;
use App\Models\Reply;
use App\Models\Review;
use Tests\UserActions;
use Tests\Helpers\Assertions;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewsRepliesTest extends TestCase
{
    use RefreshDatabase, UserActions, Assertions;

    /** @test */
    public function a_creator_of_a_product_can_reply_a_review()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_review_a_product();
        $response = $this->attempt_to_reply_a_review();

        // Assertions
        $response->assertStatus(Response::HTTP_CREATED);
        $this->AssertThatModelWasCreated(Reply::class);
    }


    /** @test */
    public function a_creator_of_a_product_can_get_a_reply()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_review_a_product();
        $this->attempt_to_reply_a_review();
        $response = $this->attempt_to_get_a_reply();

        // Assertions
        $response->assertStatus(Response::HTTP_OK);
        $this->assertNotNull($response->getData());
    }

    /** @test */
    public function a_creator_of_a_product_can_edit_a_reply()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_review_a_product();
        $this->attempt_to_reply_a_review();
        $response = $this->attempt_to_edit_a_reply();

        // Assertions
        $response->assertStatus(Response::HTTP_ACCEPTED);
        $this->AssertThatModelWasCreated(Reply::class);
        $this->assertEquals(Reply::first()->body, TestsData::reviewUpdateReply()['body']);
    }


    /** @test */
    public function a_creator_of_a_product_can_delete_a_reply()
    {
        // Act
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_review_a_product();
        $this->attempt_to_reply_a_review();
        $response = $this->attempt_to_delete_a_reply();

        // Assertions
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->AssertThatNoModelWasCreated(Reply::class);
    }

}
