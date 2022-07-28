@extends('layouts.app')

@section('content')
	<!-- Alternate row color -->
	<style>
		/*table {
			border-collapse: collapse;
			width: 100%;
		}*/
		th {
			text-align: center;
			/*padding: 8px;*/
		}
		td {
			text-align: left;
			/*padding: 8px;*/
		}
		tr:nth-child(even) {
			/*background-color: Lightblue;*/
			background-color: #e8f4f4;
		}
	</style>
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
            <div class="row" style="margin-top:10px">
                <div class="col-md-12">
                    <div class="form-group form-group-float">
                        <label class="form-group-float-label is-visible">Tanggal</label>
                        <input type="text" name="trx_date_param" class="form-control daterange-single" data-value="{{ date('Y/m/d') }}" readonly="readonly" placeholder="" aria-invalid="false" />
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datatable-pagination" id="tabel-data" width="100%">
                    <thead>
						<tr>
                            <th id="po_cd_table">po_cd_table</th>
                            <th id="po_no_table">Nomor</th>
                            <th id="supplier_cd_table">supplier_cd_table</th>
                            <th id="supplier_nm_table">Supplier</th>
                            <th id="trx_date_table">Tanggal</th>
							<th id="dana_tp_table">Sumber Dana</th>
                            <th id="dana_tp_nm_table">Sumber Dana</th>
                            <th id="unit_cd_table">Unit</th>
							<th id="total_amount_table">Total</th>
							<th id="po_st_table">po_st_table</th>
                            <th id="po_st_nm_table">Status</th>
							<th id="actions_table" width="20%">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
			<br>
			<h5 class="card-title">Riwayat Approval</h5>
			<div class="table-responsive">
                <table class="table datatable-pagination" id="tabel-history" width="100%">
                    <thead>
						<tr>
                            <th id="po_cd_table">po_cd_table</th>
                            <th id="po_no_table">Nomor</th>
                            <th id="supplier_cd_table">supplier_cd_table</th>
                            <th id="supplier_nm_table">Supplier</th>
                            <th id="trx_date_table">Tanggal</th>
							<th id="dana_tp_table">Sumber Dana</th>
                            <th id="dana_tp_nm_table">Sumber Dana</th>
                            <th id="unit_cd_table">Unit</th>
							<th id="total_amount_table">Total</th>
							<th id="po_st_table">po_st_table</th>
                            <th id="po_st_nm_table">Status</th>
							<th id="actions_table" width="20%">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
	
	<!--Modal View Data-->
	<div id="modal-view" class="modal fade" tabindex="-1" data-backdrop="false">
	    <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
				
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<label class="form-group-float-label is-visible">No. Purchase Order</label>
							<div class="form-group form-group-float">
								<input name="po_no" id="po_no" class="form-control" data-fouc />
							</div>
						</div>
						<div class="col-md-6">
							<label class="form-group-float-label is-visible">Tanggal Pengiriman (dd/mm/yyyy)</label>
							<div class="form-group form-group-float">
								<input type="text" name="delivery_datetime" id="delivery_datetime" class="form-control mask-date" placeholder="DD/MM/YYYY" aria-invalid="false">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label class="form-group-float-label is-visible">Tanggal (dd/mm/yyyy)</label>
							<div class="form-group form-group-float">
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
						<div class="col-md-3">
								<div class="form-group form-group-float">
									<label class="form-group-float-label is-visible">Unit <span class="text-danger">*</span></label>
									<select name="cc_cd" id="cc_cd" class="form-control" data-fouc>
									</select>
								</div>
							</div>
					</div>
					<div class="row">
						<div class="col-md-6" id="input-supplier"><!--Permintaan Pembelian-->
						<div class="col-md-4">
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
						</div><!--Permintaan Pembelian-->
						<div class="col-md-6">
							<div class="form-group form-group-float">
								<label class="form-group-float-label is-visible">Alamat Pengiriman</label>
								<textarea name="delivery_address" class="form-control">{{ configuration('INST_NAME') }}</textarea>
							</div>
						</div>
						<div id="input-01"><!--Input Advanced-->
						<div class="col-md-6">
							<label class="form-group-float-label is-visible">PPN (%)</label>
							<div class="form-group form-group-float">
								<input type="number" name="percent_ppn" id="percent_ppn" class="form-control" required data-fouc value="0"/>
							</div>
						</div>
						<script type='text/javascript'>
						$(document).ready(function(){
							$("#input-01").hide();
						});
						</script>
						</div><!--Input Advanced-->
					</div>
					
					<div class="table-responsive">
						<table class="table datatable-pagination" id="tabel-view" width="100%">
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
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="card" style="width: 40rem;">
				<div class="modal-header">
					<h6 class="modal-title">Riwayat Approval</h5>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table datatable-pagination" id="tabel-approval" width="100%">
								<thead>
									<tr>
										<th id="approval_no_table">No</th>
										<th id="approval_by_table">Approval</th>
										<th id="approval_date_table">Tanggal</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				</div>
				
				<div class="card" style="width: 40rem;">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table datatable-pagination" id="tabel-file" width="100%">
								<thead>
									<tr>
										<th id="file_table">Dokumen</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				</div>
				
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Selesai</button>
                </div>
            </div>
        </div>
    </div>
	<!--End Modal View Data-->
@endsection
@push('scripts')
<script>
    var tabelData;
	var tabelHistory;
	var baseUrl     = "{{ url('inventori/pembelian/approval/') }}";
    var dataCd;

    $(document).ready(function(){
        $('#bagian-form').hide();  

        tabelData = $('#tabel-data').DataTable({
            processing  : true, 
            serverSide  : true, 
            order		: [[0,'ASC']],
            scrollX     : false,
            ajax		: {
                url: baseUrl+'/data',
                type: "POST",
                data : function(d){
                    d._token         = $('meta[name="csrf-token"]').attr('content');
					d.trx_date_param = $('input[name=trx_date_param]').val();
                },
            },
			language: {
			  "sSearch": "" //--Change search box caption
			},
            lengthMenu		: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
			info 			: false, /*--Showing 1 to XX of YY entries--*/
			//dom 			: 'Blrtip',
            columns: [
                { data: 'po_cd', name:'po_cd', visible:false},
                { data: 'po_no', name:'po_no', visible:true},
                { data: 'supplier_cd', name:'supplier_cd', visible:false},
                { data: 'supplier_nm', name:'supplier_nm', visible:true},
                //{ data: 'trx_date', name:'trx_date', visible:true},
				{ data: 'trx_date', name:'trx_date', 
					'render': function (data, type, full, meta) {
						if (data != null) {
							return moment(data).format('DD/MM/YYYY');
						}
						else {
							return '';
						}
					}, 
					visible:true},
				{ data: 'dana_tp', name:'dana_tp', defaultValue : '',visible:false},
                { data: 'dana_tp_nm', name:'dana_tp_nm', defaultValue : '',visible:true},	
                { data: 'cc_cd', name:'cc_cd', visible:true},
				{ data: 'total_amount', name: 'total_amount', visible:true, render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' ), className: "text-right"},
				{ data: 'po_st', name:'po_st', visible:false},
                { data: 'po_st_nm', name:'po_st_nm', visible:true},
				{ data: 'actions', name: 'actions', orderable:false },
            ]
        });
		
		tabelHistory = $('#tabel-history').DataTable({
            processing  : true, 
            serverSide  : true, 
            order		: [[0,'ASC']],
            scrollX     : false,
            ajax		: {
                url: baseUrl+'/history',
                type: "POST",
                data : function(d){
                    d._token         = $('meta[name="csrf-token"]').attr('content');
					d.trx_date_param = $('input[name=trx_date_param]').val();
                },
            },
			language: {
			  "sSearch": "" //--Change search box caption
			},
            lengthMenu		: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
			info 			: false, /*--Showing 1 to XX of YY entries--*/
			//dom 			: 'Blrtip',
            columns: [
                { data: 'po_cd', name:'po_cd', visible:false},
                { data: 'po_no', name:'po_no', visible:true},
                { data: 'supplier_cd', name:'supplier_cd', visible:false},
                { data: 'supplier_nm', name:'supplier_nm', visible:true},
                //{ data: 'trx_date', name:'trx_date', visible:true},
				{ data: 'trx_date', name:'trx_date', 
					'render': function (data, type, full, meta) {
						if (data != null) {
							return moment(data).format('DD/MM/YYYY');
						}
						else {
							return '';
						}
					}, 
					visible:true},
				{ data: 'dana_tp', name:'dana_tp', defaultValue : '',visible:false},
                { data: 'dana_tp_nm', name:'dana_tp_nm', defaultValue : '',visible:true},	
                { data: 'cc_cd', name:'cc_cd', visible:true},
				{ data: 'total_amount', name: 'total_amount', visible:true, render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' ), className: "text-right"},
				{ data: 'po_st', name:'po_st', visible:false},
                { data: 'po_st_nm', name:'po_st_nm', visible:true},
				{ data: 'actions', name: 'actions', orderable:false },
            ]
        });

        $('input[name="trx_date_param"]').change(function() {
			tabelData.ajax.reload();
			tabelHistory.ajax.reload();
		});

        $('#reload-table').click(function(){
			setDaterange();
			
			tabelData.ajax.reload();
			tabelHistory.ajax.reload();
		});

        /* reset data */
        $('.reset').click(function()   {
            reset('');
        });
		
		/* reject */
		$(document).on('click', '.reject',function(){
			$.ajax({
				url		: baseUrl+'/reject/'+dataCd,
				type	: 'PUT',
				data: {
					'reject_note'	: $('input[name=reject_note]').val(),
                },
				success: function(response){
					if (response.status == 'ok') {
						swal.close();
						
						swal({
							title: "Info!",
							text: "Proses berhasil!",
							type: "warning",
							showCancelButton: false,
							showConfirmButton: false,
							timer: 1000
						}).then(() => {
							swal.close();
						});
						
						window.location = baseUrl;
					}
				}
			});
        });

        /* approve data */
        $(document).on('click', '.approve',function(){ 
            var rowData = tabelData.row($(this).parents('tr')).data();
            dataCd      = rowData.po_cd;
			
			swal({
                title             : "Approval Data?",
                type              : "question",
                showCancelButton  : true,
                confirmButtonColor: "#00a65a",
                confirmButtonText : "Disetujui",
                cancelButtonText  : "Batal",
				
				html:"<input name='reject_note' id='reject_note' class='form-control' data-fouc maxlength='100' placeholder='Alasan Ditolak' /> <br> <button type='button' class='reject btn btn-danger btn-flat btn-sm' data-toggle='tooltip' data-placement='top' title='Ditolak'>Ditolak</button> &nbsp",
				
                allowOutsideClick : false,
            }).then(function(result){
                if(result.value){
                    swal({allowOutsideClick : false, title: "Menyetujui Data",onOpen: () => {swal.showLoading();}});
                    
                    $.ajax({
                        url : baseUrl+'/'+dataCd,
                        type: "PUT",
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
                                    swal.close();
                                });
                            }else{
                                swal({title: "Data Gagal Approval",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
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
		
		/* view data */
        $(document).on('click', '.view',function(){ 
            var rowData = tabelData.row($(this).parents('tr')).data();
            dataCd      = rowData.po_cd;
			
			tabelView.clear().draw();
			$('#modal-view').modal('show');
			showData();
        });
		
		$(document).on('click', '.detail',function(){
			var rowData = tabelData.row($(this).parents('tr')).data();
			dataCd = rowData.po_cd;
			
            window.location = baseUrl+'/edit/'+dataCd;
        });
		
		/* view history */
        $(document).on('click', '.viewh',function(){ 
            var rowData = tabelHistory.row($(this).parents('tr')).data();
            dataCd      = rowData.po_cd;
			
			tabelView.clear().draw();
			$('#modal-view').modal('show');
			showData();
        });
		
		$(document).on('click', '.detailh',function(){
			var rowData = tabelHistory.row($(this).parents('tr')).data();
			dataCd = rowData.po_cd;
			
            window.location = baseUrl+'/edit/'+dataCd;
        });
    });
	
	function setDaterange() {
		$('input[name="trx_date_param"]').daterangepicker({
			//timePicker: true,
			startDate: moment("{{ date('Y') }}/{{ date('m') }}/1"),
			endDate: moment("{{ date('Y/m/d') }}"),
			locale: {format: 'DD/MM/YYYY'}
		});
	}
	setDaterange();
	
	//--Modal View Data
	var tabelView;
    var modalUrl = "{{ url('inventori/pembelian/approval/') }}";
	tabelView = $('#tabel-view').DataTable({
		processing  : true, 
		serverSide  : false, 
		order		: [[6,'ASC'],[1,'ASC']],
		scrollX     : true,
		lengthMenu	: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
		info		: false, /*--Showing 1 to XX of YY entries--*/
		dom			: 'Blrtip',
		paging		: false,
		columns: [
			{name: "po_po_detail_id", data: "po_po_detail_id", visible:false},
			{name: "item_cd", data: "item_cd", visible:true},
			{name: "item_nm", data: "item_nm", visible:true},
			{name: "unit_cd", data: "unit_cd", visible:false},
			{name: "unit_nm", data: "unit_nm", visible:true},
			{name: "quantity", data: "quantity", visible:true, render: $.fn.dataTable.render.number( '.', ',', 0, '' )},
			{name: "unit_price", data: "unit_price", visible:true, render: $.fn.dataTable.render.number( '.', ',', 0, '' ), className: "text-right"},
			{name: "trx_amount", data: "trx_amount", visible:true, render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' ), className: "text-right"},
		]
	});
	
	var tabelApproval;	
	tabelApproval = $('#tabel-approval').DataTable({
		processing  : true, 
		serverSide  : false, 
		order		: [],
		paging		: false,
		info		: false,
		dom			: 'Blrtip',
		columns: [
			{ data: 'approve_no', name:'approve_no', defaultValue : '',visible:true},
			{ data: 'approve_by', name:'approve_by', defaultValue : '',visible:true},
			{ 
				data : 'approve_date', name: 'approve_date', visible:true,
				render: function (data) {
					return moment(data).format('DD-MM-YYYY');
				}
			},
		],
	});
	
	var tabelFile;	
	tabelFile = $('#tabel-file').DataTable({
		processing  : true, 
		serverSide  : false, 
		order		: [],
		paging		: false,
		info		: false,
		dom			: 'Blrtip',
		columns: [
			{ data: 'file', name:'file', defaultValue : '',visible:true},
		],
	});
	
	function showData() {
		if (dataCd) {
            var url = modalUrl + "/view/" + dataCd;
			$.get(url, function(data, status){
                if (data.status == "ok") {
                    var responseData = data.data;
					
					$('#supplier_cd').val(responseData[0]['supplier_cd']).trigger('change').prop("disabled", true);
					//if (responseData[0]['po_st'] == "INV_TRX_ST_2" || responseData[0]['po_st'] == "INV_TRX_ST_3" || responseData[0]['po_st'] == "INV_TRX_ST_5") {
					if (responseData[0]['po_st'] != "INV_TRX_ST_1") {
						$("#input-supplier").hide();
					}
					
					$('input[name=po_no]').val(responseData[0]['po_no']).trigger('keyup').attr("readonly", true);
					
					$('input[name=trx_date]').val(responseData[0]['date_trx']).trigger('keyup').attr("readonly", true);
					
					$('select[name=dana_tp]').val(responseData[0]['dana_tp']).trigger('change').prop("disabled", true);
					$('select[name=po_tp]').val(responseData[0]['po_tp']).trigger('change').prop("disabled", true);
					$('input[name=percent_ppn]').val(responseData[0]['percent_ppn']).trigger('keyup').attr("readonly", true);
					
					$('input[name=delivery_datetime]').val(responseData[0]['delivery_date']).trigger('keyup').attr("readonly", true);
					
					$('textarea[name=delivery_address]').val(responseData[0]['delivery_address']).prop("readonly", true);
					
					var cc_cd = responseData[0]['unit'];
					var cc_nm = '';
					$('#cc_cd').empty();
					$('#cc_cd').select2({
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
					$('select[name=cc_cd]').val(responseData[0]['unit']).trigger('change').prop("disabled", true);
					
					for(var i = 0; i < responseData.length; i++){
						tabelView.row.add(
                            {
								'po_po_detail_id': responseData[i].po_po_detail_id,
								'item_cd'		: responseData[i].item_cd,
                                'item_nm'		: responseData[i].item_nm,
								'unit_cd'		: responseData[i].unit_cd,
								'unit_nm'		: responseData[i].unit_nm,
								'quantity'		: responseData[i].quantity,
								'unit_price'	: responseData[i].unit_price,
								'trx_amount'	: responseData[i].trx_amount,
                            }
                        ).draw();
                    }
                }
            });
			
			var urlApproval = baseUrl + "/list/" + dataCd;
			tabelApproval.clear().draw();
			$.get(urlApproval, function(data, status){
                if (data.status == "ok") {
                    var approvalData = data.data;
					
					for(var i = 0; i < approvalData.length; i++){
						tabelApproval.row.add(
                            {
								'approve_no'	: approvalData[i].approve_no,
								'approve_by'	: approvalData[i].approve_by,
                                'approve_date'	: approvalData[i].approve_date,
                            }
                        ).draw();
                    }
				}
			});
			
			var urlFile = baseUrl + "/file/" + dataCd;
			$.get(urlFile, function(data, status){
                if (data.status == "ok") {
                    var fileData = data.data;
					
					for(var i = 0; i < fileData.length; i++){
						var urlDoc  = "{{ asset('storage/trx-file/') }}";
						urlDoc = urlDoc + "/" + fileData[i].file_path;
						tabelFile.row.add(
						{
							'file'	: '<i class="' + fileData[i].file_tp_icon +' icon-2x top-0"></i> ' +
									  '<a class="text-info" href="' + urlDoc + '" target="_new">' + fileData[i].file_nm + '</a>'
						}
                        ).draw();
                    }
				}
			});
        }
    }
	//--End Modal View Data
</script>
@endpush