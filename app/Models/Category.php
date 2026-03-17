<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'color'];

    protected static function booted(): void
    {
        static::deleting(function (Category $category) {
            Product::where('category', $category->name)->update(['category' => 'Custom']);
        });
    }
}
