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
			<script>
			function CheckUnit() {
				//--Cek unit
				var unitRoot = $('select[name=pos_cd]').val().split('-')[0];
				if (unitCd != '' && $('select[name=pos_cd]').val() != '') {
					if (unitCd != $('select[name=pos_cd]').val()) {
					//if (unitCd != $('select[name=pos_cd]').val() && unitCd !=unitRoot) {	
						swal({
							title: "Gudang tidak sesuai unit user !",
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
                
            <form class="form-validate-jquery" id="form-isian" method="POST" action="{{ url('inventori/pembelian/purchase-request/') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-group-float-label is-visible">No. Permintaan Barang</label>
                        <div class="form-group form-group-float">
                            {{--<input name="pr_no" id="pr_no" class="form-control" required data-fouc value="{{ $defaultPoNo }}" />--}}
                            <input name="pr_no" id="pr_no" class="form-control" data-fouc placeholder="Kosong : nomor PR akan di-generate sistem" />
                        </div>
                    </div>
                </div>
                <div class="row">
					<div class="col-md-6">
                        <label class="form-group-float-label is-visible">Tanggal (dd/mm/yyyy)</label>
                        <div class="form-group form-group-float">
                            {{--<input name="trx_date" id="trx_date" class="form-control mask-date" placeholder="DD/MM/YYYY" required data-fouc  value="{{ date('d/m/Y') }}" />--}}
                            <input name="trx_date" id="trx_date" class="form-control date-picker" required data-fouc value="{{ date('d/m/Y') }}" />

                        </div>
                    </div>
                    <!--<div class="col-md-6">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Supplier</label>
                            <select name="supplier_cd" id="supplier_cd" class="form-control form-control-select2 select-search" data-fouc>
                                <option value=""> Pilih Salah Satu Supplier</option>
                                @foreach ($suppliers as $item)
                                    <option value="{{ $item->supplier_cd}}">{{ $item->supplier_nm}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>-->
					<div class="col-md-4">
                        <div class="form-group form-group-float">
                            <label clas="form-group-float-label is-visible">Gudang <span class="text-danger">*</span></label>
							<select name="pos_cd" id="pos_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                <option value="">=== Pilih Gudang ===</option>
								@foreach ($gudangs as $item)
									<option value="{{ $item->pos_cd}}">{{ $item->pos_nm }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
				@if(!$pr)
					<div class="d-flex justify-content-end align-items-center">
                        <button type="submit" name="submitpr" id="submitpr" class="btn btn-primary ml-3 legitRipple" onClick="return CheckUnit();">Simpan <i class="icon-floppy-disk ml-2"></i></button>
                    </div>
                @endif
            </form>

            @if ($pr) 
                @if($pr->pr_st == 'INV_TRX_ST_1')
                    <form class="form-validate-jquery" id="form-item">
						@csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Kode Item</label>
                                <div class="form-group form-group-float">
                                    <select name="item_cd" id="item_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Satuan</label>
                                <div class="form-group form-group-float">
                                    <select name="unit_cd" id="unit_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                        <option value="">=== Pilih Data ===</option>
                                        @foreach ($units as $item)
                                            <option value="{{ $item->unit_cd}}">{{ $item->unit_nm}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
							<div class="col-md-4">
                                <label class="form-group-float-label is-visible">Keterangan</label>
                                <div class="form-group form-group-float">
									<textarea name="info_note" id="info_note" class="form-control" maxlength="100"></textarea>
								</div>
                            </div>
						</div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Nama Item </label>
                                <div class="form-group form-group-float">
                                    <input name="item_nm" id="item_nm" class="form-control" readonly data-fouc/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Jumlah</label>
                                <div class="form-group form-group-float">
                                    <input type="number" name="quantity" id="quantity" class="form-control" required data-fouc value="0"/>
                                </div>
                            </div>
							@if( in_array(Auth::user()->role->role_cd,array('superuser','adminv')) )
							<div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="info_st" name="info_st">
									<label class="custom-control-label" for="info_st">Ditolak</label>
                                </div>
                            </div>
							@endif
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
							<button type="submit" name="submititem" id="submititem" class="btn btn-primary ml-3 legitRipple" onClick="return CheckUnit();">Tambah Item <i class="icon icon-plus-circle2" ></i></button>
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
                                <th id="po_pr_detail_id_table">po_pr_detail_id_table</th>
                                <th id="item_cd_table">item_cd_table</th>
                                <th id="item_nm_table">Nama Item</th>
                                <th id="unit_cd_table">unit_cd_table</th>
                                <th id="unit_nm_table">Satuan</th>
                                <th id="quantity_table">Jumlah</th>
								<th id="pos_source_table">Gudang</th>
								<th id="pos_source_nm_table">Dari Gudang</th>
								<th id="info_note_table">Keterangan</th>
								<th id="info_st_table">Status</th>
                                <th id="action_table">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        
        <div class="card-footer">
            @if(!empty($pr))
                @if($pr->pr_st == 'INV_TRX_ST_1')
					@if( in_array(Auth::user()->role->role_cd,array('superuser','adminv','supervisor','manager')) )
					<div class="col-md-3">	
					<select name="pos_source" id="pos_source" class="form-control form-control-select2 select-search" required data-fouc>
						<option value="">=== Proses Dari Gudang ===</option>
						@foreach ($gudangs as $item)
							<option value="{{ $item->pos_cd}}">{{ $item->pos_nm}}</option>
						@endforeach
					</select>
					</div>		
                    <button type="button" class="btn btn-warning legitRipple" id="proses"><i class="icon-check mr-2"></i> Proses Permintaan Barang</button>
					@endif
                    <button type="button" class="btn btn-danger legitRipple" id="hapus"><i class="icon-trash mr-2"></i> Hapus Permintaan Barang</button>
                @else
                    <button type="button" class="btn btn-success legitRipple" id="print"><i class="icon-printer mr-2"></i> Cetak Permintaan Barang</button>
                @endif
            @endif
            <button type="reset" class="btn btn-light legitRipple" id="reset"><i class="icon-reload-alt mr-2"></i> Kembali </button>
        </div>
    </div>

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
	var dataItem  = "";
    var baseUrl = "{{ url('inventori/pembelian/purchase-request/') }}";
	var unitCd	= "{{ Auth::user()->unit_cd ?? '' }}";

    $(document).ready(function(){
		
		if (unitCd != '') {
			$('select[name=pos_cd]').val(unitCd).trigger('change');
		}

        $('#reset').click(function(){
           window.location=baseUrl;
        });

        @if($pr)
            dataCd  = "{{ $pr->pr_cd }}";
            //$('#supplier_cd').val("{{ $pr->supplier_cd }}").trigger('change');
			//$('#pos_cd').val("{{ $pr->pos_cd }}").trigger('change').attr("disabled", true);
			$('#pos_cd').val("{{ $pr->pos_cd }}").trigger('change');
            $('input[name=pr_no]').val("{{ $pr->pr_no }}").trigger('keyup').attr("readonly", true);
            $('input[name=trx_date]').val("{{ $pr->trx_date }}").trigger('keyup').attr("readonly", true);
			$('input[name=trx_date]').val("{{ date_format(date_create($pr->trx_date), "d/m/Y") }}").trigger('keyup').attr("readonly", false);
            
            tabelData = $('#tabel-data').DataTable({
                language: {
                    paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
                },
                pagingType: "simple",
                processing	: true, 
                serverSide	: true, 
                order		: [[2, 'ASC']], 
                ajax		: {
                    url : baseUrl+'/'+'data',
                    type: "POST",
                    data: function(data){
                        data._token = $('meta[name="csrf-token"]').attr('content');
                        data.type   = 'detail';
                        data.id     = dataCd;
                    },
                },
                dom : 'tpi',
                columns: [
                    {name: "po_pr_detail_id", data: "po_pr_detail_id", visible:false},
                    {name: "item_cd", data: "item_cd", visible:false},
                    {name: "item_nm", data: "item_nm", visible:true},
                    {name: "unit_cd", data: "unit_cd", visible:false},
                    {name: "unit_nm", data: "unit_nm", visible:true},
                    {name: "quantity", data: "quantity", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
					{name: "pos_source", data: "pos_source", visible:false},
					{name: "pos_source_nm", data: "pos_source_nm", visible:true},
					{name: "info_note", data: "info_note", visible:true},
					{name: "info_st_nm", data: "info_st_nm", visible:true},
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

            $('#reload-table').click(function(){
                $('input[name=search_param]').val('').trigger('keyup');
                tabelData.ajax.reload();
            });

            @if($pr->pr_st == 'INV_TRX_ST_1')
                function myCallbackFunction (updatedCell, updatedRow, oldValue) {
                    var rowData = updatedRow.data();

                    $.ajax({
                        url : baseUrl+'/'+'item/'+rowData['po_pr_detail_id'],
                        type: "PUT",
                        dataType: "JSON",
                        data: {
                            '_token': $('input[name=_token]').val(),
                            'quantity' : rowData['quantity'],
                        },
                        success: function(response)
                        {
                            if(response["status"] == 'ok') { 
                                    afterSaveItem(response["pr"]);
                            }else{
                                swal({title: "Purchase Request Gagal Dihapus",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            swal({title: "Terjadi Kesalahan Sistem!", text:"Silakan Hubungi Administrator", type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                        }
                    });
                }

                function afterSaveItem(data){
                    $('input[name=item_nm]').val('').trigger('keyup');
                    $('input[name=quantity]').val('0').trigger('keypress');
                    $('select[name=unit_cd]').val('').trigger('change').attr("readonly", true);
					$('textarea[name=info_note]').val('').trigger('keyup');
					$('input[name=info_st]').prop("checked",false);

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
                                    $('select[name=unit_cd]').val(selected.unit_cd).trigger('change').attr("readonly", true);
                                });
                            }
                        },
                    });
                }
				
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
				
				/* submit form */
                $('#form-item').submit(function(e){
                    if (e.isDefaultPrevented()) {
                    // handle the invalid form...
                    } else {
						e.preventDefault();

                        /* var record  = $('#form-isian, #form-item').serialize();
                        var url     = baseUrl+'/item/'+dataCd;
                        var method  = 'POST'; */
						
						var record  = $('#form-isian, #form-item').serialize();
                        if(saveMethod == 'tambah'){
							var url     = baseUrl+'/item/'+dataCd;
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
					//--Cek Gudang
					if ($('select[name=pos_source]').val() == '{{ $pr->pos_cd }}') {
						swal({
							title: "Gudang sama dengan gudang tujuan !",
							type: "warning",
							showCancelButton: false,
							showConfirmButton: false,
							timer: 1000
						}).then(() => {
							swal.close();
						});

						return false;
					}
					//--End Cek Gudang
				
                    swal({
                        title             : "Proses Permintaan Barang?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Proses Permintaan Barang",onOpen: () => {swal.showLoading();}});
                            
                            $.ajax({
                                url : baseUrl+'/'+dataCd,
                                type: "PUT",
                                dataType: "JSON",
                                data: {
                                    '_token'	: $('input[name=_token]').val(),
									'pos_source': $('select[name=pos_source]').val()
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
                                            window.location = baseUrl+'/'+dataCd;
                                        });
                                    }else{
                                        swal({title: "Proses Permintaan Barang Gagal",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
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
                    dataItem = rowData['po_pr_detail_id'];
					
					$('input[name=item_nm]').val(rowData.item_nm).trigger('input');
					$('input[name=quantity]').val(rowData.quantity).trigger('input');
					$('textarea[name=info_note]').val(rowData.info_note).trigger('input');
					if (rowData.info_st == '1') {
                        $('input[name=info_st]').prop("checked",true);
                    }else{
                        $('input[name=info_st]').prop("checked",false);
                    }
					
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
									$('select[name=unit_cd]').val(selected.unit_cd).trigger('change').attr("readonly", true);
								});
							}
						},
					});
					
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

                /* hapus data */
                $(document).on('click', '#hapus',function(){
                    swal({
                        title             : "Hapus Permintaan Barang?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Hapus Permintaan Barang",onOpen: () => {swal.showLoading();}});
                            
                            $.ajax({
                                url : baseUrl+'/'+dataCd,
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
                                        swal({title: "Permintaan Barang Gagal Dihapus",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
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
                    dataItem = rowData['po_pr_detail_id'];
					
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
											
											//window.location = "{{ url('inventori/pembelian/purchase-request/') }}" + "/" + dataCd;
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
				
				/* update source gudang item */
                $(document).on('click', '#update-wh',function(){
                    var rowData=tabelData.row($(this).parents('tr')).data();
                    dataItem = rowData['po_pr_detail_id'];
					
                    swal({
                        title             : "Proses Dari Gudang " + $('select[name=pos_source]').val() + "?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Update Data",onOpen: () => {swal.showLoading();}});
                            
                            $.ajax({
                                url : baseUrl+'/itempos/'+dataItem,
                                type: "PUT",
                                dataType: "JSON",
                                data: {
                                    '_token': $('input[name=_token]').val(),
									'pos_source': $('select[name=pos_source]').val()
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
											
											$('select[name=pos_source]').val('').trigger('change');
											
											//window.location = "{{ url('inventori/pembelian/purchase-request/') }}" + "/" + dataCd;
                                        });
                                    }
									else if (response.status == 'no') {
										swal({title: "Stok gudang tidak cukup",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                    }
									else
									{
                                        swal({title: "Data Gagal Diupdate",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
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
                /* cetak data */
                $(document).on('click', '#print',function(){
                    window.open(baseUrl + '/print/' + dataCd,'_blank');
                });
            @endif
        @endif
    });
</script>
@endpush