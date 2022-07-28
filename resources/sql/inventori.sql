/*--Clear Data--*/
truncate inv.inv_batch_item cascade;
truncate inv.inv_item_unit cascade;
truncate inv.inv_pos_itemunit cascade;
truncate inv.inv_item_move cascade;

--truncate inv.inv_opname_detail cascade;
truncate inv.inv_opname cascade;

/* --truncate inv.po_retur_detail cascade;
truncate inv.po_retur cascade;
--truncate inv.po_receive_detail cascade;
truncate inv.po_receive_item cascade;
--truncate inv.po_po_detail cascade;
truncate inv.po_purchase_order cascade;
--truncate inv.po_pr_detail cascade;
truncate inv.po_purchase_request cascade; */


/*--Tipe Inventori--*/
truncate inv.inv_item_type cascade;

insert into inv.inv_item_type (type_cd,type_nm,created_by,created_at) values('001','INVENTORI','admin',current_timestamp);
insert into inv.inv_item_type (type_cd,type_nm,created_by,created_at) values('100','LAIN-LAIN','admin',current_timestamp);


/*--Satuan--*/
truncate inv.inv_unit cascade;

insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('PCS','PCS','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('BUAH','BUAH','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('PACK','PACK','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('BOX','BOX','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('SET','SET','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('DUS','DUS','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('EKS','EKS','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('LEMBAR','LEMBAR','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('ROLL','ROLL','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('BOTOL','BOTOL','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('GALON','GALON','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('KALENG','KALENG','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('SACHET','SACHET','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('TUBE','TUBE','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('BKS','BUNGKUS','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('RIM','RIM','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('KG','KG','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('GR','GR','admin',current_timestamp);
insert into inv.inv_unit (unit_cd,unit_nm,created_by,created_at) values('LITER','LITER','admin',current_timestamp);


/*--Master Inventori--*/
truncate inv.inv_item_master cascade;
insert into inv.inv_item_master (item_cd,item_nm,type_cd,unit_cd,minimum_stock,item_price_buy,item_price,created_by,created_at) values('00001','Item 001','001','PCS',0,0,0,'admin',current_timestamp);
insert into inv.inv_item_master (item_cd,item_nm,type_cd,unit_cd,minimum_stock,item_price_buy,item_price,created_by,created_at) values('00002','Item 002','001','PCS',0,0,0,'admin',current_timestamp);
insert into inv.inv_item_master (item_cd,item_nm,type_cd,unit_cd,minimum_stock,item_price_buy,item_price,created_by,created_at) values('00003','Item 003','001','PCS',0,0,0,'admin',current_timestamp);
insert into inv.inv_item_master (item_cd,item_nm,type_cd,unit_cd,minimum_stock,item_price_buy,item_price,created_by,created_at) values('00004','Item 004','001','PCS',0,0,0,'admin',current_timestamp);
insert into inv.inv_item_master (item_cd,item_nm,type_cd,unit_cd,minimum_stock,item_price_buy,item_price,created_by,created_at) values('00005','Item 005','001','PCS',0,0,0,'admin',current_timestamp);


/*--Set Inventori to Gudang--*/
insert into inv.inv_pos_itemunit (pos_cd,item_cd, unit_cd, quantity, created_by, created_at)
select 
inv_pos_inventori.pos_cd,
master.item_cd,
master.unit_cd,
0 as quantity,
'admin' as created_by,
current_timestamp as created_at
from inv.inv_pos_inventori
join inv.inv_item_master master on 1=1
where inv_pos_inventori.pos_cd='WHMASTER'