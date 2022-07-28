@extends('layouts.app')

@section('content')
    <div class="row">
		<div class="col-xl-12">
            <div class="card" style="zoom: 1;">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Data Perusahaan</h5>
                </div>

                <div class="card-body">
                    <div id="bagian-tabel">
						<!--
                        <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i> Tambah</button>
                        <a href="{{url('sistem/admin/company')}}" class="btn btn-primary ml-3 legitRipple" title="index"><i class='icon icon-undo'></i></a>
                        <a href="{{url('sistem/admin/company').'/'.$root}}" class="btn btn-primary ml-3 legitRipple" title="previous"><i class='icon icon-undo2'></i></a>
                        <div class="row" style="margin-top:10px">
                            <div class="col-md-12">
                                <div class="form-group form-group-float">
                                    <label class="form-group-float-label is-visible">Nama Perusahaan</label>
                                    <input name="search_param" id="search_param" placeholder="Pencarian Perusahaan" class="form-control" data-fouc />
                                </div>
                            </div>
                        </div>
						-->
                        <div class="table-responsive">
                            <table class="table datatable-pagination" id="tabel-data">
                                <thead>
                                    <tr>
                                        <th>Kode {{$type}}</th>
                                        <th id="comp_nm_table">Nama {{$type}}</th>
                                        <th id="address_table">address_table</th>
                                        <th id="postcode_table">postcode_table</th>
                                        <th id="region_prop">region_prop</th>
                                        <th id="region_kab">region_kab</th>
                                        <th id="region_kec">region_kec</th>
                                        <th id="region_kel">region_kel</th>
                                        <th id="phone">phone</th>
                                        <th id="mobile">mobile</th>
                                        <th id="email">email</th>
                                        <th id="fax">fax</th>
                                        <th class="text-center" width="20%">#</th>
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
                            <input type="hidden" name="comp_root" value="{{$id}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Kode {{$type}} <span class="text-danger">*</span></label>
                                        <input type="text" name="comp_cd" class="form-control" id="comp_cd" required placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Nama {{$type}} <span class="text-danger">*</span></label>
                                        <input type="text" name="comp_nm" class="form-control" required="" placeholder="" aria-invalid="false">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Alamat <span class="text-danger">*</span></label>
                                        <textarea name="address" cols="10" rows="3" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Kode Pos</label>
                                        <input type="text" name="postcode" class="form-control" placeholder="" aria-invalid="false">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Provinsi</label>
                                        <select name="region_prop" id="region_prop" data-placeholder="Pilih Provinsi" class="form-control form-control-select2 select-search" data-fouc></select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Kabupaten</label>
                                        <select name="region_kab" id="region_kab" data-placeholder="Pilih Kabupaten" class="form-control form-control-select2 select-search" data-fouc></select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Kecamatan</label>
                                        <select name="region_kec" id="region_kec" data-placeholder="Pilih Kecamatan" class="form-control form-control-select2 select-search" data-fouc></select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Kelurahan</label>
                                        <select name="region_kel" id="region_kel" data-placeholder="Pilih Kelurahan" class="form-control form-control-select2 select-search" data-fouc></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Phone </label>
                                        <input type="text" name="phone" class="form-control" placeholder="" aria-invalid="false">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Mobile </label>
                                        <input type="text" name="mobile" class="form-control" placeholder="" aria-invalid="false">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Fax </label>
                                        <input type="text" name="fax" class="form-control" placeholder="" aria-invalid="false">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-float">
                                        <label class="form-group-float-label is-visible">Email</label>
                                        <input type="email" name="email" class="form-control"  placeholder="" aria-invalid="false">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="reset" class="btn btn-light legitRipple" id="reset">Kembali <i class="icon-reload-alt ml-2"></i></button>
                                <button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan <i class="icon-paperplane ml-2"></i></button>
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
	    var baseUrl = '{{ url("sistem/admin/company") }}';
        var saveMethod = 'tambah';

        $(document).ready(function(){
            //pre-usage + misc + tabel
            $('#bagian-form').hide();  

            $('#reset').click(function(){
                reset();
            });
            
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
                        'root'  : '{{$id}}',
                    },
                },
                dom : 'tpi',
                columns: [
                    { data: 'comp_cd', name: 'comp_cd', visible:true },
                    { data: 'comp_nm', name: 'comp_nm' },
                    { data: 'address', name: 'address', visible:false },
                    { data: 'postcode', name: 'postcode', visible:false },
                    { data: 'region_prop', name: 'region_prop', visible:false },
                    { data: 'region_kab', name: 'region_kab', visible:false },
                    { data: 'region_kec', name: 'region_kec', visible:false },
                    { data: 'region_kel', name: 'region_kel', visible:false },
                    { data: 'phone', name: 'phone', visible:false },
                    { data: 'mobile', name: 'mobile', visible:false },
                    { data: 'fax', name: 'fax', visible:false },
                    { data: 'email', name: 'email', visible:false },
                    { data: 'actions', name: 'actions' },
                ]
            });

            $(document).on('keyup', '#search_param',function(){ 
                tabelData.column('#comp_nm_table').search($(this).val()).draw();
            });

            //--Tambah data
            $('#tambah').click(function()   {
                saveMethod  ='tambah';

                $('#bagian-tabel').hide();      
                $('#bagian-form').show(); 
            });

            //--Reset form
            $('#reset').click(function()   {
                reset();    
            });

            //--Ubah data
            $(document).on('click', '#ubah',function(){ 

                var rowData=tabelData.row($(this).parents('tr')).data();
                dataCd = rowData['comp_cd'];
                saveMethod = 'ubah';
                $('#tambah').hide();
                $('#kembali').show();
                $('input[name=comp_nm]').focus();
                $('input[name=comp_cd]').val(rowData['comp_cd']).prop('readonly',true);
                $('input[name=comp_nm]').val(rowData['comp_nm']);
                $('textarea[name=address]').val(rowData['address']);
                $('input[name=postcode]').val(rowData['postcode']);
                $('input[name=phone]').val(rowData['phone']);
                $('input[name=mobile]').val(rowData['mobile']);
                $('input[name=fax]').val(rowData['fax']);
                $('input[name=email]').val(rowData['email']);
                $('select[name=region_prop]').val(rowData['region_prop']).trigger('change');
                $('select[name=region_kab]').val(rowData['region_kab']).trigger('change');
                $('select[name=region_kel]').val(rowData['region_kel']).trigger('change');
                $('select[name=region_kec]').val(rowData['region_kec']).trigger('change');
                editRegion(rowData['region_prop'],rowData['region_kab'],rowData['region_kec'],rowData['region_kel']);
                $('#bagian-tabel').hide();      
                $('#bagian-form').show(); 

            });

            //--Submit form
            $('#form-isian').submit(function(e){
                if (e.isDefaultPrevented()) {
                //--Handle the invalid form
                } else {
                    e.preventDefault();
                    var record=$('#form-isian').serialize();
                    if(saveMethod == 'tambah'){
                        var url     = baseUrl;
                        var method  = 'POST';
                    }else{
                        var url     = baseUrl+'/'+ dataCd;
                        var method  = 'PUT';
                    }

                    swal({
                        title               : "Simpan data?",
                        type                : "question",
                        showCancelButton    : true,
                        // confirmButtonColor  : "#00a65a",
                        confirmButtonText   : "YA",
                        cancelButtonText    : "TIDAK",
                        allowOutsideClick   : false,
                    }).then((result) => {
                        if(result.value){
                            swal({
                                allowOutsideClick   : false,
                                title               : "Proses Simpan",
                                didOpen             : () => {swal.showLoading();}
                            });
                            $.ajax({
                                'type': method,
                                'url' : url,
                                'data': record,
                                'dataType': 'JSON',
                                'success': function(response){
                                    if(response["status"] == 'ok') {  
                                        swal({
                                            title               : "Proses berhasil",
                                            type                : "success",
                                            showConfirmButton   : false,
                                            timer               : 1000,
                                        }).then(() => {
                                            reset();
                                            swal.close();
                                        });
                                    }else{
                                        swal({
                                            title               : "Proses Gagal",
                                            type                : "error",
                                            showConfirmButton   : false,
                                            timer               : 1000,
                                        });
                                    }
                                },
                                'error': function(response){ 
                                    var errorText = '';
                                    $.each(response.responseJSON.errors, function(key, value) {
                                        errorText += value+'<br>'
                                    });

                                    swal({
                                        title               : response.status.toString(),
                                        type                : 'error',
                                        html                : errorText,
                                        confirmButtonText : "OK",
                                    }).then((result) => {
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
                dataCd = rowData['comp_cd'];
                swal({
                    title             : "Hapus Data?",
                    type              : "question",
                    showCancelButton  : true,
                    // confirmButtonColor: "#00a65a",
                    confirmButtonText : "YA",
                    cancelButtonText  : "TIDAK",
                    allowOutsideClick : false,
                }).then((result)=>{
                    if(result.value){
                        swal({
                            allowOutsideClick   : false,
                            title               : "Proses Hapus",
                            didOpen             : () => {swal.showLoading();}
                        });
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
                                        title               : "Proses berhasil",
                                        type                : "success",
                                        showConfirmButton   : false,
                                        timer               : 1000,
                                    }).then(() => {
                                        reset();
                                        swal.close();
                                    });
                                }else{
                                    swal({
                                    title               : "Proses gagal",
                                    type                : "success",
                                    showConfirmButton   : false,
                                    timer               : 1000,
                                })
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                swal({
                                    title               : "Terjadi kesalahan sistem",
                                    text                : "Silahkan hubungi Administrator",
                                    type                : "error",
                                    showConfirmButton   : false,
                                    timer               : 1000,
                                });
                            }
                        })
                    } else {
                        swal.close();
                    }
                    
                });
            });
            //--Detail data
            $(document).on('click','#detail',function(){
                var rowData=tabelData.row($(this).parents('tr')).data();
                dataCd = rowData['comp_cd'];
                window.location = baseUrl + '/' + dataCd;
            })
            //--Region
            //-Provinsi
            $('#region_prop').select2({
                placeholder : "Pilih Provinsi",
                ajax : {
                    url :  "{{ url('daftar-daerah/provinsi/') }}",
                    dataType: 'json',
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                },
            });
            $('#region_prop').change(function () {
                $('#region_kab').empty();
                $('#region_kec').empty();
                $('#region_kel').empty();
                $('#region_kab').select2({
                    placeholder : "Pilih Kabupaten",
                    ajax : {
                        url :  "{{ url('daftar-daerah/by-root/') }}"+"/"+$('#region_prop').val(),
                        dataType: 'json',
                        processResults: function(data){
                            return {
                                results: data
                            };
                        },
                    },
                });
            });
            //-Kabupaten
            $('#region_kab').change(function () {
                $('#region_kec').empty();
                $('#region_kel').empty();
                $('#region_kec').select2({
                    placeholder : "Pilih Kecamatan",
                    ajax : {
                        url :  "{{ url('daftar-daerah/by-root/') }}"+"/"+$('#region_kab').val(),
                        dataType: 'json',
                        processResults: function(data){
                            return {
                                results: data
                            };
                        },
                    },
                });
            });
            //-Kecamatan
            $('#region_kec').change(function () {
                $('#region_kel').empty();
                $('#region_kel').select2({
                    placeholder : "Pilih Kelurahan",
                    ajax : {
                        url :  "{{ url('daftar-daerah/by-root/') }}"+"/"+$('#region_kec').val(),
                        dataType: 'json',
                        processResults: function(data){
                            return {
                                results: data
                            };
                        },
                    },
                });
            });
        });
    function reset(){
        saveMethod  ='';
        $('input[name=search_param]').val('').trigger('keyup');
        $('input[name=comp_cd]').val('').prop('readonly',false).removeClass("bg-gray-100 cursor-not-allowed");
        $('input[name=comp_nm]').val('');
        $('input[name=postcode]').val('');
        $('input[name=phone]').val('');
        $('input[name=mobile]').val('');
        $('input[name=email]').val('');
        $('textarea[name=address]').val('');
        $('select[name=region_prop]').val('').trigger('change');
        $('select[name=region_kab]').val('').trigger('change');
        $('select[name=region_kec]').val('').trigger('change');
        $('select[name=region_kel]').val('').trigger('change');
        $('#bagian-tabel').show();      
        $('#bagian-form').hide(); 
        $('#kembali').hide();
        $('#tambah').show();
        tabelData.ajax.reload();
    }
    function editRegion(region_prop,region_kab,region_kec,region_kel){
        /*region edit*/
        if(region_prop){
            $.ajax({
                url: "{{ url('nama-daerah/') }}" + "/" + region_prop,
                success: function(prop_nm) {
                    $('#region_prop').select2({
                        data:[{"id": region_prop ,"text": prop_nm}],
                        placeholder : "Pilih Provinsi",
                        ajax : {
                            url :  "{{ url('daftar-daerah/provinsi/') }}",
                            dataType: 'json',
                            processResults: function(data){
                                return {
                                    results: data
                                };
                            },
                        },
                    });
                }
            });
            $('#region_kab').select2({
                placeholder : "Pilih Kabupaten",
                ajax : {
                    url :  "{{ url('daftar-daerah/by-root/') }}"+"/"+$('#region_prop').val(),
                    dataType: 'json',
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                },
            });
        }
        if(region_kab){
            $.ajax({
                url: "{{ url('nama-daerah/') }}" + "/" + region_kab,
                success: function(kab_nm) {
                    $('#region_kab').select2({
                        data:[{"id": region_kab ,"text":kab_nm}],
                        placeholder : "Pilih Kabupaten",
                        ajax : {
                            url :  "{{ url('daftar-daerah/by-root/') }}"+"/"+$('#region_prop').val(),
                            dataType: 'json',
                            processResults: function(data){
                                return {
                                    results: data
                                };
                            },
                        },
                    });
                }
            });
            $('#region_kec').select2({
                placeholder : "Pilih Kecamatan",
                ajax : {
                    url :  "{{ url('daftar-daerah/by-root/') }}"+"/"+region_kab,
                    dataType: 'json',
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                },
            });
        }
        if(region_kec){
            $.ajax({
                url: "{{ url('nama-daerah/') }}" + "/" + region_kec,
                success: function(kec_nm) {
                    $('#region_kec').select2({
                        data:[{"id": region_kec ,"text":kec_nm}],
                        placeholder : "Pilih Kecamatan",
                        ajax : {
                            url :  "{{ url('daftar-daerah/by-root/') }}"+"/"+region_kab,
                            dataType: 'json',
                            processResults: function(data){
                                return {
                                    results: data
                                };
                            },
                        },
                    });
                }
            });
            $('#region_kel').select2({
                placeholder : "Pilih Kelurahan",
                ajax : {
                    url :  "{{ url('daftar-daerah/by-root/') }}"+"/"+region_kec,
                    dataType: 'json',
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                },
            });
        }
        if(region_kel){
            $.ajax({
                url: "{{ url('nama-daerah/') }}" + "/" + region_kel,
                success: function(kel_nm) {
                    $('#region_kel').select2({
                        data:[{"id": region_kel ,"text":kel_nm}],
                        placeholder : "Pilih Kelurahan",
                        ajax : {
                            url :  "{{ url('daftar-daerah/by-root/') }}"+"/"+region_kec,
                            dataType: 'json',
                            processResults: function(data){
                                return {
                                    results: data
                                };
                            },
                        },
                    });
                }
            });
        }
    }
    </script>
@endpush