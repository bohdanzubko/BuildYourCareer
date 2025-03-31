<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->text('description');
            $table->decimal('area', 10, 2);
            $table->decimal('estimated_price', 10, 2);
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
