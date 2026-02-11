<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $candle = \App\Models\Product::create([
            'name' => 'Handcrafted Candle',
            'slug' => 'handcrafted-candle',
            'price' => 1200,
            'description' => 'Soy wax, lavender scent',
            'image_url' => '',
        ]);

        $mug = \App\Models\Product::create([
            'name' => 'Custom Name Mug',
            'slug' => 'custom-name-mug',
            'price' => 1800,
            'description' => 'Add your name or a short text',
            'image_url' => '',
        ]);

        foreach (['Ivory', 'Rose', 'Sage'] as $color) {
            $candle->options()->create(['type' => 'color', 'value' => $color]);
        }
        foreach (['Small', 'Medium', 'Large'] as $size) {
            $candle->options()->create(['type' => 'size', 'value' => $size]);
        }

        foreach (['White', 'Black', 'Blue'] as $color) {
            $mug->options()->create(['type' => 'color', 'value' => $color]);
        }
        foreach (['300ml', '450ml'] as $size) {
            $mug->options()->create(['type' => 'size', 'value' => $size]);
        }
        $mug->options()->create(['type' => 'text', 'value' => 'custom']);
    }

}
