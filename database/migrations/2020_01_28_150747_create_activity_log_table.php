<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('log_name', 191)->nullable();
            $table->text('description');
            $table->integer('subject_id')->unsigned()->nullable();
            $table->string('subject_type', 191)->nullable();
            $table->integer('causer_id')->unsigned()->nullable();
            $table->string('causer_type', 191)->nullable();
            $table->text('properties')->nullable();
            $table->timestamps();

            $table->index('log_name');
            $table->index(['subject_id', 'subject_type'], 'subject');
            $table->index(['causer_id', 'causer_type'], 'causer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
