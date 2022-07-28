<?php
namespace Modules\Inventori\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Models\AuthMenu;

class InventoriMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        AuthMenu::insert([
            [
                'menu_cd'       => 'INV',
                'menu_nm'       => 'Inventori',
                'menu_url'      => 'inventori',
                'menu_no'       => '90',
                'menu_level'    => 1,
                'menu_root'     => '',
                'menu_image'    => 'icon-cart-add',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
            [
                'menu_cd'       => 'INV01',
                'menu_nm'       => 'Setting',
                'menu_url'      => '#',
                'menu_no'       => '9001',
                'menu_level'    => 2,
                'menu_root'     => 'INV',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],[
                'menu_cd'       => 'INV0101',
                'menu_nm'       => 'Satuan Inventori',
                'menu_url'      => 'inventori/setting/satuan',
                'menu_no'       => '900101',
                'menu_level'    => 3,
                'menu_root'     => 'INV01',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],[
                'menu_cd'       => 'INV0102',
                'menu_nm'       => 'Jenis Inventori',
                'menu_url'      => 'inventori/setting/tipe-inventori',
                'menu_no'       => '900102',
                'menu_level'    => 3,
                'menu_root'     => 'INV01',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],[
                'menu_cd'       => 'INV0103',
                'menu_nm'       => 'Gudang',
                'menu_url'      => 'inventori/setting/pos-inventori',
                'menu_no'       => '900103',
                'menu_level'    => 3,
                'menu_root'     => 'INV01',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
            [
                'menu_cd'       => 'INV0104',
                'menu_nm'       => 'Supplier',
                'menu_url'      => 'inventori/setting/supplier',
                'menu_no'       => '900104',
                'menu_level'    => 3,
                'menu_root'     => 'INV01',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
            /*[
                'menu_cd'       => 'INV0105',
                'menu_nm'       => 'Principal',
                'menu_url'      => 'inventori/setting/principal',
                'menu_no'       => '900105',
                'menu_level'    => 3,
                'menu_root'     => 'INV01',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
            [
                'menu_cd'       => 'INV0106',
                'menu_nm'       => 'Formula',
                'menu_url'      => 'inventori/setting/formula',
                'menu_no'       => '900106',
                'menu_level'    => 3,
                'menu_root'     => 'INV01',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],*/
            [
                'menu_cd'       => 'INV02',
                'menu_nm'       => 'Daftar Inventori',
                'menu_url'      => 'inventori/daftar-inventori',
                'menu_no'       => '9002',
                'menu_level'    => 2,
                'menu_root'     => 'INV',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
            [
                'menu_cd'       => 'INV03',
                'menu_nm'       => 'Stock Inventori',
                'menu_url'      => 'inventori/stock-inventori',
                'menu_no'       => '9003',
                'menu_level'    => 2,
                'menu_root'     => 'INV',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
            [
                'menu_cd'       => 'INV04',
                'menu_nm'       => 'Transaksi Inventori',
                'menu_url'      => 'inventori/mutasi-inventori',
                'menu_no'       => '9004',
                'menu_level'    => 2,
                'menu_root'     => 'INV',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],[
                'menu_cd'       => 'INV0401',
                'menu_nm'       => 'Transaksi Barang Masuk',
                'menu_url'      => 'inventori/mutasi-inventori/stock-in',
                'menu_no'       => '900401',
                'menu_level'    => 3,
                'menu_root'     => 'INV04',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],[
                'menu_cd'       => 'INV0402',
                'menu_nm'       => 'Transaksi Barang Keluar',
                'menu_url'      => 'inventori/mutasi-inventori/stock-out',
                'menu_no'       => '900402',
                'menu_level'    => 3,
                'menu_root'     => 'INV04',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],[
                'menu_cd'       => 'INV0403',
                'menu_nm'       => 'Transfer',
                'menu_url'      => 'inventori/mutasi-inventori/transfer',
                'menu_no'       => '900403',
                'menu_level'    => 3,
                'menu_root'     => 'INV04',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],[
                'menu_cd'       => 'INV0404',
                'menu_nm'       => 'Konversi',
                'menu_url'      => 'inventori/mutasi-inventori/konversi',
                'menu_no'       => '900404',
                'menu_level'    => 3,
                'menu_root'     => 'INV04',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],[
                'menu_cd'       => 'INV0405',
                'menu_nm'       => 'Penyesuaian',
                'menu_url'      => 'inventori/mutasi-inventori/penyesuaian',
                'menu_no'       => '900405',
                'menu_level'    => 3,
                'menu_root'     => 'INV04',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],[
                'menu_cd'       => 'INV0406',
                'menu_nm'       => 'Stock Alert',
                'menu_url'      => 'inventori/mutasi-inventori/stock-alert',
                'menu_no'       => '900406',
                'menu_level'    => 3,
                'menu_root'     => 'INV04',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
            /*[
                 'menu_cd'       => 'INV0407',
                 'menu_nm'       => 'Stock Opname',
                 'menu_url'      => 'inventori/mutasi-inventori/stock-opname',
                 'menu_no'       => '900407',
                 'menu_level'    => 3,
                 'menu_root'     => 'INV04',
                 'menu_image'    => '',
                 'created_by'    => 'admin',
                 'created_at'    => date('Y-m-d H:i:s')
            ],*/
            [
                'menu_cd'       => 'INV0408',
                'menu_nm'       => 'Riwayat Transaksi',
                'menu_url'      => 'inventori/mutasi-inventori/history',
                'menu_no'       => '900408',
                'menu_level'    => 3,
                'menu_root'     => 'INV04',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'menu_cd'       => 'INV0409',
                'menu_nm'       => 'Produksi',
                'menu_url'      => 'inventori/mutasi-inventori/produksi',
                'menu_no'       => '900409',
                'menu_level'    => 3,
                'menu_root'     => 'INV04',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'menu_cd'       => 'INV05',
                'menu_nm'       => 'Stock Opname',
                'menu_url'      => 'inventori/stock-opname',
                'menu_no'       => '9005',
                'menu_level'    => 2,
                'menu_root'     => 'INV',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],[
                'menu_cd'       => 'INV06',
                'menu_nm'       => 'Pembelian/Permintaan',
                'menu_url'      => 'inventori/pembelian',
                'menu_no'       => '9006',
                'menu_level'    => 2,
                'menu_root'     => 'INV',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'menu_cd'       => 'INV0600',
                'menu_nm'       => 'Permintaan Barang',
                'menu_url'      => 'inventori/pembelian/purchase-request',
                'menu_no'       => '900600',
                'menu_level'    => 3,
                'menu_root'     => 'INV06',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'menu_cd'       => 'INV0601',
                'menu_nm'       => 'Purchase Order',
                'menu_url'      => 'inventori/pembelian/purchase-order',
                'menu_no'       => '900601',
                'menu_level'    => 3,
                'menu_root'     => 'INV06',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'menu_cd'       => 'INV0604',
                'menu_nm'       => 'Permintaan Pembelian',
                'menu_url'      => 'inventori/pembelian/purchase-order/popr',
                'menu_no'       => '900601',
                'menu_level'    => 3,
                'menu_root'     => 'INV06',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'menu_cd'       => 'INV0602',
                'menu_nm'       => 'Penerimaan Barang',
                'menu_url'      => 'inventori/pembelian/receive-item',
                'menu_no'       => '900602',
                'menu_level'    => 3,
                'menu_root'     => 'INV06',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'menu_cd'       => 'INV0603',
                'menu_nm'       => 'Retur Barang',
                'menu_url'      => 'inventori/pembelian/retur-item',
                'menu_no'       => '900603',
                'menu_level'    => 3,
                'menu_root'     => 'INV06',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'menu_cd'       => 'INV0605',
                'menu_nm'       => 'Approval',
                'menu_url'      => 'inventori/pembelian/approval',
                'menu_no'       => '900605',
                'menu_level'    => 3,
                'menu_root'     => 'INV06',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ],
			[
                'menu_cd'       => 'INV0606',
                'menu_nm'       => 'Invoice',
                'menu_url'      => 'inventori/pembelian/invoice',
                'menu_no'       => '900606',
                'menu_level'    => 3,
                'menu_root'     => 'INV06',
                'menu_image'    => '',
                'created_by'    => 'admin',
                'created_at'    => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
