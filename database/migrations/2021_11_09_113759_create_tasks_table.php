<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task')->nullable();
            $table->string('topic')->nullable();
            $table->string('instructions')->nullable();
            $table->dateTime('task_given_on')->nullable();
            $table->dateTime('task_started_on')->nullable();
            $table->dateTime('task_submitted_on')->nullable();
            $table->string('word_limit')->nullable();
            $table->string('time_limit')->nullable();
            $table->uuid('assigned_to');
            $table->foreign('assigned_to')->references('id')->on('users');
            $table->foreignId('region_target')->constrained('regions')->onDelete('cascade');
            $table->foreignId('website_id')->constrained('websites')->onDelete('cascade');
            $table->enum('task_type', ['Internal', 'External'])->default('Internal');
            $table->string('payout_amount')->nullable();
            $table->string('payout_id')->nullable();
            $table->string('Published_date')->nullable();
            $table->string('Published_url')->nullable();
            $table->string('link_id')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}