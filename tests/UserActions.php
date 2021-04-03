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
        $response = $this->sendPostRequest('/api/auth/signup', TestsData::user());
        $this->token = $response->getData()->token;
        return $response;
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
    public function attempt_to_get_user()
    {
        return $this->sendGetRequest('/api/auth/me');
    }

    public function attempt_to_get_user_without_token()
    {
        $this->token = '';
        return $this->sendGetRequest('/api/auth/me');
    }

    public function attempt_to_logout_with_token()
    {
        return $this->sendPostRequest('/api/auth/logout', []);
    }


    // Product Actions

    public function attempt_to_create_product_as_authenticated_user()
    {
        return $this->sendPostRequest('/api/product', TestsData::product());
    }

    public function attempt_to_create_product_as_authenticated_user_with_missing_field()
    {
        return $this->sendPostRequest('/api/product', array_merge(TestsData::product(), ['name' => '']));
    }

    public function attempt_to_update_a_product()
    {
        return $this->sendPatchRequest('/api/product/'.Product::first()->id, TestsData::updatedProduct());
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


    public function attempt_to_signup_and_create_a_product()
    {
        $this->attempt_user_signup();
        $response = $this->attempt_to_create_product_as_authenticated_user();
        return $response;
    }

    public function attempt_to_signup_and_create_multiple_products()
    {
        $this->attempt_to_signup_and_create_a_product();
        $response = $this->attempt_to_create_product_as_authenticated_user();
        return $response;
    }

}
