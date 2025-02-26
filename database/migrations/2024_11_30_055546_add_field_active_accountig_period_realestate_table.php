<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('realestates', function($table)
        {
            $table->unsignedBigInteger('abrechnungssetting_id')->nullable();
            $table->foreign('abrechnungssetting_id')->references('id')->on('abrechnungssettings')->onDelete('cascade');
            $table->dropColumn('periodFrom');
            $table->dropColumn('periodTo');
            $table->string('prepaidtype')->default('H');
        });

        Schema::table('abrechnungssettings', function($table)
        {
            $table->date('periodFrom')->nullable();
            $table->date('periodTo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
