<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalGurusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_gurus', function (Blueprint $table) {
            $table->id();
            $table->integer('kelas_id');
            $table->date('waktu');
            $table->integer('hapus')->default(0);
            $table->string('pertemuan');
            $table->text('materi');
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
        Schema::dropIfExists('jurnal_gurus');
    }
}
