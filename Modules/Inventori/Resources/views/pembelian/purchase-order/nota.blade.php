<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?></title>
	<link rel="shortcut icon" href="{{configuration('APP_IMG')}}">
</head>
<style type="text/css">
	*{
		margin:0;
		padding: 0;
	}
	 .wrapper{
            width: 1000px;
            margin: 0 auto;
        }
	.main-content-surat ,.main-inner-surat{
		display: inline-block;
		padding: 20px;
		width: 97%;
		font-size: 12px;
		font-family: Arial,sans-serif;
		height: auto;
	}
	.nomor-kop-surat{
		margin-top: 25px;
		margin-bottom: 10px;
		line-height: 20px;
	}

	.main-isi-surat, .pembayaran-informer, .main-section-TDD{
		margin-top: -20px;
		text-align: justify;
	}
	.main-isi-surat article{
		line-height: 20px;
	}
	.main-information-laporan{
		display: block;
	}
	.section-NB-1{
		margin-top: 80px;
		text-align: center;
	}
	.section-NB-2{
		margin-top: 300px;
		text-align: center;
	}
	.section-NB-3{
		margin-top: 360px;
		text-align: center;
	}
	.headlines-section-laporan{
		display: block;
		margin-top: 100px;
	}
	.space-gellar-pernyataan{
		margin-top:90px;
		text-decoration: underline;
	}
	.form-group-top-10{
		margin-top: 10px;
	}
	.form-group-top-15{
		margin-top: 15px;
	}.

	.form-group-bottom-10{
		margin-bottom: 10px;
	}
	.form-group-bottom-15{
		margin-bottom: 15px;
	}
	.text-align-center{
		text-align: center;
	}
	.text-align-right{
		text-align:right;
	}
	.section-detail-tagihan{
		margin-bottom: 20px;
	  line-height: 15px;
	}
	.kop-header-reporting{
		line-height: 20px;
	}
	.kop-header-reporting-main-3{
		margin-top:20px;
	}
	.section-main-I{
		margin-bottom: 15px;
	}
	.space-td{
		padding-left: 20px;
	}
	.space-numbering-info{
		width: 30px;
		position: relative;
		vertical-align: top;
	}
	.content{
        border-color: transparent;
        /*line-height: 1.5em;*/
        border:none;
    }
	.content .ctn-lft{
        float: left;
        width: 100%;
        margin-bottom: 10px;
    }
    .content .r-top{
        float: left;
        width: 50%;
        margin-bottom: 10px;
    }
     .data{
        font-weight: 600;
        border-color: transparent;
    }
	.content .ctn-rht{
        float: right;
        width: 50%;
        margin-bottom: 10px;
    }
	.colsleft{
		float: left;
	}
	.colsright{
		float: right;
	}
	.cols{
		float: left;
	}
	.header{
        width: 100% !important;
    }

    .info{
        width: 100%;
        float: center;
		/* margin-left: 50%; */
		text-align: center;
    }

	.columns-1{
		width: 7%;
	}
	.columns-2{
		width: 9%;
	}
	.columns-3{
		width:30%;
	}
	.columns-4{
		width: 40%;
	}
	.columns-5{
		width: 50%;
	}
	.spacelines-10{
		margin-bottom: 10px;
	}
	table{
		width: 100%;
		border-collapse: collapse;
	}
	table {
    border-collapse: collapse;
	}
	table, th, td {
		border: 1px solid black;
	}
	table.table-noborder, th.no-border, td.no-border{
		border:none;
	}
	table tbody tr td.table-atenttion-informer{
		text-align: left !important;
		font-weight: normal;
		border: 1px solid black;
	}
	table.table-data-1{
		border: 1px solid #000;
	}
	table tr td{
		padding: 2px 4px;
	}
	/*config setting page area*/
	@page{
		size: A4;
	}
	/*config media setting page area*/
	@media print{
		.main-content-surat ,.main-inner-surat{
			display: inline-block;
		}

		.nomor-kop-surat{
			margin-top: 5px;
			margin-bottom: 10px;
			line-height: 20px;
		}
		
		.headlines-section-laporan{
			display: block;
			margin-top: 100px;
		}
		.section-NB-1{
			margin-bottom: 140px;
		}
		footer {
		 	page-break-after: always;
		}

	}
</style>
<body>
	<table border="0" style="border: transparent;" style="">
	<tr>
		<td align="left" width="60%">
		UNTUK DINAS
		<br>
		Lembar Ke :
		</td>
		<td align="left" width="40%">
		<div class="main-content-surat" style="margin-top: 40px" >
			<table>
				<tbody>
					<tr>
						<td class="data" style="width: 50%">Surat Bukti</td>
						<td class="data" style="width:10px">:</td>
						<td class="data" style="margin-left:-40px">UP/ GU / TU / LS</td>
					</tr>
					<tr>
						<td class="data">Tahun Anggaran</td>
						<td class="data">:</td>
						<td class="data"><?= date('Y')?></td>
					</tr>
					<tr>
						<td class="data">Nomor BKU</td>
						<td class="data">:</td>
						<td class="data"></td>
					</tr>
					<tr>
						<td class="data">Kode Pos Kegiatan</td>
						<td class="data">:</td>
						<td class="data"></td>
					</tr>
				</tbody>
			</table>
		</div>
		</td>
	</tr>
	
	</table>
	<div class="wrapper">
		<br>
		@php
		$poTitle = 'KWITANSI / BUKTI PEMBAYARAN';
		@endphp
		<header class="header">
		    <div class="info">
		        <h2 id="und">{{ $poTitle }}</h2>
		    </div>
		</header>
		<br>
		@if(!empty($data[0]))
		<div class="content">
		    <div class="ctn-lft">
		        <table border="0" style="border: transparent;" style="">
		            <tbody>
		                <tr>
		                    <td class="data" style="">Sudah terima dari</td>
		                    <td class="data" style="width: 1px">:</td>
		                    <td class="data">BENDAHARA <?= $data[0]->dana_tp_nm ?> <?= $data[0]->po_unit ?></td>
		                </tr>
						<tr>
		                    <td class="data" style="">Jumlah Uang</td>
		                    <td class="data" style="width: 1px">:</td>
		                    <td class="data">Rp. <?= number_format($data[0]->total_amount,2,',','.') ?></td>
		                </tr>
						<tr>
		                    <td class="data" style="">Terbilang</td>
		                    <td class="data" style="width: 1px">:</td>
		                    <td class="data">
								<table style="border: transparent;">
								<tr><td>
								<?= terbilang($data[0]->total_amount,2,',','.') .' rupiah'?>
								</td></tr>
								</table>
							</td>
		                </tr>
						<tr>
		                    <td class="data" style="">Untuk Pembayaran</td>
		                    <td class="data" style="width: 1px">:</td>
		                    <td class="data">
								<?php 
								foreach ($data as $key) {
									//echo($key->item_nm) . '<br>';
									echo($key->item_nm) . ', ';
								}
								?>
							</td>
		                </tr>
		            </tbody>
		        </table>
		    </div>
		</div>        
	    <div class="section-laporan">
			<table class="table" border="1">
			<!--
			  <tr>
			    <th>No</th>
			    <th width="25%">Kode Barang</th>
			    <th>Nama Barang</th>
			    <th>Qty</th>
			    <th>Unit</th>
			    <th>Harga/Unit</th>
			    <th>Jumlah</th>
			  </tr>
				<?php 
				$nomor = 1; 
				foreach ($data as $key) {
				?>
			
			  <tr>
			    <td width="12%" style="text-align: center;"> <?= $nomor++ ?></td>
			    <td><?= $key->item_cd ?></td>
			    <td><?= $key->item_nm ?></td>
			    <td><?= (int) $key->quantity ?></td>
			    <td><?= $key->unit_nm ?></td>
			    <td style="text-align: right;"><?= number_format($key->unit_price,2,',','.') ?></td>
			    <td style="text-align: right;"><?= number_format($key->trx_amount,2,',','.') ?></td>
			  </tr>
			  <?php } ?>
			    <tr>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;" >Tanggal Kirim</td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"><?= $data[0]->deliv_date ?></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-left-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-left-color: transparent;">Sub Total</td>
				    <td style="border-bottom-color: transparent;border-left-color: transparent;text-align: right;"><?=  number_format($data[0]->total_price,2,',','.'); ?></td>
			    </tr>
				@if ($data[0]->po_st != 'INV_TRX_ST_5')
				<tr>
					<td style="border-bottom-color: transparent;border-right-color: transparent;" ></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;"></td>
					<td style="border-bottom-color: transparent;border-left-color: transparent;">PPN</td>
					<td style="border-bottom-color: transparent;border-left-color: transparent;text-align: right;"><?=  number_format($data[0]->ppn,2,',','.'); ?></td>
				</tr>
				@endif
				<tr>
					<td  style="border-right-color: transparent;" >Alamat Kirim</td>
				    <td style="border-right-color: transparent;"><?= $data[0]->deliv_addr; ?></td>
				    <td style="border-right-color: transparent;"></td>
				    <td style="border-right-color: transparent;"></td>
				    <td ></td>
					<td>Total</td>
					<td style="text-align: right;"><?=  number_format($data[0]->total_amount,2,',','.'); ?></td>
				</tr>
			-->
			</table>
				<div class=" " style="margin-top: 10px;margin-left: 630px">
					<table>
						<tbody>
							<tr>
								<td class="data" style=""><?= regionName(configuration('APPCD_REGIONKAB')).' , '.tgl_indo(formatDate($data[0]->tgl_trx)) ?>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="colsright text-align-left form-group-bottom-15 " style="margin-top: 10px;margin-left: 40px">
				
					 <table style="margin-top: 20px">
		             <tr>
		                 <th class="notbold" style="width: 50%">Toko/Rekanan/Penerima</th>
		             </tr>
		             <tr>
		                 <td style="height: 100px"><p style="margin-top: 50px;text-align: center;"><?= $data[0]->supplier_nm ?></p></td>
		             </tr>
		            </table>
				</div>
				
				<div class=" " style="margin-top: 10px;margin-left: 630px">
					<table>
						<tbody>
							<tr>
								<td class="data" style="">Setuju dan Lunas dibayar tanggal:</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="colsright text-align-left form-group-bottom-15 " style="margin-top: 10px;margin-left: 40px">
				
					 <table style="margin-top: 20px">
		             <tr>
		                 <th class="notbold" style="width: 22%">Bendahara</th>
		             </tr>
		             <tr>
		                 <td style="height: 100px"><p style="margin-top: 50px;text-align: center;"></p></td>
		             </tr>
		            </table>
				</div>
				
				<br><br><br><br><br>
				<br><br><br><br><br>
				<div class="colsleft text-align-left form-group-bottom-15" style="margin-top: 10px;margin-left: 40px">
				
					 <table style="margin-top: 20px">
		             <tr>
						Barang / Pekerjaan tersebut telah diterima / diselesaikan dengan lengkap dan baik.
						<br><br>
						Pejabat yang bertanggung jawab,
		                 <th class="notbold" style="width: 50%">
						 Kepala Sekolah
						 </th>
		             </tr>
		             <tr>
		                 <td style="height: 100px"><p style="margin-top: 50px;text-align: center;"></p></td>
		             </tr>
		            </table>
				</div>
			</div>
		</div>
		@endif
	</div>
</body>
<script type="text/javascript">
	window.onload = function() {
		window.print();
		setTimeout(function(){
			close();
		},100);
	}
</script>
