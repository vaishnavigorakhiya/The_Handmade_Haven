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
        'price'    => 'float',
        'stock'    => 'integer',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    public function getTagsArrayAttribute(): array
    {
        if (!$this->tags) return [];
        $decoded = json_decode($this->tags, true);
        return is_array($decoded) ? $decoded : [];
    }
}
