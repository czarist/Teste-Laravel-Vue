<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PagSeguroPagtoLink extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'link',
        'pagseguro_pagto_id',
        'user_id'
    ];
}
