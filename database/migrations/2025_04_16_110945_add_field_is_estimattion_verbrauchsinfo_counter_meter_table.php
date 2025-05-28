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
        Schema::table('verbrauchsinfo_counter_meters', function($table)
        {
            $table->boolean('isEstimation')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('verbrauchsinfo_counter_meters', function($table)
        {
            $table->dropColumn('isEstimation');
        });
    }
};
