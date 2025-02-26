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
        Schema::create('personcounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('occupant_id')->nullable();
            $table->foreign('occupant_id')->references('id')->on('occupants');
            $table->unsignedBigInteger('nekoId')->default(0);
            $table->double('countvalue')->nullable();
            $table->unsignedBigInteger('abrechnungssetting_id')->nullable();
            $table->foreign('abrechnungssetting_id')->references('id')->on('abrechnungssettings');
            $table->integer('OptimisticLockField')->nullable();
            $table->timestamps();
        });

        Schema::table('abrechnungssettings', function($table)
        {
            $table->boolean('brennstofflisteDone')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personcounts');
    }
};
