<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Meet extends Model
{
    protected $fillable = ['class_id', 'mapel_id', 'name', 'code', 'date_start', 'date_end'];
}
