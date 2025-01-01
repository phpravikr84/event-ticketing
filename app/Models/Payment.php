<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Payment Model
class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'user_id', 'ticket_id', 'booking_quantity', 'amount', 'status'];

    // public function event()
    // {
    //     return $this->belongsTo(Event::class);
    // }
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    
}
