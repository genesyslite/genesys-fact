<?php

namespace App\Models\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoapSend extends Model
{
    use HasFactory, UsesTenantConnection;

    public $incrementing = false;
    public $timestamps = false;
}
