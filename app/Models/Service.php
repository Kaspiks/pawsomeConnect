<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'service_category_id', 'price'];

    public function category() {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
