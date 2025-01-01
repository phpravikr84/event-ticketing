<?php

// Event Model
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'event_date' => 'datetime',
    ];

    protected $fillable = ['organizer_id', 'title', 'description', 'event_date', 'location', 'ticket_availability'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendee::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }


    protected static function booted()
    {
        static::deleting(function ($event) {
            // Delete related tickets before deleting the event
            $event->tickets()->delete();
        });
    }
}