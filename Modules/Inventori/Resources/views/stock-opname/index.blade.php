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
            <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i> Buat Stock Opname</button>
            <button type="button" class="btn btn-info legitRipple" id="detail"><i class="icon-menu-open mr-2"></i> Detail Stock Opname</button>
            
            <div class="table-responsive">
                <table class="table table-single-select datatable-pagination" id="tabel-data" width="100%">
                    <thead>
                        <tr>
                            <th id="trx_cd_table">trx_cd_table</th>
                            <th id="pos_cd_table">pos_cd_table</th>
                            <th id="pos_nm_table">Gudang</th>
                            <th id="date_start_table">Tanggal Mulai</th>
                            <th id="date_end_table">Tanggal Selesai</th>
                            <th id="datetime_trx_table">Tanggal Stock Opname</th>
                            <th id="trx_st_table">trx_st_table</th>
                            <th id="trx_st_nm_table">Status</th>
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
    var baseUrl     = "{{ url('inventori/stock-opname/') }}";

    $(document).ready(function(){
        
        tabelData = $('#tabel-data').DataTable({
            processing	: true, 
            serverSide	: true, 
            order		: [], 
            ajax		: {
                url : baseUrl+'/'+'data',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'type'  : 'data'
                },
            },
            language: {
			  "sSearch": "" //--Change search box caption
			},
            lengthMenu		: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
			info 			: false, /*--Showing 1 to XX of YY entries--*/
			dom 			: 'Blrtip',
            columns: [
                { data: 'inv_opname_id', name:'inv_opname_id', visible:false},
                { data: 'pos_cd', name:'pos_cd', visible:false},
                { data: 'pos_nm', name:'pos_nm', visible:true},
                { data: 'date_start', name:'date_start', visible:true},
                { data: 'date_end', name:'date_end', visible:true},
                { data: 'datetime_trx', name:'datetime_trx', visible:true},
                { data: 'trx_st', name:'trx_st', visible:false},
                { data: 'trx_st_nm', name:'trx_st_nm', visible:true},
            ],
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#item_nm_table').search($(this).val()).draw();
        });

        $(document).on('change', '#pos_cd_param',function(){ 
            tabelData.column('#pos_cd_table').search($(this).val()).draw();
        });

        $('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');
			tabelData.ajax.reload();
		});

        /* transaksi */
        $('#tambah').click(function() {
            window.location=baseUrl+'/'+'tambah'
        });

        /* detail data */
        $(document).on('click', '#detail',function(){ 
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
        });
    });
</script>
@endpush