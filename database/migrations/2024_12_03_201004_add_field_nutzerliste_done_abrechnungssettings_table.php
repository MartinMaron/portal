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
        Schema::table('abrechnungssettings', function($table)
        {
            $table->boolean('nutzerlisteDone')->nullable();
            $table->boolean('heizkostenlisteDone')->nullable();
            $table->boolean('betreibskostenDone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('realestates', function($table)
        {
            $table->dropColumn('nutzerlisteDone');
            $table->dropColumn('heizkostenlisteDone');
            $table->dropColumn('betreibskostenDone');
        });
    }
};
