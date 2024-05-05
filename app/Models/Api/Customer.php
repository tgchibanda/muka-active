<?php

namespace App\Models\Api;

class Customer extends \App\Models\Customer
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
