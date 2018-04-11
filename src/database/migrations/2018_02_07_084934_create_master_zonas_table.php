<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMasterZonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('master_zonas', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('tingkat');
			$table->integer('kode');
			$table->string('label');
			$table->timestamps();
			$table->softDeletes();
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
		Schema::drop('master_zonas');
	}
}
