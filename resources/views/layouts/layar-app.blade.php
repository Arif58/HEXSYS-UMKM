<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon.ico">
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ configuration('APP_NAME') }}</title>

	<!-- Global stylesheets -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<link href="/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="/css/colors.min.css" rel="stylesheet" type="text/css">
	{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/css/index.css"> --}}

	<link href="{{ asset('layar-antrian/css/app.css') }}" rel="stylesheet">

	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="/global_assets/js/main/jquery.min.js"></script>
	<script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="/global_assets/js/plugins/loaders/blockui.min.js"></script>
	{{-- <script src="/global_assets/js/plugins/ui/slinky.min.js"></script> --}}
	<script src="/global_assets/js/plugins/ui/ripple.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script src="/global_assets/js/plugins/forms/validation/validate.min.js"></script>
	<script src="/global_assets/js/plugins/forms/validation/localization/messages_id.js"></script>
	<script src="/global_assets/js/plugins/forms/inputs/touchspin.min.js"></script>
	<script src="/global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="/global_assets/js/plugins/forms/styling/switch.min.js"></script>
	<script src="/global_assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="/global_assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script src="/global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script src="/global_assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script src="/global_assets/js/plugins/ui/moment/moment.min.js"></script>
	<script src="/global_assets/js/plugins/pickers/anytime.min.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
	<script src="/global_assets/js/plugins/tables/datatables/extensions/responsive.min.js"></script>
	{{-- <script src="/global_assets/js/plugins/tables/datatables/extensions/fixed_columns.min.js"></script> --}}
	{{-- <script src="/global_assets/js/plugins/tables/datatables/extensions/select.min.js"></script> --}}
	
	{{-- <script src="/global_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js"></script>
	<script src="/global_assets/js/plugins/ui/fullcalendar/lang/locale-all.js"></script> --}}

	<script src="/js/app.js"></script>
	{{-- <script src="/global_assets/js/demo_pages/dashboard.js"></script> --}}
	{{-- <script src="/global_assets/js/demo_pages/form_validation.js"></script> --}}
	<script src="/global_assets/js/demo_pages/extra_sweetalert.js"></script>
	<!-- /theme JS files -->

	{{-- othen plugins --}}
	<!-- jquery mask -->
	<script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
	<script src="{{ asset('plugins/cell-edit/cell-edit.js') }}"></script>
	<script src="{{ asset('plugins/printjs/print.min.js') }}"></script>
	<!-- virtual keyboard -->
	{{-- <script src="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/index.min.js"></script> --}}

	<style>
		.result-user-list {
			padding-top: 4px;
			padding-bottom: 3px
		}

		.result-user-list__avatar {
			float: left;
			width: 120px;
			margin-right: 10px
		}

		.result-user-list__avatar img {
			width: 100%;
			height: auto;
			border-radius: 2px
		}

		.result-user-list__meta {
			margin-left: 70px
		}

		.result-user-list__title {
			color: black;
			/* font-weight: 700; */
			font-size: 23px;
			word-wrap: break-word;
			line-height: 1.1;
			margin-bottom: 4px
		}

		.result-user-list__forks,
		.result-user-list__stargazers {
			margin-right: 1em
		}

		.result-user-list__forks,
		.result-user-list__stargazers,
		.result-user-list__watchers {
			display: inline-block;
			color: #aaa;
			font-size: 13px
		}

		.result-user-list__description {
			font-size: 16px;
			color: #777;
			margin-top: 4px
		}

		/* style pasien tanpa foto */
		.result-pasien-list {
			padding-top: 4px;
			padding-bottom: 3px
		}

		.result-pasien-list__meta {
			margin-left: 0px
		}

		.result-pasien-list__title {
			color: black;
			/* font-weight: 700; */
			font-size: 23px;
			word-wrap: break-word;
			line-height: 1.1;
			margin-bottom: 2px
		}

		.result-pasien-list__forks,
		.result-pasien-list__stargazers {
			margin-right: 1em
		}

		.result-pasien-list__forks,
		.result-pasien-list__stargazers,
		.result-pasien-list__watchers {
			display: inline-block;
			color: #aaa;
			font-size: 13px
		}

		.result-pasien-list__description {
			font-size: 16px;
			color: #777;
			margin-top: 4px
		}
		body {
            background: url("/global_assets/images/backgrounds/user_bg1.png") no-repeat;
            background-size: cover;
            background-position: top left;
		}
		
	</style>
</head>

<body class="background-cover">
	
	@yield('content')

	<script>
		var dataCd;
		var rowData;
		
		$(document).ready(function(){
			$('.money').mask('000.000.000.000.000', {reverse: true});
			$('.mask-date').mask('00/00/0000');
			$('.mask-time').mask('00:00');
			$('.mask-phone').mask('00000000000');

			$('.form-check-input-styled').uniform();

			$.ajaxSetup({
				headers: { "X-CSRF-TOKEN":  $('meta[name="csrf-token"]').attr('content')},
				crossDomain : true,
				xhrFields: {
					withCredentials: true
				},
			});
			
			$('form').each(function() { 
				var validator = $(this).validate({
					ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
					errorClass: 'validation-invalid-label',
					successClass: 'validation-valid-label',
					validClass: 'validation-valid-label',
					highlight: function(element, errorClass) {
						$(element).removeClass(errorClass);
					},
					unhighlight: function(element, errorClass) {
						$(element).removeClass(errorClass);
					},
					// Different components require proper error label placement
					errorPlacement: function(error, element) {

						// Unstyled checkboxes, radios
						if (element.parents().hasClass('form-check')) {
							error.appendTo( element.parents('.form-check').parent() );
						}

						// Input with icons and Select2
						else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
							error.appendTo( element.parent() );
						}

						// Input group, styled file input
						else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
							error.appendTo( element.parent().parent() );
						}

						// Other elements
						else {
							error.insertAfter(element);
						}
					},
					rules: {
						password: {
							minlength: 5
						},
						repeat_password: {
							equalTo: '#password'
						},
						email: {
							email: true
						},
						repeat_email: {
							equalTo: '#email'
						},
						minimum_characters: {
							minlength: 10
						},
						maximum_characters: {
							maxlength: 10
						},
						minimum_number: {
							min: 10
						},
						maximum_number: {
							max: 10
						},
						number_range: {
							range: [10, 20]
						},
						url: {
							url: true
						},
						date: {
							date: true
						},
						date_iso: {
							dateISO: true
						},
						numbers: {
							number: true
						},
						digits: {
							digits: true
						},
						creditcard: {
							creditcard: true
						},
						basic_checkbox: {
							minlength: 2
						},
						styled_checkbox: {
							minlength: 2
						},
						switchery_group: {
							minlength: 2
						},
						switch_group: {
							minlength: 2
						}
					},
					messages: {
						custom: {
							required: 'This is a custom error message'
						},
						basic_checkbox: {
							minlength: 'Please select at least {0} checkboxes'
						},
						styled_checkbox: {
							minlength: 'Please select at least {0} checkboxes'
						},
						switchery_group: {
							minlength: 'Please select at least {0} switches'
						},
						switch_group: {
							minlength: 'Please select at least {0} switches'
						},
						agree: 'Please accept our policy'
					}
				});
				
				// Reset form
				$('#reset').on('click', function() {
					validator.resetForm();
				});
			});

			$('.table-single-select tbody').on( 'click', 'tr', function () {
				// var selectedTable = $('#'+$(this).closest('table').attr('id')).DataTable();
				// selectedTable.$('tr.selected').removeClass('selected');
				// var data = selectedTable.row(this).data();

				if ( ! $(this).hasClass('group_row') ) {
					if ( $(this).hasClass('selected') ) {
						$(this).removeClass('selected');
						dataCd 	= null;
						rowData	= null;
					}else{
						var selectedTable = $('#'+$(this).closest('table').attr('id')).DataTable();
						selectedTable.$('tr.selected').removeClass('selected');
						var data = selectedTable.row(this).data();
						if (data != null) {
							$(this).addClass('selected');
							rowData=data;
							dataCd=data[Object.keys(data)[0]];
						}
					}
				}

				console.log(rowData);
			});

			$('.modal').on('hidden.bs.modal', function() {
				dataCd=null;
				rowData=null;
			});

			/* $.extend( $.fn.dataTable.defaults, {
				autoWidth: false,
				responsive: true,
				columnDefs: [{ 
					orderable: false,
					width: 100,
					targets: [ 7 ]
				}],
				dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
				language: {
					search: '<span>Filter:</span> _INPUT_',
					searchPlaceholder: 'Type to filter...',
					lengthMenu: '<span>Show:</span> _MENU_',
					paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
				}
			}); */

			@if(session('success')) 
				swal({
					title: "{{ session('success') }}",
					type: "success",
					showCancelButton: false,
					showConfirmButton: false,
					timer: 1000
				}).then(() => {
					swal.close();
				});
			@endif

			@if(session('error'))
				swal({
					title: "{{ session('error') }}",
					type: "error",
					showCancelButton: false,
					showConfirmButton: false,
					timer: 1000
				}).then(() => {
					swal.close();
				});
			@endif

			$('.form-control-select2').select2();
		});
		function regionLayout(region) {
			if (!region.id) {
				return region.text; 
			}

			var $state = $(
				'<div class="list" style="overflow:hidden;">'+
				'<div><strong>'+ region.text +'</strong> <br></div>'+
				'<i class="icon-location4"></i> '+region.long_region+
				'</div>'
				);
			return $state;
		};

		function itemInventoryLayout(data){
			if(!data.id){
				return data.text;
			}

			let harga = data.item_price_agen;
			let hargaFormat = harga.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

			var $state = $(
				'<div class="list" style="overflow:hidden;">'+
				'<div><strong>'+ data.text +'</strong> <br></div>'+
				'<i class="icon-coin-dollar"></i> '+hargaFormat+ ' &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-cubes"></i> ' +data.quantity+ " "+ data.unit_cd+
				'</div>'
			)

			return $state;
		}

		function spelling(a){
			let val;
			if (isNaN(a) || a==="" ||  a === null){
			val = 0;
			}else{
			a = parseFloat(a);
			val = (a/1).toFixed(0).replace('.', ',');
			val=val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
			}
			return val;
		}

		function getCurrentDateTime() {
			return moment().format('DD/MM/YYYY HH:mm:ss')
		}
	</script>
	@stack('scripts')
</body>
</html>
