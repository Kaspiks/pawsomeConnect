<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['event_id', 'data'];

    public function event() {
        return $this->belongsTo(Event::class);
    }
}
