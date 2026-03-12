<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->decimal('price', 8, 2);
            $table->integer('stock')->default(0);
            $table->string('emoji')->default('🧵');
            $table->string('color')->default('#FFE8D6');
            $table->text('description');
            $table->json('tags')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
