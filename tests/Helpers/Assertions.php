<?php

namespace Tests\Helpers;

use Illuminate\Support\Facades\DB;

trait Assertions
{

    public function AssertThatResponseIsJSON($response)
    {
        return $this->assertIsObject($response);
    }


    public function AssertThatModelWasCreated($model)
    {
        return $this->assertCount(1, $model::all());
    }

    // public function AssertThatTokenWasReturned($responseData)
    // {
    //     return $this->assertNotNull($responseData->access_token);
    // }

    public function AssertThatNoModelWasCreated($model)
    {
        return $this->assertCount(0, $model::all());
    }

    public function AssertThatUserIsLoggedIn()
    {
        return $this->assertNotNull(auth()->user());
    }

    public function AssertThatUserIsNotLoggedIn()
    {
        return $this->assertNull(auth()->user());
    }

    protected function AssertThatTokenWasReturned($response)
    {
        return $this->assertNotNull($response->getData()->token);
    }

    protected function AssertThatErrorExists($response)
    {
        return $this->assertNotNull($response->getData()->errors);
    }

    protected function AssertThatPostWasLiked()
    {
        return $this->assertEquals(\App\Models\ProductLike::where('user_id', auth()->user()->id)->count(), 1);
    }

    protected function AssertThatProductWasUnLiked()
    {
        return $this->assertEquals(\App\Models\ProductLike::where('user_id', auth()->user()->id)->count(), 0);
    }

    protected function AssertThatReviewWasUnLiked()
    {
        return $this->assertEquals(\App\Models\ReviewLike::where('user_id', auth()->user()->id)->count(), 0);
    }

    protected function AssertThatResponseBodyWasReturned($response)
    {
        return $this->assertNotNull($response->getData());

    }

    protected function AssertThatANotificationForUserWasCreated()
    {
        return $this->assertEquals(DB::table('notifications')->first()->notifiable_id, auth()->user()->id);
    }

}
