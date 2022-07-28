<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your module. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => 'inventori','middleware' => ['check.role.menu:INV']], function () {
    Route::get('/', function () {
        return redirect('inventori/daftar-inventori');
    });
	
	Route::group(['prefix' => 'file'], function (){
		Route::post('/{id}', 'FileController@store');
		Route::get('/delete/{id}', 'FileController@destroy');
	});
	
	Route::group(['prefix' => 'setting','middleware' => ['check.role.menu:INV01']], function () {
        Route::get('/', function () {
            return redirect('inventori/satuan');
        });

        /* satuan */
        Route::group(['prefix' => 'satuan','middleware' => ['check.role.menu:INV0101']], function () {
            Route::get('/', 'Setting\InvUnitController@index');
            Route::post('/', 'Setting\InvUnitController@store');
            Route::post('/data', 'Setting\InvUnitController@getData')->name('satuan.get-data');
            Route::get('/{id}', 'Setting\InvUnitController@show');
            Route::put('/{id}', 'Setting\InvUnitController@update');
            Route::delete('/{id}', 'Setting\InvUnitController@destroy');
        });

        /* tipe-inventori */
        Route::group(['prefix' => 'tipe-inventori','middleware' => ['check.role.menu:INV0102']], function () {
            Route::get('/', 'Setting\InvItemTypeController@index');
            Route::post('/', 'Setting\InvItemTypeController@store');
            Route::post('/data', 'Setting\InvItemTypeController@getData')->name('tipe-inventori.get-data');
            Route::get('/{id}', 'Setting\InvItemTypeController@show');
            Route::put('/{id}', 'Setting\InvItemTypeController@update');
            Route::delete('/{id}', 'Setting\InvItemTypeController@destroy');
        });

        /* pos-inventori */
        Route::group(['prefix' => 'pos-inventori','middleware' => ['check.role.menu:INV0103']], function () {
            Route::get('/', 'Setting\PosInventoriController@index');
            Route::post('/', 'Setting\PosInventoriController@store');
            Route::post('/data', 'Setting\PosInventoriController@getData')->name('pos-inventori.get-data');
            Route::get('/{id}', 'Setting\PosInventoriController@show');
            Route::put('/{id}', 'Setting\PosInventoriController@update');
            Route::delete('/{id}', 'Setting\PosInventoriController@destroy');
        });

        /* supplier */
        Route::group(['prefix' => 'supplier','middleware' => ['check.role.menu:INV0104']], function () {
            Route::get('/', 'Setting\SupplierController@index');
            Route::post('/', 'Setting\SupplierController@store');
            Route::post('/data', 'Setting\SupplierController@getData')->name('supplier.get-data');
            Route::get('/{id}', 'Setting\SupplierController@show');
            Route::put('/{id}', 'Setting\SupplierController@update');
            Route::delete('/{id}', 'Setting\SupplierController@destroy');
        });

        /* principal */
        Route::group(['prefix' => 'principal','middleware' => ['check.role.menu:INV0105']], function () {
            Route::get('/', 'Setting\PrincipalController@index');
            Route::post('/', 'Setting\PrincipalController@store');
            Route::post('/data', 'Setting\PrincipalController@getData')->name('principal.get-data');
            Route::get('/{id}', 'Setting\PrincipalController@show');
            Route::put('/{id}', 'Setting\PrincipalController@update');
            Route::delete('/{id}', 'Setting\PrincipalController@destroy');
        });

        /* golongan */
        Route::group(['prefix' => 'golongan','middleware' => ['check.role.menu:INV0105']], function () {
            Route::get('/', 'Setting\GolonganController@index');
            Route::post('/', 'Setting\GolonganController@store');
            Route::post('/data', 'Setting\GolonganController@getData')->name('golongan.get-data');
            Route::get('/{id}', 'Setting\GolonganController@show');
            Route::put('/{id}', 'Setting\GolonganController@update');
            Route::delete('/{id}', 'Setting\GolonganController@destroy');
        });

        /* kategori */
        Route::group(['prefix' => 'kategori','middleware' => ['check.role.menu:INV0105']], function () {
            Route::get('/', 'Setting\KategoriController@index');
            Route::post('/', 'Setting\KategoriController@store');
            Route::post('/data', 'Setting\KategoriController@getData')->name('kategori.get-data');
            Route::get('/{id}', 'Setting\KategoriController@show');
            Route::put('/{id}', 'Setting\KategoriController@update');
            Route::delete('/{id}', 'Setting\KategoriController@destroy');
        });

        /* formula */
        Route::group(['prefix' => 'formula','middleware' => ['check.role.menu:INV0106']], function () {
            Route::get('/', 'Setting\FormulaController@index');
            Route::post('/', 'Setting\FormulaController@store');
            Route::post('/data', 'Setting\FormulaController@getData')->name('formula.get-data');
            Route::get('/{id}', 'Setting\FormulaController@show');
            Route::put('/{id}', 'Setting\FormulaController@update');
            Route::delete('/{id}', 'Setting\FormulaController@destroy');
        });

    });
    /* daftar-inventori */
    Route::get('/datalist', 'InvItemMasterController@getDataList');
	Route::get('/tipeaset', 'InvItemMasterController@getTipeAset');
	Route::get('/satuanlist', 'InvItemMasterController@getSatuanList');
	
    Route::group(['prefix' => 'daftar-inventori','middleware' => ['check.role.menu:INV02']], function () {
        Route::get('/', 'InvItemMasterController@index');
        Route::get('/detail/{id}', 'InvItemMasterController@detail');
        Route::post('/', 'InvItemMasterController@store');
        Route::post('/data', 'InvItemMasterController@getData')->name('daftar-inventori.get-data');
        Route::get('/{id}', 'InvItemMasterController@show');
        Route::put('/{id}', 'InvItemMasterController@update');
        Route::put('/image/{id}', 'InvItemMasterController@updateImage');
        Route::delete('/{id}', 'InvItemMasterController@destroy');
        Route::post('/satuan', 'InvItemMasterController@storeSatuan');
        Route::post('/delete-satuan', 'InvItemMasterController@deleteSatuan');
        Route::post('/data-satuan', 'InvItemMasterController@getDataSatuan');
        Route::post('cek-satuan','InvItemMasterController@cekSatuan');
        Route::post('/formula', 'InvItemMasterController@storeFormula');
        Route::post('/delete-formula', 'InvItemMasterController@deleteFormula');
        Route::post('/data-formula', 'InvItemMasterController@getDataFormula');
    });

    /* stock-inventori */
    Route::group(['prefix' => 'stock-inventori','middleware' => ['check.role.menu:INV03']], function () {
        Route::get('/', 'StockInventoriController@index');
        Route::post('/data', 'StockInventoriController@getData')->name('stock-inventori.get-data');
        Route::get('/{id}', 'StockInventoriController@show');
    });

    /* mutasi-inventori */
    Route::group(['prefix' => 'mutasi-inventori','middleware' => ['check.role.menu:INV04']], function () {
        
        /* stock in */
        Route::group(['prefix' => 'stock-in','middleware' => ['check.role.menu:INV0401']], function () {
            Route::get('/', 'MutasiInventori\StockInController@index');
            Route::post('/data', 'StockInventoriController@getData');
            Route::get('/{id}', 'StockInventoriController@show');
            Route::put('/{id}', 'MutasiInventori\StockInController@update');
        });

        /* stock out */
        Route::group(['prefix' => 'stock-out','middleware' => ['check.role.menu:INV0402']], function () {
            Route::get('/', 'MutasiInventori\StockOutController@index');
            Route::post('/data', 'StockInventoriController@getData');
            Route::get('/{id}', 'StockInventoriController@show');
            Route::put('/{id}', 'MutasiInventori\StockOutController@update');
        });

        /* transfer */
        Route::group(['prefix' => 'transfer','middleware' => ['check.role.menu:INV0403']], function () {
            Route::get('/', 'MutasiInventori\TransferController@index');
            Route::post('/data', 'StockInventoriController@getData');
            Route::get('/{id}', 'StockInventoriController@show');
            Route::put('/{id}', 'MutasiInventori\TransferController@update');
        });

        /* konversi */
        Route::group(['prefix' => 'konversi','middleware' => ['check.role.menu:INV0404']], function () {
            Route::get('/', 'MutasiInventori\KonversiController@index');
            Route::post('/data', 'StockInventoriController@getData');
            Route::get('/{id}', 'StockInventoriController@show');
            Route::put('/{id}', 'MutasiInventori\KonversiController@update');
            Route::post('/konversi-multi','MutasiInventori\KonversiController@konversiMulti');
        });

        /* penyesuaian */
        Route::group(['prefix' => 'penyesuaian','middleware' => ['check.role.menu:INV0405']], function () {
            Route::get('/', 'MutasiInventori\StockAdjustmentController@index');
            Route::post('/data', 'StockInventoriController@getData');
            Route::get('/{id}', 'StockInventoriController@show');
            Route::put('/{id}', 'MutasiInventori\StockAdjustmentController@update');
        });

        /* stock alert */
        Route::group(['prefix' => 'stock-alert','middleware' => ['check.role.menu:INV0406']], function () {
            Route::get('/', 'MutasiInventori\StockAlertController@index');
            Route::post('/data', 'MutasiInventori\StockAlertController@getData');
        });

        /* history */
        Route::group(['prefix' => 'history','middleware' => ['check.role.menu:INV0408']], function () {
            Route::get('/', 'MutasiInventori\HistoryController@index');
            Route::post('/data', 'MutasiInventori\HistoryController@getData');
        });
		
		/* produksi */
        Route::group(['prefix' => 'produksi','middleware' => ['check.role.menu:INV0409']], function () {
            Route::get('/{id?}', 'MutasiInventori\ProduksiController@index');
            Route::post('/data', 'MutasiInventori\ProduksiController@getData');
            Route::post('/', 'MutasiInventori\ProduksiController@store');
            Route::put('/{id}', 'MutasiInventori\ProduksiController@update');
            Route::delete('/{id}', 'MutasiInventori\ProduksiController@destroy');

            Route::get('/print/{id}', 'MutasiInventori\ProduksiController@print');

            Route::post('/item/{id}', 'MutasiInventori\ProduksiController@storeItem');
            Route::put('/item/{id}', 'MutasiInventori\ProduksiController@updateItem');
			Route::put('/itempos/{id}', 'MutasiInventori\ProduksiController@updatePos');
            Route::delete('/item/{id}', 'MutasiInventori\ProduksiController@destroyItem');
        });
    });

    /* stock opname */
    Route::group(['prefix' => 'stock-opname','middleware' => ['check.role.menu:INV05']], function () {
        Route::get('/{id?}', 'StockOpnameController@index');
        Route::post('/data', 'StockOpnameController@getData');
        Route::post('/', 'StockOpnameController@store');
        Route::put('/{id}', 'StockOpnameController@update');
        Route::delete('/{id}', 'StockOpnameController@destroy');

        Route::get('/print/{id}', 'StockOpnameController@print');
        Route::put('/item/{id}', 'StockOpnameController@updateItem');
    });

    /* pembelian */
    Route::group(['prefix' => 'pembelian','middleware' => ['check.role.menu:INV06']], function () {
        /* purchase request */
        Route::group(['prefix' => 'purchase-request'/*,'middleware' => ['check.role.menu:INV0600']*/], function () {
            Route::get('/{id?}', 'Pembelian\PurchaseRequestController@index');
            Route::post('/data', 'Pembelian\PurchaseRequestController@getData');
            Route::post('/', 'Pembelian\PurchaseRequestController@store');
            Route::put('/{id}', 'Pembelian\PurchaseRequestController@update');
            Route::delete('/{id}', 'Pembelian\PurchaseRequestController@destroy');

            Route::get('/print/{id}', 'Pembelian\PurchaseRequestController@print');

            Route::post('/item/{id}', 'Pembelian\PurchaseRequestController@storeItem');
            Route::put('/item/{id}', 'Pembelian\PurchaseRequestController@updateItem');
			Route::put('/itempos/{id}', 'Pembelian\PurchaseRequestController@updatePos');
            Route::delete('/item/{id}', 'Pembelian\PurchaseRequestController@destroyItem');
        });
		
		/* purchase order */
        Route::group(['prefix' => 'purchase-order'/*,'middleware' => ['check.role.menu:INV0601']*/], function () {
            Route::get('/{id?}', 'Pembelian\PurchaseOrderController@index');
			Route::get('/po/{id}', 'Pembelian\PurchaseOrderController@getDataPo');
            Route::post('/data', 'Pembelian\PurchaseOrderController@getData');
            Route::post('/', 'Pembelian\PurchaseOrderController@store');
            Route::put('/{id}', 'Pembelian\PurchaseOrderController@update');
            Route::delete('/{id}', 'Pembelian\PurchaseOrderController@destroy');

            Route::post('/item/{id}', 'Pembelian\PurchaseOrderController@storeItem');
            Route::put('/item/{id}', 'Pembelian\PurchaseOrderController@updateItem');
            Route::delete('/item/{id}', 'Pembelian\PurchaseOrderController@destroyItem');
			Route::put('/closing/{id}', 'Pembelian\PurchaseOrderController@closing');
			Route::put('/generate/{id}', 'Pembelian\PurchaseOrderController@generatePo');
			
			Route::get('/print/{id}', 'Pembelian\PurchaseOrderController@print');
			Route::get('/print-request/{id}', 'Pembelian\PurchaseOrderController@printRequest');
			Route::get('/print-nota/{id}', 'Pembelian\PurchaseOrderController@printNota');
			Route::get('/print-bast/{id}', 'Pembelian\PurchaseOrderController@printBast');
			Route::get('/print-bacek/{id}', 'Pembelian\PurchaseOrderController@printBacek');
			
			Route::post('/discount/{id}', 'Pembelian\PurchaseOrderController@discount');
        });

        /* receive item */
        Route::group(['prefix' => 'receive-item','middleware' => ['check.role.menu:INV0602']], function () {
            Route::get('/{id?}', 'Pembelian\ReceiveItemController@index');
            Route::post('/data', 'Pembelian\ReceiveItemController@getData');
            Route::post('/', 'Pembelian\ReceiveItemController@store');
            Route::put('/{id}', 'Pembelian\ReceiveItemController@update');
            Route::delete('/{id}', 'Pembelian\ReceiveItemController@destroy');

            Route::get('/print/{id}', 'Pembelian\ReceiveItemController@print');

            Route::post('/item/{id}', 'Pembelian\ReceiveItemController@storeItem');
            Route::put('/item/{id}', 'Pembelian\ReceiveItemController@updateItem');
            Route::delete('/item/{id}', 'Pembelian\ReceiveItemController@destroyItem');
            Route::post('/data-list-po','Pembelian\ReceiveItemController@getDataListPo');
        });

        /* retur item */
        Route::group(['prefix' => 'retur-item','middleware' => ['check.role.menu:INV0603']], function () {
            Route::get('/{id?}', 'Pembelian\ReturItemController@index');
            Route::post('/data', 'Pembelian\ReturItemController@getData');
            Route::post('/', 'Pembelian\ReturItemController@store');
            Route::put('/{id}', 'Pembelian\ReturItemController@update');
            Route::delete('/{id}', 'Pembelian\ReturItemController@destroy');

            Route::get('/print/{id}', 'Pembelian\ReturItemController@print');

            Route::post('/item/{id}', 'Pembelian\ReturItemController@storeItem');
            Route::put('/item/{id}', 'Pembelian\ReturItemController@updateItem');
            Route::delete('/item/{id}', 'Pembelian\ReturItemController@destroyItem');
            Route::post('/data-list-faktur','Pembelian\ReturItemController@getDataListFaktur');
        });
		
		/* approval */
        Route::group(['prefix' => 'approval'/*,'middleware' => ['check.role.menu:INV0605']*/], function () {
            //Route::get('/{id?}', 'Pembelian\ApprovalController@index');
			Route::get('/', 'Pembelian\ApprovalController@index');
            Route::post('/data', 'Pembelian\ApprovalController@getData');
			Route::post('/history', 'Pembelian\ApprovalController@getHistory');
            Route::put('/{id}', 'Pembelian\ApprovalController@update');
            Route::delete('/{id}', 'Pembelian\ApprovalController@destroy');
			
			Route::get('/list/{id}', 'Pembelian\ApprovalController@getApproval');
			Route::put('/reject/{id}', 'Pembelian\ApprovalController@reject');
			Route::get('/view/{id}', 'Pembelian\ApprovalController@viewData');
			Route::get('/file/{id}', 'Pembelian\ApprovalController@viewFile');
			
			Route::get('/edit/{id?}', 'Pembelian\ApprovalController@editData');
        });
		
		/* invoice */
        Route::group(['prefix' => 'invoice'/*,'middleware' => ['check.role.menu:INV0606']*/], function () {
            Route::get('/', 'Pembelian\PurchaseOrderController@invoice');
			Route::post('/invoice', 'Pembelian\PurchaseOrderController@getInvoice');
			Route::put('/set/{id}', 'Pembelian\PurchaseOrderController@setInvoice');
			Route::put('/close/{id}', 'Pembelian\PurchaseOrderController@closeInvoice');
        });
    });
	
	/* laporan inventori */
    Route::group(['prefix' => 'report','middleware' => ['check.role.menu:INV10']], function () {
        /* stock in */
        Route::group(['prefix' => 'stok-in'], function () {
            Route::get('/', 'Report\StockInController@index');
            Route::post('/data', 'Report\StockInController@getData');
        });

        /* stock out */
        Route::group(['prefix' => 'stok-out'], function () {
            Route::get('/', 'Report\StockOutController@index');
            Route::post('/data', 'Report\StockOutController@getData');
        });

        /* transfer */
        Route::group(['prefix' => 'transfer-stok'], function () {
            Route::get('/', 'Report\TransferController@index');
            Route::post('/data', 'Report\TransferController@getData');
        });

        /* penyesuaian */
        Route::group(['prefix' => 'penyesuain-stok','middleware' => ['check.role.menu:INV0405']], function () {
            Route::get('/', 'Report\StockAdjustmentController@index');
            Route::post('/data', 'Report\StockAdjustmentController@getData');
        });
		
		/* kartu stok */
        Route::group(['prefix' => 'kartu-stok'], function () {
            Route::get('/', 'Report\HistoryController@index');
            Route::post('/data', 'Report\HistoryController@getData');
        });

        /* stock alert */
        Route::group(['prefix' => 'stok-minimum','middleware' => ['check.role.menu:INV0406']], function () {
            Route::get('/', 'Report\StockAlertController@index');
            Route::post('/data', 'Report\StockAlertController@getData');
        });

        /* permintaan barang */
        Route::group(['prefix' => 'permintaan-barang'], function () {
            Route::get('/', 'Report\PurchaseRequestController@index');
            Route::post('/data', 'Report\PurchaseRequestController@getData');
        });
		
		/* permohonan Pembelian */
        Route::group(['prefix' => 'purchase-request'], function () {
            Route::get('/', 'Report\PurchasePoprController@index');
            Route::post('/data', 'Report\PurchasePoprController@getData');
        });
		
		/* purchase order */
        Route::group(['prefix' => 'purchase-order'], function () {
            Route::get('/', 'Report\PurchaseOrderController@index');
            Route::post('/data', 'Report\PurchaseOrderController@getData');
        });
		
		/* realisasi permohonan Pembelian */
        Route::group(['prefix' => 'realisasi-pr'], function () {
            Route::get('/', 'Report\PurchasePoprController@realisasi');
            Route::post('/data', 'Report\PurchasePoprController@getRealisasi');
        });
		
		/* realisasi purchase order */
        Route::group(['prefix' => 'realisasi-po'], function () {
            Route::get('/', 'Report\PurchaseOrderController@realisasi');
            Route::post('/data', 'Report\PurchaseOrderController@getRealisasi');
        });

        /* receive item */
        Route::group(['prefix' => 'receive'], function () {
            Route::get('/', 'Report\ReceiveItemController@index');
            Route::post('/data', 'Report\ReceiveItemController@getData');
        });

        /* retur item */
        Route::group(['prefix' => 'retur'], function () {
            Route::get('/{id?}', 'Report\ReturItemController@index');
            Route::post('/data', 'Report\ReturItemController@getData');
        });
		
		/* approval */
        Route::group(['prefix' => 'approval'], function () {
            Route::get('/{id?}', 'Report\ApprovalController@index');
            Route::post('/data', 'Report\ApprovalController@getData');
        });
    });

    Route::get('/golongan/{root?}', 'Setting\GolonganController@getListData');
    Route::get('/kategori/{root?}', 'Setting\KategoriController@getListData');
});
