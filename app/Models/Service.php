<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'service_category_id', 'price'];

    public function category() {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function owners()
    {
        return $this->belongsToMany(User::class, 'service_user')
            ->wherePivot('user_type', 'owner');
    }

    public function customers()
    {
        return $this->belongsToMany(User::class, 'service_user')
            ->wherePivot('user_type', 'customer');
    }
}
