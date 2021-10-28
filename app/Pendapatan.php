<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    protected $fillable = [
        'id_unit', 'id_lokasi', 'id_pelayaran', 'bulan', 'call_kapal', 'gt_kapal', 'pnd_pandu', 'pnd_pandu_standby', 'pnd_tunda', 'pnd_tunda_kawal', 'pnd_kepil', 'pnd_kpl_patrol', 'pnd_tunda_standby'
    ];
}
