<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?></title>
	<link rel="shortcut icon" href="{{ configuration('INST_LOGO') }}">
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
	.main-content-surat-tagihan-RWI ,.main-inner-RWI{
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

	.main-isi-tagihan-RWI, .pembayaran-informer-RWI, .main-section-TDD{
		margin-top: -20px;
		text-align: justify;
	}
	.main-isi-tagihan-RWI article{
		line-height: 20px;
	}
	.main-information-laptagihan{
		display: block;
	}
	.section-NB-klaim{
		margin-top: 80px;
		text-align: center;
	}
	.section-NB-klaim-II{
		margin-top: 300px;
		text-align: center;
	}
	.section-NB-klaim-III{
		margin-top: 360px;
		text-align: center;
	}
	.headlines-section-laporan-piutang{
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
        width: 50%;
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
        width: 60%;
        float: center;
        margin-left: 50%;
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

	.text-center{
		text-align: center;
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
	table.table-piutang-perusahaan{
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
		.main-content-surat-tagihan-RWI ,.main-inner-RWI{
			display: inline-block;
		}

		.nomor-kop-surat{
			margin-top: 5px;
			margin-bottom: 10px;
			line-height: 20px;
		}
		
		.headlines-section-laporan-piutang{
			display: block;
			margin-top: 100px;
		}
		.section-NB-klaim{
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
		<td align="center">
			<p><img src="{{ url('/images/logo.png') }}" alt="" width="50" height="50"></p>
			<p><font color="red">HEXSYS</font></p>
			<p><font size="2px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></p>
			<p><font size="2px">Telp. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fax : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></p>
		</td>
	</tr>
	</table>
	<div class="wrapper">
		<header class="header">
		    <div class="text-center">
		        <h2 id="und">PENERIMAAAN BARANG</h2>
		    </div>
		</header>
		<div class="main-surat-tagihan-RWJ" style="margin-top: 40px" >
			<div class="main-information-laptagihan">
				<div class="columns-5 colsleft form-group-bottom-15 ">
					<!--<p><?= configuration('INST_NAME') ?></p>-->
				</div>
				<div class="colsright text-align-left form-group-bottom-15 " style="margin-top: -10px">
					<table>
						<tbody>
							<tr>
								<td class="data" style="width: 50%">Print Date</td>
								<td class="data" style="width:10px">:</td>
								<td class="data" style="margin-left:-40px"><?= date("Y-m-d") ?></td>
							</tr>
							<tr>
								<td class="data">Time</td>
								<td class="data">:</td>
								<td class="data"><?= date('H:i')?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		@if(!empty($data[0]))
		<div class="content">
		    <div class="ctn-lft">
		        <table border="0" style="border: transparent;" style="">
		            <tbody>
		                <tr>
		                    <td class="data" style="">Nomor</td>
		                    <td class="data" style="width: 1px">:</td>
		                    <td class="data"><?= $data[0]->ri_no ?></td>
		                </tr>
		                <tr>
		                    <td class="data">Tanggal</td>
		                    <td class="data">:</td>
		                    <td class="data"><?= $data[0]->tgl_trx ?> </td>
		                </tr>
		                <tr>
		                    <td class="data">Supplier</td>
		                    <td class="data">:</td>
		                    <td class="data"><?= $data[0]->supplier_nm ?></td>
		                </tr>
		                <tr>
		                    <td class="data">Alamat</td>
		                    <td class="data">:</td>
		                    <td class="data"><?= $data[0]->supp_add ?></td>
		                </tr>

		            </tbody>
		        </table>
		    </div>
			<!--
		    <div class="colsright text-align-left form-group-bottom-15 " style="margin-top: 60px">
				<table>
		            <tbody>
		                <tr>
		                    <td class="data">Mata Uang</td>
		                    <td class="data">:</td>
		                    <td class="data"><?= $data[0]->currency_cd ?></td>
		                </tr>
		            </tbody>
		        </table>
			</div>
			-->
		</div>          
		<div class="section-laporan-piutang">
			<table class="table" border="1">
			  <tr>
			    <th>No</th>
			    <th width="25%"> Nama Barang</th>
			    <th>No/Tgl Faktur</th>
			    <th>No Batch/Tgl Expire</th>
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
			    <td><?= $key->item_nm ?></td>
			    <td><?= $key->faktur_no.' - '.$key->faktur_date ?></td>
			    <td><?= $key->batch_no.' - '.$key->expired_date ?></td>
			    <td><?= (int) $key->quantity ?></td>
			    <td><?= $key->unit_nm ?></td>
			    <td style="text-align: right;"><?= number_format($key->unit_price,2,',','.') ?></td>
			    <td style="text-align: right;"><?= number_format($key->trx_amount,2,',','.') ?></td>
			  </tr>
			  <?php } ?>
			    <tr>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;" ></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-left-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-left-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-left-color: transparent;">Sub Total</td>
				    <td style="border-bottom-color: transparent;border-left-color: transparent;text-align: right;"><?=  number_format($data[0]->total_price,2,',','.'); ?></td>
			    </tr>
				<tr>
					<td style="border-bottom-color: transparent;border-right-color: transparent;" ></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;"></td>
					<td style="border-bottom-color: transparent;border-left-color: transparent;"></td>
					<td style="border-bottom-color: transparent;border-left-color: transparent;"></td>
					<td style="border-bottom-color: transparent;border-left-color: transparent;"></td>
				</tr>
				<tr>
					<td  style="border-right-color: transparent;" ></td>
				    <td style="border-right-color: transparent;"></td>
				    <td style="border-right-color: transparent;"></td>
				    <td style="border-right-color: transparent;"></td>
				    <td ></td>
				    <td ></td>
					<td>Total</td>
					<td style="text-align: right;"><?=  number_format($data[0]->total_amount,2,',','.'); ?></td>
				</tr>
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
		                 <th class="notbold" style="width: 30%">Disiapkan Oleh</th>
		                 <th class="notbold" style="width: 30%">Disetujui Oleh</th>
		             </tr>
		             <tr>
		                 <td style="height: 100px"><p style="margin-top: 50px;text-align: center;"><?= $data[0]->entry_by ?></p></td>
		                 <td style="height: 100px"><p style="margin-top: 50px"><p></p></td>
		             </tr>

		            </table>
				</div>
				<!--
				<div class="ctn-lft">
					<h3>Note:</h3>
					<p style="margin-left: 50px">1.Barang yang diterima harus sesuai dengan PO.</p>
					<p  style="margin-left: 50px"> 2.Barang yang diterima dalam kondisi baik.</p>
					<p style="margin-left: 50px">  3.Perubahan harga harus dikonfirmasikan terlebih dahulu</p>
				</div>
				-->
			</div>
			@endif
		</div>
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
