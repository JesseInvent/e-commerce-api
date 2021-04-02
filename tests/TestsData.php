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
            'name' => 'Product 1',
            'images' => '/path/image.jpeg',
            'description' => 'product 1 description'
        ];
    }


    public static function updatedProduct() :array
    {
        return [
            'name' => 'updated product name',
            'images' => '/path/image.jpeg',
            'description' => 'product 1 description'
        ];
    }
}
