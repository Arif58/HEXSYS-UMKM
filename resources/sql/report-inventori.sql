INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV10', 'Report', '9010', 'INV', 2, '#', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);

	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1001', 'Stok Masuk', '901001', 'INV10', 3, 'inventori/report/stok-in', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1002', 'Stok Keluar', '901002', 'INV10', 3, 'inventori/report/stok-out', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1003', 'Transfer Barang', '901003', 'INV10', 3, 'inventori/report/transfer-stok', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1004', 'Penyesuaian Stok', '901004', 'INV10', 3, 'inventori/report/penyesuain-stok', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1005', 'Kartu Stok', '901005', 'INV10', 3, 'inventori/report/kartu-stok', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1006', 'Stok Minimum', '901006', 'INV10', 3, 'inventori/report/stok-minimum', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1021', 'Permintaan Barang', '901021', 'INV10', 3, 'inventori/report/permintaan-barang', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1022', 'Permohonan Pembelian', '901022', 'INV10', 3, 'inventori/report/purchase-request', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1023', 'Pesanan Pembelian', '901023', 'INV10', 3, 'inventori/report/purchase-order', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1024', 'Penerimaan Barang', '901024', 'INV10', 3, 'inventori/report/receive', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1025', 'Retur Barang', '901025', 'INV10', 3, 'inventori/report/retur', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1026', 'Realisasi Permohonan Pembelian', '901026', 'INV10', 3, 'inventori/report/realisasi-pr', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1027', 'Realisasi Pesanan Pembelian', '901027', 'INV10', 3, 'inventori/report/realisasi-po', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);
	
	--INSERT INTO auth.menus (menu_cd, menu_nm, menu_no, menu_root, menu_level, menu_url, menu_image, created_by, updated_by, created_at, updated_at) VALUES('INV1031', 'Approval', '901031', 'INV10', 3, 'inventori/report/approval', NULL, 'admin', NULL, CURRENT_TIMESTAMP, NULL);

/*--All Role--*/
/* INSERT INTO auth.role_menus (
menu_cd,
role_cd,
created_by,
created_at 
)
SELECT 
menu_cd,
role_cd,
'admin' AS created_by,now()
FROM auth.menus m 
JOIN auth.roles ON 1=1
WHERE menu_cd ILIKE 'INV10%'; */

INSERT INTO auth.role_menus (
role_cd,
menu_cd,
created_by,
created_at 
)
SELECT 
'superuser',
menu_cd,
'admin' AS created_by,now()
FROM auth.menus m
WHERE menu_cd ILIKE 'INV10%';

INSERT INTO auth.role_menus (
role_cd,
menu_cd,
created_by,
created_at 
)
SELECT 
'admin',
menu_cd,
'admin' AS created_by,now()
FROM auth.menus m
WHERE menu_cd ILIKE 'INV10%';

INSERT INTO auth.role_menus (
role_cd,
menu_cd,
created_by,
created_at 
)
SELECT 
'admwh',
menu_cd,
'admin' AS created_by,now()
FROM auth.menus m
WHERE menu_cd ILIKE 'INV10%';
