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
        Schema::table('costs', function($table)
        {
            $table->string('prevyearPeriod')->nullable();
            $table->double('prevyearQuantity')->nullable();
            $table->double('prevyearAmountnet')->nullable();
            $table->double('prevyearAmountgros')->nullable();
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
