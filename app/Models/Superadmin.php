<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Superadmin extends Model
{
   use HasFactory;
   protected $fillable = [
      'nama', 'nip', 'jabatan', 'email', 'username'
   ];

}
