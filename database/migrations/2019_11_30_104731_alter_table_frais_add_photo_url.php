<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableFraisAddPhotoUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('frais', function (Blueprint $table) {
            $table->text('photo_url')->nullable()->after('validated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frais', function (Blueprint $table) {
            $table->dropColumn('photo_url');
        });
    }
}
