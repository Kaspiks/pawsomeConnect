<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'date', 'max_amount_of_people', 'price', 'location'];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function attachments() {
        return $this->hasMany(EventsAttachment::class, 'event_id');
    }

    public function hosts()
    {
        return $this->belongsToMany(User::class, 'event_user')
            ->wherePivot('user_type', 'host');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_user')
            ->wherePivot('user_type', 'participant');
    }
}
