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
        Schema::create('occupants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('realestate_id');
            $table->foreign('realestate_id')->references('id')->on('realestates');
            $table->string('nekoId', 40);
            $table->string('unvid', 40)->nullable();
            $table->string('budguid', 40);
            $table->unsignedInteger('nutzeinheitNo');
            $table->date('dateFrom');
            $table->date('dateTo')->nullable();
            $table->string('anrede')->nullable();
            $table->string('title')->nullable();
            $table->string('nachname');
            $table->string('vorname')->nullable();
            $table->string('street')->nullable();
            $table->string('houseNr')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->boolean('vat')->nullable();
            $table->boolean('uaw')->nullable();
            $table->double('qmkc')->default(0);
            $table->double('qmww')->default(0)->nullable();
            $table->double('pe')->default(0);
            $table->text('bemerkung')->nullable();
            $table->double('vorauszahlung')->default(0)->nullable();
            $table->string('lokalart')->nullable();
            $table->string('customEinheitNo')->nullable();
            $table->string('lage')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('eigentumer')->nullable();
            $table->boolean('leerstand')->boolean()->default(0);
            $table->boolean('umlage_nutzerwechsel')->boolean()->default(1);
            $table->integer('OptimisticLockField')->default(0);
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
        Schema::dropIfExists('occupants');
    }
};
