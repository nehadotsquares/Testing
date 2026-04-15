<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    protected static function booted()
    {
        static::deleting(function ($blog) {

            // Delete single upload (if exists)
            if ($blog->upload) {
                if (Storage::exists('public/' . $blog->upload->file_path)) {
                    Storage::delete('public/' . $blog->upload->file_path);
                }
                $blog->upload->delete();
            }

            if ($blog->pdf) {
                if (Storage::exists('public/' . $blog->pdf->file_path)) {
                    Storage::delete('public/' . $blog->pdf->file_path);
                }
                $blog->pdf->delete();
            }

            // Delete multiple blogImages
            foreach ($blog->blogImages as $image) {
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
        return $this->hasOne(BlogDetail::class);
    }

    public function blogImages()
    {
        return $this->morphMany(Upload::class, 'uploadable')->where('file_type', 'blog_image');
    }
}
