@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-xl-12">
            <div class="card" style="zoom: 1;">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">{{ $title }}</h5>
                </div>
				<div class="card-body">
					<!--Frame Tabel-->
					<div id="frame-tabel">
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-8">
                                <div class="form-group form-group-float">
                                    <!--<label class="form-group-float-label is-visible">Nama User</label>-->
                                    <input name="search_param" id="search_param" placeholder="Pencarian Nama" class="form-control" data-fouc />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group form-group-float">
                                    <!--<label class="form-group-float-label is-visible">Jenis User</label>-->
                                    <select name="role_cd_param" id="role_cd_param" data-placeholder="Pencarian Jenis User" class="form-control form-control-select2 select-search" required data-fouc>
                                        <option value=""></option>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->role_cd}}">{{ $item->role_nm}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i> Tambah</button>
                        <div class="table-responsive">
                            <table class="table datatable-pagination" id="tabel-data">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th id="user_nm_table">Nama User</th>
                                        <th id="role_cd_table">role_cd_table</th>
                                        <th>Jenis User</th>
                                        <th>Email</th>
                                        <th>Login Terakhir</th>
                                        <th class="text-center" width="20%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
					<!--Frame Form-->
                    <div id="frame-form">
                        <form class="form-validate-jquery" id="form-data" action="#">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">User ID <span class="text-danger">*</span></label>
                                        <input type="text" name="user_id" class="form-control" id="user_id" required placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Nama User <span class="text-danger">*</span></label>
                                        <input type="text" name="user_nm" class="form-control" required="" placeholder="" aria-invalid="false">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" id="email" required placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="password" class="form-control" required placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Verifikasi Password <span class="text-danger">*</span></label>
                                        <input type="password" name="repeat_password" class="form-control" required placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Jenis User <span class="text-danger">*</span></label>
                                        <select name="role_cd" id="role_cd" data-placeholder="Pilih Autorisasi" class="form-control form-control-select2 select-search" required data-fouc>
                                            <option value=""> === Pilih Data === </option>
                                            @foreach ($roles as $item)
                                                <option value="{{ $item->role_cd }}">{{ $item->role_nm }}</option>   
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
								<div id="input-01"><!--Input Advanced-->
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Company</label>
                                        <select name="comp_cd" id="comp_cd" data-placeholder="Pilih Perusahaan" class="form-control form-control-select2 select-search" data-fouc>
                                            <option value=""> === Pilih Data === </option>
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->comp_cd }}">{{ $item->comp_nm }}</option>   
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
								<script type='text/javascript'>
								$(document).ready(function(){
									$("#input-01").hide();
								});
								</script>
								</div><!--Input Advanced-->
								<div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Unit</label>
                                        <select name="unit_cd" id="unit_cd" data-placeholder="Pilih Unit" class="form-control form-control-select2 select-search" data-fouc>
                                            <option value=""> === Pilih Data === </option>
                                            @foreach ($unit as $item)
                                                <option value="{{ $item->unit_cd }}">{{ $item->unit_nm }}</option>   
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group pt-2">
                                        <label class="font-weight-semibold">Hak Akses</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input-styled" data-fouc name="create" checked value="C">
                                                Create
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input-styled" data-fouc name="read" checked value="R">
                                                Read
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input-styled" data-fouc name="update" checked value="U">
                                                Update
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input-styled" data-fouc name="delete" checked value="D">
                                                Delete
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
							<div class="d-flex justify-content-end align-items-center">
								<button type="submit" class="btn btn-primary legitRipple">Simpan <i class="icon-floppy-disk ml-2"></i></button>
								<button type="reset" class="btn btn-light ml-2 legitRipple" id="reset">Selesai <i class="icon-reload-alt ml-2"></i></button>
							</div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
	</div>
@endsection
@push('scripts')
<script>
    var tabelData;
	var baseUrl = '{{ url("sistem/admin/user/") }}';

    $(document).ready(function(){
        $('#frame-form').hide();  

        tabelData = $('#tabel-data').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
            },
            processing	: true, 
            serverSide	: true, 
            order		: [], 
            ajax		: {
				url: baseUrl + '/data',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
            },
            dom : 'tpi',
            columns: [
                { data: 'user_id', name: 'users.user_id', visible:true },
                { data: 'user_nm', name: 'user_nm' },
                { data: 'role_cd', name: 'roles.role_cd', visible:false  },
                { data: 'role_nm', name: 'role_nm' },
                { data: 'email', name: 'email' },
                { data: 'last_login', name: 'last_login' },
                { data: 'actions', name: 'actions' }
            ],
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#user_nm_table').search($(this).val()).draw();
        });

        $(document).on('change', '#role_cd_param',function(){ 
            tabelData.column('#role_cd_table').search($(this).val()).draw();
        });

        //--Tambah data
        $('#tambah').click(function()   {
            saveMethod  ='tambah';

            $('input[name=user_nm]').focus();
            $('#frame-tabel').hide();      
            $('#frame-form').show(); 
            $('.card-title').text('Tambah Data');       
        });

        //--Reset form
        $('#reset').click(function()   {
            saveMethod  ='';

            tabelData.ajax.reload();
            $('#frame-tabel').show();      
            $('#frame-form').hide(); 
            $('.card-title').text('Data User');       
        });

        //--Profil
        $(document).on('click', '#profil',function(){ 
            var rowData=tabelData.row($(this).parents('tr')).data();
            dataCd = rowData['user_id'];
			
			window.location = baseUrl + '/profil/' + dataCd;
        });

        //--Submit form
        $('#form-data').submit(function(e){
            if (e.isDefaultPrevented()) {
            //--Handle the invalid form
            } else {
                e.preventDefault();
                var record=$('#form-data').serialize();
				var url     = baseUrl;
                var method  = 'POST';

                swal({
                    title               : 'Simpan data?',
                    type                : "question",
                    showCancelButton    : true,
                    confirmButtonColor  : "#00a65a",
                    confirmButtonText   : "OK",
                    cancelButtonText    : "NO",
                    allowOutsideClick : false,
                }).then(function(result){
                    if(result.value){
                        swal({allowOutsideClick : false,title: "Proses simpan",onOpen: () => {swal.showLoading();}});

                        $.ajax({
                            'type': method,
                            'url' : url,
                            'data': record,
                            'dataType': 'JSON',
                            'success': function(response){
                                if(response["status"] == 'ok') {     
                                    swal({
                                        title: "Proses berhasil",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then(() => {
                                        $('#reset').click();
                                        swal.close();
                                    });
                                }else{
                                    swal({title: "Proses gagal",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                }
                            },
                            'error': function(response){ 
                                var errorText = '';
                                $.each(response.responseJSON.errors, function(key, value) {
                                    errorText += value+'<br>'
                                });

                                swal({
                                    title             : response.status.toString(),
                                    type              : "error",
                                    html              : errorText, 
                                    showCancelButton  : false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText : "OK",
                                    cancelButtonText  : "NO",
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
		
		//--Hapus data
        $(document).on('click', '#hapus',function(){ 
            var rowData=tabelData.row($(this).parents('tr')).data();
            dataCd = rowData['user_id'];
            
            swal({
                title             : "Hapus data?",
                type              : "question",
                showCancelButton  : true,
                confirmButtonColor: "#00a65a",
                confirmButtonText : "OK",
                cancelButtonText  : "NO",
                allowOutsideClick : false,
            }).then(function(result){
                if(result.value){
                    swal({allowOutsideClick : false, title: "Proses hapus",onOpen: () => {swal.showLoading();}});
                    
                    $.ajax({
						url: baseUrl + '/' + dataCd,
                        type: "DELETE",
                        dataType: "JSON",
                        data: {
                            '_token': $('input[name=_token]').val(),
                        },
                        success: function(response)
                        {
                            if (response.status == 'ok') {
                                swal({
                                    title: "Proses berhasil",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    tabelData.ajax.reload();
                                    swal.close();
                                });
                            }else{
                                swal({title: "Proses gagal",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            swal({title: "Terjadi kesalahan sistem !", text:"Silakan hubungi Administrator", type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                        }
                    })
                }else {
                    swal.close();
                }
            });
        });
    });
</script>
@endpush