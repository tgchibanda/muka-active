<?php

namespace App\Models\Api;

class Customer extends \App\Models\Customer
{
    protected $fillable = ['first_name', 'last_name', 'phone', 'status',];
}
