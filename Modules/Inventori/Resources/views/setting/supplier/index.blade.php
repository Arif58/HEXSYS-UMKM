@extends('layouts.app')

@section('content')
	@include('inventori::layouts.master')
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
                            {{-- <label class="form-group-float-label is-visible">Nama Supplier</label> --}}
                            <input name="search_param" id="search_param" placeholder="Pencarian Nama Supplier" class="form-control" data-fouc />
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i> Tambah</button>
                <button type="button" class="btn btn-warning legitRipple" id="ubah"><i class="icon-pencil mr-2"></i> Ubah</button>
                <button type="button" class="btn btn-danger legitRipple" id="hapus"><i class="icon-trash mr-2"></i> Hapus</button>
				<br><br>
                <div class="table-responsive">
                    <table class="table table-single-select datatable-pagination" id="tabel-data" width="100%">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th id="supplier_nm_table" width="30%">Nama Supplier</th>
								<th id="address_table" width="35%">Alamat</th>
								<th id="supplier_note_table" width="30%">Keterangan</th>
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
                                <label class="form-group-float-label is-visible">Kode Supplier</label>
                                <input type="text" name="supplier_cd" class="form-control text-uppercase" placeholder="Kode digenerate sistem" aria-invalid="false" maxlength="20" readonly>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Nama Supplier</label>
                                <input type="text" name="supplier_nm" class="form-control" required="" placeholder="" aria-invalid="false" maxlength="100">
                            </div>
                        </div>
                    </div>
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
                         <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Kota/Kabupaten</label>
                                <select name="region_kab" id="region_kab" class="form-control form-control-select2 select-search" data-fouc>

                                </select>
                            </div>
                        </div>
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
                                <input type="text" name="supplier_note" id="supplier_note" class="form-control" placeholder="" aria-invalid="false" maxlength="200">
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
    var baseUrl     = "{{ url('inventori/setting/supplier/') }}";

    $(document).ready(function(){
        $('#bagian-form').hide();  
        /*tabel terkait */
        tabelData = $('#tabel-data').DataTable({
            processing	: true, 
            serverSide	: true, 
            order		: [], 
            ajax		: {
                url: baseUrl+'/data',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
            },
            language: {
			  "sSearch": "" //--Change search box caption
			},
            lengthMenu		: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
			info 			: false, /*--Showing 1 to XX of YY entries--*/
			dom 			: 'Blrtip',
			buttons: [
				{
					extend:    'excelHtml5',
					exportOptions: {
						columns: [0,1,2,3]
					},
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'pdfHtml5',
					exportOptions: {
						columns: [0,1,2,3]
					},
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF',
					//orientation:'landscape',
					orientation:'portrait',
					pageSize: 	'A4',
					download: 	'open',
					customize: function (doc) {
						//--Header & Parameter
						var reportTitle =  'Data Supplier';	
												
						//--Full width table
						//doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
						doc.content[1].table.widths = [40,150,180,160];
						var rowCount = doc.content[1].table.body.length;
						for (i = 1; i < rowCount; i++) {
							doc.content[1].table.body[i][0].alignment = 'left';
							doc.content[1].table.body[i][1].alignment = 'left';
							doc.content[1].table.body[i][2].alignment = 'left';
							doc.content[1].table.body[i][3].alignment = 'left';
						}
						
						//doc.defaultStyle.alignment = 'center'; //--alignment all column
						doc.styles.tableHeader.alignment = 'center';
						doc.defaultStyle.fontSize = 10;
						doc.styles.tableHeader.fontSize = 12;
						doc.styles.tableFooter.fontSize = 10;
						doc.styles.title.fontSize = 14;
						
						doc.content.splice(0,1);
						var now = new Date();
						var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
						doc.pageMargins = [20,60,20,30];
						doc.defaultStyle.fontSize = 10;
						doc.styles.tableHeader.fontSize = 10;
						doc['header']=(function() {
							return {
								columns: [
									{
										alignment: 'left',
										bold: true,
										//italics: true,
										text: reportTitle,
										fontSize: 10,
										margin: [10,0]
									},
								],
								margin: 20
							}
						});
						doc['footer']=(function(page, pages) {
							return {
								columns: [
									{
										alignment: 'left',
										text: ['Tanggal : ', { text: jsDate.toString() }]
									},
									{
										alignment: 'right',
										text: ['Page ', { text: page.toString() },	' of ',	{ text: pages.toString() }]
									}
								],
								margin: 10
							}
						});
						var objLayout = {};
						objLayout['hLineWidth'] = function(i) { return .5; };
						objLayout['vLineWidth'] = function(i) { return .5; };
						objLayout['hLineColor'] = function(i) { return '#aaa'; };
						objLayout['vLineColor'] = function(i) { return '#aaa'; };
						objLayout['paddingLeft'] = function(i) { return 4; };
						objLayout['paddingRight'] = function(i) { return 4; };
						doc.content[0].layout = objLayout;
					}
				},
				{
					extend:    'print',
					exportOptions: {
						columns: [0,1,2,3]
					},
					text:      '<i class="fa fa-print"></i>',
					titleAttr: 'Print'
				}
			],
            columns: [
                { data: 'supplier_cd', name: 'supplier_cd', visible:true },
                { data: 'supplier_nm', name: 'supplier_nm' },
				{ data: 'address', name: 'address' },
				{ data: 'supplier_note', name: 'supplier_note' },
            ],
        });

        $(document).on('keyup', '#search_param',function(){ 
            tabelData.column('#supplier_nm_table').search($(this).val()).draw();
        });

        $('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');

			tabelData.ajax.reload();
		});

        /* tambah data */
        $('#tambah').click(function()   {
            saveMethod  ='tambah';

            $('input[name=supplier_nm]').focus();
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
                
                $('input[name=supplier_cd]').val(rowData['supplier_cd']).prop('readonly',true);
                $('input[name=supplier_nm]').val(rowData['supplier_nm']);
                $('input[name=address]').val(rowData['address']);
                $('input[name=postcode]').val(rowData['postcode']);
                $('input[name=phone]').val(rowData['phone']);
                $('input[name=mobile]').val(rowData['mobile']);
                $('input[name=fax]').val(rowData['fax']);
                $('input[name=email]').val(rowData['email']);
                $('input[name=npwp]').val(rowData['npwp']);
                $('input[name=pic]').val(rowData['pic']);
                var prop_nm;
                var kab_nm;
                /*region edit*/
                $.ajax({
                    url: "{{ url('nama-daerah/') }}" + "/" + rowData['region_prop'],
                    success: function(prop_nm) {
                        $('#region_prop').select2({
                            data:[{"id": rowData['region_prop'] ,"text": prop_nm}],
                            placeholder : "Pilih Propinsi",
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
                $.ajax({
                    url: "{{ url('nama-daerah/') }}" + "/" + rowData['region_kab'],
                    success: function(kab_nm) {
                        $('#region_kab').select2({
                            data:[{"id": rowData['region_kab'] ,"text":kab_nm}],
                            placeholder : "Pilih Kota",
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
        $('input[name=supplier_cd]').focusout(function(){
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
                            $('input[name=supplier_cd]').val('');
                            $('input[name=supplier_cd]').focus();
                            swal.close();
                        });
                    }
                });
            }
        });

        /*region */
        $('#region_prop').select2({
	        placeholder : "Pilih Propinsi",
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
            $('#region_kab').select2({
		        placeholder : "Pilih Kota",
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
    });

    function reset(type) {
        saveMethod  ='';
        dataCd = null;
        rowData = null;
        tabelData.ajax.reload();
        
        $('#bagian-tabel').show();      
        $('#bagian-form').hide(); 
        $('input[name=supplier_cd]').val('').prop('readonly',false);
        $('input[name=supplier_nm]').val('');
        $('.card-title').text('Data Supplier');       
    }
</script>
@endpush