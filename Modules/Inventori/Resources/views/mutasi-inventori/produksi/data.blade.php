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
                
            <form class="form-validate-jquery" id="form-isian" method="POST" action="{{ url('inventori/mutasi-inventori/produksi/') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-group-float-label is-visible">No. Produksi</label>
                        <div class="form-group form-group-float">
                            {{--<input name="prod_no" id="prod_no" class="form-control" required data-fouc value="{{ $defaultPoNo }}" />--}}
                            <input name="prod_no" id="prod_no" class="form-control" data-fouc placeholder="Kosong : nomor akan di-generate sistem" />
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
                            <label clas="form-group-float-label is-visible">Gudang <span class="text-danger">*</span></label>
                            <select name="pos_cd" id="pos_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                <option value="">=== Pilih Gudang ===</option>
                                @foreach ($gudangs as $item)
                                    <option value="{{ $item->pos_cd}}">{{ $item->pos_nm}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
					<div class="col-md-4">
                        <div class="form-group form-group-float">
                            <label clas="form-group-float-label is-visible">Barang Produksi <span class="text-danger">*</span></label>
                            <select name="prod_item" id="prod_item" class="form-control form-control-select2 select-search" required data-fouc>
							</select>
                        </div>
                    </div>
					<div class="col-md-2">
						<label class="form-group-float-label is-visible">Jumlah Produksi</label>
						<div class="form-group form-group-float">
							<input type="number" name="prod_quantity" id="prod_quantity" class="form-control" required data-fouc value="0" min="0" />
						</div>
					</div>
                </div>
                <hr>
				@if(!$prod)
					<div class="d-flex justify-content-end align-items-center">
                        <button type="submit" name="submitpr" id="submitpr" class="btn btn-primary ml-3 legitRipple" onClick="return CheckUnit();">Simpan <i class="icon-floppy-disk ml-2"></i></button>
                    </div>
                @endif
            </form>

            @if ($prod) 
                @if($prod->prod_st == 'INV_TRX_ST_1')
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
                </div>

                <div class="table-responsive">
                    <table class="table datatable-pagination" id="tabel-data" width="100%">
                        <thead>
                            <tr>
                                <th id="prod_detail_id_table">prod_detail_id_table</th>
                                <th id="item_cd_table">item_cd_table</th>
                                <th id="item_nm_table">Nama Item</th>
                                <th id="unit_cd_table">unit_cd_table</th>
                                <th id="unit_nm_table">Satuan</th>
                                <th id="quantity_table">Jumlah</th>
								<th id="pos_source_table">Gudang</th>
								<th id="pos_source_nm_table">Dari Gudang</th>
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
            @if(!empty($prod))
                @if($prod->prod_st == 'INV_TRX_ST_1')
					@if( in_array(Auth::user()->role->role_cd,array('superuser','adminv')) )
					{{--<div class="col-md-3">	
					<select name="pos_source" id="pos_source" class="form-control form-control-select2 select-search" required data-fouc>
						<option value="">=== Proses Dari Gudang ===</option>
						@foreach ($gudangs as $item)
							<option value="{{ $item->pos_cd}}">{{ $item->pos_nm}}</option>
						@endforeach
					</select>
					</div>--}}
                    <button type="button" class="btn btn-warning legitRipple" id="proses"><i class="icon-check mr-2"></i> Proses Stok</button>
					@endif
                    <button type="button" class="btn btn-danger legitRipple" id="hapus"><i class="icon-trash mr-2"></i> Hapus Produksi</button>
                @else
                    <button type="button" class="btn btn-success legitRipple" id="print"><i class="icon-printer mr-2"></i> Cetak Produksi</button>
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
    var baseUrl = "{{ url('inventori/mutasi-inventori/produksi/') }}";
	var unitCd	= "{{ Auth::user()->unit_cd ?? '' }}";

    $(document).ready(function(){

        $('#reset').click(function(){
           window.location=baseUrl;
        });

        @if($prod)
            dataCd  = "{{ $prod->prod_cd }}";
            $('#pos_cd').val("{{ $prod->pos_cd }}").trigger('change');
            $('input[name=prod_no]').val("{{ $prod->prod_no }}").trigger('keyup').attr("readonly", true);
            $('input[name=trx_date]').val("{{ $prod->trx_date }}").trigger('keyup').attr("readonly", true);
			$('input[name=trx_date]').val("{{ date_format(date_create($prod->trx_date), "d/m/Y") }}").trigger('keyup').attr("readonly", false);
			$('input[name=prod_quantity]').val("{{ $prod->quantity }}").trigger('keyup');
			
			$('#prod_item').empty();
			$('#prod_item').select2({
				//data:[{"id": '{{ $prod->prod_item }}' ,"text": '{{ $prod->prod_item }}' + " - " + '{{ $prod->prod_item_nm }}' }] ,
				data:[{"id": '{{ $prod->prod_item }}' ,"text": '{{ $prod->prod_item }}' }] ,
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
			});
            
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
                    {name: "prod_detail_id", data: "prod_detail_id", visible:false},
                    {name: "item_cd", data: "item_cd", visible:false},
                    {name: "item_nm", data: "item_nm", visible:true},
                    {name: "unit_cd", data: "unit_cd", visible:false},
                    {name: "unit_nm", data: "unit_nm", visible:true},
                    {name: "quantity", data: "quantity", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
					{name: "pos_source", data: "pos_source", visible:false},
					{name: "pos_source_nm", data: "pos_source_nm", visible:false},
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
			
            $('#reload-table').click(function(){
                $('input[name=search_param]').val('').trigger('keyup');
                tabelData.ajax.reload();
            });

            @if($prod->prod_st == 'INV_TRX_ST_1')
                function myCallbackFunction (updatedCell, updatedRow, oldValue) {
                    var rowData = updatedRow.data();

                    $.ajax({
                        url : baseUrl+'/'+'item/'+rowData['prod_detail_id'],
                        type: "PUT",
                        dataType: "JSON",
                        data: {
                            '_token': $('input[name=_token]').val(),
                            'quantity' : rowData['quantity'],
                        },
                        success: function(response)
                        {
                            if(response["status"] == 'ok') { 
                                    afterSaveItem(response["prod"]);
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
                                    afterSaveItem(response["prod"]);
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
					if ($('select[name=pos_source]').val() == '{{ $prod->pos_cd }}') {
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
                        title             : "Proses Produksi?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Proses Produksi",onOpen: () => {swal.showLoading();}});
                            
                            $.ajax({
                                url : baseUrl+'/'+dataCd,
                                type: "PUT",
                                dataType: "JSON",
                                data: {
                                    '_token'		: $('input[name=_token]').val(),
									'prod_quantity'	: $('input[name=prod_quantity]').val(),
									'pos_source'	: $('select[name=pos_source]').val()
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
                                        swal({title: "Proses Produksi Gagal",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
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
					/* tableRow     = $(this).parents('tr');
					var rowData     = tabelData.row(tableRow).data();
					dataCdDetail    = rowData.cm_transaction_detail_id; */
					
					var rowData=tabelData.row($(this).parents('tr')).data();
                    dataItem = rowData['prod_detail_id'];
					
					$('input[name=item_nm]').val(rowData.item_nm).trigger('input');
					$('input[name=quantity]').val(rowData.quantity).trigger('input');
					
					//--Item
					var item_cd = '';
					var item_nm = '';
					if (rowData.item_cd) {
						item_cd = rowData.item_cd;
						item_nm = rowData.item_nm;
					}
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
					
					$('select[name=unit_cd]').val(rowData.unit_cd).trigger('change');
				});

                /* hapus data */
                $(document).on('click', '#hapus',function(){
                    swal({
                        title             : "Hapus Produksi?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Hapus Produksi",onOpen: () => {swal.showLoading();}});
                            
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
                                        swal({title: "Produksi Gagal Dihapus",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
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
                    dataItem = rowData['prod_detail_id'];
					
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
											
											//window.location = "{{ url('inventori/mutasi-inventori/produksi/') }}" + "/" + dataCd;
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
                    dataItem = rowData['prod_detail_id'];
					
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
											
											//window.location = "{{ url('inventori/mutasi-inventori/produksi/') }}" + "/" + dataCd;
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
        @else
		init();
		@endif
    });
	
	function init() {
		/* item */
        $('#prod_item').empty();
        $('#prod_item').select2({
            data:[{"id": "" ,"text":"" }] ,
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
        });
	}
</script>
@endpush