<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterSkemaKeterampilan extends Model
{
    protected $fillable = [
        'id',
        'name'
    ];

    public function penilaian_keterampilan () {

        return $this->hasMany(MasterPenilaianKeterampilan::class, 'skema_id', 'id');
    }

    public function by_siswa($user_id, $kd) {
        $nilai = $this->penilaian_keterampilan()->whereHas('kd_keterampilan', function($q) use($kd)  {
            $q->where('kd_id', $kd);
        })
        ->withCount(['nilai as total' => function($q) use($user_id){
            $q->where('user_detail_id', $user_id);
            $q->select(DB::raw('sum(nilai)'))  ; 
        }])
       
        ->get();

        $total = $nilai->sum('total');
        
        return $total;


    }
}
