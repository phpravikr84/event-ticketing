<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Attendee Model
class Attendee extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'user_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
