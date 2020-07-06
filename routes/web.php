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

// Route::get('reset_password/{token}', ['as' => 'password.reset', function($token)
// {
//     // implement your reset password route here!
// }]);
Auth::routes(['register' => false]);

Route::get('/', 'MapsController@maps');

// Route::get('/test', function () {
//     return view('admin.test');
// });

// Route::get('/tests', function () {
//         $poly = App\Distance::select('polyline')->first()->polyline;
//         $ex = explode (",", $poly);
//         $count = count($ex)-1;

//         for ($x = 0; $x <= $count; $x+=2) {
// 		   $distance[] = array(
// 		   		-$ex[$x],
// 		   		+$ex[$x+1]
// 		   );
// 		}

// 		return $distance;
//     });

Route::group(['middleware' => 'auth', 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/', function () {
        return view('admin.index');
    })->name('index');

    Route::resource('kecamatan', 'KecamatanController');
    Route::resource('kelurahan', 'KelurahanController');

    Route::resource('jenis_kasus', 'JenisKasusController');

    Route::resource('posko', 'PoskoController');
    Route::get('get-kelurahan-list', 'PoskoController@getKelurahan');
    Route::resource('rumah_sakit', 'RumahSakitController');
    Route::resource('pasien', 'PasienController');
    Route::resource('napi', 'NapiController');
    Route::get('data/pasien-all', 'PasienController@indexByPetugas')->name('pasien.petugas');
    Route::get('data/napi-all', 'NapiController@indexAll')->name('napi.all');
    Route::get('petugas/history', 'UserController@petugasHistory')->name('petugas.history');

    Route::resource('distance', 'DistanceController');

    Route::resource('user', 'UserController');
    Route::post('user/import', 'UserController@import_excel')->name('import.user');
    Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
	Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');
    
    Route::get('/peta', 'MapsController@polisi')->name('peta');
    
    Route::post('user_posko/{poskoId}', 'UserPoskoController@store')->name('user.posko');
    Route::delete('user_posko/{poskoId}', 'UserPoskoController@delete')->name('user.posko.delete');
    
    Route::post('user_pasien/{pasienId}', 'PasienController@storeUserPasien')->name('user.pasien');
    
    Route::get('laporan/panic_button/', 'PasienController@panicIndex')->name('pasien.panic');
    Route::get('interval/laporan/panic_button/', 'PasienController@setIntervalPanic')->name('pasien.panic_interval');
    
    Route::get('laporan/pasien/harian/', 'PasienController@laporanPasienPositif')->name('pasien.laporan');
    Route::get('interval/laporan/pasien/harian/', 'PasienController@intervalLaporanPasienPositif')->name('pasien.laporan_interval');
    
    Route::resource('test', 'TestController');
    Route::get('get_filtered_by', 'TestController@getFilteredResults');
    
    Route::get('cetak/data_pasien/pdf/{kecamatan_id}', 'PrintPdfController@print_pdf_pasien_per_kecmatan')->name('print.pdf_pasien.kecamatan');
    
    Route::get('get_filtered_by_kel', 'TestController@get_filtered_by_kel');
});

Route::group(['middleware' => 'auth', 'prefix' => 'pasien', 'as' => 'pasien.'], function () {

    Route::resource('laporan', 'PenilaianController');

    Route::get('tahap-1/penilaian', 'PenilaianController@beriNilai1')->name('penilaian1.index');
    Route::get('tahap-2/penilaian', 'PenilaianController@beriNilai2')->name('penilaian2.index');
    Route::post('penilaian1', 'PenilaianController@penilaian1')->name('penilaian.tahap1');
    Route::post('penilaian2/{id}', 'PenilaianController@penilaian2')->name('penilaian.tahap2');
    Route::resource('panic', 'PanicController');
    
});

Route::group(['middleware' => 'auth', 'prefix' => 'posko', 'as' => 'posko.'], function () {

    Route::resource('fitur', 'PoskoNewFiturController');
    Route::get('pasien/positif', 'PoskoNewFiturController@indexPasienPosko')->name('pasien.positif');
    Route::get('ajax/pasien', 'PoskoNewFiturController@setIntervalPasien')->name('pasien.interval');
    Route::match(['put', 'patch'], 'update/pasien/wa/{id}', 'PoskoNewFiturController@waPasien')->name('pasien.wa');
    Route::get('laporan/panic', 'PoskoNewFiturController@panicIndex')->name('panic.index');
    Route::match(['put', 'patch'], 'update/panic', 'PoskoNewFiturController@panicUpdateStatus')->name('panic.update');
    Route::get('ajax/panic', 'PoskoNewFiturController@setIntervalPanic')->name('panic.interval');
});

Route::group(['middleware' => 'auth', 'prefix' => 'dinas', 'as' => 'dinas.'], function () {

    Route::get('interval/laporan/pasien/', 'DinasController@intervalLaporanPasienPositif')->name('pasien.interval');
    Route::get('laporan/pasien/', 'DinasController@laporanPasienPositif')->name('pasien.positif');

    Route::get('pasien/', 'DinasController@index')->name('index');
    Route::get('dashboard/', 'DinasController@dashboard')->name('dashboard');
});

// Route::get('/home', 'HomeController@index')->name('home');
