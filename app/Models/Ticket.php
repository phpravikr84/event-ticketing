<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Ticket Model
class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'type', 'price', 'quantity'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}