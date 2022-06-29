<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagSeguroPagtoLink extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'link',
        'pagseguro_pagto_id',
        'user_id',
    ];
}
