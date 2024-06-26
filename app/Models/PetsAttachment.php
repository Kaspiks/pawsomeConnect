<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetsAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['pet_id', 'data'];

    public function pet() {
        return $this->belongsTo(Pet::class);
    }
}
