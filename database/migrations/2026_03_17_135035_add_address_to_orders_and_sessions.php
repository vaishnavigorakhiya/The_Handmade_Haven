<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add address fields to orders
        Schema::table('orders', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('status');
            $table->string('phone', 20)->nullable()->after('full_name');
            $table->string('address')->nullable()->after('phone');
            $table->string('address_line')->nullable()->after('address');
            $table->string('city', 100)->nullable()->after('address_line');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('pincode', 10)->nullable()->after('state');
        });

        // Create sessions table if it doesn't exist
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'phone', 'address', 'address_line', 'city', 'state', 'pincode']);
        });

        Schema::dropIfExists('sessions');
    }
};
