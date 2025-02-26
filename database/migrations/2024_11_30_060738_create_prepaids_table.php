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
        Schema::create('prepaids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('occupant_id')->nullable();
            $table->foreign('occupant_id')->references('id')->on('occupants');
            $table->unsignedBigInteger('nekoId')->default(0);
            $table->double('netAmount')->nullable();
            $table->double('grosAmount')->nullable();
            $table->string('prepaidtype')->default('H');
            $table->unsignedBigInteger('abrechnungssetting_id')->nullable();
            $table->foreign('abrechnungssetting_id')->references('id')->on('abrechnungssettings');
            $table->integer('OptimisticLockField')->nullable();
            $table->timestamps();
        });

        Schema::table('cost_amounts', function (Blueprint $table) {
            $table->unsignedBigInteger('abrechnungssetting_id')->nullable();
            $table->foreign('abrechnungssetting_id')->references('id')->on('abrechnungssettings');
            $table->boolean('startvalue')->nullable();
            $table->boolean('endvalue')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prepaids');

        Schema::table('cost_amounts', function (Blueprint $table) {
            $table->dropColumn('abrechnungssetting_id');
            $table->dropColumn('startvalue');
            $table->dropColumn('endvalue');
        });
    }
};
