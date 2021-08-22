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
            $table->string('title')->comment('タイトル');
            $table->text('task')->nullable()->comment('タスク');
            $table->unsignedBigInteger('task_status_id')->default(\App\Models\TaskStatus::DOING)->index()->comment('タスクステータスID');
            $table->unsignedBigInteger('assigned_user_id')->nullable()->comment('担当者ID');
            $table->timestamps();
            $table->softDeletes();
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
