<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
