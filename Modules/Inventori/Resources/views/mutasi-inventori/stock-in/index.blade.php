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
            <button type="button" class="btn btn-primary legitRipple" id="transaksi-inventori"><i class="icon-add mr-2"></i> {{ $title }}</button>
            <div class="table-responsive">
                <table class="table table-single-select datatable-pagination" id="tabel-data" width="100%">
                    <thead>
                        <tr>
                            <th>Kode Stock Inventori</th>
                            <th id="pos_cd_table">Kode Gudang</th>
                            <th>Gudang</th>
                            <th id="item_nm_table">Nama Inventori</th>
                            <th id="satuan_inventori">Satuan Inventori</th>
                            <th id="jumlah">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- modal-stock -->
	<div id="modal-stock" class="modal fade" tabindex="-1" data-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form class="form-validate-jquery" id="form-isian" action="#">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Nama Inventori</label>
                                    <input type="text" name="item_nm" id="item_nm" class="form-control text-uppercase" required="" placeholder="" aria-invalid="false">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Stok Inventori</label>
                                    <input type="text" name="stock_inventori" class="form-control" readonly aria-invalid="false">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Gudang</label>
                                    <select name="pos_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                        <option value="">=== Pilih Gudang ===</option>
                                        @foreach ($gudangs as $item)
                                        <option value="{{ $item->pos_cd }}">{{ $item->pos_nm }}</option>                                                        
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Jumlah Transaksi</label>
                                    <input type="number" name="jumlah_trx" id="jumlah_trx" min="1" class="form-control text-uppercase" required="" placeholder="" aria-invalid="false">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Stok Setelah Transaksi</label>
                                    <input type="text" name="new_stock" id="new_stock" class="form-control text-uppercase" readonly aria-invalid="false">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Tanggal Expired :</label>
                                    <input type="date" name="expire_date" class="form-control" placeholder="" aria-invalid="false">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-light legitRipple" id="reset" data-dismiss="modal">Reset <i class="icon-reload-alt ml-2"></i></button>
                    <button type="button" id="submit-button" class="btn btn-primary ml-3 legitRipple">Simpan <i class="icon-floppy-disk ml-2"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!-- /modal-stock-->

@endsection
@push('scripts')
<script>
    var tabelData;
    var baseUrl     = "{{ url('inventori/mutasi-inventori/stock-in/') }}";
	var unitCd		= "{{ Auth::user()->unit_cd ?? '' }}";

    $(document).ready(function(){
        
        tabelData = $('#tabel-data').DataTable({
            language: {
                paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'},
                emptyTable: 'Tidak ada data',
            },
            pagingType: "simple",
            processing	: true, 
            serverSide	: true, 
            order		: [2,'asc'], 
            ajax		: {
                url : baseUrl+'/'+'data',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
            },
            dom : 'tpi',
            columns: [
                { data: 'positemunit_cd', name: 'positemunit_cd', visible:false},
                { data: 'pos_cd', name: 'pos_cd', visible:false },
                { data: 'pos_nm', name: 'pos.pos_nm', visible:true },
                { data: 'item_nm', name: 'master.item_nm' },
                { data: 'unit_nm', name: 'unit.unit_nm' },
                { data: "quantity", name : "quantity", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ), className: "text-right" },
            ],
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#item_nm_table').search($(this).val()).draw();
        });

        $(document).on('change', '#pos_cd_param',function(){ 
            //tabelData.column('#pos_cd_table').search($(this).val()).draw();
			
			if (CheckUnit()) {
				tabelData.column('#pos_cd_table').search($(this).val()).draw();
			} else {
				tabelData.column('#pos_cd_table').search(unitCd).draw();
			}
        });

        $('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');
			tabelData.ajax.reload();
		});

        $('#submit-button').click(function(){
            $('#form-isian').submit();
        });

        /* transaksi */
        $('#transaksi-inventori').click(function() {
            if (dataCd == null) {
                swal({
                    title: "Pilih Data!",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1000
                });
            }else{
                swal({title: "Mengambil Data",showConfirmButton: false,showCancelButton: false,onOpen: () => {swal.showLoading();}});

                saveMethod  = 'ubah';

                reset('modal');

                $('.modal-title').text('{{ $title }}');  

                var urlUpdate='{{ url("/inventori/mutasi-inventori/stock-in") }}'+'/'+dataCd;

                $.getJSON( urlUpdate, function(data){
                    if (data['status'] == 'ok') {
                        oldStock = parseFloat(data['data']['quantity']);
                        unitNm = data['data']['unit_nm'];

                        $('input[name=item_nm]').val(data['data']['item_nm']);
                        $('select[name=pos_cd]').val(data['data']['pos_cd']).trigger('change');
                        $("select[name=pos_cd]").prop("disabled", true);
                        $('input[name=stock_inventori]').val(data['data']['quantity']+' '+data['data']['unit_nm']);
                        $('input[name=new_stock]').val(data['data']['quantity']+' '+data['data']['unit_nm']);
                        $('#modal-stock').modal('show');

                        swal.close();
                    }else{
                        swal({title: "Data Tidak Ditemukan",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                    }
                });
            }
        });

        $('input[name=jumlah_trx]').keyup(function() {
            var jumTrx      = parseFloat($('input[name=jumlah_trx]').val());
            var newStock    = jumTrx + oldStock;

            $('input[name=new_stock]').val(newStock+' '+unitNm);
        });

        /* submit form */
        $('#form-isian').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();

                var record  = $('#form-isian').serialize();
                var url     = baseUrl+'/'+dataCd;
                var method  = 'PUT';

                swal({
                    title               : 'Simpan Data?',
                    type                : "question",
                    showCancelButton    : true,
                    confirmButtonColor  : "#00a65a",
                    confirmButtonText   : "Ya",
                    cancelButtonText    : "Tidak",
                    allowOutsideClick : false,
                }).then(function(result){
                    if(result.value){
                        swal({allowOutsideClick : false,title: "Menyimpan Data",showConfirmButton: true,onOpen: () => {swal.showLoading();}});

                        $.ajax({
                            'type': method,
                            'url' : url,
                            'data': record,
                            'dataType': 'JSON',
                            'success': function(response){
                                if(response["status"] == 'ok') {     
                                    swal({
                                        title: "Berhasil",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then(() => {
                                        reset('');
                                        swal.close();
                                    });
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
                    }
                });
            }
        });
		
		init();
    });

    function reset(){
        $('input[name=new_stock]').val(0);
        $('input[name=jumlah_trx]').val(1);
        $('input[name=expire_date]').val('');
        tabelData.ajax.reload();
        $('#modal-stock').modal('hide');
    }

    function validateForm(){
        if(parseFloat($('input[name=jumlah_trx]').val()) <= 0){
            swal({
                title: "Jumlah Tidak Valid!",
                type: "error",
                showCancelButton: false,
                showConfirmButton: false,
                timer: 1000
            });

            return false;
        }
    }
	
	function init() {
		if (unitCd != '') {
			$('select[name=pos_cd_param]').val(unitCd).trigger('change');
		} else {
			$('select[name=pos_cd_param]').val("{{ configuration('WHPOS_TRX') }}").trigger('change');
		}
	}
	
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
</script>
@endpush