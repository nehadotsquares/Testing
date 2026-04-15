<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogDetail extends Model
{
    protected $fillable = [
        'blog_id',
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

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
