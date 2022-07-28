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
                            <!--<label class="form-group-float-label is-visible">Nomor Rekening Bank</label>-->
                            <input name="search_param" id="search_param" placeholder="Pencarian Berdasarkan Nomor Rekening" class="form-control" data-fouc />
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-pagination" id="tabel-data" width="100%">
                        <thead>
                            <tr>
                                <th id="com_company_bank_id_table">com_company_bank_id_table</th>
                                <th id="comp_cd_table">comp_cd_table</th>
                                <th id="comp_nm_table">Perusahaan</th>
                                <th id="account_cd_table">No Rekening</th>
                                <th id="bank_cd_table">bank_cd_table</th>
                                <th id="bank_nm_table">Bank</th>
                                <th id="branch_nm_table">Cabang</th>
                                <th id="account_nm_table">Nama</th>
                                <th id="account_no_table">account_no_table</th>
                                <th id="currency_cd_table">currency_cd_table</th>
                                <th id="currency_nm_table">Mata Uang</th>
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
                                <label class="form-group-float-label is-visible">No Rekening Bank <span class="text-danger">*</span></label>
                                <input type="text" name="account_cd" class="form-control" required="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Nama Rekening <span class="text-danger">*</span></label>
                                <input type="text" name="account_nm" class="form-control" required="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Bank <span class="text-danger">*</span></label>
                                <select name="bank_cd" id="bank_cd" class="form-control" data-fouc required>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Cabang <span class="text-danger">*</span></label>
                                <input type="text" name="branch_nm" class="form-control" required="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Mata Uang <span class="text-danger">*</span></label>
                                <select name="currency_cd" id="currency_cd" class="form-control" data-fouc required>
                                </select>
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
    var baseUrl = "{{ url('sistem/erp/rekening-bank') }}";
    
    $(document).ready(function(){
        $('#bagian-form').hide();  

        tabelData = $('#tabel-data').DataTable({
            processing  : true, 
            serverSide  : true, 
            order		: [[1,'ASC'],[4,'ASC']],
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
                { data: 'com_company_bank_id', name: 'com_company_bank_id', visible:false},
                { data: 'comp_cd', name: 'comp_cd', visible:false},
                { data: 'com_company.comp_nm', name: 'com_company.comp_nm', visible:false},
                { data: 'account_cd', name: 'account_cd', visible:true},
                { data: 'bank_cd', name: 'bank_cd', visible:false},
                { data: 'com_bank.bank_nm', name: 'com_bank.bank_nm', visible:true},
                { data: 'branch_nm', name: 'branch_nm', visible:true},
                { data: 'account_nm', name: 'account_nm', visible:true},
                { data: 'account_no', name: 'account_no', visible:false},
                { data: 'currency_cd', name: 'currency_cd', visible:false},
                { data: 'com_currency.currency_nm', name: 'com_currency.currency_nm', visible:true},
                { data: 'actions', name: 'actions', orderable:false },
            ],
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#account_cd_table').search($(this).val()).draw();
        });

        $('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');

			tabelData.ajax.reload();
		});

        /* tambah data */
        $('#tambah').click(function()   {
            saveMethod  ='tambah';

            $('input[name=account_cd]').focus();
            $('#bagian-tabel').hide();      
            $('#bagian-form').show(); 
            $('.card-title').text('Tambah Data');       
        });

        /* tambah data */
        $('#reset').click(function()   {
            reset('form');
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
                                        reset('form');
                                        swal.close();
                                    });
                                }else{
                                    console.log(response);
                                    swal({title: "Data Gagal Disimpan",type: "error", showCancelButton: false,showConfirmButton: false,timer: 1000});
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
            dataCd      = rowData.com_company_bank_id;
            
            $('input[name=account_cd]').val(rowData.account_cd);
            $('input[name=account_nm]').val(rowData.account_nm);
            $('input[name=branch_nm]').val(rowData.branch_nm);

            /* pilihan bank */
            $('#bank_cd').empty();
            $('#bank_cd').select2({
                data:[{"id": rowData.bank_cd ,"text":rowData.com_bank.bank_nm }] ,
                ajax : {
                    url :  "{{ url('/sistem/erp/dropdown-data/bank') }}",
                    dataType: 'json', 
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                    cache : true,
                },
            });

            /* pilihan mata uang */
            $('#currency_cd').empty();
            $('#currency_cd').select2({
                data:[{"id": rowData.currency_cd ,"text":rowData.com_currency.currency_nm }] ,
                ajax : {
                    url :  "{{ url('/sistem/erp/dropdown-data/mata-uang') }}",
                    dataType: 'json', 
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                    cache : true,
                },
            });

            $('#bagian-tabel').hide();      
            $('#bagian-form').show(); 
        });

        /* hapus data */
        $(document).on('click', '.hapus',function(){ 
            var rowData=tabelData.row($(this).parents('tr')).data();
            dataCd = rowData.com_company_bank_id;
            
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

       reset('init');
    });

    function reset(params) {
        switch (params) {
            case 'init':
                /* pilihan bank*/
                $('#bank_cd').empty();
                $('#bank_cd').select2({
                    data:[{"id": "" ,"text":"=== Pilih Data ===" }] ,
                    ajax : {
                        url :  "{{ url('/sistem/erp/dropdown-data/bank') }}",
                        dataType: 'json', 
                        processResults: function(data){
                            return {
                                results: data
                            };
                        },
                        cache : true,
                    },
                });

                /* pilihan bank*/
                $('#currency_cd').empty();
                $('#currency_cd').select2({
                    data:[{"id": "" ,"text":"=== Pilih Data ===" }] ,
                    ajax : {
                        url :  "{{ url('/sistem/erp/dropdown-data/mata-uang') }}",
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
        
            default:
                saveMethod  ='tambah';

                tabelData.ajax.reload();
                $('#bagian-tabel').show();      
                $('#bagian-form').hide(); 
                $('.card-title').text('{{ $title }}');      

                $('input[name=account_cd]').val('');
                $('input[name=account_nm]').val('');
                $('input[name=branch_nm]').val('');

                /* pilihan bank*/
                $('#bank_cd').empty();
                $('#bank_cd').select2({
                    data:[{"id": "" ,"text":"=== Pilih Data ===" }] ,
                    ajax : {
                        url :  "{{ url('/sistem/erp/dropdown-data/bank') }}",
                        dataType: 'json', 
                        processResults: function(data){
                            return {
                                results: data
                            };
                        },
                        cache : true,
                    },
                });

                /* pilihan bank*/
                $('#currency_cd').empty();
                $('#currency_cd').select2({
                    data:[{"id": "" ,"text":"=== Pilih Data ===" }] ,
                    ajax : {
                        url :  "{{ url('/sistem/erp/dropdown-data/mata-uang') }}",
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
        
    }
</script>
@endpush