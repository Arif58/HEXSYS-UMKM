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
            <form class="form-validate-jquery" id="form-isian" method="POST" action="{{ url('inventori/stock-opname/') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Gudang <span class="text-danger">*</span></label>
                            <select name="pos_cd" id="pos_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                <option value="">=== Pilih Gudang ===</option>
                                @foreach ($gudangs as $item)
                                    <option value="{{ $item->pos_cd}}">{{ $item->pos_nm}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Tipe Inventori</label>
                            <select name="type_cd" id="type_cd" class="form-control form-control-select2 select-search" data-fouc>
                                <option value=""> Pilih Salah Satu</option>
                                @foreach ($types as $item)
                                    <option value="{{ $item->type_cd}}">{{ $item->type_nm}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Tanggal</label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                </span>
                                <input type="text" name="date_range" class="form-control daterange-basic" value="{{ date('Y/m/d') }}-{{ date('Y/m/d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-float">
                            {{-- <input name="search_param" id="search_param" placeholder="Pencarian Nama Inventori" class="form-control" data-fouc /> --}}
                        </div>
                    </div>
                </div>
                @if(!$opname)
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan <i class="icon-floppy-disk ml-2"></i></button>
                    </div>
                @endif
            </form>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-float">
                        <input name="item_nm_param" id="item_nm_param" placeholder="Pencarian Nama" class="form-control" data-fouc />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-float">
                        <select name="unit_cd_param" id="unit_cd_param" class="form-control form-control-select2 select-search" data-fouc>
                                <option value="">=== Pilih Satuan ===</option>
                                @foreach ($units as $item)
                                    <option value="{{ $item->unit_cd}}">{{ $item->unit_nm}}</option>
                                @endforeach
                            </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datatable-pagination" id="tabel-data" width="100%">
                    <thead>
                        <tr>
                            <th id="inv_opname_detail_id_table">ID</th>
                            <th id="item_cd_table">Item CD</th>
                            <th id="item_nm_table">Nama Item</th>
                            <th id="unit_cd_table">Unit CD</th>
                            <th id="unit_nm_table">Satuan</th>
                            <th id="quantity_system_table">Stok Sistem</th>
                            <th id="quantity_real_table">Stok Real</th>
                            <th id="order_st_table">order_st_table</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            @if(!empty($opname))
                @if($opname->trx_st == 0)
                    <button type="button" class="btn btn-warning legitRipple" id="proses"><i class="icon-check mr-2"></i> Proses Stock Opname</button>
                    <button type="button" class="btn btn-danger legitRipple" id="hapus"><i class="icon-trash mr-2"></i> Hapus Stock Opname</button>
                @else
                    <button type="button" class="btn btn-success legitRipple" id="print"><i class="icon-printer mr-2"></i> Cetak Stock Opname</button>
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
    var baseUrl = "{{ url('inventori/stock-opname/') }}";

    @if($opname)
        var dataCd  = "{{ $opname->inv_opname_id }}";
    @else
        var dataCd  = "";
    @endif

    $(document).ready(function(){

        tabelData = $('#tabel-data').DataTable({
            processing	: true, 
            serverSide	: true, 
            order		: [[7,'ASC'], [2, 'ASC']], 
            ajax		: {
                url : baseUrl+'/'+'data',
                type: "POST",
                data: function(data){
                    data._token = $('meta[name="csrf-token"]').attr('content');
                    data.type   = 'detail';
                    data.id     = dataCd;
                },
            },
            language: {
			  "sSearch": "" //--Change search box caption
			},
            lengthMenu		: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
			info 			: false, /*--Showing 1 to XX of YY entries--*/
			dom 			: 'Blrtip',
            columns: [
                { data: "inv_opname_detail_id", name:"inv_opname_detail_id",visible:false},
                { data: "item_cd", name:"item_cd",visible:false},
                { data: "item_nm", name:"master.item_nm",visible:true},
                { data: "unit_cd", name:"unit_cd",visible:false},
                { data: "unit_nm", name:"unit_nm",visible:true},
                { data: "quantity_system", name:"quantity_system",visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
                { data: "quantity_real", name:"quantity_real",visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
                { data: "order_st", name:"order_st",visible:false},
            ],
        });

        $(document).on('keyup', '#item_nm_param',function(){ 
            tabelData.column('#item_nm_table').search($(this).val()).draw();
        });

        $(document).on('change', '#unit_cd_param',function(){ 
            tabelData.column('#unit_cd_table').search($(this).val()).draw();
        });

        $('#reload-table').click(function(){
            $('input[name=search_param]').val('').trigger('keyup');
            tabelData.ajax.reload();
        });

        $('#reset').click(function(){
           window.location=baseUrl;
        });
		
		function setDaterange() {
			$('input[name="date_range"]').daterangepicker({
				//timePicker: true,
				startDate: moment("{{ date('Y/m/d') }}"),
				endDate: moment("{{ date('Y/m/d') }}"),
				locale: {format: 'DD/MM/YYYY'}
			});
		}
		setDaterange();

        @if($opname)
            $('#pos_cd').val("{{ $opname->pos_cd }}").trigger('change').attr("disabled", true);
            $('#type_cd').val("").trigger('change').attr("disabled", true);
            $('input[name=date_range]').val("{{ $opname->date_start.'-'.$opname->date_end }}").trigger('change').attr("readonly", true);
            $('input[name=date_range]').data('daterangepicker').remove();
            dataCd = "{{ $opname->inv_opname_id }}";

            @if($opname->trx_st == 0)
                function myCallbackFunction (updatedCell, updatedRow, oldValue) {
                    var rowData = updatedRow.data();

                    $.ajax({
                        url : baseUrl+'/'+'item/'+rowData['inv_opname_detail_id'],
                        type: "PUT",
                        dataType: "JSON",
                        data: {
                            '_token': $('input[name=_token]').val(),
                            'quantity_real' : rowData['quantity_real']
                        },
                        success: function(response)
                        {
                            if (response.status == 'ok') {
                                console.log('saved')
                            }else{
                                swal({title: "Stock Opname Gagal Dihapus",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            swal({title: "Terjadi Kesalahan Sistem!", text:"Silakan Hubungi Administrator", type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                        }
                    });
                }

                tabelData.MakeCellsEditable({
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
                });
                
                /* proses data */
                $(document).on('click', '#proses',function(){ 
                    swal({
                        title             : "Proses Stock Opname?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Memproses Stock Opname",onOpen: () => {swal.showLoading();}});
                            
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
                                            swal.close();
                                            window.location = baseUrl+'/'+dataCd;
                                        });
                                    }else{
                                        swal({title: "Stock Opname Gagal Dihapus",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
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

                /* hapus data */
                $(document).on('click', '#hapus',function(){
                    swal({
                        title             : "Hapus Stock Opname?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Menghapus Stock Opname",onOpen: () => {swal.showLoading();}});
                            
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
                                        swal({title: "Stock Opname Gagal Dihapus",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
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
                /* hapus data */
                $(document).on('click', '#print',function(){
                    alert('print')
                });
            @endif
        @endif
    });
</script>
@endpush