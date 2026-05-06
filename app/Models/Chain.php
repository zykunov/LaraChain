<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chain extends Model
{
    protected $fillable = [
        'chain',
    ];

    protected $casts = [
        'chain' => 'array',
    ];
}
