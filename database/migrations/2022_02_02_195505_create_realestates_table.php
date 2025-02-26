<?php



use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;



class CreateRealestatesTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {
        Schema::create('realestates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->index(['user_id']);
            $table->text('nekoId', 40);
            $table->text('address', 255)->nullable();
            $table->text('unvid', 40);
            $table->text('street',255);
            $table->text('postCode',100);
            $table->text('city',255);
            $table->date('dateFrom')->nullable();
            $table->date('dateTo')->nullable();
            $table->date('dateStart');
            $table->boolean('heizkosten');
            $table->boolean('rauchmelder');
            $table->boolean('miete');
            $table->boolean('eingabeCostNetto')->default(0);
            $table->boolean('eingabeCostDatum')->default(1);
            $table->boolean('occupant_name_mode')->default(0);
            $table->boolean('occupant_number_mode') ->default(0);
            $table->integer('OptimisticLockField')->nullable();
            $table->softDeletes();
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

        Schema::dropIfExists('realestates');

    }

}

