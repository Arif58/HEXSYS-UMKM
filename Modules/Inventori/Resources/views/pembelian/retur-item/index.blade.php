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
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group form-group-float">
                        <select name="supplier_cd_param" id="supplier_cd_param" class="form-control form-control-select2 select-search" required data-fouc>
                            <option value="">=== Pilih Supplier ===</option>
                            @foreach ($suppliers as $item)
                                <option value="{{ $item->supplier_cd}}">{{ $item->supplier_nm}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-float">
                        <input name="retur_no_param" id="retur_no_param" placeholder="Pencarian Nomor Retur" class="form-control" data-fouc />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-float">
                        <input type="text" name="trx_date_param" class="form-control daterange-single" data-value="{{ date('Y/m/d') }}" readonly="readonly" placeholder="" aria-invalid="false" />
                        <!--<input name="entry_date_param" id="entry_date_param" placeholder="DD/MM/YYYY" class="form-control mask-date" data-fouc />-->
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i>Retur</button>
            <!--<button type="button" class="btn btn-info legitRipple" id="detail"><i class="icon-menu-open mr-2"></i>Detail Retur</button>-->
            
            <div class="table-responsive">
                <table class="table datatable-pagination" id="tabel-data" width="100%">
                    <thead>
                        <tr>
                            <th id="retur_cd_table">retur_cd_table</th>
                            <th id="retur_no_table">Nomor</th>
                            <th id="supplier_cd_table">supplier_cd_table</th>
                            <th id="supplier_nm_table">Supplier</th>
                            <th id="trx_date_table">Tanggal</th>
                            <th id="retur_st_table">retur_st_table</th>
                            <th id="retur_st_nm_table">Status</th>
							<th id="actions_table" width="20%">#</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script>
    var tabelData;
    var baseUrl     = "{{ url('inventori/pembelian/retur-item/') }}";

    $(document).ready(function(){
        
        tabelData = $('#tabel-data').DataTable({
            language: {
                paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'},
                emptyTable: 'Tidak ada data',
            },
            pagingType: "simple",
            processing	: true, 
            serverSide	: true, 
            order		: [], 
            ajax		: {
                url : baseUrl+'/'+'data',
                type: "POST",
                /* data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'type'  : 'data',
					'trx_date_param' : $('input[name=trx_date_param]').val();
                }, */
				data : function(d){
                    d._token         = $('meta[name="csrf-token"]').attr('content');
					d.type			 = 'data';
                    d.trx_date_param = $('input[name=trx_date_param]').val();
                },
            },
            dom : 'tpi',
            columns: [
                { data: 'retur_cd', name:'retur_cd', visible:false},
                { data: 'retur_no', name:'retur_no', visible:true},
                { data: 'supplier_cd', name:'supplier_cd', visible:false},
                { data: 'supplier_nm', name:'supplier_nm', visible:true},
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
                { data: 'retur_st', name:'retur_st', visible:false},
                { data: 'retur_st_nm', name:'retur_st_nm', visible:true},
				{ data: 'actions', name: 'actions', orderable:false },
            ],
        });

        $(document).on('change', '#supplier_cd_param',function(){ 
            tabelData.column('#supplier_cd_table').search($(this).val()).draw();
        });

        $(document).on('keyup', '#retur_no_param',function(){ 
            tabelData.column('#retur_no_table').search($(this).val()).draw();
        });

        /* $(document).on('keyup', '#entry_date_param',function(){ 
            tabelData.column('#entry_date_table').search($(this).val()).draw();
        }); */
		$('input[name="trx_date_param"]').change(function() {
			tabelData.ajax.reload();
		});

        $('#reload-table').click(function(){
			$('input[name=retur_no_param]').val('').trigger('keyup');
			tabelData.ajax.reload();
		});

        /* transaksi */
        $('#tambah').click(function() {
            window.location=baseUrl+'/'+'tambah'
        });

        /* detail data */
        /* $(document).on('click', '#detail',function(){ 
            if (dataCd == null) {
                swal({
                    title: "Pilih Data!",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1000
                });
            }else{
                window.location = baseUrl+'/'+dataCd;
            }
        }); */
		$(document).on('click', '.detail',function(){
			var rowData = tabelData.row($(this).parents('tr')).data();
			dataCd = rowData.retur_cd;
			
            window.location = baseUrl+'/'+dataCd;
        });
		
		/* hapus data */
		$(document).on('click', '.hapus',function(){
			var rowData = tabelData.row($(this).parents('tr')).data();
			dataCd = rowData.retur_cd;
			
            //--Cek status Retur
			if (rowData.retur_st != 'INV_TRX_ST_1') {
				swal({
					title: "Transaksi sudah proses !",
					type: "warning",
					showCancelButton: false,
					showConfirmButton: false,
					timer: 1000
				}).then(() => {
					swal.close();
				});

				return false;
			}
			else{
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
                        swal({allowOutsideClick : false, title: "Menghapus Data",onOpen: () => {swal.showLoading();}});
                        
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
                                        reset('')
                                        swal.close();
                                    });
									window.location = "{{ url('inventori/pembelian/retur-item/') }}";
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
            } 
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
</script>
@endpush