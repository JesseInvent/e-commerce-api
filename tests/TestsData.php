<?php

namespace Tests;

class TestsData {

    public static function  user() :array
    {
      return   [
                    'name' => 'John Doe',
                    'email' => 'johndoe@gmail.com',
                    'password' => 'password',
                    'business_name' => 'Invent',
                    'business_description' => 'Sales of goods and services'
                ];
    }

    public static function product() :array
    {
        return [
            'name' => 'product 1',
            'images' => '/path/image.jpeg',
            'price' => 299.54,
            'description' => 'product 1 description'
        ];
    }


    public static function updateProduct() :array
    {
        return [
            'name' => 'updated product name',
            'images' => '/path/image.jpeg',
            'price' => 499.54,
            'description' => 'product 1 description'
        ];
    }

    public static function review() :array
    {
        return [
            'body' => 'Nice product'
        ];
    }

    public static function updateReview() :array
    {
        return [
            'body' => 'Updated Review'
        ];
    }
}
