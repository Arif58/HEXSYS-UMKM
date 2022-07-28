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
                <div class="col-md-3">
                    <div class="form-group form-group-float">
						<!--<input name="item_cd_param" id="item_cd_param" placeholder="Pencarian Nama Inventori" class="form-control search-param" data-fouc />-->
						<select name="item_cd_param" id="item_cd_param" class="form-control form-control-select2 search-param" data-fouc>
						</select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group form-group-float">
                        <select name="pos_cd_param" id="pos_cd_param" class="form-control form-control-select2 search-param" data-fouc>
                            <option value="">=== Pilih Gudang ===</option>
                            @foreach ($gudangs as $item)
                                <option value="{{ $item->pos_cd}}">{{ $item->pos_nm}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
				<div class="col-md-3">
                    <div class="form-group form-group-float">
                        <input type="text" name="tanggal_param" class="form-control daterange-single search_param" data-value="{{ date('Y/m/d') }}" readonly="readonly" placeholder="Tanggal" aria-invalid="false" />
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-single-select datatable-pagination" id="tabel-data" width="100%">
                    <thead>
                        <tr>
                            <th>Kode Stock Inventori</th>
                            <th id="pos_cd_table">Kode Gudang</th>
                            <th id="pos_nm_table">Gudang</th>
                            <th id="item_cd_table">Kode Inventori</th>
							<th id="item_nm_table">Nama Inventori</th>
                            <th id="trx_date_table">Tanggal</th>
							<th id="trx_tp_table">Jenis Transaksi</th>
                            <th id="stok_awal_table">Stok Awal</th>
                            <th id="stok_akhir_table">Stok Akhir</th>
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
    var baseUrl     = "{{ url('inventori/mutasi-inventori/history/') }}";
	var unitCd		= "{{ Auth::user()->unit_cd ?? '' }}";

    $(document).ready(function(){
        
        tabelData = $('#tabel-data').DataTable({
            processing	: true, 
            serverSide	: true, 
            order		: [], 
            ajax		: {
                url : baseUrl+'/'+'data',
                type: "POST",
                data: function(d){
                    //'_token': $('meta[name="csrf-token"]').attr('content'),
					d._token        = $('meta[name="csrf-token"]').attr('content');
                    d.tanggal_param = $('input[name=tanggal_param]').val();
                },
            },
            language: {
			  "sSearch": "" //--Change search box caption
			},
            lengthMenu		: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
			info 			: false, /*--Showing 1 to XX of YY entries--*/
			dom 			: 'Blrtip',
            columns: [
                { data: 'inv_item_move_id', name: 'inv_item_move_id', visible:false},
                { data: 'pos_cd', name: 'pos_cd', visible:false },
                { data: 'pos_nm', name: 'pos_nm' },
                { data: 'item_cd', name: 'item_cd', visible:false },
				{ data: 'item_nm', name: 'item_nm' },
                { data: 'trx_datetime', name: 'trx_datetime' },
				/* { 
                    data : 'trx_datetime', 
                    name: 'trx_datetime', 
                    visible:true,
                    render: function (data) {
                        return moment(data).format('DD-MM-YYYY');
                    }
                }, */
				{ data: 'trx_tp', name: 'trx_tp' },
                { data: "stok_awal", name : "stok_awal", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
                { data: "stok_akhir", name : "stok_akhir", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
            ],
        });
		
		/* $('.search-param').change(function() {
			tabelData.ajax.reload();
        }); */

        /* $(document).on('keyup', '#item_cd_param',function(){ 
            tabelData.column('#item_nm_table').search($(this).val()).draw();
        }); */
		$(document).on('change', '#item_cd_param',function(){ 
            tabelData.column('#item_cd_table').search($(this).val()).draw();
        });

        $(document).on('change', '#pos_cd_param',function(){ 
            if (CheckUnit()) {
				//tabelData.column('#pos_cd_table').search($(this).val()).draw();
				tabelData.column('#pos_cd_table').search("^" + $(this).val() + "$", true, false).draw();
			} else {
				tabelData.column('#pos_cd_table').search(unitCd).draw();
			}
        });
		
		$('input[name="tanggal_param"]').change(function() {
            tabelData.ajax.reload();
		});

        $('#reload-table').click(function(){
			//$('input[name=item_cd_param]').val('').trigger('keyup');
			$('select[name=item_cd_param]').val('').trigger('change');
			//tabelData.column('#item_cd_table').search('').draw();
			
			//$('select[name=pos_cd_param]').val('').trigger('change');
			if (unitCd != '') {
				$('select[name=pos_cd_param]').val(unitCd).trigger('change');
			} else {
				$('select[name=pos_cd_param]').val("{{ configuration('WHPOS_TRX') }}").trigger('change');
			}
			
			setDaterange();
            
			tabelData.ajax.reload();
		});
		
		function setDaterange() {
			$('input[name="tanggal_param"]').daterangepicker({
				//timePicker: true,
				startDate: moment("{{ date('Y') }}/{{ date('m') }}/1"),
				endDate: moment("{{ date('Y/m/d') }}"),
				locale: {format: 'DD/MM/YYYY'}
			});
		}
		setDaterange();

        init();
    });
	
	function init() {
		if (unitCd != '') {
			$('select[name=pos_cd_param]').val(unitCd).trigger('change');
		} else {
			$('select[name=pos_cd_param]').val("{{ configuration('WHPOS_TRX') }}").trigger('change');
		}
		
		$('select[name=item_cd_param]').empty();
		$('select[name=item_cd_param]').select2({
			data:[{"id": "" ,"text":"=== Pilih Item ===" }] ,
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
	
	function CheckUnit() {
		//--Cek unit
		var unitRoot = $('select[name=pos_cd_param]').val().split('-')[0];
		if (unitCd != '' && $('select[name=pos_cd_param]').val() != '') {
			if (unitCd != $('select[name=pos_cd_param]').val()) {
			//if (unitCd != $('select[name=pos_cd_param]').val() && unitCd != unitRoot) {
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
</script>
@endpush