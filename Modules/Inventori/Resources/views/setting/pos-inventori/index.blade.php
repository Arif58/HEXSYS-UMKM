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
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-float">
                            {{-- <label class="form-group-float-label is-visible">Nama UMKM</label> --}}
                            <input name="search_param" id="search_param" placeholder="Pencarian Nama UMKM" class="form-control" data-fouc />
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i> Tambah</button>
                <button type="button" class="btn btn-warning legitRipple" id="ubah"><i class="icon-pencil mr-2"></i> Ubah</button>
                <button type="button" class="btn btn-danger legitRipple" id="hapus"><i class="icon-trash mr-2"></i> Hapus</button>
                <div class="table-responsive">
                    <table class="table table-single-select datatable-pagination" id="tabel-data" width="100%">
                        <thead>
                            <tr>
                                <th width="15%">Kode UMKM</th>
                                <th id="pos_nm_table" width="15%">Nama UMKM</th>
                                <th id="description_table" width="15%">Keterangan</th>
                                <th id="postrx_st_table" width="1%">postrx_st_table</th>
                                
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
                                <label class="form-group-float-label is-visible">Kode UMKM</label>
                                <input type="text" name="pos_cd" class="form-control text-uppercase" placeholder="Kode digenerate sistem" aria-invalid="false" maxlength="20" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Nama UMKM</label>
                                <input type="text" name="pos_nm" class="form-control" required="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-4" style="display: none">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Pos Transaksi</label>
                                <div class="input-group">
                                    <input type="checkbox" id="checkbox_transaksi" name="checkbox_transaksi">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<div class="row">
                        <div class="col-md-8">
                            <label class="form-group-float-label is-visible">Keterangan</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>
                    </div>--}}
					<div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Alamat</label>
                                <input type="text" name="address" id="address" class="form-control" required="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                         <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Propinsi</label>
                                <select name="region_prop" id="region_prop" class="form-control form-control-select2 select-search" data-fouc>

                                </select>
                            </div>
                        </div>
                        {{--<div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Kota/Kabupaten</label>
                                <select name="region_kab" id="region_kab" class="form-control form-control-select2 select-search" data-fouc>

                                </select>
                            </div>
                        </div>--}}
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Kode Pos</label>
                                <input type="text" name="postcode" id="postcode" class="form-control" placeholder="" aria-invalid="false" maxlength="6">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Telepon</label>
                                <input type="text" name="phone" id="phone" class="form-control" required="" placeholder="" aria-invalid="false" maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">HP</label>
                                <input type="text" name="mobile" id="mobile" class="form-control" required="" placeholder="" aria-invalid="false" maxlength="20">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Fax</label>
                                <input type="text" name="fax" id="fax" class="form-control" placeholder="" aria-invalid="false" maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="" aria-invalid="false" maxlength="100">
                            </div>
                        </div>
						<div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">NPWP</label>
                                <input type="text" name="npwp" id="npwp" class="form-control" placeholder="" aria-invalid="false" maxlength="50">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Kontak Person</label>
                                <input type="text" name="pic" id="pic" class="form-control" placeholder="" aria-invalid="false" maxlength="200">
                            </div>
                        </div>
						<div class="col-md-8">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Keterangan</label>
                                <input type="text" name="description" id="description" class="form-control" placeholder="" aria-invalid="false" maxlength="200">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan <i class="icon-floppy-disk ml-2"></i></button>
                        <button type="reset" class="btn btn-light legitRipple" id="reset">Selesai <i class="icon-reload-alt ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    var tabelData;
    var saveMethod  = 'tambah';
    var baseUrl     = "{{ url('inventori/setting/pos-inventori/') }}";

    $(document).ready(function(){
        $('#bagian-form').hide();  

        tabelData = $('#tabel-data').DataTable({
            language: {
                paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'},
                emptyTable: 'Tidak ada data',
            },
            pagingType: "simple",
            processing	: true, 
            serverSide	: true, 
            order		: [1,'asc'], 
            ajax		: {
                url: baseUrl+'/'+'data',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
            },
            dom : 'tpi',
            columns: [
                { data: 'pos_cd', name: 'pos_cd', visible:true },
                { data: 'pos_nm', name: 'pos_nm',visible:true },
                { data: 'description', name: 'description',visible:true },
                { data: 'postrx_st', name: 'postrx_st',visible:false },
            ],
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#pos_nm_table').search($(this).val()).draw();
        });

        $('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');

			tabelData.ajax.reload();
		});

        /* tambah data */
        $('#tambah').click(function()   {
            saveMethod  ='tambah';

            $('input[name=pos_nm]').focus();
            $('#bagian-tabel').hide();      
            $('#bagian-form').show(); 
            $('.card-title').text('Tambah Data');       
        });

        /* reset form */
        $('#reset').click(function()   {
            reset('')
        });
        
        /* submit form */
        $('#form-isian').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();

                var record  = $('#form-isian').serialize();
                console.log(record);
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
                    cancelButtonText    : "Tidak",
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

        /* ubah data */
        $(document).on('click', '#ubah',function(){ 
            if (dataCd == null) {
                swal({
                    title: "Pilih Data!",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1000
                });
            }else{
                saveMethod  ='ubah';
                
                $('input[name=pos_cd]').val(rowData['pos_cd']).prop('readonly',true);
                $('input[name=pos_nm]').val(rowData['pos_nm']);
                $("#description").val(rowData['description']);
                if(rowData['postrx_st'] == "1"){
                    // document.getElementById("checkbox-katarak").checked = true;
                    $("#checkbox_transaksi").prop("checked", true);
                }
                $('#bagian-tabel').hide();      
                $('#bagian-form').show(); 
            }
        });

        /* hapus data */
        $(document).on('click', '#hapus',function(){
            if (dataCd == null) {
                swal({
                    title: "Pilih Data!",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1000
                });
            }else{
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

        /*cek kode*/
        $('input[name=pos_cd]').focusout(function(){
            var id          = $(this).val();
            var urlUpdate   = baseUrl+'/'+id;

            if ($(this).val() && saveMethod === 'tambah') {
                $.getJSON( urlUpdate, function(data){
                    if (data['status'] == 'ok') {
                        swal({
                            title: "Peringatan!",
                            text: "Kode Sudah Digunakan!",
                            type: "warning",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            $('input[name=pos_cd]').val('');
                            $('input[name=pos_cd]').focus();
                            swal.close();
                        });
                    }
                });
            }
        });
    });

    function reset(type) {
        saveMethod  ='';
        dataCd = null;
        rowData = null;
        tabelData.ajax.reload();
        
        $('#bagian-tabel').show();      
        $('#bagian-form').hide(); 
        $('input[name=pos_cd]').val('').prop('readonly',false);
        $('input[name=pos_nm]').val('');
        $('.card-title').text('Data Gudang');       
    }
</script>
@endpush