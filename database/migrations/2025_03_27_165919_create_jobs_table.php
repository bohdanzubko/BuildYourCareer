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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description');
            $table->decimal('salary_min', 10, 2);
            $table->decimal('salary_max', 10, 2);
            $table->string('location', 255);
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
