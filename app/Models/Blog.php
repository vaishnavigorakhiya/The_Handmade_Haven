<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'tag',
        'body',
        'image',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function getExcerptAttribute(): string
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->body), 120);    
    }
}
