<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'details',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'details' => 'array', // Cast the details column as an array
    ];
}
