@extends('layouts.app')

@section('content')
	{{-- @include('inventori::layouts.master') --}}
	@include('erpgl::layouts.master')
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
            <ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0 nav-justified">
                <li class="nav-item"><a href="#tab-stock-alert" class="nav-link active" data-toggle="tab">Stok Minimum</a></li>
                <li class="nav-item"><a href="#tab-stock-expired" class="nav-link" data-toggle="tab">Stok Expired</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-stock-alert">
					
					<div class="row">
						<div class="col-md-3">
						<div class="form-group form-group-float">
							<select name="item_cd_param" id="item_cd_param" class="form-control form-control-select2 search-param" data-fouc>
							</select>
						</div>
					</div>
						<div class="col-md-3">
							<div class="form-group form-group-float">
								<select name="pos_cd_param" id="pos_cd_param" class="form-control form-control-select2 search-param" data-fouc>
									<option value="">=== Pilih Gudang ===</option>
									@foreach ($gudangs as $item)
										<option value="{{ $item->pos_cd}}">{{ $item->pos_nm}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					
                    <div class="table-responsive">
                        <table class="table table-single-select datatable-pagination" id="tabel-stock-alert" width="100%">
                            <thead>
                                <tr>
                                    <th id="item_cd_table">item_cd_table</th>
                                    <th id="item_nm_table">Nama Item</th>
                                    <th id="jenis_table">Jenis</th>
                                    <th id="satuan_table">Satuan</th>
                                    <th id="minimum_stock_table">Stok Minimum</th>
                                    <th id="maximum_stock_table">Stok Maksimum</th>
                                    <th id="stock_table">Stok Saat Ini</th>
                                    <th id="alert_status_table">Status Alert</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-stock-expired">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <!--<input type="text" name="tanggal_expired_param" class="form-control mask-date" placeholder="Tanggal Expired (dd/mm/yyyy)" aria-invalid="false">-->
                                <input type="date" name="tanggal_expired_param" class="form-control"  aria-invalid="false">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable-pagination" id="tabel-stock-expired" width="100%">
                            <thead>
                                <tr>
                                    <th id="item_cd_table">item_cd_table</th>
                                    <th id="item_nm_table">Nama Item</th>
                                    <th id="jenis_table">Jenis</th>
                                    <th id="satuan_table">Satuan</th>
                                    <th id="tanggal_masuk_table">Tanggal Masuk</th>
                                    <th id="tanggal_expired_table"> Tanggal Expired</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script>
    var tabelStockAlert;
    var tabelStockExpired;
    var baseUrl     = "{{ url('inventori/report/stok-minimum/') }}";
	var unitCd		= "{{ Auth::user()->unit_cd ?? '' }}";

    $(document).ready(function(){
        // tabel stock alert
        tabelStockAlert = $('#tabel-stock-alert').DataTable({
            processing	: true, 
            serverSide	: true, 
            order		: [], 
            ajax		: {
                url : baseUrl+'/'+'data',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'type'  : 'alert'
                },
            },
            language: {
			  "sSearch": "" //--Change search box caption
			},
            lengthMenu		: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
			info 			: false, /*--Showing 1 to XX of YY entries--*/
			paging			: false,
			dom 			: 'Blrtip',
			buttons: [
				{
					extend:    'excelHtml5',
					exportOptions: {
						columns: [1,2,3,4,6]
					},
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'pdfHtml5',
					exportOptions: {
						columns: [1,2,3,4,6]
					},
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF',
					//orientation:'landscape',
					orientation:'portrait',
					pageSize: 	'A4',
					download: 	'open',
					customize: function (doc) {
						//--Header & Parameter
						var gudangSelect = '';
							if ($("#pos_cd_param option:selected").val() != '') {
								gudangSelect = $("#pos_cd_param option:selected").text();
							}
						var reportTitle =  'Laporan Stok Minimum ' + gudangSelect;	
												
						//--Full width table
						//doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
						doc.content[1].table.widths = [200,80,50,80,80];
						var rowCount = doc.content[1].table.body.length;
						for (i = 1; i < rowCount; i++) {
							doc.content[1].table.body[i][0].alignment = 'left';
							doc.content[1].table.body[i][1].alignment = 'left';
							doc.content[1].table.body[i][2].alignment = 'right';
							doc.content[1].table.body[i][3].alignment = 'right';
							doc.content[1].table.body[i][4].alignment = 'left';
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
						columns: [1,2,3,4,6]
					},
					text:      '<i class="fa fa-print"></i>',
					titleAttr: 'Print'
				}
			],
            columns: [
                { data : 'item_cd', name : 'item_cd', visible:false},
                { data : 'item_nm', name : 'item_nm', visible:true},
                { data : 'jenis', name : 'jenis', visible:true},
                { data : 'satuan', name : 'satuan', visible:true},
                { data : 'minimum_stock', name : 'minimum_stock', visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
                { data : 'maximum_stock', name : 'maximum_stock', visible:false, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
                { data : 'stock', name : 'stock', visible:true , render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
                { data : 'alert_status', name : 'alert_status', visible:true},
            ],
        });
		
		/* $(document).on('change', '#item_cd_param',function(){ 
            tabelData.column('#item_cd_table').search($(this).val()).draw();
        });
        $(document).on('change', '#pos_cd_param',function(){ 
            if (CheckUnit()) {
				//tabelData.column('#pos_cd_table').search($(this).val()).draw();
				tabelData.column('#pos_cd_table').search("^" + $(this).val() + "$", true, false).draw();
			} else {
				tabelData.column('#pos_cd_table').search(unitCd).draw();
			}
        }); */
		
        $(document).on('change', '#item_cd_param',function(){ 
            tabelStockAlert.column('#item_cd_table').search($(this).val()).draw();
        });
		$(document).on('change', '#pos_cd_param',function(){ 
            tabelStockAlert.column('#pos_cd_table').search($(this).val()).draw();
        });

        // tabel stock expired
        tabelStockExpired = $('#tabel-stock-expired').DataTable({
            language: {
                paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'},
                emptyTable: 'Tidak ada data',
            },
            pagingType: "simple",
            processing	: true, 
            serverSide	: true, 
            order		: [], 
            ajax		: {
                url : baseUrl+'/'+'data',
                type: "POST",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'type'  : 'expired'
                },
            },
            dom : 'tpi',
            columns: [
                { data : 'item_cd', name : 'item_cd', visible:false},
                { data : 'item_nm', name : 'item_nm', visible:true},
                { data : 'jenis', name : 'jenis', visible:true},
                { data : 'satuan', name : 'satuan', visible:true},
                { data : 'tanggal_masuk', name : 'tanggal_masuk', visible:true } ,
                { data : 'tanggal_expired', name : 'tanggal_expired', visible:true }
            ],
        });

        $(document).on('keyup', 'input[name=tanggal_expired_param]',function(){ 
            tabelStockExpired.column('#tanggal_expired_table').search($(this).val()).draw();
        });

        $('#reload-table').click(function(){
			$('input[name=tanggal_expired_param]').val('').trigger('keyup');
			tabelStockAlert.ajax.reload();
			tabelStockExpired.ajax.reload();
		});

        $('input[name=tanggal_expired_param]').val('{{ date("d/m/Y") }}').trigger('keyup');
		
		function loadStockExpired() {
			$("#tabel-stock-expired").dataTable().fnDestroy();
			
			tabelStockExpired = $('#tabel-stock-expired').DataTable({
				language: {
					paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'},
					emptyTable: 'Tidak ada data',
				},
				pagingType: "simple",
				processing	: true, 
				serverSide	: true, 
				order		: [], 
				ajax		: {
					url : baseUrl+'/'+'data',
					type: "POST",
					data: {
						'_token': $('meta[name="csrf-token"]').attr('content'),
						'type'  : 'expired'
					},
				},
				dom : 'tpi',
				columns: [
					{ data : 'item_cd', name : 'item_cd', visible:false},
					{ data : 'item_nm', name : 'item_nm', visible:true},
					{ data : 'jenis', name : 'jenis', visible:true},
					{ data : 'satuan', name : 'satuan', visible:true},
					{ data : 'tanggal_masuk', name : 'tanggal_masuk', visible:true } ,
					{ data : 'tanggal_expired', name : 'tanggal_expired', visible:true }
				],
			});
		}
		loadStockExpired();
		
		init();
    });
	
	function init() {
		if (unitCd != '') {
			$('select[name=pos_cd_param]').val(unitCd).trigger('change');
		} else {
			$('select[name=pos_cd_param]').val("{{ configuration('WHPOS_TRX') }}").trigger('change');
		}
		
		$('select[name=item_cd_param]').empty();
		$('select[name=item_cd_param]').select2({
			data:[{"id": "" ,"text":"=== Pilih Item ===" }] ,
			ajax : {
				url :  "{{ url('inventori/datalist') }}",
				dataType: 'json', 
				processResults: function(data){
					return {
						results: data
					};
				},
				cache : true,
			},
		});
	}
	
	function CheckUnit() {
		//--Cek unit
		var unitRoot = $('select[name=pos_cd_param]').val().split('-')[0];
		if (unitCd != '' && $('select[name=pos_cd_param]').val() != '') {
			if (unitCd != $('select[name=pos_cd_param]').val()) {
			//if (unitCd != $('select[name=pos_cd_param]').val() && unitCd != unitRoot) {
				swal({
					title: "Gudang tidak sesuai unit user !",
					type: "warning",
					showCancelButton: false,
					showConfirmButton: false,
					timer: 1000
				}).then(() => {
					swal.close();
				});

				return false;
			}
		} else {
			return true;
		}
	}
</script>
@endpush