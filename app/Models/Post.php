<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function upload()
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('file_type', 'image');
    }

    public function pdf()
    {
        return $this->morphOne(Upload::class, 'uploadable')->where('file_type', 'pdf');
    }
}
