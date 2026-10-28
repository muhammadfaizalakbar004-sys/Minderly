<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    protected $table = 'proyek';

    protected $primaryKey = 'id_proyek';

    public $timestamps = false;

    protected $fillable = [
        'nama_proyek',
        'deskripsi',
        'id_pembuat',
    ];

    protected $casts = [
        'dibuat_pada' => 'datetime',
    ];
}
