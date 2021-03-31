<?php

namespace Tests;

class TestsData {

    public static function  user () :array
    {
      return   [
                    'name' => 'John Doe',
                    'email' => 'johndoe@gmail.com',
                    'password' => 'password',
                    'business_name' => 'Invent',
                    'business_description' => 'Sales of goods and services'
                ];
    }
}
