<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['proses', 'return', 'hold', 'approve'])->default('proses'); 
            $table->date('deadline')->nullable(); 
            $table->string('title');
            $table->string('client');
            $table->text('description');
            $table->foreignId('pic_designer_id')->constrained('users'); 
            $table->string('file_path')->nullable();
            $table->string('file_designer')->nullable();
            $table->text('komen_koordinator')->nullable();
            $table->text('komen_qc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
