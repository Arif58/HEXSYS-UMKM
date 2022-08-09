@extends('layouts.app')

@section('content')
<!-- Basic datatable -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title-head">{{ $title }}</h5>
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
                        {{-- <label class="form-group-float-label is-visible">Nama UMKM</label> --}}
                        <input name="search_param" id="search_param" placeholder="Pencarian Nama UMKM"
                            class="form-control" data-fouc />
                    </div>
                </div>
                {{-- <div class="col-md-6">
                        <div class="form-group form-group-float">
                            <label class="form-group-float-label is-visible">Daerah UMKM</label>
                            <select name="type_cd" class="form-control form-control-select2 select-search" data-fouc>
                                <option value="">=== Pilih Data ===</option>
                                {{-- @foreach ($types as $item)
                                    <option value="{{ $item->type_cd }}">{{ $item->type_nm }}</option>
                @endforeach--}}
                {{-- </select>
                        </div>
                    </div>  --}}
            </div>

            <button type="button" class="btn btn-primary legitRipple" id="tambah"><i class="icon-add mr-2"></i>
                Tambah</button>
            <button type="button" class="btn btn-warning legitRipple" id="ubah"><i class="icon-pencil mr-2"></i>
                Ubah</button>
            <button type="button" class="btn btn-danger legitRipple" id="hapus"><i class="icon-trash mr-2"></i>
                Hapus</button>
            <button type="button" class="btn btn-secondary legitRipple" id="print"></i> Cetak Data</button>
            <div class="table-responsive">
                <table class="table table-single-select datatable-pagination" id="tabel-data" width="100%">
                    <thead>
                        <tr>
                            <th width="15%">Kode UMKM</th>
                            <th id="pos_nm_table" width="15%">Nama UMKM</th>
                            <th id="description_table" width="15%">Keterangan</th>
                            <th id="postrx_st_table" width="1%">postrx_st_table</th>
                            <th id="user_nm" width="1%">User Name</th>
                            <th id="email" width="1%">Email</th>

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

                <!-- Collapsible with right control button -->
                <div class="card-group-control card-group-control-right">
                    <div class="card">
                        <div class="card-header bg-slate">
                            <h6 class="card-title">
                                <a data-toggle="collapse" class="text-white"
                                    href="#collapsible-control-right-group1">Data UMKM</a>
                            </h6>
                        </div>

                        <div id="collapsible-control-right-group1" class="collapse show">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Kode UMKM</label>
                                            <input type="text" name="pos_cd" class="form-control text-uppercase"
                                                placeholder="Kode digenerate sistem" aria-invalid="false" maxlength="20"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Nama UMKM</label>
                                            <input type="text" name="pos_nm" class="form-control" required=""
                                                placeholder="" aria-invalid="false">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Deskripsi UMKM</label>
                                            <input type="text" name="description" class="form-control" required=""
                                                placeholder="" aria-invalid="false">
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="display: none">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Pos Transaksi</label>
                                            <div class="input-group">
                                                <input type="checkbox" id="checkbox_transaksi"
                                                    name="checkbox_transaksi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Alamat</label>
                                            <input type="text" name="address" id="address" class="form-control"
                                                required="" placeholder="" aria-invalid="false">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Propinsi</label>
                                            <select name="region_prop" id="region_prop"
                                                class="form-control form-control-select2 select-search" data-fouc>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Kota/Kabupaten</label>
                                            <select name="region_kab" id="region_kab"
                                                class="form-control form-control-select2 select-search" data-fouc>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Kecamatan</label>
                                            <select name="region_kec" id="region_kec"
                                                class="form-control form-control-select2 select-search" data-fouc>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Kelurahan</label>
                                            <select name="region_kel" id="region_kel"
                                                class="form-control form-control-select2 select-search" data-fouc>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Kode Pos</label>
                                            <input type="text" name="postcode" id="postcode" class="form-control"
                                                placeholder="" aria-invalid="false" maxlength="6">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Telepon</label>
                                            <input type="text" name="phone" id="phone" class="form-control" required=""
                                                placeholder="" aria-invalid="false" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">HP</label>
                                            <input type="text" name="mobile" id="mobile" class="form-control"
                                                required="" placeholder="" aria-invalid="false" maxlength="20">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Fax</label>
                                            <input type="text" name="fax" id="fax" class="form-control" placeholder=""
                                                aria-invalid="false" maxlength="20">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Email</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="" aria-invalid="false" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">NPWP</label>
                                            <input type="text" name="npwp" id="npwp" class="form-control" placeholder=""
                                                aria-invalid="false" maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Kontak Person</label>
                                            <input type="text" name="pic" id="pic" class="form-control" placeholder=""
                                                aria-invalid="false" maxlength="200">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Keterangan</label>
                                            <input type="text" name="pos_note" id="pos_note" class="form-control"
                                                placeholder="" aria-invalid="false" maxlength="200">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-slate">
                            <h6 class="card-title">
                                <a class="collapsed text-white" data-toggle="collapse"
                                    href="#collapsible-control-right-group3">Data User/Login</a>
                            </h6>
                        </div>

                        <div id="collapsible-control-right-group3" class="collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">User ID <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="user_id" class="form-control" id="user_id" required
                                                placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Nama User <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="user_nm" class="form-control" required="" placeholder=""
                                                aria-invalid="false">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" id="email" required
                                                placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Password <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password" class="form-control" required
                                                placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Verifikasi Password <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" name="repeat_password" class="form-control" required
                                                placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">Jenis User <span
                                                    class="text-danger">*</span></label>
                                            <select name="role_cd" id="role_cd" data-placeholder="Pilih Autorisasi"
                                                class="form-control form-control-select2 select-search" required data-fouc>
                                                <option value=""> === Pilih Data === </option>
                                                @foreach($roles as $item)
                                                    <option value="{{ $item->role_cd }}">{{ $item->role_nm }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn btn-primary ml-3 legitRipple">Simpan <i
                            class="icon-floppy-disk ml-2"></i></button>
                    <button type="reset" class="btn btn-light legitRipple" id="reset">Selesai <i
                            class="icon-reload-alt ml-2"></i></button>
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
        var baseUrl = "{{ url('inventori/setting/pos-inventori/') }}";

        $(document).ready(function () {
            $('#bagian-form').hide();

            tabelData = $('#tabel-data').DataTable({
                language: {
                    paginate: {
                        'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;',
                        'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'
                    },
                    emptyTable: 'Tidak ada data',
                },
                pagingType: "simple",
                processing: true,
                serverSide: true,
                order: [1, 'asc'],
                ajax: {
                    url: baseUrl + '/' + 'data',
                    type: "POST",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                    },
                },
                dom: 'tpi',
                columns: [{
                        data: 'pos_cd',
                        name: 'pos_cd',
                        visible: true
                    },
                    {
                        data: 'pos_nm',
                        name: 'pos_nm',
                        visible: true
                    },
                    {
                        data: 'description',
                        name: 'description',
                        visible: true
                    },
                    {
                        data: 'postrx_st',
                        name: 'postrx_st',
                        visible: false
                    },
                    {
                        data: 'user_nm',
                        name: 'user_nm',
                        visible: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        visible: true
                    },
                ],
            });

            $(document).on('keyup', '#search_param', function () {
                tabelData.column('#pos_nm_table').search($(this).val()).draw();
            });

            $('#reload-table').click(function () {
                $('input[name=search_param]').val('').trigger('keyup');

                tabelData.ajax.reload();
            });

            /* tambah data */
            $('#tambah').click(function () {
                saveMethod = 'tambah';

                $('input[name=pos_nm]').focus();
                $('#bagian-tabel').hide();
                $('#bagian-form').show();
                $('.card-title-head').text('Tambah Data');
            });

            /* reset form */
            $('#reset').click(function () {
                reset('')
            });

            /* submit form */
            $('#form-isian').submit(function (e) {
                if (e.isDefaultPrevented()) {
                    // handle the invalid form...
                } else {
                    e.preventDefault();

                    var record = $('#form-isian').serialize();
                    console.log(record);
                    if (saveMethod == 'tambah') {
                        var url = baseUrl;
                        var method = 'POST';
                    } else {
                        var url = baseUrl + '/' + dataCd;
                        var method = 'PUT';
                    }

                    swal({
                        title: 'Simpan Data?',
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText: "Ya",
                        cancelButtonText: "Tidak",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            swal({
                                allowOutsideClick: false,
                                title: "Menyimpan Data",
                                onOpen: () => {
                                    swal.showLoading();
                                }
                            });

                            $.ajax({
                                'type': method,
                                'url': url,
                                'data': record,
                                'dataType': 'JSON',
                                'success': function (response) {
                                    if (response["status"] == 'ok') {
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
                                    } else {
                                        swal({
                                            title: "Data Gagal Disimpan",
                                            type: "error",
                                            showCancelButton: false,
                                            showConfirmButton: false,
                                            timer: 1000
                                        });
                                    }
                                },
                                'error': function (response) {
                                    var errorText = '';
                                    $.each(response.responseJSON.errors, function (
                                        key, value) {
                                        errorText += value + '<br>'
                                    });

                                    swal({
                                        title: response.status + ':' +
                                            response.responseJSON.message,
                                        type: "error",
                                        html: errorText,
                                        showCancelButton: false,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText: "OK",
                                        cancelButtonText: "Tidak",
                                    }).then(function (result) {
                                        if (result.value) {
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
            $(document).on('click', '#ubah', function () {
                if (dataCd == null) {
                    swal({
                        title: "Pilih Data!",
                        type: "warning",
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1000
                    });
                } else {
                    saveMethod = 'ubah';

                    $('input[name=pos_cd]').val(rowData['pos_cd']).prop('readonly', true);
                    $('input[name=pos_nm]').val(rowData['pos_nm']);
                    $('input[name=description]').val(rowData['description']);
                    $('input[name=address]').val(rowData['address']);
                    if (rowData['postrx_st'] == "1") {
                        // document.getElementById("checkbox-katarak").checked = true;
                        $("#checkbox_transaksi").prop("checked", true);
                    }
                    $('#bagian-tabel').hide();
                    $('#bagian-form').show();
                }
            });
            //print data
            $(document).on('click', '#print', function () {
                if (dataCd == null) {
                    swal({
                        title: "Pilih Data!",
                        type: "warning",
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1000
                    });
                } else {
                    window.location = baseUrl + '/print/' + dataCd;
                }
            });

            /* hapus data */
            $(document).on('click', '#hapus', function () {
                if (dataCd == null) {
                    swal({
                        title: "Pilih Data!",
                        type: "warning",
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1000
                    });
                } else {
                    swal({
                        title: "Hapus Data?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#00a65a",
                        confirmButtonText: "Ya",
                        cancelButtonText: "Batal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            swal({
                                allowOutsideClick: false,
                                title: "Menghapus Data",
                                onOpen: () => {
                                    swal.showLoading();
                                }
                            });

                            $.ajax({
                                url: baseUrl + '/' + dataCd,
                                type: "DELETE",
                                dataType: "JSON",
                                data: {
                                    '_token': $('input[name=_token]').val(),
                                },
                                success: function (response) {
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
                                    } else {
                                        swal({
                                            title: "Data Gagal Dihapus",
                                            type: "error",
                                            showCancelButton: false,
                                            showConfirmButton: false,
                                            timer: 1000
                                        });
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    swal({
                                        title: "Terjadi Kesalahan Sistem!",
                                        text: "Silakan Hubungi Administrator",
                                        type: "error",
                                        showCancelButton: false,
                                        showConfirmButton: false,
                                        timer: 1000
                                    });
                                }
                            })
                        } else {
                            swal.close();
                        }
                    });
                }
            });

            /*cek kode*/
            $('input[name=pos_cd]').focusout(function () {
                var id = $(this).val();
                var urlUpdate = baseUrl + '/' + id;

                if ($(this).val() && saveMethod === 'tambah') {
                    $.getJSON(urlUpdate, function (data) {
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
            $('#region_prop').select2({
                placeholder: "Pilih Propinsi",
                ajax: {
                    url: "{{ url('daftar-daerah/provinsi/') }}",
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                },
            });
            $('#region_prop').change(function () {
                $('#region_kab').select2({
                    placeholder: "Pilih Kota",
                    ajax: {
                        url: "{{ url('daftar-daerah/by-root/') }}" + "/" +
                            $('#region_prop').val(),
                        dataType: 'json',
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                    },
                });
            });
            $('#region_kab').change(function () {
                $('#region_kec').select2({
                    placeholder: "Pilih Kecamatan",
                    ajax: {
                        url: "{{ url('daftar-daerah/by-root/') }}" + "/" +
                            $('#region_kab').val(),
                        dataType: 'json',
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                    },
                });
            });
            $('#region_kec').change(function () {
                $('#region_kel').select2({
                    placeholder: "Pilih Kelurahan",
                    ajax: {
                        url: "{{ url('daftar-daerah/by-root/') }}" + "/" +
                            $('#region_kec').val(),
                        dataType: 'json',
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                    },
                });
            });
        });
        /*region */



        function reset(type) {
            saveMethod = '';
            dataCd = null;
            rowData = null;
            tabelData.ajax.reload();

            $('#bagian-tabel').show();
            $('#bagian-form').hide();
            $('input[name=pos_cd]').val('').prop('readonly', false);
            $('input[name=pos_nm]').val('');
            $('input[name=description]').val('');
            $('input[name=address]').val('');
            $('input[name=phone]').val('');
            $('input[name=mobile]').val('');
            $('input[name=fax]').val('');
            $('input[name=email]').val('');
            $('input[name=npwp]').val('');
            $('input[name=password]').val('');
            $('input[name=repeat_password]').val('');
            $('input[name=user_id]').val('');
            $('input[name=user_nm]').val('');
            $('input[name=pic]').val('');
            $('input[name=pos_note]').val('');
            $('input[name=postcode]').val('');
            $('select[name=role_cd]').val('').trigger('change');
            $('select[name=region_prop]').val('').trigger('change');
            $('select[name=region_kec]').val('').trigger('change');
            $('select[name=region_kel]').val('').trigger('change');
            $('select[name=region_kab]').val('').trigger('change');

            $('.card-title').text('Data Gudang');
        }

    </script>
@endpush
