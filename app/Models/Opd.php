<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
   use HasFactory;
   protected $fillable = [
      'kode_pd', 'nama_pd', 'nama_lain', 'kode_unit', 'unor'
   ];

}
