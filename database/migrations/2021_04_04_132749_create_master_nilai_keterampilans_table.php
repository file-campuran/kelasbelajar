<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterNilaiKeterampilansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_nilai_keterampilans', function (Blueprint $table) {
            $table->id();
            $table->integer('user_detail_id');
            $table->integer('penilaian_keterampilan_id');
            $table->integer('materi')->default(0);
            $table->integer('jumlah_skor')->default(0);
            $table->integer('tugas')->default(0);
            $table->integer('nilai')->default(0);
            $table->integer('remidi')->nullable(true);
            $table->text('feedback')->nullable(true);

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
        Schema::dropIfExists('master_nilai_keterampilans');
    }
}
