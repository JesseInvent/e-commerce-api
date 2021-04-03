<?php

namespace Tests\Feature\Products;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Helpers\Assertions;
use Tests\TestCase;
use Tests\UserActions;

class ProductsLikeTest extends TestCase
{
    use RefreshDatabase, UserActions, Assertions;

    /** @test */
    public function an_authenticated_user_can_like_a_product()
    {
        // Arrange

        // Act
       
    }
}
