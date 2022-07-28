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
                <div class="col-md-6">
                    <div class="form-group form-group-float">
                        <input name="search_param" id="search_param" placeholder="Pencarian Nama Inventori" class="form-control" data-fouc />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-float">
                        <select name="pos_cd_param" id="pos_cd_param" class="form-control form-control-select2 select-search" required data-fouc>
                            <option value="">=== Pilih Gudang ===</option>
                            @foreach ($gudangs as $item)
                                <option value="{{ $item->pos_cd}}">{{ $item->pos_nm}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datatable-pagination" id="tabel-data" width="100%">
                    <thead>
                        <tr>
                            <th id="positemunit_cd_table">Kode Stok</th>
                            <th id="pos_cd_table">Kode Gudang</th>
                            <th id="pos_nm_table">Gudang</th>
                            <th id="item_cd_table">Kode Inventori</th>
                            <th id="item_nm_table">Nama Inventori</th>
                            <!--
							<th id="item_price_buy_table">Harga Beli</th>
                            <th id="item_price_table">Harga Jual</th>
                            -->
                            <th id="unit_cd_table">Kode Satuan</th>
							<th id="unit_nm_table">Satuan</th>
                            <th id="quantity_table">Jumlah</th>
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
    var saveMethod  = 'tambah';
    var baseUrl     = "{{ url('inventori/stock-inventori/') }}";
	var unitCd		= "{{ Auth::user()->unit_cd ?? '' }}";

    $(document).ready(function(){
        
        tabelData = $('#tabel-data').DataTable({
            processing	: true, 
            serverSide	: true, 
            order		: [2,'asc'], 
            ajax		: {
                url: baseUrl+'/'+'data',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
            },
            /*language: {
                paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
            },
            pagingType: "simple",*/
            language: {
			  "sSearch": "" //--Change search box caption
			},
            lengthMenu		: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
			info 			: false, /*--Showing 1 to XX of YY entries--*/
			dom 			: 'Blrtip',
            columns: [
                { data: "positemunit_cd", name : "positemunit_cd", visible:false},
                { data: "pos_cd", name : "inv_pos_itemunit.pos_cd", visible:false},
                { data: "pos_nm", name : "pos_nm", visible:true},
                { data: "item_cd", name : "item_cd", visible:false},
                { data: "item_nm", name : "master.item_nm", visible:true},
                //{ data: "item_price", name : "item_price", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' )},
                //{ data: "item_price_buy", name : "item_price_buy", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' )},
                { data: "unit_cd", name : "unit_cd", visible:false},
                { data: "unit_nm", name : "unit_nm", visible:true},
                { data: "quantity", name : "quantity", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
            ],
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#item_nm_table').search($(this).val()).draw();
        });

        $(document).on('change', '#pos_cd_param',function(){
			//tabelData.column('#pos_cd_table').search($(this).val()).draw();
			
			if (CheckUnit()) {
				//tabelData.column('#pos_cd_table').search($(this).val()).draw();
				tabelData.column('#pos_cd_table').search("^" + $(this).val() + "$", true, false).draw();
			} else {
				//tabelData.column('#pos_cd_table').search(unitCd).draw();
				tabelData.column('#pos_cd_table').search("^" + unitCd + "$", true, false).draw();
			}
        });

        $('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');

			tabelData.ajax.reload();
		});
		
		init();
    });
	
	function init() {
		if (unitCd != '') {
			$('select[name=pos_cd_param]').val(unitCd).trigger('change');
		} else {
			$('select[name=pos_cd_param]').val("{{ configuration('WHPOS_TRX') }}").trigger('change');
		}
	}
	
	function CheckUnit() {
		//--Cek unit
		if (unitCd != '' && $('select[name=pos_cd_param]').val() != '') {
			if (unitCd != $('select[name=pos_cd_param]').val()) {
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