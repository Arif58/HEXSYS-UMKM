
<html>
    <head>
        <title>DATA UMKM</title>
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
                    <th>Kode UMKM</th>
                    <th>Nama UMKM</th>
                    <th>Deskripsi</th>
                    <th>Nama User</th>
                    <th>User ID</th>
                    <th>Password</th>
                 
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    <tr>
                        <td>1</td>
                        <td>{{ $data->pos_cd }}</td>
                        <td>{{ $data->pos_nm }}</td>
                        <td>{{ $data->description }}</td>
                        <td>{{ $data->user_nm }}</td>
                        <td>{{ $data->user_id }}</td>
                        <td>{{ $data->password }}</td>
                        {{-- <td>{{ $data->user_nm }}</td> --}}
                        {{-- <td>{{ $data->password }}</td> --}}
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
