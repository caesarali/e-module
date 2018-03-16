<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('register', function() {
	return abort(404);
});

Route::get('password/reset', function() {
	return abort(404);
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

	
Route::group(['middleware' => 'auth'], function() {
	Route::get('/module', 'ModuleController@index')->name('module');
	Route::get('/module/{slug}', 'ModuleController@show')->name('show.module');
	Route::get('/module/download/{slug}/{filename}', 'ModuleController@download')->name('module.download');

	Route::get('/profile', 'ProfileController@index')->name('profile.index');
	Route::patch('/profile/{userId}', 'ProfileController@update')->name('profile.update');

    Route::put('password', 'PasswordController@update')->name('password.update');

	Route::group(['middleware' => 'role:dosen'], function() {
		Route::get('/matkul/{matkul}/edit', 'Admin\MatakuliahController@edit')->name('edit.matkul');
		Route::post('/matkul', 'Admin\MatakuliahController@store')->name('store.matkul');
		Route::delete('/matkul/{matkul}', 'Admin\MatakuliahController@destroy')->name('destroy.matkul');
		Route::put('/matkul/{matkul}', 'Admin\MatakuliahController@update')->name('update.matkul');

		Route::post('/module', 'Admin\ModuleController@store')->name('store.module');
		Route::delete('/module/{module}', 'Admin\ModuleController@destroy')->name('destroy.module');
	});

	Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'role:admin'], function () {
		// Route Home
		Route::get('/', 'HomeController@index');
		// Route Dosen, Mahasiswa
		Route::resource('/dosen', 'DosenController');
		Route::resource('/mahasiswa', 'MahasiswaController');
		Route::post('/mahasiswa/angkatan', 'MahasiswaController@mahasiswa')->name('mahasiswa.filter');
		// Kelas & Angkatan
		Route::get('/kelas', 'KelasController@index')->name('kelas.index');
		Route::post('/kelas', 'KelasController@storeKelas')->name('kelas.store');
		Route::delete('/kelas/{kelas}', 'KelasController@destroyKelas')->name('kelas.destroy');
		Route::post('/angkatan', 'KelasController@storeAngkatan')->name('angkatan.store');
		Route::delete('/angkatan/{angkatan}', 'KelasController@destroyAngkatan')->name('angkatan.destroy');
		// Route E-Module
		Route::get('/module', 'ModuleController@index')->name('module.index');
		Route::get('/module/{slug}', 'ModuleController@show')->name('module.show');
		Route::post('/module', 'ModuleController@store')->name('module.store');
		Route::delete('/module/{module}', 'ModuleController@destroy')->name('module.destroy');
		// Route Matakuliah
		Route::post('/matkul', 'MatakuliahController@store')->name('matkul.store');
		Route::get('/matkul/{matkul}/edit', 'MatakuliahController@edit')->name('matkul.edit');
		Route::put('/matkul/{matkul}', 'MatakuliahController@update')->name('matkul.update');
		Route::delete('/matkul/{matkul}', 'MatakuliahController@destroy')->name('matkul.destroy');
	});
});