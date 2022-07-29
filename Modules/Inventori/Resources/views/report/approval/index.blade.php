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
            <div class="row">
				<div class="col-md-4">
					<div class="form-group form-group-float">
						<select name="cc_cd_param" id="cc_cd_param" class="form-control" data-fouc>
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
                            <th id="po_cd_table">po_cd_table</th>
                            <th id="po_no_table">Nomor</th>
                            <th id="supplier_cd_table">supplier_cd_table</th>
                            <th id="supplier_nm_table">Supplier</th>
                            <th id="trx_date_table">Tanggal</th>
							<th id="dana_tp_table">Sumber Dana</th>
                            <th id="dana_tp_nm_table">Sumber Dana</th>
                            <th id="unit_cd_table">Unit</th>
							<th id="total_amount_table">Total</th>
							<th id="po_st_table">po_st_table</th>
                            <th id="po_st_nm_table">Status</th>
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
    var baseUrl     = "{{ url('inventori/report/approval/') }}";
	var unitCd		= "{{ Auth::user()->unit_cd ?? '' }}";

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
						columns: [1,3,4,6,7,8,10]
					},
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'pdfHtml5',
					exportOptions: {
						columns: [1,3,4,6,7,8,10]
					},
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF',
					orientation:'landscape',
					//orientation:'portrait',
					pageSize: 	'A4',
					download: 	'open',
					customize: function (doc) {
						//--Header & Parameter
						var unitSelect = '';
							if ($("#cc_cd_param option:selected").val() != '') {
								unitSelect = $("#cc_cd_param option:selected").val();
							}
						var tanggalSelect = $('input[name=tanggal_param]').val();	
						var reportTitle =  'Laporan Approval ' + tanggalSelect + ' | ' + unitSelect;	
												
						//--Full width table
						//doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
						doc.content[1].table.widths = [60,160,60,100,120,100,120];
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
						columns: [1,3,4,6,7,8,10]
					},
					text:      '<i class="fa fa-print"></i>',
					titleAttr: 'Print'
				}
			],
            columns: [
                { data: 'po_cd', name:'po_cd', visible:false},
                { data: 'po_no', name:'po_no', visible:true},
                { data: 'supplier_cd', name:'supplier_cd', visible:false},
                { data: 'supplier_nm', name:'supplier_nm', visible:true},
                //{ data: 'trx_date', name:'trx_date', visible:true},
				{ data: 'trx_date', name:'trx_date', 
					'render': function (data, type, full, meta) {
						if (data != null) {
							return moment(data).format('DD/MM/YYYY');
						}
						else {
							return '';
						}
					}, 
					visible:true},
				{ data: 'dana_tp', name:'dana_tp', defaultValue : '',visible:false},
                { data: 'dana_tp_nm', name:'dana_tp_nm', defaultValue : '',visible:true},	
                { data: 'unit_cd', name:'unit_cd', visible:true},
				{ data: 'total_amount', name: 'total_amount', visible:true, render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' ), className: "text-right"},
				{ data: 'po_st', name:'po_st', visible:false},
                { data: 'po_st_nm', name:'po_st_nm', visible:true},
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

        $(document).on('change', '#cc_cd_param',function(){
			if ($('select[name=cc_cd_param]').val() != '') {
				if (CheckUnit()) {
					tabelData.column('#unit_cd_table').search("^" + $(this).val() + "$", true, false).draw();
				} else {
					tabelData.column('#unit_cd_table').search(unitCd).draw();
				}
			} else {
				if (unitCd == '') {
					tabelData.column('#unit_cd_table').search($(this).val()).draw();
				} else {
					tabelData.column('#unit_cd_table').search(unitCd).draw();
				}
			}	
        });
		
        $('input[name="tanggal_param"]').change(function() {
			tabelData.ajax.reload();
		});
        
        $('#reload-table').click(function(){
			setDaterange();
			$('select[name=cc_cd_param]').val('').trigger('change');
			
			tabelData.ajax.reload();
		});
		
		setDaterange();
		init();
    });
	
	function init() {
		var cc_cd = '';
		var cc_nm = '=== Pilih Unit ===';
		if (unitCd != '') {
			cc_cd = unitCd;
			cc_nm = unitCd;
		}
		$('#cc_cd_param').empty();
		$('#cc_cd_param').select2({
			data:[{"id": cc_cd ,"text": cc_nm }] ,
			ajax : {
				url :  "{{ url('/e-general-ledger/dropdown-data/cost-center') }}",
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
	
	function setDaterange() {
		$('input[name="tanggal_param"]').daterangepicker({
			//timePicker: true,
			startDate: moment("{{ date('Y') }}/{{ date('m') }}/1"),
			endDate: moment("{{ date('Y/m/d') }}"),
			locale: {format: 'DD/MM/YYYY'}
		});
	}
	
	function CheckUnit() {
		//--Cek unit
		if (unitCd != '' && $('select[name=cc_cd_param]').val() != '') {
			if (unitCd != $('select[name=cc_cd_param]').val()) {
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