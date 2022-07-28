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
                    <div class="col-md-6">
                        <button type="button" class="btn btn-danger legitRipple" id="delete-all"><i class="icon-trash mr-2"></i> Hapus Semua Log</button>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-check-switchery form-check-switchery-double">
                            <label class="form-check-label">
                                Matikan Log Aktivitas
                                <input type="checkbox" name="log_st" class="form-check-input-switchery" {{ configuration('LOG_ST') == "ON" ? "checked" : "" }} value="ON" data-fouc>
                                Nyalakan Log Aktivitas
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-md-6">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Tanggal</label>
                            <input type="text" name="tanggal_param" class="form-control daterange-single" data-value="{{ date('Y/m/d') }}" readonly="readonly" placeholder="" aria-invalid="false" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">User</label>
                            <select name="user_id_param" id="user_id_param" class="form-control form-control-select2 select-search" data-fouc>
                                @foreach ($users as $item)
                                    <option value="{{ $item->user_id }}">{{ $item->user_nm }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Jenis Aktivitas</label>
                            <select name="log_tp_param" id="log_tp_param" class="form-control form-control-select2 select-search" data-fouc>
                                <option value="visit">Membuka Halaman</option>
                                <option value="create">Menambahkan Data</option>
                                <option value="update">Mengupdate Data</option>
                                <option value="delete">Menghapus Data</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table datatable-pagination" id="tabel-data" width="100%">
                        <thead>
                            <tr>
                                <th id="log_activity_id_table">log_activity_id_table</th>
                                <th id="created_at_table">Waktu</th>
                                <th id="user_id_table">user_id_table</th>
                                <th id="user_nm_table">User</th>
                                <th id="log_tp_table">Jenis</th>
                                <th id="log_nm_table">Keterangan</th>
                                <th id="table_table">table_table</th>
                                <th id="old_data_table">old_data_table</th>
                                <th id="new_data_table">new_data_table</th>
                                <th id="ip_address_table">ip_address_table</th>
                                <th id="user_agent_table">user_agent_table</th>
                                <th id="note_table">note_table</th>
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
                                <label class="form-group-float-label is-visible">Waktu Aktivitas<span class="text-danger">*</span></label>
                                <input type="text" name="created_at" class="form-control" readonly="readonly" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Nama User <span class="text-danger">*</span></label>
                                <input type="text" name="user_nm" class="form-control" readonly="readonly" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Jenis Aktivitas<span class="text-danger">*</span></label>
                                <input type="text" name="log_tp" class="form-control" readonly="readonly" placeholder="" aria-invalid="false">

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Keterangan <span class="text-danger">*</span></label>
                                <input type="text" name="log_nm" class="form-control" readonly="readonly" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Data Baru</label>
                                <pre id="new_data" data-fouc></pre>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Data Lama</label>
                                <pre id="old_data" data-fouc></pre>
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
<script src="{{ asset('/global_assets/js/plugins/editors/ace/ace.js') }}"></script>
<script src="{{ asset('/global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
<script>
    var tabelData;
    var old_data;
    var new_data;
    var saveMethod = 'tambah';
    var baseUrl = "{{ url('sistem/admin/log-activity') }}";

    
    $(document).ready(function(){
        var logSt = document.querySelector('.form-check-input-switchery');
        var switchery = new Switchery(logSt);

        $(".form-check-input-switchery").click(function() {
            if ($('[name="log_st"]').is(':checked')){ 
                var value = 'ON';
                var label = "Menyalakan Log Aktivitas";
            } else { 
                var value = 'OFF';
                var label = "Mematikan Log Aktivitas";
            }

            $.ajax({
                'type': 'POST',
                'url' : baseUrl,
                'data': {'value' : value},
                'dataType': 'JSON',
                'success': function(response){
                    if(response["status"] == 'ok') {     
                        swal({
                            title: "Berhasil "+label,
                            type: "success",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
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
                        confirmButtonText : "Oke",
                        cancelButtonText  : "Tidak",
                    }).then(function(result){
                        if(result.value){   	
                            swal.close();
                        }
                    });  
                }
            });
        });

        // JSON editor
        old_data = ace.edit('old_data');
        old_data.setTheme('ace/theme/monokai');
        old_data.getSession().setMode('ace/mode/json');
        old_data.setShowPrintMargin(false);

        new_data = ace.edit('new_data');
        new_data.setTheme('ace/theme/monokai');
        new_data.getSession().setMode('ace/mode/json');
        new_data.setShowPrintMargin(false);

        $('#bagian-form').hide();  

        tabelData = $('#tabel-data').DataTable({
            processing  : true, 
            serverSide  : true, 
            order		: [[1,'DESC']],
            scrollX     : false,
            ajax		: {
                url: baseUrl+'/data',
                type: "POST",
                data    : function(data){
                    data._token         = $('meta[name="csrf-token"]').attr('content');
                    data.tanggal 	    = $('input[name="tanggal_param"]').val();
                },
            },
            columns: [
                { data : 'log_activity_id', name: 'log_activity_id', visible:false},
                { 
                    data : 'created_at', 
                    name: 'created_at', 
                    visible:true,
                    render: function (data) {
                        return moment(data, 'YYYY-MM-DD HH:mm:ss').format('LL HH:mm:ss')
                    }
                },
                { data : 'user_id', name: 'user_id', visible:false},
                { data : 'user_nm', name: 'user_nm', visible:true},
                { data : 'log_tp', name: 'log_tp', visible:true},
                { data : 'log_nm', name: 'log_nm', visible:true},
                { data : 'table', name: 'table', visible:false},
                { data : 'old_data', name: 'old_data', visible:false},
                { data : 'new_data', name: 'new_data', visible:false},
                { data : 'ip_address', name: 'ip_address', visible:false},
                { data : 'user_agent', name: 'user_agent', visible:false},
                { data : 'note', name: 'note', visible:false},
                { data : 'actions', name: 'actions', orderable:false },
            ],
        });

		$('input[name="tanggal_param"]').change(function() {
            tabelData.ajax.reload();
		});

        $('select[name="user_id_param"]').change(function() {
            tabelData.column('#user_id_table').search($(this).val()).draw();
		});

        $('select[name="log_tp_param"]').change(function() {
            tabelData.column('#log_tp_table').search($(this).val()).draw();
		});

        $('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');

			tabelData.ajax.reload();
		});


        /* tambah data */
        $('#reset').click(function()   {
            saveMethod  ='';

            tabelData.ajax.reload();
            $('#bagian-tabel').show();      
            $('#bagian-form').hide(); 
            $('.card-title').text('{{ $title }}');       
        });

        /* ubah data */
        $(document).on('click', '#detail',function(){ 
            var rowData = tabelData.row($(this).parents('tr')).data();
            dataCd      = rowData['log_activity_id'];
            
            $('input[name=created_at]').val(rowData['created_at']);
            $('input[name=user_nm]').val(rowData['user_nm']);
            $('input[name=log_tp]').val(rowData['log_tp']);
            $('input[name=log_nm]').val(rowData['log_nm']);

            var oldData = JSON.stringify(JSON.parse(rowData['old_data'].replace(/&quot;/g,'"')),null,2);
            var newData = JSON.stringify(JSON.parse(rowData['new_data'].replace(/&quot;/g,'"')),null,2);
            new_data.setValue(newData);
            old_data.setValue(oldData);

            $('#bagian-tabel').hide();      
            $('#bagian-form').show(); 
        });

        $(document).on('click', '#delete-all',function(){ 
            swal({
                title             : "Hapus Semua Log ?",
                type              : "question",
                showCancelButton  : true,
                confirmButtonColor: "#00a65a",
                confirmButtonText : "OK",
                cancelButtonText  : "NO",
            }).then(function(result){
                if(result.value){
                    swal({title: "Proses hapus",onOpen: () => {swal.showLoading();}});
                    $.ajax({
                        url       : baseUrl,
                        type      : "DELETE", 
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
                                    tabelData.ajax.reload();
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
    });
</script>
@endpush