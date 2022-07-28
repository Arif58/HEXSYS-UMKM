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
                <div class="row" style="margin-top:10px">
                    <div class="col-md-12">
                        <div class="form-group form-group-float">
                            <!--<label class="form-group-float-label is-visible">Nama Approval</label>-->
                            <input name="search_param" id="search_param" placeholder="Pencarian Berdasarkan Nama" class="form-control" data-fouc />
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-pagination" id="tabel-data" width="100%">
                        <thead>
                            <tr>
                                <th id="approval_cd_table">Kode Approval</th>
                                <th id="approval_nm_table">Nama Approval</th>
                                <th id="approval_tp_table">Tipe Approval</th>
                                <th id="approval_tp_nm_table">Tipe Approval</th>
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
                                <label class="form-group-float-label is-visible">Kode Approval<span class="text-danger">*</span></label>
                                <input type="text" name="approval_cd" class="form-control" required="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
						<div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Nama Approval<span class="text-danger">*</span></label>
                                <input type="text" name="approval_nm" class="form-control" required="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Tipe Approval<span class="text-danger">*</span></label>
                                <select name="approval_tp" class="form-control form-control-select2 select-search" required data-fouc>
                                    {!! comCodeOptions('APPROVAL_TP') !!}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="reset" class="reset btn btn-light legitRipple">Reset <i class="icon-reload-alt ml-2"></i></button>
                        <button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan <i class="icon-floppy-disks ml-2"></i></button>
                    </div>
                </form>
            </div>

            <div id="bagian-detail">
                <form class="form-validate-jquery" id="form-isian-detail" action="#">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Nama Approval<span class="text-danger">*</span></label>
                                <input type="text" name="approval_nm_detail" class="form-control" readonly="readonly" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Tipe Approval<span class="text-danger">*</span></label>
                                <input type="text" name="approval_tp_detail" class="form-control" readonly="readonly" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <h5 class="card-title">Data Detail Approval</h5>
                <form class="form-validate-jquery" id="form-detail" action="#">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Role <span class="text-danger">*</span></label>
                                <select name="role_cd" id="role_cd" class="form-control" data-fouc required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Urutan <span class="text-danger">*</span></label>
                                <input type="number" name="approval_order" class="form-control" required="required" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-start align-items-center">
                            <button type="button" class="reset btn btn-info legitRipple"><i class="icon-arrow-left7"></i> Kembali Ke Daftar Approval</button>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <button type="reset" class="reset-lokasi btn btn-light legitRipple">Reset Form <i class="icon-reload-alt ml-2"></i></button>
                            <button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan <i class="icon-floppy-disks ml-2"></i></button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table datatable-pagination" id="tabel-detail" width="100%">
                        <thead>
                            <tr>
                                <th id="approval_detail_id_table">approval_detail_id_table</th>
                                <th id="approval_detail_rolecd_table">Kode Role</th>
                                <th id="approval_detail_rolenm_table">Nama Role</th>
                                <th id="approval_detail_order_table">Order</th>
                                <th id="actions_table" width="20%">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    var tabelData;
    var saveMethod  = 'tambah';
    var baseUrl     = "{{ url('sistem/erp/approval') }}";
    var dataCd      = '00000000';

    $(document).ready(function(){
        $('#bagian-form').hide();  
        $('#bagian-detail').hide();  

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
			/*language: {
                paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
            },
            pagingType: "simple",*/
			lengthMenu		: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
			info 			: false, /*--Showing 1 to XX of YY entries--*/
			//dom 			: 'Blrtip',
            columns: [
                { data: 'approval_cd', name: 'approval_cd', visible:true},
                { data: 'approval_nm', name: 'approval_nm', visible:true},
                { data: 'approval_tp', name: 'approval_tp', visible:false},
                { data: 'approval_tp_nm', name: 'approval_tp_nm', visible:true},
                { data: 'actions', name: 'actions', orderable:false },
            ],
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#approval_nm_table').search($(this).val()).draw();
        });

        $('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');

			tabelData.ajax.reload();
		});

        /* tambah data */
        $('#tambah').click(function()   {
            saveMethod  ='tambah';

            $('input[name=approval_nm]').focus();
            $('select[name=active_st]').val('').trigger('change');  
            $('#bagian-tabel').hide(); 
            $('#bagian-detail').hide();  

            $('#bagian-form').show(); 
            $('.card-title').text('Tambah Data');       
        });

        /* tambah data */
        $('.reset').click(function()   {
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
            saveMethod  = 'ubah';
            var rowData = tabelData.row($(this).parents('tr')).data();
            dataCd      = rowData['approval_cd'];
            
            //$('input[name=approval_cd]').val(rowData['approval_cd']);
			$('input[name=approval_cd]').val(rowData['approval_cd']).prop('readonly',true);
			$('input[name=approval_nm]').val(rowData['approval_nm']);
            $('select[name=approval_tp]').val(rowData["approval_tp"]).trigger('change');
			
            /* $('#approval_tp').empty();
            $('#approval_tp').select2({
                data:[{"id": rowData["approval_tp"] ,"text":rowData["approval_tp_nm"] }] ,
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
            $('#bagian-detail').hide();
            $('#bagian-form').show(); 
        });

        /* hapus data */
        $(document).on('click', '.hapus',function(){ 
            var rowData = tabelData.row($(this).parents('tr')).data();
            dataCd      = rowData['approval_cd'];
            
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

        /* pilihan root Approval*/
        $('#approval_tp').empty();
        $('#approval_tp').select2({
            data:[{"id": "" ,"text":"=== Pilih Data ===" }] ,
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
        });
		
		/* detail Approval*/
		/*tabelDetail = $('#tabel-detail').DataTable({
            processing  : true, 
            serverSide  : true, 
            order		: [[1,'ASC']],
            scrollX     : false,
            ajax		: {
                url: baseUrl+'/detail-approval/data',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
            },
            columns: [
                { data: 'com_approval_detail_id', name : 'com_approval_detail_id', visible:false},
                { data: 'role_cd', name : 'role_cd', visible:true},
                { data: 'role_nm', name : 'role_nm', visible:true},
                { data: 'approval_order', name : 'approval_order', visible:false},
                { data: 'actions', name: 'actions', orderable:false },
            ],
        });*/

        /* ubah data */
        $(document).on('click', '.detail',function(){ 
            var rowData = tabelData.row($(this).parents('tr')).data();
            dataCd      = rowData['approval_cd'];

            $('input[name=approval_cd_detail]').val(rowData['approval_cd']);
            $('input[name=approval_nm_detail]').val(rowData['approval_nm']);
            $('input[name=approval_tp_detail]').val(rowData['approval_tp_nm']);

            // tabelDetail.column('#approval_cd_detail_table').search(dataCd).draw();
            // tabelDetail.ajax.reload();

            $('#bagian-tabel').hide();      
            $('#bagian-form').hide(); 
            $('#bagian-detail').show();
        });

        /* ubah data */
        $(document).on('click', '.ubah-detail',function(){ 
            saveMethod  ='ubah';
            var rowData = tabelDetail.row($(this).parents('tr')).data();
            dataCd      = rowData['detail_no'];
            
            $('input[name=detail_aset_detail_cd]').val(rowData['aset_detail_cd']);
            $('input[name=detail_aset_detail_nm]').val(rowData['aset_detail_nm']);
            $('input[name=approval_order]').val(rowData['order_no']);
            $('select[name=detail_value_tp]').val(rowData['value_tp']).trigger('change');
        });

        /* hapus data */
        $(document).on('click', '.hapus-detail',function(){ 
            var rowData = tabelDetail.row($(this).parents('tr')).data();
            dataCd = rowData['detail_no'];
            
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
                        url : baseUrl+'/detail-aset/'+dataCd,
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
                                    reset('detail');
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

        /* submit form */
        $('#form-detail').submit(function(e){
            if (e.isDefaultPrevented()) {
            // handle the invalid form...
            } else {
                e.preventDefault();

                var record  = $('#form-detail').serialize();
                console.log(record);

                if(saveMethod == 'tambah'){
                    var url     = baseUrl+'/detail-aset/';
                    var method  = 'POST';
                }else{
                    var url     = baseUrl+'/detail-aset/'+dataCd;
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
                            'data': 'detail_approval_cd='+dataCd+'&'+record,
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
                                        reset('detail');
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

        /*cek kode*/
        $('input[name=approval_cd]').focusout(function(){
            var id          = $(this).val();
            var urlUpdate   = baseUrl+'/'+id;

            if ($(this).val() && saveMethod === 'tambah') {
                $.getJSON( urlUpdate, function(data){
                    if (data['data']) {
                        swal({
                            title: "Peringatan!",
                            text: "Kode Sudah Digunakan!",
                            type: "warning",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            $('input[name=approval_cd]').val('');
                            $('input[name=approval_cd]').focus();
                            swal.close();
                        });
                    }
                });
            }
        });
    });

    function reset(params) {
        switch (params) {
            case 'detail':
                $('input[name=detail_aset_detail_cd]').val('');
                $('input[name=detail_aset_detail_nm]').val('');
                $('select[name=detail_value_tp]').val('').trigger('change');
                
                tabelDetail.ajax.reload();
                
                break;
        
            default:
                tabelData.ajax.reload();
                $('.card-title').text('{{ $title }}');  
                $('#bagian-tabel').show();      
                $('#bagian-form').hide(); 
                $('#bagian-detail').hide();  
                
				$('input[name=approval_cd]').val('').prop('readonly',false);
                $('input[name=approval_nm]').val('');
                
                /* pilihan root Approval*/
                $('#approval_tp').empty();
                $('#approval_tp').select2({
                    data:[{"id": "" ,"text":"=== Pilih Data ===" }] ,
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
                });
                break;
        }

        saveMethod  ='tambah';
    }
</script>
@endpush