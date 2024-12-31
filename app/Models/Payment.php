<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Payment Model
class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'user_id', 'amount', 'status'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
