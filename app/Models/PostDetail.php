<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostDetail extends Model
{
    protected $fillable = [
        'post_id',
        'ckeditor',
        'number',
        'category',
        'status',
        'tags',
        'publish_date',
        'publish_time',
        'rating',
        'color',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
