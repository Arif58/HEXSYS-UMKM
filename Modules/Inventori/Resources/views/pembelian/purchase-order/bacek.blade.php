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
		<td align="center">
			<p><img src="{{ url('/images/logo.png') }}" alt="" width="50" height="50"></p>
			<p><font color="red">HEXSYS</font></p>
			<p><font size="2px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></p>
			<p><font size="2px">Telp. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fax : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></p>
		</td>
	</tr>
	</table>
	<div class="wrapper">
		<div class="main-content-surat" style="margin-top: 40px" >
			<div class="main-information-laporan">
				<div class="columns-5 colsleft form-group-bottom-15 ">
					<!--<p><?= configuration('INST_NAME') ?></p>-->
					<!--
					<p><img src="{{ url('/images/logo.png') }}" alt="" width="50" height="50"></p>
					<p><font color="red">HEXSYS</font></p>
					<p><font size="2px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></p>
					<p><font size="2px">Telp. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fax : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></p>
					-->
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
		@php
		$poTitle = 'BERITA ACARA PEMERIKSAAN BARANG';
		
		//$trx_date = date("Y-m-d",strtotime($data[0]->trx_date));
		@endphp
		<header class="header">
		    <div class="info">
		        <h2 id="und">{{ $poTitle }}</h2>
		    </div>
			@if(!empty($data[0]))
			@if(!empty($data[0]->data_no))
			
			@php
			$array_romawi = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
			
			$no_bulan = $array_romawi[date("n",strtotime($data[0]->trx_date))];
			@endphp
			<div class="info">
		        <h3 id="und">Nomor : <?= str_pad($data[0]->data_no,3,"0",STR_PAD_LEFT) .'/BAST/' .$data[0]->po_unit .' HEXSYS/' . $no_bulan .'/' .date("Y",strtotime($data[0]->trx_date)) ?></h2>
		    </div>
			@endif
			@endif
		</header>
		@if(!empty($data[0]))
		<div class="content">
		    <div>
		        <table border="0" style="border: transparent;" style="">
		            <tbody>
		                <tr>
		                    <td class="data" colspan="3">
							<p>
							Pada hari ini <?= hari(date("N",strtotime($data[0]->trx_date))) ?> tanggal <?= date("d",strtotime($data[0]->trx_date)) ?> bulan <?= date("m",strtotime($data[0]->trx_date)) ?> tahun <?= date("Y",strtotime($data[0]->trx_date)) ?>, kami masing-masing yang bertanda tangan dibawah ini 
							</p>
							</td>
		                </tr>
						<tr>
		                    <td class="data" colspan="3">&nbsp;</td>
		                </tr>
		                <tr>
		                    <td class="data" width="10%">1. Nama</td>
		                    <td class="data" width="50%">: <?= $data[0]->data_10 ?></td>
		                    <td class="data"></td>
		                </tr>
						<tr>
		                    <td class="data" width="10%">&nbsp;&nbsp;&nbsp;&nbsp;NIP</td>
		                    <td class="data" width="50%">: <?= $data[0]->data_20 ?></td>
		                    <td class="data"></td>
		                </tr>
						<tr>
		                    <td class="data" width="10%">2. Nama</td>
		                    <td class="data" width="50%">: <?= $data[0]->data_11 ?></td>
		                    <td class="data"></td>
		                </tr>
						<tr>
		                    <td class="data" width="10%">&nbsp;&nbsp;&nbsp;&nbsp;NIP</td>
		                    <td class="data" width="50%">: <?= $data[0]->data_21 ?></td>
		                    <td class="data"></td>
		                </tr>
						<tr>
		                    <td class="data" width="10%">3. Nama</td>
		                    <td class="data" width="50%">: <?= $data[0]->data_12 ?></td>
		                    <td class="data"></td>
		                </tr>
						<tr>
		                    <td class="data" width="10%">&nbsp;&nbsp;&nbsp;&nbsp;NIP</td>
		                    <td class="data" width="50%">: <?= $data[0]->data_22 ?></td>
		                    <td class="data"></td>
		                </tr>
						<tr>
		                    <td class="data" colspan="3">&nbsp;</td>
		                </tr>
						<tr>
		                    <td class="data" colspan="3">
							<p>
							Kami yang tersebut di atas adalah Panitia Pemeriksa Pengadaan Barang / Jasa pada  <?= $data[0]->po_unit ?> HEXSYS, yang dibentuk berdasarkan Surat Keputusan Direktur No. : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tanggal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Telah melakukan pemeriksaan terhadap pengadaan barang untuk <?= $data[0]->po_unit ?> HEXSYS sesuai Surat Pesanan Barang Nomor: <?= str_pad($data[0]->data_no,3,"0",STR_PAD_LEFT) .'/' .$no_bulan .'/' .date("Y",strtotime($data[0]->trx_date)) ?> Tanggal <?= $data[0]->tgl_trx ?> yang dilaksanakan oleh <?= $data[0]->supplier_nm ?>. 
							</p>
							<br>
							<p>
							Setelah diadakan pemeriksaan secara cermat dan seksama bahwa barang -barang tersebut di bawah telah diadakan dengan baik dan cukup jumlahnya sesuai dengan Surat Pesanan Barang.
							</p>
							</td>
		                </tr>
						<tr>
		                    <td class="data" colspan="3">&nbsp;</td>
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
	    <div class="section-laporan">
			<table class="table" border="1">
			  <tr>
			    <th width="12%">No</th>
			    <!--<th width="20%">Kode Barang</th>-->
			    <th width="35%">Nama Barang</th>
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
			    <td style="text-align: center;"> <?= $nomor++ ?></td>
			    <!--<td><?= $key->item_cd ?></td>-->
			    <td><?= $key->item_nm ?></td>
			    <td><?= (int) $key->quantity ?></td>
			    <td><?= $key->unit_nm ?></td>
			    <td style="text-align: right;"><?= number_format($key->unit_price,2,',','.') ?></td>
			    <td style="text-align: right;"><?= number_format($key->trx_amount,2,',','.') ?></td>
			  </tr>
			  <?php } ?>
			    <tr>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"><?= $data[0]->deliv_date ?></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-left-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-left-color: transparent;">Sub Total</td>
				    <td style="border-bottom-color: transparent;border-left-color: transparent;text-align: right;"><?=  number_format($data[0]->total_price,2,',','.'); ?></td>
			    </tr>
				@if ($data[0]->po_st != 'INV_TRX_ST_5')
				<tr>
					<td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
				    <td style="border-bottom-color: transparent;"></td>
					<td style="border-bottom-color: transparent;border-left-color: transparent;">PPN</td>
					<td style="border-bottom-color: transparent;border-left-color: transparent;text-align: right;"><?=  number_format($data[0]->ppn,2,',','.'); ?></td>
				</tr>
				<tr>
					<td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
					<td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
					<td style="border-bottom-color: transparent;border-right-color: transparent;"></td>
					<td style="border-bottom-color: transparent;"></td>
					<td style="border-bottom-color: transparent;border-left-color: transparent;">Discount [<?=  number_format($data[0]->discount_percent,0,',','.'); ?> %]</td>
					<td style="border-bottom-color: transparent;border-left-color: transparent;text-align: right;"><?=  number_format($data[0]->discount_amount,2,',','.'); ?></td>
				</tr>
				@endif
				<tr>
					<td style="border-right-color: transparent;"></td>
				    <td style="border-right-color: transparent;"></td>
				    <td style="border-right-color: transparent;"></td>
				    <td ></td>
					<td>Total</td>
					<td style="text-align: right;"><?= number_format($data[0]->total_amount - $data[0]->discount_amount,2,',','.'); ?></td>
				</tr>
			</table>
				<table border="0" style="border: transparent;" style="">
		            <tbody>
						<tr>
		                    <td class="data">&nbsp;</td>
		                </tr>
		                <tr>
		                    <td class="data">
							<p>
							Demikian Berita Acara ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
							</p>
							</td>
		                </tr>
		            </tbody>
		        </table>
				<div class="" style="margin-top: 10px;margin-left: 630px">
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
		                 <th class="notbold" style="width: 30%">
						 Penyedia Barang / Jasa <br>
						 <?= $data[0]->supplier_nm ?>
						 </th>
						 <th class="notbold" style="width: 30%">
						 Panitia Pemeriksa <br>
						 Pengadaan Barang/Jasa
						 </th>
		                 <th class="notbold" style="width: 30%">
						 Mengetahui, <br>
						 Pejabat Pelaksana Kegiatan
						 </th>
		             </tr>
		             <tr>
						<td style="height: 100px"><p style="margin-top: 50px"></p></td>
		                <td style="height: 100px">
						
						<table border="0" style="border: transparent;" style="">
							<tbody>
								<tr>
									<td class="data" colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td class="data" width="60%">1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
									<td class="data">....................</td>
								</tr>
								<tr>
									<td class="data" colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td class="data" width="60%">2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
									<td class="data">....................</td>
								</tr>
								<tr>
									<td class="data" colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td class="data" width="60%">3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
									<td class="data">....................</td>
								</tr>
							</tbody>
						</table>
						
						</td>
		                <td style="height: 100px"><p style="margin-top: 50px"></p></td>
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
