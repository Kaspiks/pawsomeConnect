<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostsAttachment extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'data'];

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
