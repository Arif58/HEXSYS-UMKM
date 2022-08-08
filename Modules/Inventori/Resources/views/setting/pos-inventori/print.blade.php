
<html>
    <head>
        <title>SLIP GAJI</title>
        <link href="{{asset('theme/plugin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <!-- page css -->
        <link href="{{asset('theme/css/pages/login-register-lock.css')}}" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="{{asset('theme/css/style.css')}}" rel="stylesheet" type="text/css">

        <!-- You can change the theme colors from here -->
        <link href="{{asset('theme/css/colors/green-dark.css')}}" rel="stylesheet" type="text/css" id="theme">

        <style type="text/css">
            .text-center{
                text-align: center;
                font-size: 12px;
            }
            .size{
                font-size: 12px;
            }
            /* A4 Landscape*/
            @page {
                size: A4 Potrait;
            }
        </style>

    </head>
    <body>
        <table class="table datatable-pagination" id="tabel-data" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>CD</th>
                    <th>Nama UMKM</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    <tr>
                        <td>1</td>
                        <td>{{ $data->pos_cd }}</td>
                        <td>{{ $data->pos_nm }}</td>
                        <td>{{ $data->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script type="text/javascript">
            window.onload = function() {
              window.print();
            }
            setTimeout(function(){
              close();
            },2000);
        </script>
