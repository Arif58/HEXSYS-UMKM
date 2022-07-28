/*--com_approval--*/
TRUNCATE public.com_approval CASCADE;

INSERT INTO public.com_approval(approval_cd,approval_nm,approval_tp,created_by,created_at)
VALUES('APP01','APPROVAL SUPERVISOR','APPROVAL_TP_03','admin',CURRENT_TIMESTAMP);
	/* INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP01','staff',1,'admin',CURRENT_TIMESTAMP); */
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP01','supervisor',1,'admin',CURRENT_TIMESTAMP);
	
INSERT INTO public.com_approval(approval_cd,approval_nm,approval_tp,created_by,created_at)
VALUES('APP02','APPROVAL MANAGER','APPROVAL_TP_03','admin',CURRENT_TIMESTAMP);
	/* INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP02','staff',1,'admin',CURRENT_TIMESTAMP); */
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP02','supervisor',1,'admin',CURRENT_TIMESTAMP);
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP02','manager',2,'admin',CURRENT_TIMESTAMP);
	
INSERT INTO public.com_approval(approval_cd,approval_nm,approval_tp,created_by,created_at)
VALUES('APP03','APPROVAL DIREKTUR','APPROVAL_TP_03','admin',CURRENT_TIMESTAMP);
	/* INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP03','staff',1,'admin',CURRENT_TIMESTAMP); */
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP03','supervisor',1,'admin',CURRENT_TIMESTAMP);
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP03','manager',2,'admin',CURRENT_TIMESTAMP);
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP03','direktur',3,'admin',CURRENT_TIMESTAMP);
	
INSERT INTO public.com_approval(approval_cd,approval_nm,approval_tp,created_by,created_at)
VALUES('APP04','APPROVAL KOMISARIS','APPROVAL_TP_03','admin',CURRENT_TIMESTAMP);
	/* INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP04','staff',1,'admin',CURRENT_TIMESTAMP); */
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP04','supervisor',1,'admin',CURRENT_TIMESTAMP);
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP04','manager',2,'admin',CURRENT_TIMESTAMP);
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP04','direktur',3,'admin',CURRENT_TIMESTAMP);
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP04','wketua',4,'admin',CURRENT_TIMESTAMP);
	
INSERT INTO public.com_approval(approval_cd,approval_nm,approval_tp,created_by,created_at)
VALUES('APP05','APPROVAL KOMISARIS UTAMA','APPROVAL_TP_03','admin',CURRENT_TIMESTAMP);
	/* INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP05','staff',1,'admin',CURRENT_TIMESTAMP); */
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP05','supervisor',1,'admin',CURRENT_TIMESTAMP);
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP05','manager',2,'admin',CURRENT_TIMESTAMP);
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP05','direktur',3,'admin',CURRENT_TIMESTAMP);
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP05','wketua',4,'admin',CURRENT_TIMESTAMP);
	INSERT INTO public.com_approval_detail(com_approval_detail_id,approval_cd,role_cd,approval_order,created_by,created_at) VALUES(uuid_generate_v4(),'APP05','ketua',5,'admin',CURRENT_TIMESTAMP);
	
/*--com_aging--*/
TRUNCATE public.com_aging CASCADE;

INSERT INTO public.com_aging(aging_cd,aging_nm,created_by,created_at)
VALUES('AGAPWDUE','AP WILL DUE','admin',CURRENT_TIMESTAMP);

	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGAPWDUE',7,7,'admin',CURRENT_TIMESTAMP);
	
	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGAPWDUE',21,21,'admin',CURRENT_TIMESTAMP);
	
INSERT INTO public.com_aging(aging_cd,aging_nm,created_by,created_at)
VALUES('AGAPODUE','AP OVER DUE','admin',CURRENT_TIMESTAMP);

	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGAPODUE',30,30,'admin',CURRENT_TIMESTAMP);
	
	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGAPODUE',60,60,'admin',CURRENT_TIMESTAMP);
	
	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGAPODUE',90,90,'admin',CURRENT_TIMESTAMP);
	
	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGAPODUE',120,120,'admin',CURRENT_TIMESTAMP);
	
INSERT INTO public.com_aging(aging_cd,aging_nm,created_by,created_at)
VALUES('AGARWDUE','AR WILL DUE','admin',CURRENT_TIMESTAMP);

	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGARWDUE',15,15,'admin',CURRENT_TIMESTAMP);
	
	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGARWDUE',30,30,'admin',CURRENT_TIMESTAMP);
	
INSERT INTO public.com_aging(aging_cd,aging_nm,created_by,created_at)
VALUES('AGARODUE','AR OVER DUE','admin',CURRENT_TIMESTAMP);

	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGARODUE',30,30,'admin',CURRENT_TIMESTAMP);
	
	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGARODUE',60,60,'admin',CURRENT_TIMESTAMP);
	
	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGARODUE',90,90,'admin',CURRENT_TIMESTAMP);
	
	INSERT INTO public.com_aging_detail(com_aging_detail_id,aging_cd,aging_no,VALUE,created_by,created_at)
	VALUES(uuid_generate_v4(),'AGARODUE',120,120,'admin',CURRENT_TIMESTAMP);
	
	
/*--com_payment_type--*/
TRUNCATE public.com_payment_type CASCADE;

INSERT INTO public.com_payment_type(top_cd,top_nm,top_total_day,created_by,created_at)
VALUES('TOP2W','TWO WEEKS AFTER DELIVERY',14,'admin',CURRENT_TIMESTAMP);

INSERT INTO public.com_payment_type(top_cd,top_nm,top_total_day,created_by,created_at)
VALUES('TOP1M','ONE MONTH AFTER DELIVERY',30,'admin',CURRENT_TIMESTAMP);