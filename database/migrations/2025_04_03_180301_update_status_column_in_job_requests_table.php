<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusColumnInJobRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_requests', function (Blueprint $table) {
            $table->enum('new_status', ['pending', 'viewed', 'approved', 'declined'])->default('pending')->after('status'); 
        });

        Schema::table('job_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('job_requests', function (Blueprint $table) {
            $table->renameColumn('new_status', 'status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_requests', function (Blueprint $table) {
            $table->string('status')->default('pending');
        });
    }
}
