<?php

namespace Tests;

use App\Models\Order;
use App\Models\Product;
use App\Models\Reply;
use App\Models\Review;
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

    public function attempt_to_logout()
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
        return $this->sendPatchRequest('/api/product/'.Product::first()->id, TestsData::updateProduct());
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

    public function attempt_to_like_a_product()
    {
        return $this->sendPostRequest('/api/product/'.Product::first()->id.'/like', []);
    }

    public function attempt_to_unlike_a_product()
    {
        return $this->sendDeleteRequest('/api/product/'.Product::first()->id.'/like', []);
    }

    // Reviews
    public function attempt_to_review_a_product()
    {
        return $this->sendPostRequest('/api/product/'.Product::first()->id.'/review', TestsData::review());
    }

    public function attempt_to_review_a_product_without_review_message()
    {
        return $this->sendPostRequest('/api/product/'.Product::first()->id.'/review', []);
    }

    public function attempt_to_update_a_review()
    {
        return $this->sendPatchRequest('/api/review/'.Review::first()->id, TestsData::updateReview());
    }

    public function attempt_to_delete_a_review()
    {
        return $this->sendDeleteRequest('/api/review/'.Review::first()->id);
    }

    public function attempt_to_get_all_reviews_of_a_product()
    {
        return $this->sendGetRequest('/api/product/'.Product::first()->id.'/review');
    }

    public function attempt_to_get_a_review()
    {
        return $this->sendGetRequest('/api/review/'.Review::first()->id);
    }

    public function attempt_to_like_a_review()
    {
        return $this->sendPostRequest('/api/review/'.Review::first()->id.'/like', []);
    }

    public function attempt_to_unlike_a_review()
    {
        return $this->sendDeleteRequest('/api/review/'.Review::first()->id.'/like');
    }

    // Replies
    public function attempt_to_reply_a_review()
    {
        return $this->sendPostRequest('/api/review/'.Review::first()->id.'/reply', TestsData::reviewReply());
    }

    public function attempt_to_get_a_reply()
    {
        return $this->sendGetRequest('/api/reply/'.Reply::first()->id);
    }

    public function attempt_to_edit_a_reply()
    {
        return $this->sendPatchRequest('/api/reply/'.Reply::first()->id, TestsData::reviewUpdateReply());
    }

    public function attempt_to_delete_a_reply()
    {
        return $this->sendDeleteRequest('/api/reply/'.Reply::first()->id);
    }

    // Orders
    public function attempt_to_order_a_product()
    {
        return $this->sendPostRequest('/api/product/'.Product::first()->id.'/order', TestsData::orderProduct());
    }

    public function attempt_to_get_product_orders()
    {
        return $this->sendGetRequest('/api/product/'.Product::first()->id.'/order');
    }

    public function attempt_to_get_an_order()
    {
        return $this->sendGetRequest('/api/order/'.Order::first()->id);
    }

    public function attempt_to_delete_an_order()
    {
        return $this->sendDeleteRequest('/api/order/'.Order::first()->id);
    }

    public function attempt_to_accept_product_order()
    {
        return $this->sendPostRequest('/api/order/'.Order::first()->id.'/accept', []);
    }

    public function attempt_to_reject_product_order()
    {
        return $this->sendPostRequest('/api/order/'.Order::first()->id.'/reject', []);
    }
}
