<?php

namespace GenesysLite\GenesysFact\Models;

use GenesysLite\GenesysBusiness\Models\Establishment;
use GenesysLite\GenesysCatalog\Models\DocumentType;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User as UserModel;

class User extends UserModel
{
    protected $table = 'series';

    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'establishment_id',
    ];

}