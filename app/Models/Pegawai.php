<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama', 'nip', 'jenkel', 'pangkat', 'jabatan', 'jenis_jbt', 'unit_kerja', 'unit_organisasi', 'kode_pd', 'kode_unit', 'status', 'email', 'telepon', 'foto'
    ];

}
