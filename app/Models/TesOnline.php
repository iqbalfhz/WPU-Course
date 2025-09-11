<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TesOnline extends Model
{
    protected $table = 'tes_online';

    protected $fillable = [
        'jenis', 'pertanyaan', 'opsi', 'jawaban_benar',
    ];

    protected $casts = [
        'pertanyaan'     => 'array',
        'opsi'           => 'array',
        'jawaban_benar'  => 'array',
    ];
}