<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/','HomeController@index')->name('home');
// Route::get('/tentang-kami','HomeController@about')->name('about');

// Route::get('/login','AuthController@showLogin')->name('login');
// Route::post('/login','AuthController@login');
// Route::get('/daftar','AuthController@showRegister')->name('register');
// Route::post('/daftar','AuthController@register');


// Route::prefix('/training')->name('training.')->group(function () {
//     Route::get('/','TrainingController@index')->name('index');
//     Route::get('/{slug}','TrainingController@show')->name('show');
// });

// Route::middleware('auth')->group(function () {
//     Route::post('/keluar','AuthController@logout')->name('logout');
    
//     Route::name('profil.')->group(function () {
//         Route::get('/profil','ProfilController@edit')->name('edit');
//         Route::post('/profil','ProfilController@update');
        
//         Route::get('/password','ProfilController@password')->name('password');
//         Route::post('/password','ProfilController@updatePassword');
//     });
        
//     Route::get('/pelatihan-saya','TrainingController@user')->name('user.training');
//     Route::get('/pelatihan-saya/{id}/pembayaran','TrainingController@payment')->name('user.training.payment');
//     Route::post('/pelatihan-saya/{id}/update','TrainingController@update')->name('user.training.update');
//     Route::post('/pelatihan/simpan','TrainingController@register')->name('user.training.register');    
// });

Route::get('/','Admin/LoginController@showLoginForm')->name('login');
Route::prefix('/')->name('admin.')->namespace('Admin')->group(function(){
    
    Route::middleware('guest')->group(function () {
        Route::get('/','LoginController@showLoginForm')->name('login');
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login');
    });

    Route::middleware(['auth'])->group(function () {
        Route::post('/logout','LoginController@logout')->name('logout');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/password', [ProfileController::class, 'password'])->name('password');
        Route::post('/password', [ProfileController::class, 'passwordUpdate'])->name('password.update');

        Route::middleware('verified')->group(function () {
            Route::get('/beranda','BerandaController@index')->name('beranda');
            
            Route::prefix('/pelanggan')->name('pelanggan.')->group(function () {
                Route::get('/','PelangganController@index')->name('index');
                Route::get('/create','PelangganController@create')->name('create');
                Route::get('/report','PelangganController@report')->name('report');
                Route::post('/store','PelangganController@store')->name('store');
                Route::get('/json/{id}','PelangganController@json')->name('json');
                Route::get('/{id}','PelangganController@show')->name('show');
                Route::get('/{id}/edit','PelangganController@edit')->name('edit');
                Route::post('{id}/update','PelangganController@update')->name('update');
                Route::delete('/{id}/delete','PelangganController@destroy')->name('delete');
                Route::get('/{id}/riwayat','PelangganController@riwayat')->name('riwayat');
            });

            Route::prefix('/driver')->name('driver.')->group(function () {
                Route::get('/','DriverController@index')->name('index');
                Route::get('/create','DriverController@create')->name('create');
                Route::post('/store','DriverController@store')->name('store');
                Route::get('/{id}','DriverController@show')->name('show');
                Route::get('/{id}/edit','DriverController@edit')->name('edit');
                Route::post('{id}/update','DriverController@update')->name('update');
                Route::delete('/{id}/delete','DriverController@destroy')->name('delete');
            });

            Route::prefix('/unit')->name('unit.')->group(function () {
                Route::get('/','UnitController@index')->name('index');
                Route::get('/create','UnitController@create')->name('create');
                Route::post('/store','UnitController@store')->name('store');
                Route::get('/{id}/edit','UnitController@edit')->name('edit');
                Route::post('/{id}/update','UnitController@update')->name('update');
                Route::delete('/{id}/delete','UnitController@destroy')->name('delete');
            });
            
            Route::prefix('/sparepart')->name('sparepart.')->group(function () {
                Route::get('/','SparepartController@index')->name('index');
                Route::post('/store','SparepartController@store')->name('store');
                Route::get('/{id}','SparepartController@show')->name('show');
                Route::get('/{id}/edit','SparepartController@edit')->name('edit');
                Route::post('/{id}/update','SparepartController@update')->name('store');
                Route::delete('/{id}/delete','SparepartController@destroy')->name('delete');
            });

            Route::prefix('/aktivitas/{order}')->name('aktivitas.')->group(function () {
                Route::get('/','AktivitasController@index')->name('index');
                Route::post('/store','AktivitasController@store')->name('store');
                Route::get('/{id}','AktivitasController@show')->name('show');
                Route::get('/{id}/edit','AktivitasController@edit')->name('edit');
                Route::post('/{id}/update','AktivitasController@update')->name('store');
                Route::delete('/{id}/delete','AktivitasController@destroy')->name('delete');
            });
            Route::prefix('/pembelian')->name('pembelian.')->group(function () {
                Route::get('/','PembelianController@index')->name('index');
                Route::get('/report','PembelianController@report')->name('report');
                Route::get('/create','PembelianController@create')->name('create');
                Route::post('/store','PembelianController@store')->name('store');
                Route::get('/{id}','PembelianController@show')->name('show');
                Route::get('/{id}/edit','PembelianController@edit')->name('edit');
                Route::post('{id}/update','PembelianController@update')->name('update');
                Route::post('{id}/status','PembelianController@status')->name('status');
                Route::delete('/{id}/delete','PembelianController@destroy')->name('delete');
            });

            Route::prefix('/pengiriman')->name('pengiriman.')->group(function () {
                Route::get('/','PengirimanController@index')->name('index');
                Route::get('/report','PengirimanController@report')->name('report');
                Route::get('/create','PengirimanController@create')->name('create');
                Route::post('/store','PengirimanController@store')->name('store');
                Route::get('/{id}','PengirimanController@show')->name('show');
                Route::get('/{id}/pdf','PengirimanController@pdf')->name('pdf');
                Route::get('/{id}/edit','PengirimanController@edit')->name('edit');
                Route::post('{id}/update','PengirimanController@update')->name('update');
                Route::post('{id}/bukti','PengirimanController@bukti')->name('bukti');
                Route::post('{id}/status','PengirimanController@status')->name('status');
                Route::delete('/{id}/delete','PengirimanController@destroy')->name('delete');
            });
            

            Route::prefix('/pegawai')->name('pegawai.')->group(function () {
                Route::get('/','PegawaiController@index')->name('index');
                Route::get('/data','PegawaiController@data')->name('data');
                Route::get('/create','PegawaiController@create')->name('create');
                Route::post('/store','PegawaiController@store')->name('store');
                Route::get('/{id}','PegawaiController@show')->name('show');
                Route::get('/{id}/edit','PegawaiController@edit')->name('edit');
                Route::post('{id}/update','PegawaiController@update')->name('update');
                Route::delete('/{id}/delete','PegawaiController@destroy')->name('delete');
            });

            Route::prefix('/absen')->name('absen.')->group(function () {
                Route::get('/','AbsenController@index')->name('index');
                Route::get('/tambah','AbsenController@tambah')->name('tambah');
                Route::post('/simpan','AbsenController@simpan')->name('simpan');
                Route::get('print/{ekskul}/{tgl}','AbsenController@print')->name('print');
                Route::get('/{ekskul}/{tgl}','AbsenController@show')->name('show');
                Route::get('/{id}/edit','AbsenController@edit')->name('edit');
                Route::post('{id}/update','AbsenController@update')->name('update');
                Route::delete('/{id}/delete','AbsenController@destroy')->name('delete');
            });
            
            Route::prefix('/galeri')->name('galeri.')->group(function () {
                Route::get('/','GaleriController@index')->name('index');
                Route::post('/store','GaleriController@store')->name('store');
                Route::delete('/{id}/delete','GaleriController@destroy')->name('delete');
            });

        });
    });
});


// require __DIR__.'/auth.php';
