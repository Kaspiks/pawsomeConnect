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
}
