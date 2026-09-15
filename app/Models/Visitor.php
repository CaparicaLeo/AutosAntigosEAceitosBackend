<?php

namespace App\Models;

use Database\Factories\VisitorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    /** @use HasFactory<VisitorFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone_number', 'additional_visitors',
    ];

    protected $casts = [
        'additional_visitors' => 'array',
    ];
}
