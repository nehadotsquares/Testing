<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'file_path',
        'file_type',
    ];

    public function uploadable()
    {
        return $this->morphTo();
    }
}
