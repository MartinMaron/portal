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
        Schema::table('verbrauchsinfo_user_emails', function($table)
        {
            $table->unsignedBigInteger('occupant_id')->nullable;
            $table->foreign('occupant_id')->references('id')->on('occupants')->onDelete('cascade');
            $table->boolean('anonym')->default(0);
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
