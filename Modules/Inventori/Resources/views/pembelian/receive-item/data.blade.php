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
            <form class="form-validate-jquery" id="form-isian" method="POST" action="{{ url('inventori/pembelian/receive-item/') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-group-float-label is-visible">Nomor</label>
                        <div class="form-group form-group-float">
                            {{--<input name="ri_no" id="ri_no" class="form-control" required data-fouc value="{{ $defaultNo }}" placeholder="Kosong : nomor akan di-generate sistem" />--}}
							<input name="ri_no" id="ri_no" class="form-control" data-fouc placeholder="Kosong : nomor akan di-generate sistem" />
                        </div>
                    </div>
					<!--
                    <div class="col-md-4">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Principal</label>
                            <select name="principal_cd" id="principal_cd" class="form-control form-control-select2 select-search" data-fouc>
                                <option value="">=== Pilih Data ===</option>
                                @foreach ($principals as $item)
                                    <option value="{{ $item->principal_cd}}">{{ $item->principal_nm }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
					-->
                    <div class="col-md-4">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Supplier <span class="text-danger">*</span></label>
                            <select name="supplier_cd" id="supplier_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                <option value="">=== Pilih Supplier ===</option>
                                @foreach ($suppliers as $item)
                                    <option value="{{ $item->supplier_cd}}">{{ $item->supplier_nm}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-group-float-label is-visible">Tanggal</label>
                        <div class="form-group form-group-float">
                            {{--<input name="trx_date" id="trx_date" class="form-control mask-date" placeholder="DD/MM/YYYY" required data-fouc value="{{ date('d/m/Y') }}" />--}}
							<input name="trx_date" id="trx_date" class="form-control date-picker" required data-fouc value="{{ date('d/m/Y') }}" />
                        </div>
                    </div>
					<div id="input-01"><!--Input Advanced-->
                    <div class="col-md-4">
                        <label class="form-group-float-label is-visible">PPN</label>
                        <div class="form-group form-group-float">
                            <input type="number" name="percent_ppn" id="percent_ppn" class="form-control" required data-fouc value="10"/>
                        </div>
                    </div>
					<script type='text/javascript'>
					$(document).ready(function(){
						$("#input-01").hide();
					});
					</script>
					</div><!--Input Advanced-->
                    <div class="col-md-4">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Gudang <span class="text-danger">*</span></label>
                            <select name="pos_cd" id="pos_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                <option value="">=== Pilih Gudang ===</option>
                                @foreach ($gudangs as $item)
                                    <option value="{{ $item->pos_cd}}">{{ $item->pos_nm}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label class="form-group-float-label is-visible">No Invoice</label>
                        <div class="form-group form-group-float">
                            <input name="invoice_no" id="invoice_no" class="form-control" data-fouc  />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Catatan</label>
                            <textarea name="note" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <hr>

                @if(!$receive)
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan <i class="icon-floppy-disk ml-2"></i></button>
                    </div>
                @endif
            </form>

            @if ($receive) 
                @if($receive->ri_st == 'INV_TRX_ST_1')
                    <form class="form-validate-jquery" id="form-item">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Kode Item</label>
                                <div class="form-group form-group-float">
                                    <select name="item_cd" id="item_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Jumlah</label>
                                <div class="form-group form-group-float">
                                    <input type="number" name="quantity" id="quantity" class="form-control" required data-fouc value="0"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">No Faktur</label>
                                <div class="form-group form-group-float">
                                    <input name="faktur_no" id="faktur_no" class="form-control" data-fouc/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Nama Item </label>
                                <div class="form-group form-group-float">
                                    <input name="item_nm" id="item_nm" class="form-control" readonly data-fouc/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Harga Satuan</label>
                                <div class="form-group form-group-float">
                                    <input type="number" name="unit_price" id="unit_price" class="form-control" required data-fouc value="0"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">No Batch</label>
                                <div class="form-group form-group-float">
                                    <input name="batch_no" id="batch_no" class="form-control" data-fouc/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Satuan</label>
                                <div class="form-group form-group-float">
                                    <select name="unit_cd" id="unit_cd" class="form-control form-control-select2 select-search" required data-fouc>
                                        <option value="">=== Pilih Data ===</option>
                                        @foreach ($units as $item)
                                            <option value="{{ $item->unit_cd}}">{{ $item->unit_nm}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Total</label>
                                <div class="form-group form-group-float">
                                    <input type="number" name="trx_amount" id="trx_amount" class="form-control" required data-fouc value="0"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Tanggal Faktur</label>
                                <div class="form-group form-group-float">
                                    {{--<input name="faktur_date" id="faktur_date" class="form-control mask-date" placeholder="DD/MM/YYYY" required data-fouc value="{{ date('d/m/Y') }}" />--}}
									<input name="faktur_date" id="faktur_date" class="form-control date-picker" required data-fouc value="{{ date('d/m/Y') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                            </div>
                            <div class="col-md-4">
                                <label class="form-group-float-label is-visible">Tanggal Expired</label>
                                <div class="form-group form-group-float">
                                    {{--<input name="expire_date" id="expire_date" class="form-control mask-date" placeholder="DD/MM/YYYY" required data-fouc value="{{ date('d/m/Y') }}" />--}}
									<input type="text" name="expire_date" id="expire_date" class="form-control mask-date" placeholder="DD/MM/YYYY" aria-invalid="false">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center">
                            <button type="button" id="load-po" class="btn btn-info ml-3 legitRipple"><i class="icon-folder-open2"></i> Load Purchase Order</button>
                            <button type="submit" class="btn btn-primary ml-3 legitRipple"><i class="icon icon-plus-circle2"></i> Tambah Item</button>
                        </div>
                    </form>
                @endif
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-float">
                            <input name="item_nm_param" id="item_nm_param" placeholder="Pencarian Nama" class="form-control" data-fouc />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-float">
                            <select name="unit_cd_param" id="unit_cd_param" class="form-control form-control-select2 select-search" data-fouc>
                                    <option value=""> Pilih Satuan Inventori</option>
                                    @foreach ($units as $item)
                                        <option value="{{ $item->unit_cd}}">{{ $item->unit_nm}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table datatable-pagination" id="tabel-data" width="100%">
                        <thead>
                            <tr>
                                <th id="po_receive_detail_id_table">po_receive_detail_id_table</th>
                                <th id="item_cd_table">item_cd_table</th>
                                <th id="item_nm_table">Nama Barang</th>
                                <th id="unit_cd_table">unit_cd_table</th>
                                <th id="unit_nm_table">Satuan</th>
                                <th id="quantity_table">Jumlah</th>
                                <th id="unit_price_table">Harga Satuan</th>
                                <th id="discount_percent_table">Diskon (%)</th>
                                <th id="discount_amount_table">Diskon</th>
                                <th id="trx_amount_table">Total</th>
                                <th id="faktur_no_table">No Faktur</th>
                                <th id="faktur_date_table">Tanggal Faktur</th>
                                <th id="batch_no_table">No Batch</th>
                                <th id="expire_date_table">Tanggal Kadaluarsa</th>
                                <th id="action_table">#</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-lg-2">PPN</label>
                    <div class="col-lg-10">
                        <input type="text" name="ppn" class="form-control form-control-lg">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-lg-2">Total Discount</label>
                    <div class="col-lg-10">
                        <input type="text" name="total_discount" class="form-control form-control-lg">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-form-label-lg col-lg-2">Total</label>
                    <div class="col-lg-10">
                        <input type="text" name="total_amount" class="form-control form-control-lg">
                    </div>
                </div>
            @endif
        </div>
        
        <div class="card-footer">
            @if(!empty($receive))
                @if($receive->ri_st == 'INV_TRX_ST_1')
                    <button type="button" class="btn btn-warning legitRipple" id="proses"><i class="icon-check mr-2"></i>Proses Penerimaan Barang</button>
                    <button type="button" class="btn btn-danger legitRipple" id="hapus"><i class="icon-trash mr-2"></i>Hapus Penerimaan Barang</button>
                @endif
                    <button type="button" class="btn btn-success legitRipple" id="print"><i class="icon-printer mr-2"></i>Cetak Penerimaan Barang</button>
                
            @endif
            <button type="reset" class="btn btn-light legitRipple" id="reset"><i class="icon-reload-alt mr-2"></i> Kembali </button>
        </div>
    </div>
    <div class="modal fade" id="modal-load-po">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Load PO</h4>
                    <input type="hidden" name="id_PO">
                    <input type="hidden" name="tanggal">
                    <input type="hidden" name="item_nm">
                    <input type="hidden" name="quantity">
                    <input type="hidden" name="unit_price">
                    <input type="hidden" name="unit_nm">
                    <input type="hidden" name="unit_kode">
                    <input type="hidden" name="item_kode">
                </div>
                <div class="modal-body" >
                    <div class="table-responsive" id="table-partner-list">
                        <table class="table table-single-select datatable-pagination" id="tabel-po-kiri" style="width: 100%">
                        <!-- <table class="table table-single-select datatable-pagination" id="tabel-po-kiri" width="100%"> -->
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>No. PO</th>
                                    <th>kode item</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>kode unit</th>
                                    <th>Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row" style="margin-top:4px;">
                                <div class="col-md-3">
                                    <!-- <button class="btn btn-primary btn-flat btn-block btn-move btn-flat" data-target="right"><i class="icon-download" id="singleMoveRight"></i></button> -->
                                </div>
                                <div class="col-md-3">
                                    <!-- <button class="btn btn-primary btn-flat btn-block btn-move-all btn-flat" data-toggle="move-data" data-target="right-all"><i class="fa fa-angle-double-down fa-2x" ></i></button> -->
                                </div>
                                <div class="col-md-3">
                                    <!-- <button class="btn btn-danger btn-flat btn-block btn-remove-all btn-flat" ><i class="fa fa-angle-double-up fa-2x"></i></button> -->
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary btn-flat btn-tambah btn-move btn-flat" data-target="right"><i class="icon-download" id="singleMoveRight"></i></button>
                                </div>
                            </div>
                        </div>
                    <!-- </div>
                    <div class="table-responsive" id="table-partner-list">
                        <table class="table table-striped" id="tabel-po-kanan" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>No.PO</th>
                                    <th>kode item</th>
                                    <th>Item</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>kode unit</th>
                                    <th>Satuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal"><i class="fa fa-remove"></i> Tutup</button>
                    <!-- <button type="submit" class="btn btn-primary btn-move-down btn-sm btn-flat"><i class="fa fa-plus"></i> Tambah</button> -->
                </div>
            </div>
        </div><!-- end row -->
    </div>

@endsection
@push('scripts')
<!-- <style>
    th.right-text{
        text-align: center;
    }
    .right-text{
        text-align: right;
    }
    .th-right-text{
    	text-align: center;;
    }
    .row_selected{
		color:red;
	}
	.selected{
		background-color: #B0BED9 !important;
	}
</style> -->
<script src="/global_assets/js/plugins/pickers/daterangepicker.js"></script>
<script src="/plugins/cell-edit/cell-edit.js"></script>
<script>
    // Basic initialization
    $('.daterange-basic').daterangepicker({
        showDropdowns: true,
        applyClass: 'bg-slate-600',
        cancelClass: 'btn-light',
        locale: {
            format: "DD/MM/YYYY",
            separator: "-",
        }
    });

    var tabelData;
    var dataCdReceive  = "";
    var baseUrl = "{{ url('inventori/pembelian/receive-item/') }}";

    $(document).ready(function(){

        $('#reset').click(function(){
           window.location=baseUrl;
        });

        @if($receive)
            dataCdReceive  = "{{ $receive->ri_cd }}";
            $('select[name=supplier_cd]').val("{{ $receive->supplier_cd }}").trigger('change').attr("disabled", true);
            $('select[name=principal_cd]').val("{{ $receive->principal_cd }}").trigger('change').attr("disabled", true);
            $('select[name=pos_cd]').val("{{ $receive->pos_cd }}").trigger('change').attr("disabled", true);

            $('input[name=ri_no]').val("{{ $receive->ri_no }}").trigger('keyup').attr("readonly", true);
            
			//$('input[name=trx_date]').val("{{ $receive->trx_date }}").trigger('keyup').attr("readonly", true);
			$('input[name=trx_date]').val("{{ date_format(date_create($receive->trx_date), "d/m/Y") }}").trigger('keyup').attr("readonly", false);
			
            $('input[name=percent_ppn]').val("{{ $receive->percent_ppn }}").trigger('keyup').attr("readonly", true);
            $('input[name=invoice_no]').val("{{ $receive->invoice_no }}").trigger('keyup').attr("readonly", true);
            $('textarea[name=note]').val('{{ $receive->note }}').prop("readonly", true);

            $('input[name=ppn]').val('Rp '+spelling('{{ $receive->ppn }}')).attr('readonly', true);  
            $('input[name=total_amount]').val('Rp '+spelling('{{ $receive->total_amount }}')).attr('readonly', true); 
            $('input[name=total_discount]').val('Rp '+spelling('{{ $receive->total_discount }}')).attr('readonly', true); 

            tabelData = $('#tabel-data').DataTable({
                language: {
                    paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
                },
                pagingType: "simple",
                processing	: true, 
                serverSide	: false, 
                // order		: [[7,'ASC'], [2, 'ASC']], 
                ajax		: {
                    url : baseUrl+'/'+'data',
                    type: "POST",
                    data: function(data){
                        data._token = $('meta[name="csrf-token"]').attr('content');
                        data.type   = 'detail';
                        data.id     = dataCdReceive;
                    },
                },
                dom : 'tpi',
                columns: [
                    {name: "po_receive_detail_id", data: "po_receive_detail_id", visible:false},
                    {name: "item_cd", data: "item_cd", visible:false},
                    //{name: "item_nm", data: "item_nm", visible:true},
					{name: "item_nm", data: null,
						"render": function ( data, type, row ) {
							if (data.item_cd == null) {
								return data.item_desc;
							}
							else {
								return data.item_nm;
							}
						}
					},
					
                    {name: "unit_cd", data: "unit_cd", visible:false},
                    {name: "unit_nm", data: "unit_nm", visible:true},
                    {name: "quantity", data: "quantity", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
                    {name: "unit_price", data: "unit_price", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' )},
                    {name: "discount_percent", data: "discount_percent", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
                    {name: "discount_amount", data: "discount_amount", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' )},
                    {name: "trx_amount", data: "trx_amount", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' )},
                    {name: "faktur_no", data: "faktur_no", visible:true},
                    {name: "faktur_date", data: "faktur_date", visible:true},
                    {name: "batch_no", data: "batch_no", visible:true},
                    {name: "expire_date", data: "expire_date", visible:true},
                    {data: "action", visible:true, orderable: false, searchable: false, className: "text-center"},
                ],
            });

            $(document).on('keyup', '#item_nm_param',function(){ 
                tabelData.column('#item_nm_table').search($(this).val()).draw();
            });

            $(document).on('change', '#unit_cd_param',function(){ 
                tabelData.column('#unit_cd_table').search($(this).val()).draw();
            });

            $('select[name=item_cd]').empty();
            $('select[name=item_cd]').select2({
                ajax : {
                    url :  "{{ url('inventori/datalist') }}",
                    dataType: 'json', 
                    processResults: function(data){
                        return {
                            results: data
                        };
                    },
                    cache : true,
                    success: function(response){
                        $('select[name=item_cd]').on('select2:select', function (evt) {
                            var selected = evt.params.data;
                            // $('input[name=item_nm]').val(selected.text);
                            $('input[name=item_nm]').val(selected.text).trigger('keyup');
                            $('input[name=unit_price]').val(selected.item_price).trigger('keypress');
                            $('select[name=unit_cd]').val(selected.unit_cd).trigger('change').attr("readonly", true);
                            $('select[name=unit_cd] option:not(:selected)').attr('disabled', true);
                        });
                    }
                },
            });

            $('#reload-table').click(function(){
                $('input[name=search_param]').val('').trigger('keyup');
                tabelData.ajax.reload();
            });

            @if($receive->ri_st == 'INV_TRX_ST_1')
                function myCallbackFunction (updatedCell, updatedRow, oldValue) {
                    var rowData = updatedRow.data();

                    $.ajax({
                        url : baseUrl+'/'+'item/'+rowData['po_receive_detail_id'],
                        type: "PUT",
                        dataType: "JSON",
                        data: {
                            '_token'            : $('input[name=_token]').val(),
                            'quantity'          : rowData['quantity'],
                            'unit_price'        : rowData['unit_price'],
                            'discount_percent'  : rowData['discount_percent'],
                            'discount_amount'   : rowData['discount_amount'],
                        },
                        success: function(response)
                        {
                            if(response["status"] == 'ok') { 
                                    afterSaveItem(response["po"]);
                            }else{
                                swal({title: "Update Receive Gagal",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            swal({title: "Terjadi Kesalahan Sistem!", text:"Silakan Hubungi Administrator", type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                        }
                    });
                }

                function getTrxAmount(){
                    var jumlah 	= $('input[name=quantity]').val();
                    var harga 	= $('input[name=unit_price]').val().replace(/,/g, "");
                    var results = jumlah *= harga;

                    $('input[name=trx_amount]').val(results).trigger('keyup');
                }

                function afterSaveItem(data){
                    $('input[name=ppn]').val('Rp '+spelling(data["ppn"])).attr('readonly', true);  
                    $('input[name=total_amount]').val('Rp '+spelling(data["total_amount"])).attr('readonly', true);  
                    $('input[name=total_discount').val('Rp '+spelling(data["total_discount"])).attr('readonly', true);  

                    $('input[name=item_nm]').val('').trigger('keyup');
                    $('input[name=unit_price]').val('0').trigger('keypress');
                    $('input[name=quantity]').val('0').trigger('keypress');
                    $('input[name=trx_amount]').val('0').trigger('keypress');
                    $('select[name=unit_cd]').val('').trigger('change').attr("readonly", true);

                    $('select[name=item_cd]').empty();
                    $('select[name=item_cd]').select2({
                        ajax : {
                            url :  "{{ url('data-inventori/daftar-inventori') }}",
                            dataType: 'json', 
                            processResults: function(data){
                                return {
                                    results: data
                                };
                            },
                            cache : true,
                            success: function(response){
                                $('select[name=item_cd]').on('select2:select', function (evt) {
                                    var selected = evt.params.data;
                                    // $('input[name=item_nm]').val(selected.text);
                                    $('input[name=item_nm]').val(selected.text).trigger('keyup');
                                    $('input[name=unit_price]').val(selected.item_price).trigger('keypress');
                                    $('select[name=unit_cd]').val(selected.unit_cd).trigger('change').attr("readonly", true);
                                });
                            }
                        },
                    });

                    tabelData.ajax.reload();
                }

                $(document).on('keyup', 'input[name=quantity]',function(){ 
                    getTrxAmount();
                });

                $(document).on('keyup', 'input[name=unit_price]',function(){ 
                    getTrxAmount();
                });

                tabelData.MakeCellsEditable({
                    "onUpdate": myCallbackFunction,
                    "inputCss":'my-input-class',
                    "columns": [5,6,7,8],
                    "confirmationButton": { 
                        "confirmCss": 'my-confirm-class',
                        "cancelCss": 'my-cancel-class'
                    },
                    "inputTypes": [
                        {
                            "column":5, 
                            "type":"text", 
                            "options":null 
                        },{
                            "column":6, 
                            "type":"text", 
                            "options":null 
                        },{
                            "column":7, 
                            "type":"text", 
                            "options":null 
                        },{
                            "column":8, 
                            "type":"text", 
                            "options":null 
                        }, 
                    ], 
                });

                /* submit form */
                $('#form-item').submit(function(e){
                    if (e.isDefaultPrevented()) {
                    // handle the invalid form...
                    } else {
                        e.preventDefault();
                        // alert(dataCdReceive);
                        var record  = $('#form-isian, #form-item').serialize();
                        var url     = baseUrl+'/item/'+dataCdReceive;
                        var method  = 'POST';
                        
                        $.ajax({
                            'type': method,
                            'url' : url,
                            'data': record,
                            'dataType': 'JSON',
                            'success': function(response){
                                if(response["status"] == 'ok') { 
                                    tabelData.ajax.reload();
                                    afterSaveItem(response["po"]);
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
                
                /* proses data */
                $(document).on('click', '#proses',function(){ 
                    swal({
                        title             : "Proses Receive Item?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Memproses Receive Item",onOpen: () => {swal.showLoading();}});
                            
                            $.ajax({
                                url : baseUrl+'/'+dataCdReceive,
                                type: "PUT",
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
                                            swal.close();
                                            window.location = baseUrl+'/'+dataCdReceive;
                                        });
                                    }else{
                                        swal({title: "Proses Receive Item Gagal",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    swal({title: "Terjadi Kesalahan Sistem!", text:"Silakan Hubungi Administrator", type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
                                }
                            });
                        }else {
                            swal.close();
                        }
                    });
                });

                /* hapus data */
                $(document).on('click', '#hapus',function(){
                    swal({
                        title             : "Hapus Receive Item?",
                        type              : "question",
                        showCancelButton  : true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText : "Ya",
                        cancelButtonText  : "Batal",
                        allowOutsideClick : false,
                    }).then(function(result){
                        if(result.value){
                            swal({allowOutsideClick : false, title: "Menghapus Receive Item",onOpen: () => {swal.showLoading();}});
                            
                            $.ajax({
                                url : baseUrl+'/'+dataCdReceive,
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
                                            swal.close();
                                            window.location = baseUrl;
                                        });
                                    }else{
                                        swal({title: "Receive Item Gagal Dihapus",type: "error",showCancelButton: false,showConfirmButton: false,timer: 1000});
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

                /* hapus data item */
                $(document).on('click', '#hapus-item',function(){    
                    var rowData=tabelData.row($(this).parents('tr')).data();
                    
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
                                url : baseUrl+'/item/'+rowData['po_receive_detail_id'],
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
                                            afterSaveItem(response["po"]);
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
            @else
                /* cetak data */
                /* $(document).on('click', '#print',function(){
                    window.open(baseUrl + '/print/' + dataCdReceive,'_blank')
                }); */
            @endif
        @endif
		
		/* cetak data */
		$(document).on('click', '#print',function(){
			window.open(baseUrl + '/print/' + dataCdReceive,'_blank')
		});
        
        /*load PO */
        $(document).on('click', '#load-po',function(){
            $('#tabel-po-kiri').DataTable().destroy();
			// $('#tabel-po-kanan').DataTable().destroy();

                /*tabel po kiri = asal */
            var oTable = $('#tabel-po-kiri').DataTable({
                language: {
                    paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
                },
                pagingType: "simple",
                processing	: true, 
                serverSide	: false, 
                order       : [],
                ajax		: {
                    url : baseUrl+'/'+'data-list-po',
                    type: "POST",
                    data: function(data){
                        data._token = $('meta[name="csrf-token"]').attr('content');
                        data.type   = 'detail';
                        data.supplier  = $('select[name="supplier_cd"]').val();
                    },
                },
                dom : 'tpi',
                columns: [
                    {name: "tgl_trx", data: "tgl_trx", visible:false},
                    {name: "po_no", data: "po_no", visible:false},
                    {name: "item_cd", data: "item_cd", visible:true},
                    {name: "item_nm", data: "item_nm", visible:true},
                    {name: "quantity", data: "quantity", visible:true},
                    {name: "unit_price", data: "unit_price", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
                    {name: "unit_cd", data: "unit_cd", visible:false},
                    {name: "unit_nm", data: "unit_nm", visible:true},
                    {name: "trx_amount", data: "trx_amount", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' )},
                ],
            });
            // $('#tabel-po-kiri tbody').on('click', 'tr', function(e) {
			// 		$(this).toggleClass('selected');
			// 		let data = oTable.row($(this)).data();
			// 		var tanggal 	 = data[0];
			// 		var id 	 		 = data[1];
			// 		var kode_item 	 = data[2];
			// 		var item_nm 	 = data[3];
			// 		var quantity 	 = data[4];	         
			// 		var unit_price 	 = data[5];
			// 		var kode_unit	 = data[6];
			// 		var unit_nm 	 = data[7];

			// 		$('input[name=id_PO]').val(id);
			// 		$('input[name=tanggal]').val(tanggal);
			// 		$('input[name=item_nm]').val(item_nm);
			// 		$('input[name=quantity]').val(quantity);
			// 		$('input[name=unit_price]').val(unit_price);
			// 		$('input[name=unit_nm]').val(unit_nm);
			// 		$('input[name=item_kode]').val(kode_item);
			// 		$('input[name=unit_kode]').val(kode_unit);
			// 	});	
                /*tabel po kanan (tujuan) */
        //     tableKanan = $('#tabel-po-kanan').DataTable({
        //         language: {
        //             paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
        //         },
        //         pagingType: "simple",
        //         processing	: true, 
        //         serverSide	: false, 
        //         order       : [],
        //         dom : 'tpi',
        //         columns: [
        //             {name: "tgl_trx", data: "tgl_trx", visible:false},
        //             {name: "po_no", data: "po_no", visible:false},
        //             {name: "item_cd", data: "item_cd", visible:false},
        //             {name: "item_nm", data: "item_nm", visible:true},
        //             {name: "quantity", data: "quantity", visible:true},
        //             {name: "unit_price", data: "unit_price", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, '' )},
        //             {name: "unit_cd", data: "unit_cd", visible:true},
        //             {name: "unit_nm", data: "unit_nm", visible:true},
        //             {name: "trx_amount", data: "trx_amount", visible:true, render: $.fn.dataTable.render.number( '.', ',', 2, 'Rp ' )},
        //         ],
        //     });
        //     $('#tabel-po-kanan tbody').on( 'click', 'tr', function () {
		//  	var tableright 	= $('#tabel-po-kanan').DataTable();
		//  	$(this).toggleClass('selected');
		// 	let data = tableright.row($(this)).data(); 
	    // });

            $('#modal-load-po').modal('show');
        });
        /*aktivitas moving PO */
        $('.btn-move').click(function() {
			oTable 		= $('#tabel-po-kiri').dataTable();
			tableright 	= $('#tabel-po-kanan').dataTable();
			moveRows(oTable, tableright);
			oTable.fnDraw();
		});

        $('.btn-tambah').click(function() {
            console.log(rowData);
            var record = {
                '_token'            : $('meta[name="csrf-token"]').attr('content'),
                'po_cd'           	: rowData['po_cd'],
                'item_cd'           : rowData['item_cd'],
				'item_nm'           : rowData['item_nm'],
                'unit_cd'          	: rowData['unit_cd'],
                'unit_price'        : rowData['unit_price'],
                'quantity'        	: rowData['quantity'],
                'trx_amount'       	: rowData['trx_amount'],
                'currency_cd'       : rowData['currency_cd'],
                'note'              : rowData['note'],
				'faktur_no' 		: $('input[name=faktur_no]').val(),
				'faktur_date'		: $('input[name=faktur_date]').val(),
				'batch_no'  		: $('input[name=batch_no]').val(),
				'expire_date'		: $('input[name=expire_date]').val(),
                
            };
            var url     = baseUrl+'/item/'+dataCdReceive;
            var method  = 'POST';
            
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
                        })
                        oTable 		= $('#tabel-retur-kiri').dataTable();
                        var $row= oTable.find(".selected");
                        $.each($row, function(k, v){
                        if(this !== null){
                            oTable.fnDeleteRow(this);
                        }
                    });
                        tabelData.ajax.reload();
                        afterSaveItem(response["po"]);
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
		});

        $('.btn-move-down').click(function() {
            // alert('root');
		  	var tableright 	= $('#tabel-po-kanan').DataTable();
		  	var o = tableright.rows().data();
		 	// var table_po 	= $('#tabel-data').DataTable();
	        if( !!o.length ){
                // alert(o.length);
	            for(var i = 0; i < o.length; i++){	
	            // alert(tableright.column(0).data()[i]);	
		 	 	tabelData.row.add({
		 	 		'po_receive_detail_id' 	: tableright.column(1).data()[i],
					'item_cd' 		: tableright.column(2).data()[i],
					'item_nm'		: tableright.column(3).data()[i],
					'unit_cd'    	: tableright.column(7).data()[i],
					'unit_nm'    	: tableright.column(4).data()[i],
					'quantity'     	: tableright.column(5).data()[i],
					'unit_price'     	: tableright.column(8).data()[i],
					'discount_percent'	: tableright.column(6).data()[i],
					'discount_amount'	: 0,
					'trx_amount'	: 0,
					'faktur_no' 	: '',
					'faktur_date'	: '',
					'batch_no'  	: '',
					'expire_date'	: '',
					/* 'trx_amount'	: tableright.column(5).data()[i] * tableright.column(8).data()[i],
					'faktur_no' 	: $('input[name=faktur_no]').val(),
					'faktur_date'	: $('input[name=faktur_date]').val(),
					'batch_no'  	: $('input[name=batch_no]').val(),
					'expire_date'	: $('input[name=expire_date]').val(), */
					'action'		: "<a href='#' class='btn btn-default btn-remove-static btn-remove-racik' title='hapus' data-placement='bottom' data-text='Anda Yakin?' data-model='confirm' data-type='warning'><i class='fa fa-trash-o fa-fw'></i></a>"
					
				}).draw();
                
		 	}
		 } else {
            //  alert('else');
         }
		 	// console.log(tableright.rows().data());
		 	
		 	 $('#modal-load-po').modal('hide');
            //  $('.btn-move-down').hide();
             $('#load-po').hide();

		 });
		 
		 $('select[name=pos_cd]').val("WHMASTER").trigger('change');
    });
	
	function moveRows(oTable, tableright){
		var $row= oTable.find(".selected");
        if($row.length == 0){
            swal({
                    title: "Pilih Data Terlebih Dahulu!",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 1000
                });
        }
		console.log($row);
		$.each($row, function(k, v){
			if(this !== null){
				addRow = oTable.fnGetData(this);
				tableright.fnAddData(addRow);
                oTable.fnDeleteRow(this); //masih broken
			}
		});
	}
</script>
@endpush