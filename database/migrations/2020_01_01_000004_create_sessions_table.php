<?php



use Illuminate\Support\Facades;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Schema;

use Illuminate\Validation\Rules\Unique;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



return new class extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        if (env('DB_HOST')!='127.0.0.1') {
            \Illuminate\Support\Facades\DB::statement('SET SESSION sql_require_primary_key=0');
        }

        Schema::create('sessions', function (Blueprint $table) {

            $table->string('id')->primary();

            $table->foreignId('user_id')->nullable()->index();

            $table->string('ip_address', 45)->nullable();

            $table->text('user_agent')->nullable();

            $table->text('payload');

            $table->integer('last_activity')->index();

        });

    }



    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()

    {

        Schema::dropIfExists('sessions');

    }

};

