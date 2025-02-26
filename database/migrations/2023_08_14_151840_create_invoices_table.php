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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('createDate');
            $table->string('caption')->nullable();
            $table->string('description')->nullable();
            $table->string('fileName')->nullable();
            $table->unsignedBigInteger('realestate_id');
            $table->foreign('realestate_id')->references('id')->on('realestates');
            $table->string('nekoId');
            $table->date('dateFrom');
            $table->date('dateTo');
            $table->string('vertragsart')->nullable();
            $table->boolean('bezahlt')->nullable();
            $table->date('bezahltAm')->nullable();
            $table->date('zahlungsAuftragDatum')->nullable();
            $table->string('zahlungsauftragIBAN')->nullable();
            $table->double('netto')->nullable()->default(0.0);
            $table->double('vat')->nullable()->default(0.0);
            $table->double('brutto')->nullable()->default(0.0);
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
        Schema::dropIfExists('invoices');
    }
};
