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
                    <div class="col-md-6">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Nama Inventori</label>
                            <input name="search_param" id="search_param" placeholder="Pencarian Nama Inventori" class="form-control" data-fouc />
                        </div>
                    </div>
					 <div class="col-md-6">
						<div class="form-group form-group-float">
							<label class="form-group-float-label is-visible">Jenis Inventori </label>
							<select name="type_cd_param" id="type_cd_param" class="form-control form-control-select2 select-search" data-fouc>
								<option value="">=== Pilih Data ===</option>
								@foreach ($types as $item)
									<option value="{{ $item->type_cd}}">{{ $item->type_nm}}</option>
								@endforeach
							</select>
						</div>
					</div>
                </div>
                <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i> Tambah</button>
                <button type="button" class="btn btn-warning legitRipple" id="ubah"><i class="icon-pencil mr-2"></i> Ubah</button>
                <button type="button" class="btn btn-danger legitRipple" id="hapus"><i class="icon-trash mr-2"></i> Hapus</button>
                <button type="button" class="btn btn-success legitRipple" id="multi"><i class="icon-spinner4 mr-2"></i> Multi Satuan</button>
                {{-- <button type="button" class="btn btn-info legitRipple" id="formula"><i class="icon-lab mr-2"></i> Formula</button> --}}
				<br><br>
                <div class="table-responsive">
                    <table class="table table-single-select datatable-pagination" id="tabel-data" width="100%">
                        <thead>
                            <tr>
                                <th id="item_cd_table">Kode Inventori</th>
                                <th id="item_nm_table">Nama Inventori</th>
                                <th id="unit_cd_table">unit_cd_table</th>
                                <th id="unit_nm_table">Satuan</th>
                                <th id="type_cd_table">type_cd_table</th>
                                <th id="type_nm_table">Jenis</th>
                                <th id="item_price_buy_table">Harga Beli</th>
                                <!--<th id="item_price_table">Harga Jual</th>-->
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
                                <label class="form-group-float-label is-visible">Kode Inventori <span class="text-danger">*</span></label>
                                <input type="text" name="item_cd" class="form-control text-uppercase" required="" placeholder="" aria-invalid="false" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Nama Inventori <span class="text-danger">*</span></label>
                                <input type="text" name="item_nm" class="form-control" required="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
						<!--
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Root</label>
                                <select name="item_root" class="form-control form-control-select2 select-search" data-fouc>
                                    <option value=""> Pilih Item Root</option>
                                    @foreach ($roots as $item)
                                        <option value="{{ $item->item_cd}}">{{ $item->item_nm}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
						-->
                    </div>
                    <div class="row">
						<!--
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Konversi</label>
                                <input type="number" name="map_value" class="form-control" required=""  value="0" aria-invalid="false">
                            </div>
                        </div>
						-->
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Satuan Inventori <span class="text-danger">*</span></label>
                                <select name="unit_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                    <option value="">=== Pilih Data ===</option>
                                    @foreach ($units as $item)
                                        <option value="{{ $item->unit_cd}}">{{ $item->unit_nm}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Jenis Inventori</label>
                                <select name="type_cd" class="form-control form-control-select2 select-search" data-fouc>
                                    <option value="">=== Pilih Data ===</option>
                                    @foreach ($types as $item)
                                        <option value="{{ $item->type_cd}}">{{ $item->type_nm}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
					<!--
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Golongan Inventori</label>
                                <select name="golongan_cd" id="golongan_cd" class="form-control form-control-select2 select-search" data-fouc>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Sub Golongan Inventori</label>
                                <select name="golongansub_cd" id="golongansub_cd" class="form-control form-control-select2 select-search" data-fouc>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Kategori Inventori</label>
                                <select name="kategori_cd" id="kategori_cd" class="form-control form-control-select2 select-search" data-fouc>
                                </select>
                            </div>
                        </div>
                    </div>
					-->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Pajak</label>
                                <select name="vat_tp" class="form-control form-control-select2 select-search" data-fouc>
                                    {!! comCodeOptions('VAT_TP') !!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">PPN (%)</label>
                                <input type="number" name="ppn" class="form-control" min="0" max="100" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Harga Beli</label>
                                <input type="text" name="item_price_buy" class="form-control money" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                        <!--<div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Harga Jual <span class="text-danger">*</span></label>
                                <input type="text" name="item_price" class="form-control money" placeholder="" aria-invalid="false">
                            </div>
                        </div>-->
						<div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Stok Minimal</label>
                                <input type="text" name="minimum_stock" class="form-control money" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                    </div>
					<!--
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Dosis (Miligram)</label>
                                <input type="text" name="dosis" class="form-control money" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Stok Minimal</label>
                                <input type="text" name="minimum_stock" class="form-control money" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Stok Maksimal <span class="text-danger">*</span></label>
                                <input type="text" name="maximum_stock" class="form-control money" required="" placeholder="" aria-invalid="false">
                            </div>
                        </div>
                    </div>-->
                    <div class="row">
                        <!--<div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Principal</label>
                                <select name="principal_cd" class="form-control form-control-select2 select-search" data-fouc>
                                    <option value="">=== Pilih Data ===</option>
                                    @foreach ($principals as $item)
                                        <option value="{{ $item->principal_cd}}">{{ $item->principal_nm}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>-->
                        <div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Barang Inventori</label>
                                <div class="input-group">
                                    <input type="checkbox" id="checkbox_inventori" name="checkbox_inventori">
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-md-4">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Generik</label>
                                <div class="input-group">
                                    <input type="checkbox" id="checkbox_generik" name="checkbox_generik">
                                </div>
                            </div>
                        </div>-->
                    </div>
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan <i class="icon-floppy-disk ml-2"></i></button>
                        <button type="reset" class="btn btn-light legitRipple" id="reset">Selesai <i class="icon-reload-alt ml-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal satuan --}}
    <div class="modal fade" id="modal-satuan">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="satuan_title"> </h4>
					<p hidden="hidden" id="satuan_default"></p>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" data-toggle="validator" id="form-satuan"  enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <input type="hidden" name="satuan_item_cd" id="satuan_item_cd">
                                <input type="hidden" name="unit_cd_default" id="unit_cd_default">
                                <label class="form-group-float-label is-visible">Satuan</label>
                                <select name="unit_cd_satuan" id="unit_cd_satuan" class="form-control form-control-select2 select-search" required data-fouc>
                                    <option value="">=== Pilih Data ===</option>
                                    @foreach ($units as $item)
                                        <option value="{{ $item->unit_cd}}">{{ $item->unit_nm}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Jumlah</label>
                                <input type="number" name="satuan_conversion" id="satuan_conversion" class="form-control" required="" min="0" max="100" aria-invalid="false">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <button type="submit" name="submit" class="btn btn-primary btn-sm btn-flat" id="add-satuan"><i class="icon-add"></i></button>
                            </div>
                        </div>
                    </div>
					</form>
					<div class="table-responsive">
                        <table class="table table-single-select datatable-pagination" id="tabel-satuan" width="100%">
                            <thead>
                                <tr>
                                    {{-- <th id="item_cd_table">item_cd_table</th> --}}
                                    <th id="item_nm_table">item_nm_table</th>
                                    <th id="unit_item_cd_table">unit_item_cd_table</th>
                                    <th id="unit_item_nm_table">Satuan</th>
                                    <th id="konversi_table">Konversi</th>
                                    <th id="aksi_table">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-light legitRipple" data-dismiss="modal">Selesai <i class="icon-reload-alt ml-2"></i></button>
				</div>
			</div>
		</div>
	</div>
    {{-- ./modal satuan --}}
    {{-- modal formula --}}
	<!--
    <div class="modal fade" id="modal-formula">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="formula_title"> </h4>
					<p hidden="hidden" id="formula_default"></p>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" data-toggle="validator" id="form-formula"  enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <input type="hidden" name="formula_item_cd" id="formula_item_cd">
                                <label class="form-group-float-label is-visible">Formula</label>
                                <select name="formula_cd" id="formula_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                    <option value="">=== Pilih Data ===</option>
                                    @foreach ($formulas as $item)
                                        <option value="{{ $item->formula_cd}}">{{ $item->formula_nm}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Formula Utama</label>
                                <div class="input-group">
                                    <input type="checkbox" id="checkbox_formula" name="checkbox_formula">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Jumlah</label>
                                <input type="number" name="formula_content" id="formula_content" class="form-control" required="" min="0" max="100" aria-invalid="false">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <label class="form-group-float-label is-visible">Satuan</label>
                                <select name="formula_unit_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                    <option value="">=== Pilih Data ===</option>
                                    @foreach ($units as $item)
                                        <option value="{{ $item->unit_cd}}">{{ $item->unit_nm}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-float">
                                <button type="submit" name="submit" class="btn btn-primary btn-sm btn-flat" id="add-formula"><i class="icon-add"></i></button>
                            </div>
                        </div>
                    </div>
					</form>
					<div class="table-responsive">
                        <table class="table table-single-select datatable-pagination" id="tabel-formula" width="100%">
                            <thead>
                                <tr>
                                    <th id="formula_item_id_table">formula_item_id_table</th>
                                    <th id="formula_cd_table">Formula</th>
                                    <th id="content_table">Jumlah</th>
                                    <th id="unit_cd_table">Satuan</th>
                                    <th id="action_table">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-light legitRipple" data-dismiss="modal">Selesai <i class="icon-reload-alt ml-2"></i></button>
				</div>
			</div>
		</div>
	</div>
	-->
    {{-- ./modal formula --}}
@endsection
@push('scripts')
<script>
    var tabelData;
    var saveMethod  = 'tambah';
    var baseUrl     = "{{ url('inventori/daftar-inventori/') }}";
    var item_cd_satuan = "";
    var unit_cd_satuan = ""

    $(document).ready(function(){
        $('#bagian-form').hide();

        $('select[name=vat_tp]').change(function () {
            if ($(this).val() == 'VAT_TP_0') {
                $('input[name=ppn]').prop("readonly",true);
                $('input[name=ppn]').prop("required",false);
            }else{
                $('input[name=ppn]').prop("readonly",false);
                $('input[name=ppn]').prop("required",true);
                $('input[name=ppn]').focus();
            }
        });


        tabelData = $('#tabel-data').DataTable({
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
						columns: [0,1,3,5]
					},
					text:      '<i class="fa fa-file-excel-o"></i>',
					titleAttr: 'Excel'
				},
				{
					extend:    'pdfHtml5',
					exportOptions: {
						columns: [0,1,3,5]
					},
					text:      '<i class="fa fa-file-pdf-o"></i>',
					titleAttr: 'PDF',
					//orientation:'landscape',
					orientation:'portrait',
					pageSize: 	'A4',
					download: 	'open',
					customize: function (doc) {
						//--Header & Parameter
						var reportTitle =  'Data Inventori';

						//--Full width table
						//doc.content[1].table.widths =Array(doc.content[1].table.body[0].length + 1).join('*').split('');
						doc.content[1].table.widths = [50,220,60,170];
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
						columns: [0,1,3,5]
					},
					text:      '<i class="fa fa-print"></i>',
					titleAttr: 'Print'
				}
			],
            columns: [
                { data: 'item_cd', name: 'item_cd', visible:true },
                { data: 'item_nm', name: 'item_nm', visible:true },
                { data: 'unit_cd', name: 'unit_cd', visible:false },
                { data: 'unit_nm', name: 'unit_nm', visible:true },
                { data: 'type_cd', name: 'type_cd', visible:false },
                { data: 'type_nm', name: 'type_nm', visible:true },
                { data: 'item_price_buy', name: 'item_price_buy', visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' ) },
                //{ data: 'item_price', name: 'item_price', visible:true , render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' )},
            ],
        });

        $(document).on('keyup', '#search_param',function(){
            tabelData.column('#item_nm_table').search($(this).val()).draw();
        });
		$(document).on('change', '#type_cd_param',function(){
            tabelData.column('#type_cd_table').search($(this).val()).draw();
        });

        $('#reload-table').click(function(){
			$('input[name=search_param]').val('').trigger('keyup');
			$('select[name=type_cd_param]').val('').trigger('change');

			tabelData.ajax.reload();
		});

		/* tambah data */
        $('#tambah').click(function()   {
            saveMethod  ='tambah';

            $('input[name=minimum_stock]').val('0').trigger('input');
            $('input[name=maximum_stock]').val('0').trigger('input');
            $('input[name=checkbox_inventori]').prop('checked', true);
            $('input[name=checkbox_generik]').prop('checked', false);
            $('input[name=item_nm]').focus();
            $('input[name=item_cd]').val("{{$item_cd}}");
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
                var floor = Math.floor;

                $('input[name=item_cd]').val(rowData['item_cd']).prop('readonly',true);
                $('input[name=item_nm]').val(rowData['item_nm']);
                $('input[name=item_price]').val(parseInt(rowData['item_price'])).trigger('input');
                $('input[name=item_price_buy]').val(parseInt(rowData['item_price_buy'])).trigger('input');
                $('input[name=ppn]').val(floor(rowData['ppn'])).trigger('input');
                $('input[name=minimum_stock]').val(rowData['minimum_stock']).trigger('input');
                $('input[name=maximum_stock]').val(rowData['maximum_stock']).trigger('input');
                $('input[name=dosis]').val(floor(rowData['dosis'])).trigger('input');

                $('select[name=type_cd]').val(rowData['type_cd']).trigger('change');
                $('select[name=unit_cd]').val(rowData['unit_cd']).trigger('change');
                $('select[name=vat_tp]').val(rowData['vat_tp']).trigger('change');
                if (rowData['inventory_st'] == '1'){
                    $('input[name=checkbox_inventori]').prop('checked', true);
                }
				else {
					$('input[name=checkbox_inventori]').prop('checked', false);
				}
                if (rowData['generic_st'] == '1'){
                    $('input[name=checkbox_generik]').prop('checked', true);
                }
				else {
					$('input[name=checkbox_generik]').prop('checked', false);
				}

                $('#golongan_cd').empty();
                $('#golongan_cd').select2({
                    data:[{"id": rowData["golongan_cd"] ,"text":rowData["golongan_nm"]}] ,
                    ajax : {
                        url :  "{{ url('inventori/golongan/') }}",
                        dataType: 'json',
                        processResults: function(data){
                            return {
                                results: data
                            };
                        },
                        cache : true,
                    },
                });

                $('#kategori_cd').empty();
                $('#kategori_cd').select2({
                    data:[{"id": rowData["kategori_cd"] ,"text":rowData["kategori_nm"]}] ,
                    ajax : {
                        url :  "{{ url('inventori/kategori/') }}",
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

        /*multi satuan */
        $(document).on('click', '#multi',function(){
            if (dataCd == null) {
                swal({
                    title: "Pilih Data!",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1000
                });
            }else{
                //summon datatable
                tabelSatuan = $('#tabel-satuan').DataTable({
                    language: {
                        paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
                    },
                    pagingType: "simple",
                    processing	: true,
                    serverSide	: true,
                    bDestroy    : true,
                    order		: [],
                    ajax		: {
                        url: baseUrl+'/'+'data-satuan',
                        type: "POST",
                        data: {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'item_cd' : rowData['item_cd'],
                        },
                    },
                    dom : 'tpi',
                    columns: [
                        //{ data: 'item_cd', name: 'item_cd', visible:false },
                        { data: 'item_nm', name: 'item_nm', visible:false },
                        { data: 'unit_item_cd', name: 'unit_item_cd', visible:false },
                        { data: 'unit_item_nm', name: 'unit_item_nm', visible:true },
                        { data: 'konversi', name: 'konversi', visible:true },
                        { data: 'action', name: 'action', visible:true },
                    ],
                });
                //summon modal
                $('input[name="satuan_item_cd"]').val(rowData["item_cd"]);
			    $('input[name="unit_cd_default"]').val(rowData["unit_cd"]);
                $('#modal-satuan').modal('show');
            }
        });

        /*simpan multi satuan */
        $('#form-satuan').submit(function(e){
			if (e.isDefaultPrevented()) {
			// handle the invalid form...
			} else {
				e.preventDefault();
				var record=$('#form-satuan').serialize();

				swal({
				    title               : 'Simpan Data?',
                    type                : "question",
                    showCancelButton    : true,
                    confirmButtonColor  : "#00a65a",
                    confirmButtonText   : "Ya",
                    cancelButtonText    : "Tidak",
                    allowOutsideClick : false,
				}).then(function(result){
					if (result.value) {
						swal({allowOutsideClick : false,title: "Menyimpan Data",onOpen: () => {swal.showLoading();}});
						$.ajax({
                            'type': 'POST',
                            'url' : baseUrl + '/' +'satuan',
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
                                        reset('satuan');
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

        /*hapus multi satuan */
        $(document).on('click', '#hapus-satuan',function(){
            unit_item_cd    = rowData['unit_item_cd'];
            item_cd         = $('#satuan_item_cd').val();
            console.log(rowData);
            console.log($('#satuan_item_cd').val());
            var dataMultiSatuan = {
                '_token'            : $('meta[name="csrf-token"]').attr('content'),
                'unit_item_cd'      : unit_item_cd,
                'item_cd'           : item_cd,
            };
            swal({
				    title               : 'Hapus Data?',
                    type                : "question",
                    showCancelButton    : true,
                    confirmButtonColor  : "#00a65a",
                    confirmButtonText   : "Ya",
                    cancelButtonText    : "Tidak",
                    allowOutsideClick : false,
				}).then(function(result){
					if (result.value) {
						swal({allowOutsideClick : false,title: "Menghapus Data",onOpen: () => {swal.showLoading();}});
						$.ajax({
                            'type': 'POST',
                            'url' : baseUrl + '/' +'delete-satuan',
                            'data': dataMultiSatuan,
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
                                        reset('satuan');
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

        });

        /*formula */
        $(document).on('click', '#formula',function(){
            if (dataCd == null) {
                swal({
                    title: "Pilih Data!",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1000
                });
            }else{
                //summon datatable
                tabelFormula = $('#tabel-formula').DataTable({
                    language: {
                        paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
                    },
                    pagingType: "simple",
                    processing	: true,
                    serverSide	: true,
                    bDestroy    : true,
                    order		: [],
                    ajax		: {
                        url: baseUrl+'/'+'data-formula',
                        type: "POST",
                        data: {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'item_cd' : rowData['item_cd'],
                        },
                    },
                    dom : 'tpi',
                    columns: [
                        { data: 'formula_item_id', name: 'formula_item_id', visible:false },
                        { data: 'formula_cd', name: 'formula_cd', visible:true },
                        { data: 'content', name: 'content', visible:true },
                        { data: 'unit_cd', name: 'unit_cd', visible:true },
                        { data: 'action', name: 'action', visible:true },
                    ],
                });
                //summon modal
                $('input[name="formula_item_cd"]').val(rowData["item_cd"]);
			    // $('input[name="unit_cd_default"]').val(rowData["unit_cd"]);
                $('#modal-formula').modal('show');
            }
        });
        /*simpan formula */
        $('#form-formula').submit(function(e){
			if (e.isDefaultPrevented()) {
			// handle the invalid form...
			} else {
				e.preventDefault();
				var record=$('#form-formula').serialize();
                console.log(record);

				swal({
				    title               : 'Simpan Data?',
                    type                : "question",
                    showCancelButton    : true,
                    confirmButtonColor  : "#00a65a",
                    confirmButtonText   : "Ya",
                    cancelButtonText    : "Tidak",
                    allowOutsideClick : false,
				}).then(function(result){
					if (result.value) {
						swal({allowOutsideClick : false,title: "Menyimpan Data",onOpen: () => {swal.showLoading();}});
						$.ajax({
                            'type': 'POST',
                            'url' : baseUrl + '/' +'formula',
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
                                        reset('formula');
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
        /*hapus formula */
        $(document).on('click', '#hapus-formula',function(){
            formula_item_id    = rowData['formula_item_id'];
            var dataFormula = {
                '_token'            : $('meta[name="csrf-token"]').attr('content'),
                'formula_item_id'   : formula_item_id,
            };
            console.log(dataFormula);
            swal({
				    title               : 'Hapus Data?',
                    type                : "question",
                    showCancelButton    : true,
                    confirmButtonColor  : "#00a65a",
                    confirmButtonText   : "Ya",
                    cancelButtonText    : "Tidak",
                    allowOutsideClick : false,
				}).then(function(result){
					if (result.value) {
						swal({allowOutsideClick : false,title: "Menghapus Data",onOpen: () => {swal.showLoading();}});
						$.ajax({
                            'type': 'POST',
                            'url' : baseUrl + '/' +'delete-formula',
                            'data': dataFormula,
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
                                        reset('formula');
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

        });


        /*cek kode*/
        $('input[name=item_cd]').focusout(function(){
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
                            $('input[name=item_cd]').val('');
                            $('input[name=item_cd]').focus();
                            swal.close();
                        });
                    }
                });
            }
        });

        $('#golongan_cd').empty();
        $('#golongan_cd').select2({
            // data:[{"id": "" ,"text":""}] ,
            ajax : {
                url :  "{{ url('inventori/golongan/') }}",
                dataType: 'json',
                processResults: function(data){
                    return {
                        results: data
                    };
                },
                cache : true,
            },
        });

        $('#golongansub_cd').empty();
        $('#golongan_cd').on('change', function(){
            $('#golongansub_cd').empty();
            $('#golongansub_cd').select2({
                ajax : {
                    url :  "{{ url('inventori/golongan/') }}" + '/' + $(this).val(),
                    dataType: 'json',
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                    cache : true,
                },
            });
        });

        $('#kategori_cd').empty();
        $('#kategori_cd').select2({
            // data:[{"id": " ,"text":""}] ,
            ajax : {
                url :  "{{ url('inventori/kategori/') }}",
                dataType: 'json',
                processResults: function(data){
                    return {
                        results: data
                    };
                },
                cache : true,
            },
        });

        $('select[name=vat_tp]').val('VAT_TP_0').trigger('change');
    });

    function reset(type) {
        switch(type){
            case 'satuan':
                var ox = $('#tabel-satuan').DataTable();
		        ox.ajax.reload();
                $("#unit_cd_satuan").val('').change();
		        $('input[name=satuan_conversion]').val(0);
                break;
            case 'formula':
                var o = $('#tabel-formula').DataTable();
		        o.ajax.reload();
                $("#formula_cd").val('').change();
                $("#formula_unit_cd").val('').change();
		        $('input[name=formula_content]').val(0);
                break;
            default:
				saveMethod  ='';
                dataCd = null;
                rowData = null;
                tabelData.ajax.reload();

                $('#bagian-tabel').show();
                $('#bagian-form').hide();
                $('input[name=item_cd]').val('').prop('readonly',false);
                $('input[name=item_nm]').val('');
                $('input[name=item_price_buy]').val('');
                $('input[name=item_price_sell]').val('');
                $('select[name=type_cd]').val('').trigger('change');
                $('select[name=unit_cd]').val('').trigger('change');
                //$('select[name=vat_tp]').val('').trigger('change');
                $('input[name=checkbox_inventori]').prop('checked', true);
                //$('input[name=checkbox_generik]').prop('checked', false);

                $('.card-title').text('Data Inventori');
        }
    }
</script>
@endpush
