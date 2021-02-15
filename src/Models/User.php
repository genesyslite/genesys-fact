<?php

namespace GenesysLite\GenesysFact\Models;

use \App\Models\User as UserModel;

class User extends UserModel
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'establishment_id',
    ];

}