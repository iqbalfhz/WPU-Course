<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    //
    protected $fillable = [
        'nama',
        'email',
        'usia',
        'nilai_akademik',
        'tes_kompetensi_teknis',
        'tes_psikotes',
        'tes_kepribadian',
        'soft_skill',
    ];
}
