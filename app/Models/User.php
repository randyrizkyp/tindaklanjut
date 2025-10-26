<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   use HasFactory;
   protected $fillable = [
      'nip', 'nama', 'pangkat', 'jabatan', 'jenis_jbt', 'unker', 'unor', 'kode_pd','password'
   ];

}
