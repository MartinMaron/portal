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

        Schema::create('abrechnungssettings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('realestate_id');
            $table->foreign('realestate_id')->references('id')->on('realestates');
            $table->string('bemerkung',500)->nullable();
            $table->string('description',500)->nullable();
            $table->string('nabi_inhaber',500)->nullable();
            $table->string('nabi_nr',50)->nullable();
            $table->double('stromkosten')->default(0);
            $table->boolean('brenwert_gasabrechnug')->default(0);
            $table->boolean('eigen_energielieferung')->default(0);
            $table->integer('OptimisticLockField')->nullable();
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

        Schema::dropIfExists('abrechnungssettings');

    }

};

