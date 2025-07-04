<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->decimal('estimated_price', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
            $table->decimal('estimated_price', 10, 2)->nullable(false)->change();
        });
    }
};
