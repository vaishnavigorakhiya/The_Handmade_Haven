<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'price', 'description', 'image_url'];

    public function options()
    {
        return $this->hasMany(ProductOption::class);
    }

}
