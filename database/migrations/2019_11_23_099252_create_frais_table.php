<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFraisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frais', function (Blueprint $table) {
            $table->increments('id');
            $table->float('montant',8,2);
            $table->text('description')->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('type_id')->unsigned()->index();
            $table->integer('status_id')->unsigned()->index()->nullable();
            $table->integer('validated_by')->unsigned()->index()->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->foreign('validated_by')->references('id')->on('users')->onDelete('cascade');
            
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
        Schema::dropIfExists('frais');
    }
}
