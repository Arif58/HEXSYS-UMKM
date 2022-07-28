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
            <div id="bagian-tabel">
                <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i> Tambah</button>
                <div class="row" style="margin-form:10px">
                    <div class="col-md-4">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Pencarian Nama</label>
                            <input name="search_param" id="search_param" placeholder="Pencarian Berdasarkan Nama" class="form-control" data-fouc />
                        </div>
                    </div>
					<div class="col-md-4">
						<div class="form-group form-group-float">
							<label class="form-group-float-label is-visible">Jenis Kegiatan </label>
							<select name="aktivitas_tp_param" id="aktivitas_tp_param" class="form-control form-control-select2 select-search" data-fouc>
								{!! comCodeOptions('AKTIVITAS_TP') !!}
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group form-group-float">
							<label class="form-group-float-label is-visible">Standar </label>
							<select name="standar_tp_param" id="standar_tp_param" class="form-control form-control-select2 select-search" data-fouc>
								{!! comCodeOptions('STANDAR_TP') !!}
							</select>
						</div>
					</div>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-pagination" id="tabel-data" width="100%">
                        <thead>
                            <tr>
                                <th id="aktivitas_cd_table">Kode Kegiatan</th>
                                <th id="aktivitas_nm_table">Nama Kegiatan</th>
                                <th id="aktivitas_tp_table">aktivitas_tp</th>
								<th id="aktivitas_tp_nm_table">RENSTRA</th>
								<th id="standar_tp_table">standar_tp</th>
								<th id="standar_tp_nm_table">Standar</th>
								<th id="node_table">Deskripsi</th>
                                <th id="actions_table" width="20%">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="bagian-form">
                <form class="form-validate-jquery" id="form-isian" action="#">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Kode Kegiatan <span class="text-danger">*</span></label>
                                <input type="text" name="aktivitas_cd" class="form-control" required="" placeholder="" aria-invalid="false" maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Nama Kegiatan <span class="text-danger">*</span></label>
                                <input type="text" name="aktivitas_nm" class="form-control" required="" placeholder="" aria-invalid="false" maxlength="200">
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">RENSTRA<span class="text-danger">*</span></label>
                                <select name="aktivitas_tp" class="form-control form-control-select2 select-search" required data-fouc>
                                    {!! comCodeOptions('AKTIVITAS_TP') !!}
                                </select>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Standar</label>
                                <select name="standar_tp" class="form-control form-control-select2 select-search" data-fouc>
                                    {!! comCodeOptions('STANDAR_TP') !!}
                                </select>
                            </div>
                        </div>
					</div>
					<div class="row">
						<div class="col-md-12">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Deskripsi Kegiatan </label>
                                <input type="text" name="note" class="form-control" placeholder="" aria-invalid="false" maxlength="500">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="reset" class="btn btn-light legitRipple" id="reset">Reset <i class="icon-reload-alt ml-2"></i></button>
                        <button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan <i class="icon-floppy-disks ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    var tabelData;
    var saveMethod = 'tambah';
    var baseUrl = "{{ url('sistem/erp/aktivitas') }}";
    
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
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
            },
			lengthMenu		: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
			info 			: false, /*--Showing 1 to XX of YY entries--*/
			dom 			: 'Blrtip',
            columns: [
                { data: 'aktivitas_cd', name: 'aktivitas_cd', visible:true},
                { data: 'aktivitas_nm', name: 'aktivitas_nm', visible:true},
                { data: 'aktivitas_tp', name: 'aktivitas_tp', visible:false},
                { data: 'aktivitas_tp_nm', name: 'aktivitastp.code_nm', visible:true},
				{ data: 'standar_tp', name: 'standar_tp', visible:false},
                { data: 'standar_tp_nm', name: 'standartp.code_nm', visible:true},
				{ data: 'note', name: 'note', visible:true},
                { data: 'actions', name: 'actions', orderable:false },
            ],
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#aktivitas_nm_table').search($(this).val()).draw();
        });
		$(document).on('change', '#aktivitas_tp_param',function(){ 
            tabelData.column('#aktivitas_tp_table').search($(this).val()).draw();
        });
		$(document).on('change', '#standar_tp_param',function(){ 
            tabelData.column('#standar_tp_table').search($(this).val()).draw();
        });

        $('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');
			$('select[name=aktivitas_tp_param]').val('').trigger('change');
			$('select[name=standar_tp_param]').val('').trigger('change');

			tabelData.ajax.reload();
		});

        /* tambah data */
        $('#tambah').click(function()   {
            saveMethod  ='tambah';

            $('input[name=aktivitas_nm]').focus();
			$('select[name=aktivitas_tp]').val('').trigger('change');  
            $('#bagian-tabel').hide();      
            $('#bagian-form').show(); 
            $('.card-title').text('Tambah Data');       
        });

        /* tambah data */
        $('#reset').click(function()   {
            reset('');
        });
        
        /* submit form */
        $('#form-isian').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();

                var record  = $('#form-isian').serialize();
                if(saveMethod == 'tambah'){
                    var url     = baseUrl;
                    var method  = 'POST';
                }else{
                    var url     = baseUrl+'/'+dataCd;
                    var method  = 'PUT';
                }

                swal({
                    title               : 'Simpan Data?',
                    type                : "question",
                    showCancelButton    : true,
                    confirmButtonColor  : "#00a65a",
                    confirmButtonText   : "Ya",
                    cancelButtonText    : "Batalkan",
                    allowOutsideClick : false,
                }).then(function(result){
                    if(result.value){
                        swal({allowOutsideClick : false,title: "Menyimpan Data",onOpen: () => {swal.showLoading();}});

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
                                    confirmButtonText : "Mengerti",
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

        /* ubah data */
        $(document).on('click', '.ubah',function(){ 
            saveMethod  ='ubah';
            var rowData = tabelData.row($(this).parents('tr')).data();
            dataCd      = rowData.aktivitas_cd;
            
            $('input[name=aktivitas_cd]').val(rowData['aktivitas_cd']).prop('readonly',true);
            $('input[name=aktivitas_nm]').val(rowData.aktivitas_nm);
            $('input[name=note]').val(rowData.note);
			$('select[name=aktivitas_tp]').val(rowData["aktivitas_tp"]).trigger('change');
			$('select[name=standar_tp]').val(rowData["standar_tp"]).trigger('change');
			
			/* $('#aktivitas_tp').empty();
            $('#aktivitas_tp').select2({
                data:[{"id": rowData["aktivitas_tp"] ,"text":rowData["aktivitas_tp_nm"] }] ,
                ajax : {
                    url :  baseUrl+"/data/list",
                    dataType: 'json', 
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                    cache : true,
                },
            }); */

            $('#bagian-tabel').hide();      
            $('#bagian-form').show(); 
        });

        /* hapus data */
        $(document).on('click', '.hapus',function(){ 
            var rowData=tabelData.row($(this).parents('tr')).data();
            dataCd = rowData.aktivitas_cd;
            
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
                                    tabelData.ajax.reload();
                                    swal.close();
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

         /*cek kode*/
         $('input[name=aktivitas_cd]').focusout(function(){
            var id          = $(this).val();
            var urlUpdate   = baseUrl+'/'+id;

            if ($(this).val() && saveMethod === 'tambah') {
                $.getJSON( urlUpdate, function(response){
                    if (response.data) {
                        swal({
                            title: "Peringatan!",
                            text: "Kode Sudah Digunakan!",
                            type: "warning",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            $('input[name=aktivitas_cd]').val('');
                            $('input[name=aktivitas_cd]').focus();
                            swal.close();
                        });
                    }
                });
            }
        });
    });

    function reset(params) {
        saveMethod  ='tambah';

        tabelData.ajax.reload();
        $('#bagian-tabel').show();      
        $('#bagian-form').hide(); 
        $('.card-title').text('{{ $title }}');       
        $('input[name=aktivitas_cd]').val('').prop('readonly',false);
        $('input[name=aktivitas_nm]').val('');
        $('input[name=note]').val('');
		$('select[name=aktivitas_tp]').val('').trigger('change');
		$('select[name=standar_tp]').val('').trigger('change');
    }
</script>
@endpush