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
			$table->string('nomor_un');
			$table->integer('sekolah_id')->nullable();
			$table->string('zona_siswa')->nullable();
			$table->string('zona_sekolah')->nullable();
			$table->string('lokasi_siswa')->nullable();
			$table->string('lokasi_sekolah')->nullable();
			$table->integer('nilai_zona')->nullable();
			$table->integer('user_id')->nullable();
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
