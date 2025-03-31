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
        Schema::create('service_tag_relations', function (Blueprint $table) {
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('service_tags')->onDelete('cascade');
            $table->primary(['service_id', 'tag_id']);
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_tag_relations');
    }
};
