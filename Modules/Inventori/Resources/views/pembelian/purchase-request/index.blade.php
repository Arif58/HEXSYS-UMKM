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
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group form-group-float">
                        <select name="pos_cd_param" id="pos_cd_param" class="form-control form-control-select2 select-search" required data-fouc>
							<option value="">=== Pilih Gudang ===</option>
							@foreach ($gudangs as $item)
								<option value="{{ $item->pos_cd}}">{{ $item->pos_nm}}</option>
							@endforeach
						</select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-float">
                        <input name="pr_no_param" id="pr_no_param" placeholder="Pencarian Nomor Permintaan Barang" class="form-control" data-fouc />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-float">
                        <input type="text" name="trx_date_param" class="form-control daterange-single" data-value="{{ date('Y/m/d') }}" readonly="readonly" placeholder="" aria-invalid="false" />
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i> Buat Permintaan Barang</button>
            <!--<button type="button" class="btn btn-info legitRipple" id="detail"><i class="icon-menu-open mr-2"></i> Detail Permintaan Barang</button>
            <button type="button" class="btn btn-danger legitRipple" id="hapus"><i class="icon-trash mr-2"></i> Hapus Permintaan Barang</button>-->
            
            <div class="table-responsive">
                <table class="table datatable-pagination" id="tabel-data" width="100%">
                    <thead>
                        <tr>
                            <th id="pr_cd_table">pr_cd_table</th>
                            <th id="pr_no_table">Nomor</th>
                            <th id="pos_cd_table">pos_cd_table</th>
                            <th id="pos_nm_table">Gudang</th>
                            <th id="trx_date_table">Tanggal</th>
                            <th id="pr_st_table">pr_st_table</th>
                            <th id="pr_st_nm_table">Status</th>
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
    var baseUrl     = "{{ url('inventori/pembelian/purchase-request/') }}";
	var unitCd		= "{{ Auth::user()->unit_cd ?? '' }}";

    $(document).ready(function(){
        
        tabelData = $('#tabel-data').DataTable({
            language: {
                paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'},
                emptyTable: 'Tidak ada data',
            },
            processing	: true, 
            serverSide	: true, 
            order		: [], 
            /* ajax		: {
                url : baseUrl+'/'+'data',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'type'  : 'data'
                },
            }, */
			ajax		: {
                url: baseUrl+'/data',
                type: "POST",
                data : function(d){
                    d._token         = $('meta[name="csrf-token"]').attr('content');
					d.type			 = 'data';
                    d.trx_date_param = $('input[name=trx_date_param]').val();
                },
            },
			language: {
			  "sSearch": "" //--Change search box caption
			},
            lengthMenu		: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
			info 			: false, /*--Showing 1 to XX of YY entries--*/
			dom 			: 'Blrtip',
            columns: [
                { data: 'pr_cd', name:'pr_cd', visible:false},
                { data: 'pr_no', name:'pr_no', visible:true},
                { data: 'pos_cd', name:'pos_cd', visible:false},
                { data: 'pos_nm', name:'pos_nm', visible:true},
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
                { data: 'pr_st', name:'pr_st', visible:false},
                { data: 'pr_st_nm', name:'pr_st_nm', visible:true},
				{ data: 'actions', name: 'actions', orderable:false },
            ],
        });

        $(document).on('change', '#pos_cd_param',function(){
			if (CheckUnit()) {
				tabelData.column('#pos_cd_table').search($(this).val()).draw();
			} else {
				tabelData.column('#pos_cd_table').search(unitCd).draw();
			}
        });

        $(document).on('keyup', '#pr_no_param',function(){ 
            tabelData.column('#pr_no_table').search($(this).val()).draw();
        });

        /* $(document).on('keyup', '#trx_date_param',function(){ 
            tabelData.column('#trx_date_table').search($(this).val()).draw();
        }); */
		$('input[name="trx_date_param"]').change(function() {
			tabelData.ajax.reload();
		});
        
        $('#reload-table').click(function(){
			setDaterange();
			$('input[name=pr_no_param]').val('').trigger('keyup');
			tabelData.ajax.reload();
		});

        /* transaksi */
        $('#tambah').click(function() {
            window.location=baseUrl+'/'+'tambah'
        });

        /* detail data */
		//--Datatable : table table-single-select datatable-pagination
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
			dataCd = rowData.pr_cd;
			
            window.location = baseUrl+'/'+dataCd;
        });
		
        /* hapus data */
		//--Datatable : table table-single-select datatable-pagination
		/* $(document).on('click', '#hapus',function(){
			if (dataCd == null) {
                swal({
                    title: "Pilih Data!",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1000
                }); 
			} */
				
        $(document).on('click', '.hapus',function(){
			var rowData = tabelData.row($(this).parents('tr')).data();
			dataCd = rowData.pr_cd;
			dataSt = rowData.pr_st;
				
			if (rowData.pr_st != 'INV_TRX_ST_1') {
                swal({
                    title: "Transaksi sudah proses !",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1000
                });
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
									window.location = "{{ url('inventori/pembelian/purchase-request/') }}";
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
		
		init();
    });
	
	function init() {
		if (unitCd != '') {
			$('select[name=pos_cd_param]').val(unitCd).trigger('change');
		}
		else {
			//$('select[name=pos_cd_param]').val("{{ configuration('WHPOS_TRX') }}").trigger('change');
		}
	}
	
	function setDaterange() {
		$('input[name="trx_date_param"]').daterangepicker({
			//timePicker: true,
			startDate: moment("{{ date('Y') }}/{{ date('m') }}/1"),
			endDate: moment("{{ date('Y/m/d') }}"),
			locale: {format: 'DD/MM/YYYY'}
		});
	}
	setDaterange();
	
	function CheckUnit() {
		//--Cek unit
		var unitRoot = $('select[name=pos_cd_param]').val().split('-')[0];
		if (unitCd != '' && $('select[name=pos_cd_param]').val() != '') {
			if (unitCd != $('select[name=pos_cd_param]').val() && unitCd != unitRoot) {
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
		} else {
			return true;
		}
	}
	
	/* $('#trx_date_param').datetimepicker({
		format: 'DD/MM/YYYY'
	}); */
</script>
@endpush