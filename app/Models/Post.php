<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    protected static function booted()
    {
        static::deleting(function ($post) {

            // Delete single upload (if exists)
            if ($post->upload) {
                if (Storage::exists('public/' . $post->upload->file_path)) {
                    Storage::delete('public/' . $post->upload->file_path);
                }
                $post->upload->delete();
            }

            if ($post->pdf) {
                if (Storage::exists('public/' . $post->pdf->file_path)) {
                    Storage::delete('public/' . $post->pdf->file_path);
                }
                $post->pdf->delete();
            }

            // Delete multiple postImages
            foreach ($post->postImages as $image) {
                if (Storage::exists('public/' . $image->file_path)) {
                    Storage::delete('public/' . $image->file_path);
                }
                $image->delete();
            }
        });
    }

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

    public function details()
    {
        return $this->hasOne(PostDetail::class);
    }

    public function postImages()
    {
        return $this->morphMany(Upload::class, 'uploadable')->where('file_type', 'post_image');
    }
}
