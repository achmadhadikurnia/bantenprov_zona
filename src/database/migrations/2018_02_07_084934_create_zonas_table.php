<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('zonas', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('master_zona_id');
			$table->integer('nomor_un');
			$table->integer('sekolah_id');
			$table->integer('zona_siswa')->nullable();
			$table->integer('zona_sekolah')->nullable();
			$table->integer('lokasi_siswa')->nullable();
			$table->integer('lokasi_sekolah')->nullable();
			$table->integer('nilai_zona');
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
		Schema::drop('zonas');
	}
}
