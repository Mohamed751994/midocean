<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $hidden = ['updated_at'];

    public function images() {
        return $this->morphMany(Image::class, 'parentable');
    }
    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

}
