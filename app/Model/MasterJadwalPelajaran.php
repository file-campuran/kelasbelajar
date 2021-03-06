<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MasterJadwalPelajaran extends Model
{
    //
    protected $table = 'master_jadwal_pelajarans';
    protected $fillable = [
        'id',
        'kelas_id',
        'mapel_id',
        'current_pertemuan',
        'kkm',
        'semester_id',
        'user_id',
        'pertemuan',
        'created_at',
        'updated_at'
    ];

    public function kelas () {
        return $this->belongsTo('App\Model\Kelas', 'kelas_id', 'id');
    }

    public function block() {
        return $this->hasMany(BlockKelasMapel::class, 'kelas_mapel_id', 'id');
    }
public function master_mapel() {
        return $this->belongsTo('App\Model\MasterMapel', 'mapel_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\Model\User', 'user_id', 'id');

    }

    public function penilaian_pengetahuan(){
        return $this->hasMany('App\Model\MasterPenilaianPengetahuan', 'kelas_mapel_id', 'id');
    }

    public function penilaian_keterampilan() {
        return $this->hasMany('App\Model\MasterPenilaianKeterampilan', 'kelas_mapel_id', 'id');
    }

    public function absen() {
        return $this->hasMany('App\Model\Absen', 'kelas_mapel_id', 'id');
    }
}
