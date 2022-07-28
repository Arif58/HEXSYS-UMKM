@extends('layouts.app')

@push('styles')
    <style>
        .--card {
            color: #333;
            text-decoration: none;

            position: relative;
            z-index: 1;
            overflow: hidden;
            -webkit-transition: .3s all ease-in-out;
            -o-transition: .3s all ease-in-out;
            transition: .3s all ease-in-out;
            -webkit-box-shadow: 0 9px 36px 0 rgba(13, 0, 30, .2);
            box-shadow: 0 9px 36px 0 rgba(13, 0, 30, .2);
            border-radius: 28px;
        }

        .--card2 {
            color: #333;
            text-decoration: none;

            position: relative;
            z-index: 1;
            overflow: hidden;
            -webkit-transition: .3s all ease-in-out;
            -o-transition: .3s all ease-in-out;
            transition: .3s all ease-in-out;
            -webkit-box-shadow: 0 8px 18px 0 rgba(13, 0, 30, .2);
            box-shadow: 0 8px 18px 0 rgba(13, 0, 30, .2);
            /* border-radius: 18px;
            margin-bottom: 10px;
            min-height: 82px; */

            border-radius: 20px;
            margin-bottom: 16px;
            min-height: 92px;
        }

        .--card-body {
            padding: 16px;
        }

        .--card-hover.card:hover {
            background-color: #fff;
            color: #495560;

            -webkit-transform: translate(0px, -6px);
            -ms-transform: translate(0px, -6px);
            transform: translate(0px, -6px);
        }

        .--card-img {
            height: 120px;
            width: 120px;
            margin-bottom: 32px;
        }

        .--card-img2 {
            height: 80px;
            width: 80px;
            margin-bottom: 20px;
        }

        .--card-title {
            display: block;
            font-size: 20px;
            line-height: 36px;
            letter-spacing: 2px;
            font-weight: 700;
            text-decoration: none;
            text-transform: uppercase;
            margin-bottom: 0;
        }

        .--card-title2 {
            display: block;
            font-size: 12px;
            line-height: 10px;
            letter-spacing: 1px;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 0;
        }

        .--card-text {
            display: block;
            font-family: Roboto, sans-serif;
            font-size: 16px;
            text-decoration: none;
        }

        .--floating-container {
            z-index: 10000000;
            position: fixed;
            right: 30px;
            bottom: 0;
        }

        .--floating-container .--floating-row {
            display: inline-block;
            margin-left: 24px;
            text-align: center;
        }

        .--floating-container .--floating-title {
            font-size: 18px;
            line-height: 36px;
            font-weight: 700;
            text-decoration: none;
            text-transform: uppercase;
            margin-top: 2px;
            text-align: center;
            letter-spacing: 2px;
            color: #636978;
        }

        .--floating-container .--btn-float {
            display: inline-block;
            text-align: center;
            background: #fff;
            width: 60px;
            height: 60px;
            padding: 12px;
            border-radius: 100%;
            box-sizing: border-box;
            color: #666;
            -webkit-animation: at-ripple 0.6s linear infinite;
            animation: at-ripple 0.6s linear infinite;
        }

        .--floating-container .--btn-float img {
            width: 32px;
            height: 32px;
        }

        .--floating-container .--btn-float:hover img {
            transform: rotate(360deg);
        }

        .--floating-container .--btn-float img {
            transition: 0.3s ease;
        }

        @-webkit-keyframes at-ripple {
            0% {
                box-shadow: 0 4px 10px rgba(102, 102, 102, 0.1), 0 0 0 0 rgba(102, 102, 102, 0.1), 0 0 0 5px rgba(102, 102, 102, 0.1), 0 0 0 10px rgba(102, 102, 102, 0.1);
            }

            100% {
                box-shadow: 0 4px 10px rgba(102, 102, 102, 0.1), 0 0 0 5px rgba(102, 102, 102, 0.1), 0 0 0 10px rgba(102, 102, 102, 0.1), 0 0 0 20px rgba(102, 102, 102, 0);
            }
        }

        @keyframes at-ripple {
            0% {
                box-shadow: 0 4px 10px rgba(102, 102, 102, 0.1), 0 0 0 0 rgba(102, 102, 102, 0.1), 0 0 0 5px rgba(102, 102, 102, 0.1), 0 0 0 10px rgba(102, 102, 102, 0.1);
            }

            100% {
                box-shadow: 0 4px 10px rgba(102, 102, 102, 0.1), 0 0 0 5px rgba(102, 102, 102, 0.1), 0 0 0 10px rgba(102, 102, 102, 0.1), 0 0 0 20px rgba(102, 102, 102, 0);
            }
        }

    </style>
@endpush

@section('content')
	
	@if ($approvalcm)
	<h3 class="font-weight-semibold mb-0">Cash Management</h3>
	<div class="alert bg-info text-white alert-styled-left alert-dismissible"><!--style="display:none"-->
		ANDA MEMPUNYAI PROSES UNTUK DISETUJUI [<span class="font-weight-semibold"></span> <a href="{{ url('e-cash-management/transaksi/approval') }}" class="alert-link">APPROVAL CM</a>]
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
	</div>
	@endif
	@if ($approvalpo)
	<h3 class="font-weight-semibold mb-0">Purchasing</h3>
	<div class="alert bg-info text-white alert-styled-left alert-dismissible"><!--style="display:none"-->
		ANDA MEMPUNYAI PROSES UNTUK DISETUJUI [<span class="font-weight-semibold"></span> <a href="{{ url('inventori/pembelian/approval') }}" class="alert-link">APPROVAL PO</a>]
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
	</div>
	@endif
	<!--
	<h3 class="font-weight-semibold mb-0">Proses</h3>
	<div class="row">
		<div class="col-xl-4">
			<div class="card bg-teal-400">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0" id="rekomendasi-masuk">1000</h3>
					</div> 
					<div>
						Proses I
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4">
			<div class="card bg-pink-400">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0" id="rekomendasi-belum-proses">2000</h3>
					</div>
					<div>
						Proses II
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-4">
			<div class="card bg-blue-400">
				<div class="card-body">
					<div class="d-flex">
						<h3 class="font-weight-semibold mb-0" id="rekomendasi-diproses">3000</h3>
					</div>
					<div>
						Proses III
					</div>
				</div>
			</div>
		</div>
	</div>
	-->
    <!-- Dashboard content -->
    <div class="row">
        <div class="col-xl-12">

            <!-- Dashboard -->
            <div class="card --card">
                <div class="card-header header-elements-sm-inline">
                    <h6 class="card-title --card-title mx-3">
                        {{ configuration('INST_NAME') }}
                    </h6>
                </div>

                <div class="card-body --card-body">
                    <div class="row">

                        @foreach ($menus as $key => $element)

                            <div class="col-sm-4 col-md-3">
                                @if($element->name=='Layanan')
                                    <a href="{{ url($element->url) }}" target="_blank">
                                @else
                                    <a href="{{ url($element->url) }}">
                                @endif
                                    <div class="card --card2 --card-hover">
                                        <div class="card-body --card-body text-center">
                                            <img class="card-img --card-img2"
                                                src="{{ asset('/images/dashboard/' . strtolower($element->name) . '.png') }}"
                                                alt="">
                                            <h4 class="card-title --card-title2">{{ $element->name }}</h4>
                                            <p class="card-text --card-text"></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                        {{-- @foreach ($menus as $key => $element)

                            @if (isset($newMenus[$element->name]))
                                <div class="col-sm-4 col-md-3" style="-ms-flex: 0 0 19.9%; flex: 0 0 19.9%; max-width: 19.9%;">
                                    <a href="{{ url($newMenus[$element->name][1]) }}">
                                        <div class="card --card2 --card-hover">
                                            <div class="card-body --card-body text-center">
                                                <img class="card-img --card-img2"
                                                    src="{{ asset('/images/dashboard/' . strtolower($newMenus[$element->name][2]) . '.png') }}"
                                                    alt="">
                                                <h4 class="card-title --card-title2">{{ $newMenus[$element->name][0] }}</h4>
                                                <p class="card-text --card-text"></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif

                        @endforeach --}}
                    </div>

                    {{-- <div class="row">
                        <div class="col-sm-2 col-md-2">
                            <a href="{{ configuration('APP_EXTERNAL_URL_ERP', '//erp.hexsys.id') }}" target="_blank">
                                <div class="card --card2 --card-hover">
                                    <div class="card-body --card-body text-center">
                                        <img class="card-img --card-img2"
                                            src="{{ configuration('APP_EXTERNAL_IMAGE_ERP', asset('/images/icons/report.png')) }}"
                                            alt="">
                                        <h4 class="card-title --card-title2">{{ configuration('APP_EXTERNAL_LABEL_ERP', 'KEUANGAN') }}</h4>
                                        <p class="card-text --card-text"></p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-sm-2 col-md-2">
                            <a href="{{ configuration('APP_EXTERNAL_URL_ASSET', '//asset.hexsys.id') }}" target="_blank">
                                <div class="card --card2 --card-hover">
                                    <div class="card-body --card-body text-center">
                                        <img class="card-img --card-img2"
                                            src="{{ configuration('APP_EXTERNAL_IMAGE_ASSET', asset('/images/icons/transfusion.png')) }}"
                                            alt="">
                                        <h4 class="card-title --card-title2">{{ configuration('APP_EXTERNAL_LABEL_ASSET', 'ASSET') }}</h4>
                                        <p class="card-text --card-text"></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div> --}}

                </div>

            </div>
            <!-- /marketing campaigns -->
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var tabelData;
        $(document).ready(function() {

        });

    </script>
@endpush
