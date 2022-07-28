@extends('layouts.app')

@section('content')
    <!-- Basic datatable -->
	<div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">{{ $title }}</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload" id="reload-table"></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form class="form-validate-jquery" id="form-isian" method="POST" action="{{ url('inventori/pembelian/purchase-order/') }}">
			
				<!--Reject-->
				<div id="reject-info">
				<div class="row">
                    <div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Status Transaksi : </label>
                            <span class="text-danger"><b><label name="po_st" id="po_st" ></label></b></span>
                        </div>
                    </div>
					<div class="col-md-5">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Alasan Penolakan : </label>
                            <b><label name="reject_note" id="reject_note" ></label></b>
                        </div>
                    </div>
					<div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Ditolak Oleh : </label>
                            <b><label name="reject_by" id="reject_by" ></label></b>
                        </div>
                    </div>
                </div>
				<script type='text/javascript'>
				$(document).ready(function(){
					$("#reject-info").hide();
				});
				</script>
				</div>
				<!--End Reject-->
			
				<!--<input type="text" name="po_cd" id="po_cd" />-->
				<input type="hidden" name="popr" value="{{ $popr ?? '' }}" />
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-group-float-label is-visible">No. Purchase Order</label>
                        <div class="form-group form-group-float">
                            {{-- <input name="po_no" id="po_no" class="form-control" required data-fouc value="{{ $defaultPoNo }}" /> --}}
                            <input name="po_no" id="po_no" class="form-control" data-fouc placeholder="Kosong : nomor PO akan di-generate sistem" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-group-float-label is-visible">Tanggal Pengiriman (dd/mm/yyyy)</label>
                        <div class="form-group form-group-float">
                            {{--<input name="delivery_datetime" id="delivery_datetime" class="form-control mask-date" placeholder="DD/MM/YYYY" required data-fouc value="{{ date('d/m/Y') }}" />--}}
                            <input type="text" name="delivery_datetime" id="delivery_datetime" class="form-control mask-date" placeholder="DD/MM/YYYY" aria-invalid="false">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-group-float-label is-visible">Tanggal (dd/mm/yyyy)</label>
                        <div class="form-group form-group-float">
                            {{--<input name="trx_date" id="trx_date" class="form-control mask-date" placeholder="DD/MM/YYYY" required data-fouc  value="{{ date('d/m/Y') }}" />--}}
                            <input name="trx_date" id="trx_date" class="form-control date-picker" required data-fouc value="{{ date('d/m/Y') }}" />

                        </div>
                    </div>
					<div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Sumber Dana <span class="text-danger">*</span></label>
                            <select name="dana_tp" class="form-control form-control-select2 select-search" required data-fouc>
								{!! comCodeOptions('DANA_TP') !!}
							</select>
                        </div>
                    </div>
					<div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Jenis Pembelian </label>
                            <select name="po_tp" class="form-control form-control-select2 select-search" required data-fouc>
								<option value="0">Inventori</option>
								<option value="1">Asset</option>
								<option value="2">Lain-Lain</option>
							</select>
                        </div>
                    </div>
					@php
					if ($popr == 'popr') {
						$req = 'required';
					}	
					else {
						$req = '';
					}
					@endphp
					<div class="col-md-3">
						<div class="form-group form-group-float">
							<label class="form-group-float-label is-visible">Unit <span class="text-danger">*</span></label>
							<select name="cc_cd" id="cc_cd" class="form-control" {{ $req }} data-fouc>
							</select>
						</div>
					</div>
                </div>
                <div class="row">
					@if ($popr == '')
                    <div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Supplier <span class="text-danger">*</span></label>
                            <select name="supplier_cd" id="supplier_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                <option value="">=== Pilih Supplier ===</option>
                                @foreach ($suppliers as $item)
                                    <option value="{{ $item->supplier_cd}}">{{ $item->supplier_nm}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
					@endif
                    <div class="col-md-4">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Alamat Pengiriman</label>
                            <textarea name="delivery_address" class="form-control">{{ configuration('INST_NAME') }}</textarea>
                        </div>
                    </div>
					<div class="col-md-3">
						<div class="form-group form-group-float">
							<label class="form-group-float-label is-visible">Jenis Kegiatan </label>
							<select name="aktivitas_cd" id="aktivitas_cd" class="form-control" data-fouc>
							</select>
						</div>
					</div>
					<div class="col-md-3 " style="display: none">
						<div class="form-group form-group-float">
							<label class="form-group-float-label is-visible">Sub Kegiatan </label>
							<select name="aktivitas_tp" class="form-control form-control-select2 select-search" data-fouc>
								{!! comCodeOptions('AKTIVITAS_ITEM') !!}
							</select>
						</div>
					</div>
					<div id="input-01"><!--Input Advanced-->
					<div class="col-md-5">
                        <label class="form-group-float-label is-visible">PPN (%)</label>
                        <div class="form-group form-group-float">
                            <input type="number" name="percent_ppn" id="percent_ppn" class="form-control" required data-fouc value="0"/>
                        </div>
                    </div>
					<script type='text/javascript'>
					$(document).ready(function(){
						@if ($popr == 'popr')
						$("#input-01").hide();
						@endif
					});
					</script>
					</div><!--Input Advanced-->
                </div>
                <hr>

                @if(!$po)
					<script>
					function checkUnit() {
						var unitCd	= "{{ Auth::user()->unit_cd ?? '' }}";
						
						//--Cek unit
						if (unitCd != '' && $('select[name=cc_cd]').val() != '') {
							if (unitCd != $('select[name=cc_cd]').val()) {
								swal({
									title: "Unit tidak sesuai unit user !",
									type: "warning",
									showCancelButton: false,
									showConfirmButton: false,
									timer: 1000
								}).then(() => {
									swal.close();
								});

								return false;
							}
						}
						//--End Cek unit
					}	
					</script>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary ml-3 legitRipple" onClick="return checkUnit();">Simpan <i class="icon-floppy-disk ml-2"></i></button>
                    </div>
				@endif
            </form>

            @if ($po) 
                @if($po->po_st == 'INV_TRX_ST_1' or $po->po_st == 'INV_TRX_ST_5')
                    <form class="form-validate-jquery" id="form-item">
                        @csrf
                        <div class="row">
							@if($po->po_tp == '0')
                            <div class="col-md-3">
                                <label class="form-group-float-label is-visible">Kode Barang</label>
                                <div class="form-group form-group-float">
                                    <select name="item_cd" id="item_cd" class="form-control form-control-select2 select-search" data-fouc>
                                    </select>
                                </div>
                            </div>
							@endif
							@if($po->po_tp == '1')
							<div class="col-md-3">
                                <label class="form-group-float-label is-visible">Jenis Aset</label>
                                <div class="form-group form-group-float">
                                    <select name="assettp_cd" id="assettp_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                    </select>
                                </div>
                            </div>
							@endif
                            <div class="col-md-2">
                                <label class="form-group-float-label is-visible">Satuan</label>
                                <div class="form-group form-group-float">
                                    <select name="unit_cd" id="unit_cd" class="form-control form-control-select2 select-search" data-fouc>
                                        <option value="">=== Pilih Data ===</option>
                                        @foreach ($units as $item)
                                            <option value="{{ $item->unit_cd}}">{{ $item->unit_nm}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Harga Satuan</label>
                                <div class="form-group form-group-float">
                                    <input type="number" name="unit_price" id="unit_price" class="form-control" required data-fouc value="0"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Nama Barang <span class="text-danger">*</span></label>
                                <div class="form-group form-group-float">
                                    <input name="item_nm" id="item_nm" class="form-control" required data-fouc/ maxlength="255">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Jumlah</label>
                                <div class="form-group form-group-float">
                                    <input type="number" name="quantity" id="quantity" class="form-control" required data-fouc value="0"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Total</label>
                                <div class="form-group form-group-float">
                                    <input type="number" name="trx_amount" id="trx_amount" class="form-control" required data-fouc value="0"/>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-primary ml-3 legitRipple">Tambah Item <i class="icon icon-plus-circle2"></i></button>
                        </div>
                    </form>
                @endif
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-float">
                            <input name="item_nm_param" id="item_nm_param" placeholder="Pencarian Nama" class="form-control" data-fouc />
                        </div>
                    </div>
					<!--//--Pencarian Satuan
                    <div class="col-md-6">
                        <div class="form-group form-group-float">
                            <select name="unit_cd_param" id="unit_cd_param" class="form-control form-control-select2 select-search" data-fouc>
                                    <option value=""> Pilih Satuan Inventori</option>
                                    @foreach ($units as $item)
                                        <option value="{{ $item->unit_cd}}">{{ $item->unit_nm}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
					-->
                </div>

                <div class="table-responsive">
                    <table class="table datatable-pagination" id="tabel-data" width="100%">
                        <thead>
                            <tr>
                                <th id="po_po_detail_id_table">po_po_detail_id_table</th>
                                <th id="item_cd_table">Kode Barang</th>
                                <th id="item_nm_table">Nama Barang</th>
                                <th id="unit_cd_table">unit_cd_table</th>
                                <th id="unit_nm_table">Satuan</th>
                                <th id="quantity_table">Jumlah</th>
                                <th id="unit_price_table">Harga Satuan</th>
                                <th id="trx_amount_table">Total</th>
                                <th id="action_table">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
				@if ($popr == '')
				<div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-lg-2">PPN</label>
                    <div class="col-lg-10">
                        <input type="text" name="ppn" class="form-control form-control-lg">
                    </div>
                </div>
				@endif
				<div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-lg-2">Total</label>
                    <div class="col-lg-10">
                        <input type="text" name="total_amount" class="form-control form-control-lg">
                    </div>
                </div>
            @endif
        </div>
        
        <div class="card-footer">
			<script>
			function validasiData() {
				//--Cek supplier
				if ($('select[name=supplier_cd]').val() == '') {
					swal({
						title: "Pilih supplier !",
						type: "warning",
						showCancelButton: false,
						showConfirmButton: false,
						timer: 1000
					}).then(() => {
						swal.close();
					});

					return false;
				}
				
				if (parseInt($('input[name=percent_ppn]').val()) == 0) {
					swal({
						title: "PPN = 0 !",
						type: "warning",
						showCancelButton: false,
						showConfirmButton: false,
						timer: 1000
					}).then(() => {
						swal.close();
					});

					return false;
				}
				
				return true;
			}	
			</script>
					
			@php
			$poTitle = 'Purchase Order';
			$pocd = '';
			if(!empty($po)) {
				if ($po->po_st == 'INV_TRX_ST_5') {
					$poTitle = 'Permintaan Pembelian';
				}	
				else {
					$poTitle = 'Purchase Order';
				}
				
				$pocd = $po->po_cd;
			}
			@endphp
            @if(!empty($po))
                @if($po->po_st == 'INV_TRX_ST_1' or $po->po_st == 'INV_TRX_ST_5')
					@if( in_array(Auth::user()->role->role_cd,array('superuser','adminv')) )
                    <button type="button" class="btn btn-warning legitRipple" id="proses"><i class="icon-check mr-2"></i> 
					@if($po->po_st == 'INV_TRX_ST_5')
					Proses Permintaan Pembelian
					@else
					Proses Purchase Order
					@endif
					</button>
					@endif
                    <button type="button" class="btn btn-danger legitRipple" id="hapus"><i class="icon-trash mr-2"></i> Hapus {{ $poTitle }}</button>
                @endif
                    <button type="button" class="btn btn-success legitRipple" id="print"><i class="icon-printer mr-2"></i> Cetak {{ $poTitle }}</button>
					@if($po->po_st != 'INV_TRX_ST_5')
					<div class="col-md-7">
					<select name="print_tp" id="print_tp" class="form-control form-control-select2" >
						<option value="1">Purchase Order</option>
						<option value="2">Pemintaan Pembelian</option>
						<option value="3">Nota Dinas</option>
						<option value="4">Berita Acara Serah Terima Barang</option>
						<option value="5">Berita Acara Pemeriksaan Barang</option>
					</select>
					</div>
					@endif
					
					<button type="button" class="btn btn-primary legitRipple" id="upload"><i class="icon-upload mr-2"></i> Upload</button>
					@if( in_array(Auth::user()->role->role_cd,array('superuser','adminv')) )
					<button type="button" class="btn btn-primary legitRipple" id="discount"><i class="icon-upload mr-2"></i> Discount | Saksi</button>
					@endif
            @endif
            <button type="reset" class="btn btn-light legitRipple" id="reset"><i class="icon-reload-alt mr-2"></i> Kembali </button>
        </div>
		
		<div id="tab-data-file">
			@if(!empty($file))
			@if (count($file) > 0)
				<ul class="list-inline mb-0">
					@foreach ($file as $item)
						<li class="list-inline-item">
							<div class="card bg-light py-2 px-3 mt-3 mb-0">
								<div class="media my-1">
									<div class="mr-3 align-self-center">
										<i class="{{ $item->file_tp_icon }} icon-2x top-0"></i>
									</div>
									<div class="media-body">
									<div class="font-weight-semibold">{{ $item->file_nm }}</div>
										<ul class="list-inline list-inline-condensed mb-0">
											{{-- <li class="list-inline-item text-muted">174 KB</li> --}}
											<li class="list-inline-item">
												<a class="text-info" href='{{ asset("storage/trx-file/".$item->file_path) }}' target="_new">
													<i class="icon icon-folder-open2"></i> Buka Dokumen
												</a>
											</li>
											<li class="list-inline-item">
												<a class="hapus-dokumen text-danger" data-trx_file_id="{{ $item->trx_file_id }}">
													<i class="icon icon-trash"></i> Hapus Dokumen
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			@endif
			@endif
		</div>
    </div>
	<!--File modal-->
    <div id="modal-file" class="modal fade" tabindex="">
		<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-file-title"> Upload Berkas</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form class="form-validate-jquerys" id="form-file" method="POST" action='{{ url("/inventori/file/$pocd") }}' enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Nama Berkas <span class="text-danger">*</span></label>
                                    <input type="text" name="file_nm" class="form-control" placeholder="Nama Berkas" aria-invalid="false" required>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Jenis Berkas <span class="text-danger">*</span></label>
                                    <select name="file_tp" id="file_tp" class="form-control form-control-select2 select-search" required data-fouc>
                                        {!! comCodeOptions('FILE_TP') !!}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Keterangan </label>
                                    <textarea name="file_desc" id="file_desc" class="form-control" ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Berkas <span class="text-danger">*</span></label>
                                    <input type="file" name="file" class="file-input berkas" aria-invalid="false" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary ml-3 legitRipple" id="save-file">Upload <i class="icon-upload ml-2"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!--File modal-->
	<!--Discount modal-->
    <div id="modal-discount" class="modal fade" tabindex="">
		<div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
				<div class="modal-body">
                    <form class="form-validate-jquerys" id="form-discount" method="POST" action='{{ url("/inventori/pembelian/purchase-order/discount/$pocd") }}'>
                        @csrf
						<div>
							<h5 class="modal-title" id="modal-discount-title"> Discount</h5>
						</div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Discount [Rp.]</label>
                                    <input type="number" name="discount_amount" class="form-control" placeholder="nominal" aria-invalid="false">
                                </div>
                            </div>
							<div class="col-md-4">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Discount [%]</label>
                                    <input type="number" name="discount_percent" class="form-control" placeholder="%" aria-invalid="false">
                                </div>
                            </div>
                        </div>
						<br>
						<div>
							<h5 class="modal-title" id="modal-discount-title"> Saksi</h5>
						</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Saksi 1</label>
                                    <input type="text" name="data_10" class="form-control" placeholder="Nama" aria-invalid="false">
                                </div>
                            </div>
							<div class="col-md-3">
                                <div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">&nbsp;</label>
                                    <input type="text" name="data_20" class="form-control" placeholder="Badge No" aria-invalid="false">
                                </div>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Saksi 2</label>
                                    <input type="text" name="data_11" class="form-control" placeholder="Nama" aria-invalid="false">
                                </div>
                            </div>
							<div class="col-md-3">
                                <div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">&nbsp;</label>
                                    <input type="text" name="data_21" class="form-control" placeholder="Badge No" aria-invalid="false">
                                </div>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Saksi 3</label>
                                    <input type="text" name="data_12" class="form-control" placeholder="Nama" aria-invalid="false">
                                </div>
                            </div>
							<div class="col-md-3">
                                <div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">&nbsp;</label>
                                    <input type="text" name="data_22" class="form-control" placeholder="Badge No" aria-invalid="false">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary ml-3 legitRipple" id="save-discount">Simpan <i class="icon-upload ml-2"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!--Discount modal-->
	
@endsection
@push('scripts')
<script src="/global_assets/js/plugins/pickers/daterangepicker.js"></script>
<script src="/plugins/cell-edit/cell-edit.js"></script>
<script>
    // Basic initialization
    $('.daterange-basic').daterangepicker({
        showDropdowns: true,
        applyClass: 'bg-slate-600',
        cancelClass: 'btn-light',
        locale: {
            format: "DD/MM/YYYY",
            separator: "-",
        }
    });

    var tabelData;
	var saveMethod = 'tambah';
	var dataCd  = "";
    var dataTrxCd  = "";
	var dataItem  = "";
    var baseUrl = "{{ url('inventori/pembelian/purchase-order/') }}";
	
    $(document).ready(function(){
		$('#reset').click(function(){
           window.location=baseUrl;
        });

        @if($po)
			//--Reject
			if ('{{ $po->po_st }}' == 'INV_TRX_ST_9') {
				$("#po_st").text('DITOLAK');
				$("#reject_note").text('{{ $po->reject_note }}');
				$("#reject_by").text('{{ $po->reject_by }}');
			
				$("#reject-info").show();
			}
			else {
				$("#po_st").text('');
				$("#reject_note").text('');
				$("#reject_by").text('');
			
				$("#reject-info").hide();
			}
			//--End Reject
					
            dataTrxCd  = "{{ $po->po_cd }}";
			//$('input[name=po_cd]').val("{{ $po->po_cd }}");
			
            //$('#supplier_cd').val("{{ $po->supplier_cd }}").trigger('change').attr("disabled", true);
			$('#supplier_cd').val("{{ $po->supplier_cd }}").trigger('change');
            $('input[name=po_no]').val("{{ $po->po_no }}").trigger('keyup').attr("readonly", true);
			
            //$('input[name=trx_date]').val("{{ $po->trx_date }}").trigger('keyup').attr("readonly", true);
			$('input[name=trx_date]').val("{{ date_format(date_create($po->trx_date), "d/m/Y") }}").trigger('keyup').attr("readonly", false);
			
			$('select[name=dana_tp]').val("{{ $po->dana_tp }}").trigger('change');
			$('select[name=po_tp]').val("{{ $po->po_tp }}").trigger('change');
			$('input[name=percent_ppn]').val("{{ $po->percent_ppn }}").trigger('keyup').attr("readonly", false);
            
			//$('input[name=delivery_datetime]').val("{{ $po->delivery_datetime }}").trigger('keyup').attr("readonly", true);
			@if($po->delivery_datetime != null)
			$('input[name=delivery_datetime]').val("{{ date_format(date_create($po->delivery_datetime), "d/m/Y") }}").trigger('keyup').attr("readonly", false);
			@endif
			
            $('textarea[name=delivery_address]').val('{{ $po->delivery_address }}').prop("readonly", false);

            $('input[name=ppn]').val('Rp '+spelling('{{ $po->ppn }}')).attr('readonly', true);  
            $('input[name=total_amount]').val('Rp '+spelling('{{ $po->total_amount }}')).attr('readonly', true);
			
			/* pilihan unit */
			var cc_cd = '{{ $po->unit_cd }}';
			var cc_nm = '';
			$('#cc_cd').empty();
            $('#cc_cd').select2({
                //data:[{"id": cc_cd ,"text": cc_cd + " - " + cc_nm }] ,
				data:[{"id": cc_cd ,"text": cc_cd}] ,
                ajax : {
                    url :  "{{ url('/e-general-ledger/dropdown-data/cost-center') }}",
                    dataType: 'json', 
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                    cache : true,
                },
            });
			
			/* pilihan aktivitas */
			var aktivitas_cd = '{{ $po->aktivitas_cd }}';
			var aktivitas_nm = '';
			var urlinfo = "{{ url('data-list/aktivitas/') }}" + '/' + '{{ $po->aktivitas_cd }}';
			$.getJSON(urlinfo, function(response){
				if (response.data.aktivitas_nm != '') {
					aktivitas_nm = response.data.aktivitas_nm;
				}
			});
			$('#aktivitas_cd').empty();
			$('#aktivitas_cd').select2({
				data:[{"id": aktivitas_cd ,"text": aktivitas_cd + " - " + aktivitas_nm }] ,
				ajax : {
					url :  "{{ url('data-list/aktivitas') }}",
					dataType: 'json', 
					processResults: function(data){
						return {
							results: data
						};
					},
					cache : true,
				},
			});
			$('select[name=aktivitas_tp]').val('{{ $po->aktivitas_tp }}').trigger('change');
			
            tabelData = $('#tabel-data').DataTable({
                language: {
                    paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
                },
                pagingType: "simple",
                processing	: true, 
                serverSide	: true, 
                order		: [[2,'ASC']], 
                ajax		: {
                    url : baseUrl+'/'+'data',
                    type: "POST",
                    data: function(data){
                        data._token = $('meta[name="csrf-token"]').attr('content');
                        data.type   = 'detail';
                        data.id     = dataTrxCd;
                    },
                },
                dom : 'tpi',
                columns: [
                    {name: "po_po_detail_id", data: "po_po_detail_id", visible:false},
                    {name: "item_cd", data: "item_cd", visible:true},
                    {name: "item_nm", data: "item_nm", visible:true},
                    {name: "unit_cd", data: "unit_cd", visible:false},
                    {name: "unit_nm", data: "unit_nm", visible:true},
                    {name: "quantity", data: "quantity", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
                    {name: "unit_price", data: "unit_price", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' ), className: "text-right"},
                    {name: "trx_amount", data: "trx_amount", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' ), className: "text-right"},
                    {data: "action", visible:true, orderable: false, searchable: false, className: "text-center"},
                ],
            });

            $(document).on('keyup', '#item_nm_param',function(){ 
                tabelData.column('#item_nm_table').search($(this).val()).draw();
            });

            $(document).on('change', '#unit_cd_param',function(){ 
                tabelData.column('#unit_cd_table').search($(this).val()).draw();
            });
			
			$('select[name=item_cd]').empty();
            $('select[name=item_cd]').select2({
                ajax : {
                    url :  "{{ url('inventori/datalist') }}",
                    dataType: 'json', 
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                    cache : true,
                    success: function(response){
                        $('select[name=item_cd]').on('select2:select', function (evt) {
							var selected = evt.params.data;
							// $('input[name=item_nm]').val(selected.text);
                            $('input[name=item_nm]').val(selected.text).trigger('keyup');
                            $('input[name=unit_price]').val(selected.item_price_buy).trigger('keypress');
							$('select[name=unit_cd]').val(selected.unit_cd).trigger('change').attr("readonly", true);
                        });
                    }
                },
            });
			/*$('#item_cd').empty();
			$('#item_cd').select2({
				data:[{"id": "" ,"text":"=== Pilih Item ===" }],
				ajax : {
					url :  "{{ url('inventori/datalist') }}",
					dataType: 'json', 
					processResults: function(data){
						return {
							results: data
						};
					},
					cache : true,
				},
			});*/
			
			$('select[name=assettp_cd]').empty();
            $('select[name=assettp_cd]').select2({
                ajax : {
                    url :  "{{ url('inventori/tipeaset') }}",
                    dataType: 'json', 
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                    cache : true,
                    success: function(response){
                        $('select[name=assettp_cd]').on('select2:select', function (evt) {
                            var selected = evt.params.data;
                            $('input[name=item_nm]').val(selected.text).trigger('keyup');
                        });
                    }
                },
            });

            $('#reload-table').click(function(){
                $('input[name=search_param]').val('').trigger('keyup');
                tabelData.ajax.reload();
            });
			
            @if($po->po_st == 'INV_TRX_ST_1' or $po->po_st == 'INV_TRX_ST_5')
                function myCallbackFunction (updatedCell, updatedRow, oldValue) {
                    var rowData = updatedRow.data();

                    $.ajax({
                        url : baseUrl+'/'+'item/'+rowData['po_po_detail_id'],
                        type: "PUT",
                        dataType: "JSON",
                        data: {
                            '_token': $('input[name=_token]').val(),
                            'quantity' : rowData['quantity'],
                            'unit_price' : rowData['unit_price'],
                        },
                        success: function(response)
                        {
                            if(response["status"] == 'ok') { 
                                    afterSaveItem(response["po"]);
                            }else{
                                swal({title: "Purchase Order Gagal Dihapus",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            swal({title: "Terjadi Kesalahan Sistem!", text:"Silakan Hubungi Administrator", type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                        }
                    });
                }

                function getTrxAmount(){
                    var jumlah 	= $('input[name=quantity]').val();
                    var harga 	= $('input[name=unit_price]').val().replace(/,/g, "");
                    var results = jumlah * harga;
					
					//--Pembulatan ke atas
					//var temp = results % 10;
					//var results = results + ((10 - temp) % 10);
					if ((results % 10) >= 5) {
						var results = results + ((10 - (results % 10)) % 10);
					} else {
						var results = results - (results % 10);
					}
					
					//$('input[name=trx_amount]').val(results).trigger('keyup');
					$('input[name=trx_amount]').val(results);
                }

                function afterSaveItem(data){
                    $('input[name=ppn]').val('Rp '+spelling(data["ppn"])).attr('readonly', true);  
                    $('input[name=total_amount]').val('Rp '+spelling(data["total_amount"])).attr('readonly', true);  

                    $('input[name=item_nm]').val('').trigger('keyup');
                    $('input[name=unit_price]').val('0').trigger('keypress');
                    $('input[name=quantity]').val('0').trigger('keypress');
                    $('input[name=trx_amount]').val('0').trigger('keypress');
                    $('select[name=unit_cd]').val('').trigger('change').attr("readonly", true);
					
                    $('select[name=item_cd]').empty();
                    $('select[name=item_cd]').select2({
                        ajax : {
                            url :  "{{ url('inventori/datalist') }}",
                            dataType: 'json', 
                            processResults: function(data){
                                return {
                                    results: data
                                };
                            },
                            cache : true,
                            success: function(response){
                                $('select[name=item_cd]').on('select2:select', function (evt) {
									var selected = evt.params.data;
                                    // $('input[name=item_nm]').val(selected.text);
                                    $('input[name=item_nm]').val(selected.text).trigger('keyup');
                                    $('input[name=unit_price]').val(selected.item_price_buy).trigger('keypress');
                                    $('select[name=unit_cd]').val(selected.unit_cd).trigger('change').attr("readonly", true);
                                });
                            }
                        },
                    });
					
					@if($po->po_tp == '1')
					$('select[name=assettp_cd]').val('').trigger('change');
					@endif
                }

                $(document).on('keyup', 'input[name=quantity]',function(){ 
                    getTrxAmount();
                });

                $(document).on('keyup', 'input[name=unit_price]',function(){ 
                    getTrxAmount();
                });
				
				//--Show Confirm Cancel hapus item
                /* tabelData.MakeCellsEditable({
                    "onUpdate": myCallbackFunction,
                    "inputCss":'my-input-class',
                    "columns": [6],
                    "confirmationButton": { 
                        "confirmCss": 'my-confirm-class',
                        "cancelCss": 'my-cancel-class'
                    },
                    "inputTypes": [
                        {
                            "column":6, 
                            "type":"text", 
                            "options":null 
                        }, 
                    ], 
                }); */
				
				$('#form-item').submit(function(e){
                    if (e.isDefaultPrevented()) {
                    // handle the invalid form...
                    } else {
						e.preventDefault();

                        var record  = $('#form-isian, #form-item').serialize();
                        //var url     = baseUrl+'/item/'+dataTrxCd;
                        //var method  = 'POST';
						if(saveMethod == 'tambah'){
							var url     = baseUrl+'/item/'+dataTrxCd;
							var method  = 'POST';
						}else{
							var url     = baseUrl+'/item/'+dataItem;
							var method  = 'PUT';
						}
                        
                        $.ajax({
                            'type': method,
                            'url' : url,
                            'data': record,
                            'dataType': 'JSON',
                            'success': function(response){
                                if(response["status"] == 'ok') { 
                                    tabelData.ajax.reload();
                                    afterSaveItem(response["po"]);
                                }else{
                                    swal({title: "Data Gagal Disimpan",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                }
                            },
                            'error': function(response){ 
                                var errorText = '';
                                $.each(response.responseJSON.errors, function(key, value) {
                                    errorText += value+'<br>'
                                });

                                swal({
                                    title             : response.status+':'+response.responseJSON.message,
                                    type              : "error",
                                    html              : errorText, 
                                    showCancelButton  : false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText : "OK",
                                    cancelButtonText  : "Tidak",
                                }).then(function(result){
                                    if(result.value){   	
                                        reset('ubah');
                                    }
                                });  
                            }
                        });
						
						saveMethod = 'tambah';
						dataItem  = '';
                    }
                });
                
                /* proses data */
                $(document).on('click', '#proses',function(){
					if  ($('#supplier_cd').val() == '') {
						swal({
							title: "Pilih Supplier !",
							type: "warning",
							showCancelButton: false,
                            showConfirmButton: false,
							timer: 1000
						}).then(() => {
							swal.close();
						});
						return false;
					}
					
					/* if (parseInt($('input[name=percent_ppn]').val()) == 0) {
						swal({
							title: "PPN = 0 !",
							type: "info",
							showCancelButton: false,
							showConfirmButton: false,
							timer: 1000
						}).then(() => {
							swal.close();
						});
						return false;
					} */
					
                    swal({
                        title             : "Proses Purchase Order?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Proses Purchase Order",onOpen: () => {swal.showLoading();}});
                            
                            $.ajax({
                                url : baseUrl+'/'+dataTrxCd,
                                type: "PUT",
                                dataType: "JSON",
                                data: {
                                    '_token': $('input[name=_token]').val(),
									'supplier_cd': $('#supplier_cd').val(),
									'percent_ppn': $('#percent_ppn').val(),
									'delivery_datetime': $('#delivery_datetime').val(),
                                },
                                success: function(response)
                                {
                                    if (response.status == 'ok') {
                                        swal({
                                            title: "Berhasil",
                                            type: "success",
                                            showCancelButton: false,
                                            showConfirmButton: false,
                                            timer: 1000
                                        }).then(() => {
                                            swal.close();
                                            window.location = baseUrl+'/'+dataTrxCd;
                                        });
                                    }else{
                                        swal({title: "Purchase Order Gagal",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    swal({title: "Terjadi Kesalahan Sistem!", text:"Silakan Hubungi Administrator", type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                }
                            });
                        }else {
                            swal.close();
                        }
                    });
                });
				
				/* ubah data */
				$(document).on('click', '.ubah-item',function(){ 
					saveMethod      = 'ubah';
					/* tableRow        = $(this).parents('tr');
					var rowData     = tabelData.row(tableRow).data();
					dataCdDetail    = rowData.cm_transaction_detail_id; */
					
					var rowData=tabelData.row($(this).parents('tr')).data();
                    dataItem = rowData['po_po_detail_id'];
					
					$('input[name=item_nm]').val(rowData.item_nm).trigger('input');
					$('input[name=unit_price]').val(rowData.unit_price).trigger('input');
					$('input[name=quantity]').val(rowData.quantity).trigger('input');
					$('input[name=trx_amount]').val(rowData.trx_amount).trigger('input');

					//--Item
					var item_cd = '';
					var item_nm = '';
					if (rowData.item_cd) {
						item_cd = rowData.item_cd;
						item_nm = rowData.item_nm;
					}
					/* $('#item_cd').empty();
					$('#item_cd').select2({
						data:[{"id": item_cd ,"text":item_nm }] ,
						ajax : {
							url :  "{{ url('inventori/datalist') }}",
							dataType: 'json', 
							processResults: function(data){
								return {
									results: data
								};
							},
							cache : true,
						},
					}); */
					$('select[name=item_cd]').empty();
					$('select[name=item_cd]').select2({
						data:[{"id": item_cd ,"text":item_nm }] ,
						ajax : {
							url :  "{{ url('inventori/datalist') }}",
							dataType: 'json', 
							processResults: function(data){
								return {
									results: data
								};
							},
							cache : true,
							success: function(response){
								$('select[name=item_cd]').on('select2:select', function (evt) {
									var selected = evt.params.data;
									// $('input[name=item_nm]').val(selected.text);
									$('input[name=item_nm]').val(selected.text).trigger('keyup');
									//$('input[name=unit_price]').val(selected.item_price_buy).trigger('keypress');
									$('select[name=unit_cd]').val(selected.unit_cd).trigger('change').attr("readonly", true);
								});
							}
						},
					});
					
					@if($po->po_tp == '1')
					//--Asset
					var assettp_cd = '';
					var assettp_nm = '';
					if (rowData.assettp_cd) {
						assettp_cd = rowData.assettp_cd;
						assettp_nm = rowData.assettp_desc;
					}
					$('select[name=assettp_cd]').empty();
					$('select[name=assettp_cd]').select2({
						data:[{"id": assettp_cd ,"text":assettp_cd }],
						ajax : {
							url :  "{{ url('inventori/tipeaset') }}",
							dataType: 'json', 
							processResults: function(data){
								return {
									results: data
								};
							},
							cache : true,
							success: function(response){
								$('select[name=assettp_cd]').on('select2:select', function (evt) {
									var selected = evt.params.data;
									$('input[name=item_nm]').val(selected.text).trigger('keyup');
								});
							}
						},
					});
					@endif
					
					//--Satuan
					/* var unit_cd = '';
					var unit_nm = '';
					if (rowData.unit_cd) {
						unit_cd = rowData.unit_cd;
						//unit_nm = rowData.unit_nm;
						unit_nm = rowData.unit_cd;
					}
					$('#unit_cd').empty();
					$('#unit_cd').select2({
						data:[{"id": unit_cd ,"text":unit_nm }] ,
						ajax : {
							url :  "{{ url('inventori/satuanlist') }}",
							dataType: 'json', 
							processResults: function(data){
								return {
									results: data
								};
							},
							cache : true,
						},
					}); */
					$('select[name=unit_cd]').val(rowData.unit_cd).trigger('change');
				});
				
				/* upload file */
				$(document).on('click', '#upload',function(){
					$('#modal-file').modal('show');
				});
				$('#save-file').click(function(){
					$('#form-file').submit();
				});
				
				/* input discount | saksi */
				$(document).on('click', '#discount',function(){
					$('#modal-discount').modal('show');
					showDiscount(dataTrxCd);
				});
				$('#save-discount').click(function(){
					$('#form-discount').submit();
				});
				
				/* hapus */
				$(document).on('click', '.hapus-dokumen',function(){ 
					dataFileId = $(this).data("trx_file_id");
					swal({
						title             : "Hapus Berkas?",
						type              : "question",
						showCancelButton  : true,
						confirmButtonColor: "#00a65a",
						confirmButtonText : "Ya",
						cancelButtonText  : "Batal",
						allowOutsideClick : false,
					}).then(function(result){
						if(result.value){
							swal({allowOutsideClick : false, title: "Menghapus Data",onOpen: () => {swal.showLoading();}});
							window.location = '/inventori/file/delete/'+ dataFileId;
						}
					});
				});
				/* end upload file */

                /* hapus data */
                $(document).on('click', '#hapus',function(){
                    swal({
                        title             : "Hapus Purchase Order?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Hapus Purchase Order",onOpen: () => {swal.showLoading();}});
                            
                            $.ajax({
                                url : baseUrl+'/'+dataTrxCd,
                                type: "DELETE",
                                dataType: "JSON",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                },
                                success: function(response)
                                {
                                    if (response.status == 'ok') {
                                        swal({
                                            title: "Berhasil",
                                            type: "success",
                                            showCancelButton: false,
                                            showConfirmButton: false,
                                            timer: 1000
                                        }).then(() => {
                                            swal.close();
                                            window.location = baseUrl;
                                        });
                                    }else{
                                        swal({title: "Purchase Order Gagal Dihapus",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    swal({title: "Terjadi Kesalahan Sistem!", text:"Silakan Hubungi Administrator", type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                }
                            })
                        }else {
                            swal.close();
                        }
                    });
                });

                /* hapus data item */
                $(document).on('click', '#hapus-item',function(){
                    var rowData=tabelData.row($(this).parents('tr')).data();
                    dataItem = rowData['po_po_detail_id'];
                    
                    swal({
                        title             : "Hapus Data?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Hapus Data",onOpen: () => {swal.showLoading();}});
                            
                            $.ajax({
                                url : baseUrl+'/item/'+dataItem,
                                type: "DELETE",
                                dataType: "JSON",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                },
                                success: function(response)
                                {
                                    if (response.status == 'ok') {
                                        swal({
                                            title: "Berhasil",
                                            type: "success",
                                            showCancelButton: false,
                                            showConfirmButton: false,
                                            timer: 1000
                                        }).then(() => {
                                            tabelData.ajax.reload();
                                            //afterSaveItem;
                                            swal.close();
											
											window.location = "{{ url('inventori/pembelian/purchase-order/') }}" + "/" + dataTrxCd;
                                        });
                                    }else{
                                        swal({title: "Data Gagal Dihapus",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    swal({title: "Terjadi Kesalahan Sistem!", text:"Silakan Hubungi Administrator", type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                }
                            })
                        }else {
                            swal.close();
                        }
                    });
                });
            @else
                //--cetak data
                /* $(document).on('click', '#print',function(){
					window.open(baseUrl + '/print/' + dataTrxCd,'_blank');
                }); */
            @endif
        @endif
		
		$(document).on('click', '#print',function(){
			/* window.open(baseUrl + '/print/' + dataTrxCd, '_blank');
			
			window.open(baseUrl + '/print-bast/' + dataTrxCd, '_blank');
			window.open(baseUrl + '/print-bacek/' + dataTrxCd, '_blank');
			@if($po)
			@if( in_array($po->dana_tp,array('DANA_TP_02','DANA_TP_03','DANA_TP_04')) )
			//--BOS | BOSDA | BOP
				window.open(baseUrl + '/print-nota/' + dataTrxCd, '_blank');
			@endif
			@endif */
			
			switch($('select[name=print_tp]').val()) {
				case '1':
					window.open(baseUrl + '/print/' + dataTrxCd, '_blank');
					break;
				case '2':
					window.open(baseUrl + '/print-request/' + dataTrxCd, '_blank');
					break;
				case '3':
					window.open(baseUrl + '/print-nota/' + dataTrxCd, '_blank');
					break;
				case '4':
					window.open(baseUrl + '/print-bast/' + dataTrxCd, '_blank');
					break;
				case '5':
					window.open(baseUrl + '/print-bacek/' + dataTrxCd, '_blank');
					break;
				default:
					window.open(baseUrl + '/print/' + dataTrxCd, '_blank');
			}
		});
		
		@if(!$po)
		init();
		@endif
    });
	
	function init() {
		/* pilihan unit */
		$('#cc_cd').empty();
		$('#cc_cd').select2({
			data:[{"id": "" ,"text":"=== Pilih Data ===" }] ,
			ajax : {
				url :  "{{ url('/e-general-ledger/dropdown-data/cost-center') }}",
				dataType: 'json', 
				processResults: function(data){
					return {
						results: data
					};
				},
				cache : true,
			},
		});
		
		/* pilihan aktivitas */
		$('#aktivitas_cd').empty();
		$('#aktivitas_cd').select2({
			data:[{"id": "" ,"text":"=== Pilih Data ===" }] ,
			ajax : {
				url :  "{{ url('data-list/aktivitas') }}",
				dataType: 'json', 
				processResults: function(data){
					return {
						results: data
					};
				},
				cache : true,
			},
		});
	}
	
	function showDiscount(ppocd) {
		var urlshow = "{{ url('inventori/pembelian/purchase-order/po/') }}" + "/" + ppocd;
		$.get(urlshow, function(response){
			if (response.status == "ok") {
				var responseData = response.data;
				
				$('input[name=discount_amount]').val(responseData.discount_amount);
				$('input[name=discount_percent]').val(responseData.discount_percent);
				
				$('input[name=data_10]').val(responseData.data_10);
				$('input[name=data_20]').val(responseData.data_20);
				$('input[name=data_11]').val(responseData.data_11);
				$('input[name=data_21]').val(responseData.data_21);
				$('input[name=data_12]').val(responseData.data_12);
				$('input[name=data_22]').val(responseData.data_22);
			}
		});
	}
	
	$('#delivery_datetime').datetimepicker({
		format: 'DD/MM/YYYY'
	});
</script>
@endpush