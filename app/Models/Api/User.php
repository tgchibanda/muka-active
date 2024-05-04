<?php

namespace App\Models\Api;

class User extends \App\Models\User
{
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
