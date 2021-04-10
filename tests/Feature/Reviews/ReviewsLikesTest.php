<?php

namespace Tests\Feature\Reviews;

use Tests\TestCase;
use Tests\UserActions;
use App\Models\ReviewLike;
use Tests\Helpers\Assertions;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewsLikesTest extends TestCase
{
    use UserActions, RefreshDatabase, Assertions;

    protected function perform_review_like()
    {
        $this->attempt_to_signup_and_create_a_product();
        $this->attempt_to_review_a_product();
        $response = $this->attempt_to_like_a_review();
        return $response;
    }

    /** @test */
    public function an_authenticated_user_can_like_a_review ()
    {

        //Act
        $response = $this->perform_review_like();

        //Assertions
        $response->assertStatus(Response::HTTP_CREATED);
        $this->AssertThatModelWasCreated(ReviewLike::class);
        $this->AssertThatANotificationForUserWasCreated();
    }


    /** @test */
    public function an_authenticated_user_cannot_like_a_review_twice ()
    {
        //Act
        $this->perform_review_like();
        $response = $this->attempt_to_like_a_review();

        //Assertions
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->AssertThatErrorExists($response);
    }


    /** @test */
    public function an_authenticated_user_can_unliked_a_review_liked_by_that_user ()
    {
        //Act
        $this->perform_review_like();
        $response = $this->attempt_to_unlike_a_review();


        //Assertions
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->AssertThatReviewWasUnliked();
    }

}
