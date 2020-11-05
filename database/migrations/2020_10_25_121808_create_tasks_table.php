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
            $table->string('name', 120)->default('No name');
            $table->text('description')->nullable();
            $table->enum('priority', ['1', '2', '3', '4', '5']);
            $table->boolean('is_active');
            $table->dateTime('deadline', 0)->nullable();
            $table->foreignId('list_id');
            $table->foreignId('type_id');
            $table->timestamps();

            $table->foreign('list_id')->references('id')->on('task_lists')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('task_types')->onDelete('cascade');
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
