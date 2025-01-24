<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = ['locale', 'key', 'content'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'translation_tag');
    }
}
