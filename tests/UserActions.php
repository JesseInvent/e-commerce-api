<?php

namespace Tests;

use App\Models\Product;
use App\Models\User;
use Tests\Helpers\Requests;

trait UserActions {

    use Requests;

    // Auth Actions

    public function attempt_user_signup()
    {
        return $this->sendPostRequest('/api/auth/signup', TestsData::user());
    }

    public function attempt_user_invalid_signup()
    {
        return $this->sendPostRequest('/api/auth/signup', array_merge(TestsData::user(), ['email' => '']));
    }

    public function attempt_user_login()
    {
        return $this->sendPostRequest('/api/auth/login', [
            'email' => TestsData::user()['email'],
            'password' => TestsData::user()['password'],
        ]);
    }

    public function attempt_user_invalid_login()
    {
        return $this->sendPostRequest('/api/auth/login', [
            'email' => TestsData::user()['email'],
            'password' => 'wrongPassword',
        ]);
    }

    // User Actions
    public function attempt_to_get_user($token)
    {
        return $this->sendGetRequest('/api/auth/me', $token);
    }


    public function attempt_to_logout_with_token(string $token)
    {
        return $this->sendPostRequest('/api/auth/logout', [], $token);
    }


    // Product Actions

    public function attempt_to_create_product_as_authenticated_user(string $token)
    {
        return $this->sendPostRequest('/api/product', TestsData::product(), $token);
    }

    public function attempt_to_create_product_as_authenticated_user_with_missing_field(string $token)
    {
        return $this->sendPostRequest('/api/product', array_merge(TestsData::product(), ['name' => '']), $token);
    }

    public function attempt_to_update_a_product(string $token)
    {
        return $this->sendPatchRequest('/api/product/'.Product::first()->id, TestsData::updatedProduct(), $token);
    }

    public function attempt_to_get_all_products()
    {
        return $this->sendGetRequest('/api/product');
    }

    public function attempt_to_get_a_product()
    {
        return $this->sendGetRequest('/api/product/'.Product::first()->id);
    }

    public function attempt_to_delete_a_product()
    {
        return $this->sendDeleteRequest('/api/product/'.Product::first()->id);
    }

    public function attempt_product_search()
    {
        return $this->sendGetRequest('/api/product/search?search=product');
    }

}
