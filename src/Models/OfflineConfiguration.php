<?php

namespace GenesysLite\GenesysFact\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_client',
        'token_server',
        'url_server',
    ];
}
