<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category', 'price', 'stock',
        'emoji', 'color', 'description',
        'image', 'tags', 'badge', 'featured',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'price' => 'float',
        'stock' => 'integer',
        'tags' => 'array',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->image)) 
        {            
            return asset('storage/' . $this->image);
        }

        return null;
    }

    public function getTagsArrayAttribute(): array
    {
        return is_array($this->tags) ? $this->tags : [];
    }
}
