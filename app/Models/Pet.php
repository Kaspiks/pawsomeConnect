<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'breed', 'pet_type_id', 'age', 'description'];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function type() {
        return $this->belongsTo(PetType::class, 'pet_type_id');
    }

    public function attachments() {
        return $this->hasMany(PetsAttachment::class, 'pet_id');
    }
}
