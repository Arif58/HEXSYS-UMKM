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
                    <div class="col-md-12">
                        <div class="form-group form-group-float">
                            <!--<label class="form-group-float-label is-visible">Form</label>-->
                            <input name="search_param" id="search_param" placeholder="Pencarian Berdasarkan Nama" class="form-control" data-fouc />
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-pagination" id="tabel-data" width="100%">
                        <thead>
                            <tr>
                                <th id="form_cd_table">Kode</th>
                                <th id="form_nm_table">Form</th>
                                <th id="comp_cd_table">Perusahaan</th>
                                <th id="form_file_table">File</th>
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
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Kode Form <span class="text-danger">*</span></label>
                                <input type="text" name="form_cd" class="form-control" required="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Nama Form <span class="text-danger">*</span></label>
                                <input type="text" name="form_nm" class="form-control" required="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">form_file</label>
                                <input type="text" name="form_file" class="form-control" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                    </div> --}}
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
    var baseUrl = "{{ url('sistem/erp/form') }}";
    
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
			//dom 			: 'Blrtip',
            columns: [
                { data: 'form_cd', name: 'form_cd', visible:true},
                { data: 'form_nm', name: 'form_nm', visible:true},
                { data: 'comp_cd', name: 'comp_cd', visible:false},
                { data: 'form_file', name: 'form_file', visible:false},
                { data: 'actions', name: 'actions', orderable:false },
            ],
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#form_nm_table').search($(this).val()).draw();
        });

        $('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');

			tabelData.ajax.reload();
		});

        /* tambah data */
        $('#tambah').click(function()   {
            saveMethod  ='tambah';

            $('input[name=form_nm]').focus();
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
            dataCd      = rowData.form_cd;
            
            $('input[name=form_cd]').val(rowData.form_cd);
            $('input[name=form_nm]').val(rowData.form_nm);
            $('input[name=form_file]').val(rowData.form_file);

            $('#bagian-tabel').hide();      
            $('#bagian-form').show(); 
        });

        /* hapus data */
        $(document).on('click', '.hapus',function(){ 
            var rowData=tabelData.row($(this).parents('tr')).data();
            dataCd = rowData.form_cd;
            
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
         $('input[name=form_cd]').focusout(function(){
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
                            $('input[name=form_cd]').val('');
                            $('input[name=form_cd]').focus();
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
        $('input[name=form_cd]').val('');
        $('input[name=form_nm]').val('');
        $('input[name=form_file]').val('');
    }
</script>
@endpush