@extends('layouts.app')

@section('content')
    <!-- Inner container -->
    <div class="d-md-flex align-items-md-start">

        <!-- Left sidebar component -->
        <div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left wmin-300 border-0 shadow-0 sidebar-expand-md">

            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- Navigation -->
                <div class="card">
                    <div class="card-body bg-indigo-400 text-center card-img-top" style="background-image: url(/global_assets/images/backgrounds/panel_bg.png); background-size: contain;">
                        <div class="card-img-actions d-inline-block mb-3">
                            @if ($dataUser->image == NULL)                                     
                                <img class="img-fluid rounded-circle" src="{{ asset('/global_assets/images/placeholders/placeholder.jpg') }}" width="170" height="170" alt="">
                            @else
                                <!--<img class="img-fluid rounded-circle" src="{{ url($dataUser->image) }}" width="170" height="170" style="background: #fff" alt="">-->
								<img class="img-fluid rounded-circle" src="{{ asset('/storage/file/image/') }}/{{ $dataUser->image }}" width="170" height="170" style="background: #fff" alt="">
                            @endif
                        </div>

                        <h6 class="font-weight-semibold mb-0">{{ $dataUser->user_nm }}</h6>
                        <span class="d-block opacity-75">{{ $dataUser->role_nm }}</span>

                        <div class="list-icons list-icons-extended mt-3">
                            <a href="/sistem/admin/user" class="list-icons-item text-white" data-popup="tooltip" title="" data-container="body" data-original-title="Kembali ke Daftar User"><i class="icon-undo2"></i></a>
                            <a href="#" id="hapus" class="list-icons-item text-white" data-popup="tooltip" title="" data-container="body" data-original-title="Hapus User"><i class="icon-trash"></i></a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <ul class="nav nav-sidebar mb-2" id="tab-menu">
                            <li class="nav-item-header"></li>
                            <li class="nav-item">
                                <a href="#profile" class="nav-link active" data-toggle="tab">
                                    <i class="fa fa-building"></i>
                                     Profil User
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#data-foto" class="nav-link" data-toggle="tab">
                                    <i class="fa fa-image"></i>
                                    Foto Profil User
                                    <!--<span class="font-size-sm font-weight-normal opacity-75 ml-auto"></span>-->
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#data-password" class="nav-link" data-toggle="tab">
                                    <i class="fa fa-key"></i>
                                    Ubah Password
                                    <!--<span class="badge bg-danger badge-pill ml-auto"></span>-->
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /navigation -->

            </div>
            <!-- /sidebar content -->

        </div>
        <!-- /left sidebar component -->


        <!-- Right content -->
        <div class="tab-content w-100 overflow-auto">
            <div class="tab-pane fade active show" id="profile">
                <!-- Profil User -->
                <div class="card">
                    <div class="card-header header-elements-sm-inline">
                        <h6 class="card-title">Profil User</h6>
                    </div>

                    <div class="card-body">
                        <form class="form-validate-jquery" id="form-isian" action="#">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Nama User</label>
                                        <input type="text" name="user_nm" class="form-control" required="" placeholder="" aria-invalid="false" value="{{ $dataUser->user_nm }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Email</label>
                                        <input type="text" name="email" class="form-control" id="email" placeholder="" value="{{ $dataUser->email }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Jenis User</label>
                                        <select name="role_cd" data-placeholder="Pilih Autorisasi" class="form-control form-control-select2 select-search" required data-fouc>
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
                                        <select name="comp_cd" data-placeholder="Pilih Perusahaan" class="form-control form-control-select2 select-search" data-fouc>
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
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary legitRipple">Simpan <i class="icon-floppy-disks ml-2"></i></button>
								<button type="reset" class="btn btn-light ml-2 legitRipple" id="reset">Reset <i class="icon-reload-alt ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /profil perusahaan -->
            </div>

            <div class="tab-pane fade" id="data-foto">
                <!-- change company image -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Foto Profil User</h6>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-warning"> 
                            <i class="fa fa-exclamation-triangle"></i> 
                            Ukuran file maksimal 2 MB
                        </div>
                        <div class="row" id="img-cropper">
                            <div class="col-md-12 p-20">
                                <div class="img-container" style="display:none" id="img-container">
                                    <img id="image" src="" class="img-responsive" alt="Picture">
                                </div>
                                <label class="data-url"></label>
                            </div>
                        </div>
                        <div class="btn-group btn-group-justified">
                            <button type="button" id="image-select" class="btn bg-slate-700 legitRipple"><i class="fa fa-image">Pilih Foto</i></button>
                            <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*" style="display:none">
                            <button type="button" id="image-save" class="btn bg-slate-700 legitRipple"><i class="fa fa-floppy-o">Simpan Foto</i></button>
                            <button type="button" id="reset-cropper" class="btn bg-slate-700 legitRipple"><i class="fa fa-refresh">Reset</i></button>
                        </div><br>
                        <div class="btn-group btn-group-justified">
                            <button type="button" id="image-delete" class="btn bg-slate-700 legitRipple"><i class="fa fa-trash-o">Hapus Foto</i></button>
                            <button type="button" id="image-cancel" class="btn bg-slate-700 legitRipple"><i class="fa fa-remove">Selesai</i></button>
                        </div>
                    </div>
                </div>
                <!-- /change company image -->
            </div>

            <div class="tab-pane fade" id="data-password">
                <!-- Account settings -->
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Ubah Password</h5>
                    </div>

                    <div class="card-body">
                        <form action="#" id="form-password">
							<input type="hidden" name="user_id" value="{{ $dataUser->user_id }}">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Password Lama </label>
                                        <input type="password" name="old_password" value="password" readonly="readonly" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Password Baru <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="password" class="form-control" required placeholder="Password">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Konfirmasi Passsword <span class="text-danger">*</span></label>
                                        <input type="password" name="repeat_password" class="form-control" required placeholder="Konfirmasi Password">
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary legitRipple">Simpan <i class="icon-floppy-disks ml-2"></i></button>
								<button type="reset" class="btn btn-light ml-2 legitRipple" id="reset-password">Reset <i class="icon-reload-alt ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /account settings -->
            </div>
        </div>
        <!-- /right content -->

    </div>
    <!-- /inner container -->

@endsection
@push('scripts')
<script src="/global_assets/js/plugins/media/cropper.min.js"></script>
<script>
    var dataCd = "{{ $dataUser->user_id }}";
    var base64Image = '';
    var baseUrl = "{{url('sistem/admin/user/profil/')}}";

    $(function () {

        'use strict';

        var console = window.console || { log: function () {} };
        var $image = $('#image');
        var options = {
            aspectRatio: 200/200,
            preview: '.img-preview',
            crop: function (e) {
                base64Image = $image.cropper('getCroppedCanvas').toDataURL(0.5)
            }
        };

        //--Cropper
        $image.cropper(options);

        $('#reset-cropper').click(function(){
            $image.cropper("reset");  
        });

        $('#image-select').click(function(){
            $('#inputImage').click();  
        });

        //--Import image
        var $inputImage = $('#inputImage');
        var URL = window.URL || window.webkitURL;
        var blobURL;

        if (URL) {
            $inputImage.change(function () {
                var files = this.files;
                var file;

                if (!$image.data('cropper')) {
                    return;
                }

                if (files && files.length) {
                    file = files[0];

                    if(file.size < 1000000){
                        if (/^image\/\w+$/.test(file.type)) {
                            blobURL = URL.createObjectURL(file);
                            
                            $image.one('built.cropper', function () {

                                //--Revoke when load complete
                                URL.revokeObjectURL(blobURL);
                            }).cropper('reset').cropper('replace', blobURL);
                            
                            $inputImage.val('');
                            $('#img-container').show();
                        } else {
                            swal({
                                title: "Silakan pilih foto",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: false,
                                timer: 1000
                            }).then(() => {
                                swal.close()
                            });
                        }
                    }else{
                        swal({
                            title: "Ukuran foto terlalu besar (max 1 MB)",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            $inputImage.val('');
                            swal.close()
                        });
                    }

                }
            });
        } else {
            $inputImage.prop('disabled', true).parent().addClass('disabled');
        }

        //--Simpan foto
        $('#image-save').click(function(){
            if(base64Image == ''){
                swal({
                    title: "Silakan pilih foto",
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1000
                }).then(() => {
                    swal.close()
                });
                return false;
            }

            swal({
                title               : 'Upload foto ?',
                type                : "question",
                showCancelButton    : true,
                confirmButtonColor  : "#00a65a",
                confirmButtonText   : "OK",
                cancelButtonText    : "NO",
            }).then(function(result){
                if(result.value){
                    swal({title: "Proses simpan",onOpen: () => {swal.showLoading();}});

                    $.ajax({
                        url          : baseUrl + '/image/' + dataCd,
                        type         : "PUT", 
                        data         :{"image" : base64Image, '_token': $('input[name=_token]').val()},
                        dataType     : 'JSON',
                        success   : function(response){
                            if(response.status == 'ok') {     
                                swal({
                                    title: "Proses berhasil",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    swal.close();
                                    window.location = baseUrl + '/' + dataCd;
                                });
                            }else{
                                swal({title: "Proses gagal",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                            }
                        },
                        error: function(response){ 
                            var errorText = '';
                            console.log(response)
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
        });

        $('#image-delete').click(function(){
            swal({
                title             : "Hapus foto ?",
                type              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#00a65a",
                confirmButtonText : "OK",
                cancelButtonText  : "NO",
            }).then(function(result){
                if(result.value){
                    swal({title: "Proses hapus",onOpen: () => {swal.showLoading();}});
                    $.ajax({
                        url       : baseUrl + '/image/' + dataCd,
                        type      : "PUT", 
                        data      :{"image" : base64Image, '_token': $('input[name=_token]').val()},
                        dataType  : "JSON",
                        success   : function(response){
                            if(response.status == 'ok') {     
                                swal({
                                    title: "Proses berhasil",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    swal.close();
                                    window.location = baseUrl + '/' + dataCd;
                                });
                            }else{
                                swal({title: "Proses gagal",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                            }
                        },
                        error: function(response){ 
                            var errorText = '';
                            console.log(response)
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
                                cancelButtonText  : "NO",
                            }).then(function(result){
                                if(result.value){   	
                                    reset('ubah');
                                }
                            });
                        }
                    })
                }else {
                    swal.close();
                }
            });
        });

        $('#image-cancel').click(function(){
            swal({
                title             : "Batal upload foto ?",
                type              : "question",
                showCancelButton  : true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText : "OK",
                cancelButtonText  : "NO",
            }).then(function(result){
                if(result.value){   
                    $('.nav-sidebar a[href="#profile"]').tab('show');
                }
            });
        });

    });

    $(document).ready(function(){
        $('select[name=role_cd]').val("{{ $dataUser->role_cd }}").trigger('change');
        $('select[name=comp_cd]').val("{{ $dataUser->comp_cd }}").trigger('change');
		$('select[name=unit_cd]').val("{{ $dataUser->unit_cd }}").trigger('change');
        
        //--Submit form
        $('#form-isian').submit(function(e){
            if (e.isDefaultPrevented()) {
            //--Handle the invalid form
            } else {
                e.preventDefault();
                var record=$('#form-isian').serialize();
                var url     = '{{ url("/sistem/admin/user/") }}' + '/{{ $dataUser->user_id }}';
                var method  = 'PUT';

                swal({
                    title               : 'Simpan data ?',
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
                                        init();
                                        swal.close();
                                        location.reload();
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
                                    title             : response.status+':'+response.responseJSON.message,
                                    type              : "error",
                                    html              : errorText, 
                                    showCancelButton  : false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText : "OK",
                                    cancelButtonText  : "NO",
                                }).then(function(result){
                                    if(result.value){   	
                                        swal.close();
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
            swal({
                title             : "Hapus data ?",
                type              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#00a65a",
                confirmButtonText : "OK",
                cancelButtonText  : "NO",
                allowOutsideClick : false,
            }).then(function(result){
                if(result.value){
                    swal({allowOutsideClick : false, title: "Proses hapus",onOpen: () => {swal.showLoading();}});
                    
                    $.ajax({
                        url : '{{ url("/sistem/admin/user/") }}' + '/' + dataCd,
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
                                    //tabelData.ajax.reload();
									window.location = '/sistem/admin/user';
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

        //--Password
        $('#form-password').submit(function(e){
            if (e.isDefaultPrevented()) {
            //--Handle the invalid form
            } else {
                e.preventDefault();
                var record = $('#form-password').serialize();
                var url     = '{{ url("/sistem/admin/user/password/") }}';
                var method  = 'POST';

                swal({
                    title               : 'Simpan data ?',
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
                                        init();
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
                                    title             : response.status+':'+response.responseJSON.message,
                                    type              : "error",
                                    html              : errorText, 
                                    showCancelButton  : false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText : "OK",
                                    cancelButtonText  : "NO",
                                }).then(function(result){
                                    if(result.value){   	
                                        swal.close();
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

    function init(){
        var urlUpdate='{{ url("/sistem/admin/user/".$dataUser->user_id) }}';

        $.getJSON( urlUpdate, function(data){
            if (data['status'] == 'ok') {
                $.each(data['data'], function (index, data) {
                    $('input[name='+index+']').val(data);
                    $('textarea[name='+index+']').val(data);
                });

                $('#tab-menu a[href="#profile"]').tab('show');
            }
        });
    }
</script>
@endpush