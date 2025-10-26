<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CutibawahanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BantuanController;
use App\Http\Controllers\SuperadminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PengajuanController;

use App\Http\Controllers\ProfilController;

use App\Http\Controllers\DatapegawaiController;
use App\Http\Controllers\KassubagController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\ExcelController;

//Tindak Lanjut
use App\Http\Controllers\BpkadminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PicController;

//Export Excel
use App\Exports\KertasKerja;
use Maatwebsite\Excel\Facades\Excel;


Route::get('/', function () {
    return view('login.login');
});


Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::post('/signin', [AuthController::class, 'authenticate']);
Route::get('/signout', [AuthController::class, 'signout']);
Route::get('/bypass/{nip}', [AuthController::class, 'bypass']);
Route::get('/bypass_puskes/{nip}', [AuthController::class, 'bypass_puskes']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/signup', [RegisterController::class, 'signup']);

Route::group(['middleware' => ['AuthAdmin']], function () {

    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/bpkmatix', [BpkadminController::class, 'index']);
    Route::post('/bpkinputlhp', [BpkadminController::class, 'inputlhp']);
    Route::get('/bpkdetail/{id}', [BpkadminController::class, 'detailbpk']);
    Route::get('/bpkrekomendasi/{id}', [BpkadminController::class, 'rekomendasibpk']);
    Route::post('/bpkinputtemuan', [BpkadminController::class, 'inputtemuan']);
    Route::post('/bpkedittemuan', [BpkadminController::class, 'edittemuan']);
    Route::post('/bpkhapustemuan', [BpkadminController::class, 'hapustemuan']);
    Route::post('/bpkinputrekomendasi', [BpkadminController::class, 'inputrekomendasi']);
    Route::put('/bpkeditrekom/{id}', [BpkadminController::class, 'editrekom']);
    Route::post('/bpkhapusrekom', [BpkadminController::class, 'hapusrekom']);
    Route::get('/bpkdetailrekom/{id}', [BpkadminController::class, 'bpkdetailrekom']);
    Route::post('/bpkinputpjbrekom', [BpkadminController::class, 'bpkinputpjbrekom']);
    Route::post('/bpkhapuspjbrekom', [BpkadminController::class, 'bpkhapuspjbrekom']);
    Route::put('/bpkeditpjbrekom', [BpkadminController::class, 'bpkeditpjbrekom']);
    Route::get('/bpkhapuspjb/{id}', [BpkadminController::class, 'bpkhapuspjb']);
    Route::post('/validasi', [BpkadminController::class, 'validasi']);


    //Config User
    Route::get('/userconfig', [UserController::class, 'index']);
    Route::post('/inputuser', [UserController::class, 'inputuser']);
    Route::post('/updateuser/{id}', [UserController::class, 'updateuser']);

    Route::get('/export-temuan/{rekom_id}', function ($rekom_id) {
    return Excel::download(new KertasKerja($rekom_id), 'temuan.xlsx');
});

});

Route::group(['middleware' => ['AuthPic']], function () {
    Route::get('/pic', [PicController::class, 'index']);
    Route::get('/bpkpic', [PicController::class, 'index']);
    Route::get('/bpkpicpd/{id}', [PicController::class, 'bpkpicpd']);
    Route::get('/bpkpictemuan/{kode_pd}/{id_lhp}', [PicController::class, 'bpkpictemuan']);
    Route::get('/bpkpicrekom/{kode_pd}/{id_lhp}/{id_temuan}', [PicController::class, 'bpkpicrekom']);
    Route::get('/bpkpicpjb/{kode_pd}/{id_lhp}/{id_temuan}/{id_rekom}', [PicController::class, 'bpkpicpjb']);
    Route::post('/bpkpicinputpbj/{id}', [PicController::class, 'bpkpicinputpbj']);
    Route::get('/bpkpichapuspjb/{id}', [PicController::class, 'bpkpichapuspjb']);


});