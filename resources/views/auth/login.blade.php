<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon.ico">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ 'Login | '.configuration('APP_NAME') }}</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
		type="text/css">
	<link href="/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="/css/colors.min.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<style>
		:root {
			--app-white: #ffffff;
			--app-sidebar-dark: #06623b;
			--app-sidebar-dark-secondary: #ffcc29;
		}
	</style>

	<link href="/css/style.min.css" rel="stylesheet" type="text/css">
	{{-- <link href="/css/style.css" rel="stylesheet" type="text/css"> --}}

	<!-- Core JS files -->
	<script src="/global_assets/js/main/jquery.min.js"></script>
	<script src="/global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="/global_assets/js/plugins/loaders/blockui.min.js"></script>
	<script src="/global_assets/js/plugins/ui/ripple.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script src="/global_assets/js/plugins/forms/validation/validate.min.js"></script>
	<script src="/global_assets/js/plugins/forms/validation/localization/messages_id.js"></script>

	<script src="/js/app.js"></script>

	<style>
		body {
			background-color: #fff;
		}
		.login-cover2 {
			background: url("/images/bg2.png") no-repeat;
			/* background-size: cover; */
            background-position: bottom center;
			background-attachment: fixed;
			background-size: cover;
		}

		.logo-content {
			margin-bottom: 24px;
		}

		.logo-content .logo {
			height: 108px;
		}

		.logo-content span {
			font-size: 15px;
			color: #999;
			margin-top: 8px;
		}

		.footer {
			position: absolute;
			bottom: 0;
			width: 100%;
			background-color: transparent;
			padding-bottom: 10px;
		}

		.footer img {
			height: 40px;
		}

		.footer .tagline {
			font-size: 10px;
			letter-spacing: 6px;
			color: #ccc;
			margin-top: 8px;
			margin-bottom: 0;
		}
	</style>

</head>

<body>
	<!-- Page content -->
	<div class="page-content login-cover2">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Login form -->
				<form class="login-form wmin-sm-400" id="form-login" method="POST" action="{{ route('login') }}">
					@csrf
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center logo-content">
								<img src="{{ url(configuration('APP_ALIAS_LOGO')) }}" class="logo">
								<span class="d-block text-muted">{{ configuration('APP_NAME') }}</span>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="text" name="login" class="form-control" placeholder="{{ __('User ID') }}"
									required="" placeholder="" aria-invalid="false" />
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password" name="password" class="form-control"
									placeholder="{{ __('Password') }}" required=""
									aria-invalid="false" />
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>
							<!--
							<div class="form-group d-flex align-items-center">
								<div class="form-check mb-0">
									<label class="form-check-label">
										<input type="checkbox" name="remember" class="form-input-styled" data-fouc>
										{{ __('Ingat Saya') }}
									</label>
								</div>

								{{-- <a href="{{ route('password.request') }}" class="ml-auto">{{ __('Lupa Kata Sandi?') }}</a> --}}
							</div>
							-->
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">{{ __('Login') }} <i
										class="icon-circle-right2 ml-2"></i></button>
							</div>

							<span class="form-text text-center text-muted">{{ configuration('INST_NAME') }}</span>
						</div>
					</div>
				</form>
				<!-- /login form -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<footer class="footer">
		<div class="container text-center">
			<img src="{{ asset('/images/logo.png') }}">
			<h4 class="tagline">{{ strtoupper(configuration('APP_DESC')) }}</h4>
		</div>
	</footer>

	<script>
		$(document).ready(function () {
			$('.form-input-styled').uniform();

			@if ($errors->has('email'))
				swal({
					title: "{{ $errors->first('email') }}",
					type: "error",
					showCancelButton: false,
					showConfirmButton: false,
					timer: 2000
				}).then(() => {
					swal.close();
				});
			@endif

			@if ($errors->has('user_id'))
				swal({
					title: "{{ $errors->first('user_id') }}",
					type: "error",
					showCancelButton: false,
					showConfirmButton: false,
					timer: 2000
				}).then(() => {
					swal.close();
				});
			@endif

			@if ($errors->has('password'))
				swal({
					title: "{{ $errors->first('password') }}",
					type: "error",
					showCancelButton: false,
					showConfirmButton: false,
					timer: 2000
				}).then(() => {
					swal.close();
				});
			@endif

			var validator = $('#form-login').validate({
				ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
				errorClass: 'validation-invalid-label',
				successClass: 'validation-valid-label',
				validClass: 'validation-valid-label',
				highlight: function (element, errorClass) {
					$(element).removeClass(errorClass);
				},
				unhighlight: function (element, errorClass) {
					$(element).removeClass(errorClass);
				},
				// Different components require proper error label placement
				errorPlacement: function (error, element) {

					// Unstyled checkboxes, radios
					if (element.parents().hasClass('form-check')) {
						error.appendTo(element.parents('.form-check').parent());
					}

					// Input with icons and Select2
					else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
						error.appendTo(element.parent());
					}

					// Input group, styled file input
					else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
						error.appendTo(element.parent().parent());
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
		});
	</script>

</body>

</html>
