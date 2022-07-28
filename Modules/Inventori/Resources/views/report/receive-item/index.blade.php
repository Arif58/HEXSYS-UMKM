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
            <div class="row">
				<div class="col-md-4">
                    <div class="form-group form-group-float">
                        <select name="supplier_cd_param" id="supplier_cd_param" class="form-control form-control-select2 select-search" required data-fouc>
                            <option value="">=== Pilih Supplier ===</option>
                            @foreach ($suppliers as $item)
                                <option value="{{ $item->supplier_cd}}">{{ $item->supplier_nm}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-float">
                        <input type="text" name="tanggal_param" class="form-control daterange-single" data-value="{{ date('Y/m/d') }}" readonly="readonly" placeholder="" aria-invalid="false" />
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table datatable-pagination" id="tabel-data" width="100%">
                    <thead>
                        <tr>
                            <th id="ri_cd_table">ri_cd_table</th>
                            <th id="ri_no_table">Nomor</th>
                            <th id="supplier_cd_table">supplier_cd_table</th>
                            <th id="supplier_nm_table">Supplier</th>
                            <th id="entry_date_table">Tanggal</th>
                            <th id="ri_st_table">ri_st_table</th>
                            <th id="ri_st_nm_table">Status</th>
							<th id="item_cd_table">Item</th>
							<th id="item_nm_table" width="20%">Barang</th>
							<th id="quantity_table">Jumlah</th>
							<th id="unit_cd_table">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script>
    var tabelData;
    var baseUrl     = "{{ url('inventori/report/receive/') }}";

    $(document).ready(function(){
        
        tabelData = $('#tabel-data').DataTable({
            processing	: true, 
            serverSide	: true, 
            order		: [], 
            ajax		: {
                url: baseUrl+'/data',
                type: "POST",
                data : function(d){
                    d._token        = $('meta[name="csrf-token"]').attr('content');
					d.tanggal_param	= $('input[name=tanggal_param]').val();
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
						columns: [1,3,4,6,8,9,10]
					},
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'pdfHtml5',
					exportOptions: {
						columns: [1,3,4,6,8,9,10]
					},
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF',
					orientation:'landscape',
					//orientation:'portrait',
					pageSize: 	'A4',
					download: 	'open',
					customize: function (doc) {
						//--Header & Parameter
						var supplierSelect = '';
							if ($("#supplier_cd_param option:selected").val() != '') {
								supplierSelect = $("#supplier_cd_param option:selected").text();
							}	
						var tanggalSelect = $('input[name=tanggal_param]').val();	
						var reportTitle =  'Laporan Penerimaan Barang ' + tanggalSelect + ' | ' + supplierSelect;	
												
						//--Full width table
						//doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
						doc.content[1].table.widths = [60,150,80,80,200,50,50];
						var rowCount = doc.content[1].table.body.length;
						for (i = 1; i < rowCount; i++) {
							doc.content[1].table.body[i][0].alignment = 'left';
							doc.content[1].table.body[i][1].alignment = 'left';
							doc.content[1].table.body[i][2].alignment = 'left';
							doc.content[1].table.body[i][3].alignment = 'left';
							doc.content[1].table.body[i][4].alignment = 'left';
							doc.content[1].table.body[i][5].alignment = 'right';
							doc.content[1].table.body[i][6].alignment = 'left';
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
						columns: [1,3,4,6,8,9,10]
					},
					text:      '<i class="fa fa-print"></i>',
					titleAttr: 'Print'
				}
			],
            columns: [
                { data: 'ri_cd', name:'ri_cd', visible:false},
                { data: 'ri_no', name:'ri_no', visible:true},
                { data: 'supplier_cd', name:'supplier_cd', visible:false},
                { data: 'supplier_nm', name:'supplier_nm', visible:true},
                { data: 'entry_date', name:'entry_date', 
					'render': function (data, type, full, meta) {
						if (data != null) {
							return moment(data).format('DD/MM/YYYY');
						}
						else {
							return '';
						}
					}, 
					visible:true},
                { data: 'ri_st', name:'ri_st', visible:false},
                { data: 'ri_st_nm', name:'ri_st_nm', visible:true},
				{ data: 'item_cd', name:'item_cd', visible:false},
				{ data: 'item_nm', name:'item_nm', visible:true},
				{ data: 'quantity', name: 'quantity', visible:true, render: $.fn.dataTable.render.number( '.', ',', 0, '' ), className: "text-right"},
				{ data: 'unit_cd', name:'unit_cd', visible:true},
            ],
        });
		
		tabelData.on( 'draw', function () {
			var key = '';
			var next = '';
			tabelData.rows().every(function(rowIdx, tableLoop, rowLoop){
				if (rowIdx != 0) {
					next = tabelData.cell(rowIdx,0).data();
					
					if (next == key) {
						tabelData.cell(rowIdx,1).data('');
						tabelData.cell(rowIdx,3).data('');
						//tabelData.cell(rowIdx,4).data('');
						tabelData.cell(rowIdx,6).data('');
					}
					else {
						key = tabelData.cell(rowIdx,0).data();
					}
				}
				else {
					key = tabelData.cell(rowIdx,0).data();
				}
			});
		});
		
		$(document).on('change', '#supplier_cd_param',function(){
			tabelData.column('#supplier_cd_table').search($(this).val()).draw();
        });

        $('input[name="tanggal_param"]').change(function() {
			tabelData.ajax.reload();
		});
        
        $('#reload-table').click(function(){
			setDaterange();
			$('select[name=supplier_cd_param]').val('').trigger('change');
			
			tabelData.ajax.reload();
		});
		
		setDaterange();
    });
	
	function setDaterange() {
		$('input[name="tanggal_param"]').daterangepicker({
			//timePicker: true,
			startDate: moment("{{ date('Y') }}/{{ date('m') }}/1"),
			endDate: moment("{{ date('Y/m/d') }}"),
			locale: {format: 'DD/MM/YYYY'}
		});
	}
</script>
@endpush