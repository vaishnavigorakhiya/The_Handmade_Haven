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

    /**
     * Return a safe image URL — storage path if image exists, null otherwise.
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Decoded tags array.
     */
    public function getTagsArrayAttribute(): array
    {
        if (!$this->tags) return [];
        $decoded = json_decode($this->tags, true);
        return is_array($decoded) ? $decoded : [];
    }
}
