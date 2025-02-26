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
        Schema::create('costtypes', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('costinvoicingtype_id');
            $table->foreign('costinvoicingtype_id')->references('id')->on('costinvoicingtypes');
            $table->string('caption');
            $table->integer('sort');
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
        Schema::dropIfExists('costtypes');
    }
};
