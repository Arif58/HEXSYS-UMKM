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

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

/* dropdown data */
Route::group(['prefix' => 'data-list'], function () {
	Route::get('aktivitas', 'Erp\AktivitasController@getDataList');
	Route::get('aktivitas/{id}', 'Erp\AktivitasController@getDataInfo');
});
	
Route::group(['prefix' => 'sistem','middleware' => ['check.role.menu:SYS']], function () {
    Route::get('/', function () {
        return redirect('sistem/admin/user');
    });
	
	/* admin */
    Route::group(['prefix' => 'admin','middleware' => ['check.role.menu:SYS01']], function () {
        /* user */
        Route::group(['prefix' => 'user','middleware' => ['check.role.menu:SYS0101']], function () {
            Route::get('/', 'Admin\UserController@index');
            Route::get('/daftar-koneksi/{id}', 'Admin\UserController@getConnection');
            Route::post('/', 'Admin\UserController@store');
            Route::post('/data', 'Admin\UserController@getData')->name('autorisasi.get-data');
            Route::get('/{id}', 'Admin\UserController@show');
            Route::put('/{id}', 'Admin\UserController@update');
            Route::delete('/{id}', 'Admin\UserController@destroy');
            Route::post('/password', 'Admin\UserController@changePassword');

            Route::group(['prefix' => 'profil','middleware' => ['check.role.menu:SYS01']], function () {
                Route::get('/{id}', 'Admin\UserController@profil');
                Route::put('/image/{id}', 'Admin\UserController@changeImage');
            });
        });

        /* autorisasi */
        Route::group(['prefix' => 'autorisasi','middleware' => ['check.role.menu:SYS0102']], function () {
            Route::get('/', 'Admin\RoleController@index');
            Route::post('/', 'Admin\RoleController@store');
            Route::post('/data', 'Admin\RoleController@getData')->name('autorisasi.get-data');
            Route::get('/{id}', 'Admin\RoleController@show');
            Route::put('/{id}', 'Admin\RoleController@update');
            Route::delete('/{id}', 'Admin\RoleController@destroy');
            Route::get('/detail/{id}', 'Admin\RoleController@detail');
            Route::post('/role-menu', 'Admin\RoleController@saveRoleMenu');
        });
        
        //--kode
        Route::group(['prefix' => 'kode','middleware' => ['check.role.menu:SYS0103']], function () {
            Route::get('/', 'Admin\CodeController@index');
            Route::post('/data', 'Admin\CodeController@getData');
            Route::post('/', 'Admin\CodeController@store');
            Route::get('/{id}', 'Admin\CodeController@show');
            Route::put('/{id}', 'Admin\CodeController@update');
            Route::delete('/{id}', 'Admin\CodeController@destroy');
        });

        /* log-activity */
        Route::group(['prefix' => 'log-activity','middleware' => ['check.role.menu:SYS0104']], function () {
            Route::get('/', 'Admin\LogActivityController@index');
            Route::post('/', 'Admin\LogActivityController@store');
            Route::post('/data', 'Admin\LogActivityController@getData');
            Route::get('/{id}', 'Admin\LogActivityController@show');
            Route::delete('/{id?}', 'Admin\LogActivityController@destroy');
        });

        /* region */
        Route::group(['prefix' => 'region','middleware' => ['check.role.menu:SYS0105']], function () {
            Route::get('/{id?}', 'Admin\RegionController@index');
            Route::post('/', 'Admin\RegionController@store');
            Route::post('/data', 'Admin\RegionController@getData');
            Route::put('/{id}', 'Admin\RegionController@update');
            Route::get('/{id}', 'Admin\RegionController@show');
            Route::delete('/{id}', 'Admin\RegionController@destroy');
        });

        //--kode
        Route::group(['prefix' => 'company','middleware' => ['check.role.menu:SYS0106']], function () {
            Route::get('/{id?}', 'Admin\CompanyController@index');
            Route::post('/data', 'Admin\CompanyController@getData');
            Route::post('/', 'Admin\CompanyController@store');
            Route::get('/{id}', 'Admin\CompanyController@show');
            Route::put('/{id}', 'Admin\CompanyController@update');
            Route::delete('/{id}', 'Admin\CompanyController@destroy');
        });
    });
    /* erp */
    Route::group(['prefix' => 'erp','middleware' => ['check.role.menu:SYS02']], function () {
        Route::group(['prefix' => 'dropdown-data'], function () {
            Route::get('/term-pembayaran/{periode-pembayaran?}', 'Erp\TermPembayaranController@getDataList');
            Route::get('/rekening-bank', 'Erp\RekeningBankController@getDataList');
            Route::get('/mata-uang', 'Erp\MataUangController@getDataList');
            Route::get('/bank', 'Erp\MataUangController@getDataListBank');
            
            Route::get('/periode-pembayaran', 'Erp\PeriodePembayaranController@getDataList');
        });
        
        /* rekening-bank */
        Route::group(['prefix' => 'rekening-bank','middleware' => ['check.role.menu:SYS0201']], function () {
            Route::get('/', 'Erp\RekeningBankController@index');
            Route::post('/', 'Erp\RekeningBankController@store');
            Route::post('/data', 'Erp\RekeningBankController@getData');
            Route::get('/{id}', 'Erp\RekeningBankController@show');
            Route::put('/{id}', 'Erp\RekeningBankController@update');
            Route::delete('/{id}', 'Erp\RekeningBankController@destroy');
            Route::get('/data/list', 'Erp\RekeningBankController@getDataList');
        });

        /* mata-uang */
        Route::group(['prefix' => 'mata-uang','middleware' => ['check.role.menu:SYS0202']], function () {
            Route::get('/', 'Erp\MataUangController@index');
            Route::post('/', 'Erp\MataUangController@store');
            Route::post('/data', 'Erp\MataUangController@getData');
            Route::get('/{id}', 'Erp\MataUangController@show');
            Route::put('/{id}', 'Erp\MataUangController@update');
            Route::delete('/{id}', 'Erp\MataUangController@destroy');
            Route::get('/data/list', 'Erp\MataUangController@getDataList');
        });

        /* periode-pembayaran */
        Route::group(['prefix' => 'periode-pembayaran','middleware' => ['check.role.menu:SYS0203']], function () {
            Route::get('/', 'Erp\PeriodePembayaranController@index');
            Route::post('/', 'Erp\PeriodePembayaranController@store');
            Route::post('/data', 'Erp\PeriodePembayaranController@getData');
            Route::get('/{id}', 'Erp\PeriodePembayaranController@show');
            Route::put('/{id}', 'Erp\PeriodePembayaranController@update');
            Route::delete('/{id}', 'Erp\PeriodePembayaranController@destroy');
            Route::get('/data/list', 'Erp\PeriodePembayaranController@getDataList');
        });

        /* term-pembayaran */
        Route::group(['prefix' => 'term-pembayaran','middleware' => ['check.role.menu:SYS0204']], function () {
            Route::get('/', 'Erp\TermPembayaranController@index');
            Route::post('/', 'Erp\TermPembayaranController@store');
            Route::post('/data', 'Erp\TermPembayaranController@getData');
            Route::get('/{id}', 'Erp\TermPembayaranController@show');
            Route::put('/{id}', 'Erp\TermPembayaranController@update');
            Route::delete('/{id}', 'Erp\TermPembayaranController@destroy');
            Route::get('/data/list', 'Erp\TermPembayaranController@getDataList');
        });

        /* form */
        Route::group(['prefix' => 'form','middleware' => ['check.role.menu:SYS0205']], function () {
            Route::get('/', 'Erp\FormController@index');
            Route::post('/', 'Erp\FormController@store');
            Route::post('/data', 'Erp\FormController@getData');
            Route::get('/{id}', 'Erp\FormController@show');
            Route::put('/{id}', 'Erp\FormController@update');
            Route::delete('/{id}', 'Erp\FormController@destroy');
            Route::get('/data/list', 'Erp\FormController@getDataList');
        });

        /* approval */
        Route::group(['prefix' => 'approval','middleware' => ['check.role.menu:SYS0206']], function () {
            Route::get('/', 'Erp\ApprovalController@index');
            Route::post('/', 'Erp\ApprovalController@store');
            Route::post('/data', 'Erp\ApprovalController@getData');
            Route::get('/{id}', 'Erp\ApprovalController@show');
            Route::put('/{id}', 'Erp\ApprovalController@update');
            Route::delete('/{id}', 'Erp\ApprovalController@destroy');
            Route::get('/data/list', 'Erp\ApprovalController@getDataList');

        });
		
		/* aktivitas */
        Route::group(['prefix' => 'aktivitas','middleware' => ['check.role.menu:SYS0207']], function () {
            Route::get('/', 'Erp\AktivitasController@index');
            Route::post('/', 'Erp\AktivitasController@store');
            Route::post('/data', 'Erp\AktivitasController@getData');
            Route::get('/{id}', 'Erp\AktivitasController@show');
            Route::put('/{id}', 'Erp\AktivitasController@update');
            Route::delete('/{id}', 'Erp\AktivitasController@destroy');
            Route::get('/data/list', 'Erp\AktivitasController@getDataList');
        });
    });
    /* inv */
    /* pos */
});


Route::group(['prefix' => 'daftar-daerah'], function () {
    Route::get('/', 'Admin\RegionController@getRegionList');
    Route::get('/by-root/{id}', 'Admin\RegionController@getRegionList');
    
    Route::get('/provinsi', [
        'uses'          => 'Admin\RegionController@getRegionList',
        'region_level'  => 1
    ]);

    Route::get('/kabupaten', [
        'uses'          => 'Admin\RegionController@getRegionList',
        'region_level'  => 2
    ]);

    Route::get('/kecamatan', [
        'uses'          => 'Admin\RegionController@getRegionList',
        'region_level'  => 3
    ]);

    Route::get('/kelurahan', [
        'uses'          => 'Admin\RegionController@getRegionList',
        'region_level'  => 4
    ]);

});

Route::get('/daftar-negara', 'Admin\NationController@getNationList');
Route::get('/nama-daerah/{id}','Admin\RegionController@getRegionName');

/* my profile */
Route::group(['prefix' => 'my-profile'], function () {
    Route::get('/', 'MyProfileController@index');
    Route::get('/{id}', 'MyProfileController@show');
    Route::put('/', 'MyProfileController@update');
    Route::put('/image', 'MyProfileController@changeImage');
    Route::post('/password', 'MyProfileController@changePassword');
});

//Global Data route (select2 list, single data show, etc.)
Route::group(['prefix' => 'global-data'], function (){
    
});

/* changed soon on erp dev */
Route::group(['prefix' => 'dropdown-data'], function () {
    Route::get('/approval', 'Erp\ApprovalController@getDataList');
    
    Route::get('/term-pembayaran/{periode-pembayaran?}', 'Erp\TermPembayaranController@getDataList');
    Route::get('/rekening-bank', 'Erp\RekeningBankController@getDataList');
    Route::get('/mata-uang', 'Erp\MataUangController@getDataList');
    Route::get('/bank', 'Erp\MataUangController@getDataListBank');
    Route::get('/customer', 'Erp\CustomerController@getDataList');
    Route::get('/supplier', 'Erp\SupplierController@getDataList');
    Route::get('/form', 'Erp\FormController@getDataList');

    Route::get('/coa', '\Modules\ErpGL\Http\Controllers\Setting\CoaController@getDataList');
    Route::get('/cost-center', '\Modules\ErpGL\Http\Controllers\Setting\CostCenterController@getDataList');
    Route::get('/journal-document', '\Modules\ErpGL\Http\Controllers\Setting\DokumenJurnalController@getDataList');
    
    Route::get('/periode-pembayaran', 'Erp\PeriodePembayaranController@getDataList');
    Route::get('/term-pembayaran', 'Erp\TermPembayaranController@getDataList');
});