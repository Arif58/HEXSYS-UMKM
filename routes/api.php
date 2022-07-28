<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/','Api\AntreanController@index');

// USER MANAGEMENT
Route::post('register', 'Api\UserController@register');
Route::post('login', 'Api\UserController@login');
Route::get('user', 'Api\UserController@getAuthenticatedUser')->middleware('jwt.verify');
Route::post('refresh', 'Api\UserController@refresh');

//ANTRIAN
Route::post('getNomorAntrean','Api\AntreanController@nomorAntrean')->middleware('jwt.verify');
Route::post('getRekapAntrean','Api\AntreanController@rekapAntrean')->middleware('jwt.verify');
Route::post('getKodeBookingOperasi','Api\AntreanController@kodeBookingOperasi')->middleware('jwt.verify');
Route::post('getJadwalOperasiHarian','Api\AntreanController@jadwalOperasiHarian')->middleware('jwt.verify');
Route::post('verifikasiAntrean','Api\AntreanController@verifikasiAntrean')->middleware('jwt.verify');

//MOBILE
Route::post('app-registrasi','Api\MobileAppController@registrasi')->middleware('jwt.verify');
Route::get('app-listjadwal','Api\MobileAppController@getListJadwal')->middleware('jwt.verify');
Route::post('app-verifikasi','Api\MobileAppController@verifikasi')->middleware('jwt.verify');
Route::get('app-profilpasien/{id}','Api\MobileAppController@getProfilPasien')->middleware('jwt.verify');
// Route::post('app-profilpasien','Api\MobileAppController@getProfilPasien')->middleware('jwt.verify');
Route::get('app-jadwalpasien/{id}','Api\MobileAppController@getJadwalPasien')->middleware('jwt.verify');
// Route::post('app-jadwalpasien','Api\MobileAppController@getJadwalPasien')->middleware('jwt.verify');
Route::post('app-riwayat','Api\MobileAppController@getRiwayatPasien')->middleware('jwt.verify');
Route::get('app-riwayat/{id}','Api\MobileAppController@getRiwayatPasien')->middleware('jwt.verify');