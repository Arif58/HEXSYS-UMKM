/*--Update-20220101--*/
--Menu Produksi
INSERT INTO auth.menus(menu_cd,menu_nm,menu_root,menu_no,menu_level,menu_url,menu_image,created_by,created_at)
VALUES('INV0409','Produksi','INV04','900409',3,'inventori/mutasi-inventori/produksi','','admin',CURRENT_TIMESTAMP);
INSERT INTO auth.role_menus(role_cd,menu_cd,created_by,created_at) VALUES('superuser','INV0409','admin',CURRENT_TIMESTAMP);
INSERT INTO auth.role_menus(role_cd,menu_cd,created_by,created_at) VALUES('adminv','INV0409','admin',CURRENT_TIMESTAMP);
/*--End Update-20220101--*/