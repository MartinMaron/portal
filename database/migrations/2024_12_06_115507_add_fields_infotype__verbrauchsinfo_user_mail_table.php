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
            $table->boolean('infoPerPortal')->default(1);
            $table->boolean('infoPerEmail')->default(0);
            $table->boolean('infoPerPost')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('verbrauchsinfo_user_emails', function($table)
        {
            $table->dropColumn('infoPerPortal');
            $table->dropColumn('infoPerEmail');
            $table->dropColumn('infoPerPost');
        });
    }
};
