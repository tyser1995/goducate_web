<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images') }}/logo.webp">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!-- Extra details for Live View on GitHub Pages -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <script src="{{asset('atlantis')}}/js/plugin/webfont/webfont.min.js"></script>
    <script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../atlantis/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

    <!-- CSS Files -->
	<link rel="stylesheet" href="{{asset('atlantis')}}/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{asset('atlantis')}}/css/atlantis.min.css">
    <link rel="stylesheet" href="{{asset('atlantis')}}/css/global.css">
    <link rel="stylesheet" href="{{asset('atlantis')}}/plugins/summernote/summernote-bs4.min.css">
     <!-- daterange picker -->
  	<link rel="stylesheet" href="{{asset('atlantis')}}/plugins/daterangepicker/daterangepicker.css">
    
    <style>
        body {
            background-image: url('images/A14.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
    <script src="{{ asset('js/print.js') }}"></script>
</head>

<x-head.tinymce-config />
<body class="hold-transition login-page">

    @auth()
    @include('layouts.page_templates.auth')
    @endauth

    @guest
    @include('layouts.page_templates.guest')
    @endguest

    <script>
        var base_url = "{{ url('/') }}";
    </script>
    {{-- <script src="{{ asset('service-worker.js') }}"></script> --}}
 {{-- <script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("service-worker.js").then(function(reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
    </script> --}}

    <!-- adminlte -->
    <!-- REQUIRED SCRIPTS -->
    <!--   Core JS Files   -->
	<script src="{{ asset('atlantis') }}/js/core/jquery.3.2.1.min.js"></script>
	<script src="{{ asset('atlantis') }}/js/core/popper.min.js"></script>
	<script src="{{ asset('atlantis') }}/js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('atlantis') }}/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="{{ asset('atlantis') }}/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('atlantis') }}/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


	<!-- Chart JS -->
	<script src="{{ asset('atlantis') }}/js/plugin/chart.js/chart.min.js"></script>

	<!-- jQuery Sparkline -->
	<script src="{{ asset('atlantis') }}/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('atlantis') }}/js/plugin/chart-circle/circles.min.js"></script>

	<!-- Datatables -->
	<script src="{{ asset('atlantis') }}/js/plugin/datatables/datatables.min.js"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('atlantis') }}/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

	<!-- jQuery Vector Maps -->
	<script src="{{ asset('atlantis') }}/js/plugin/jqvmap/jquery.vmap.min.js"></script>
	<script src="{{ asset('atlantis') }}/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

	<!-- Sweet Alert -->
	<script src="{{ asset('atlantis') }}/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Summernote -->
    <script src="{{ asset('atlantis') }}/plugins/summernote/summernote-bs4.min.js"></script>
    
    <!-- date-range-picker -->
	<script src="{{ asset('atlantis') }}/plugins/daterangepicker/daterangepicker.js"></script>
    
    <!-- InputMask -->
    <script src="{{ asset('atlantis') }}/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('atlantis') }}/plugins/inputmask/jquery.inputmask.min.js"></script>

    <!-- Atlantis JS -->
	<script src="{{ asset('atlantis') }}/js/atlantis.min.js"></script>
	

    <script>
    var base_url = "{{ url('/') }}";
    var PRELOADING = "<div class='text-center'><i class='fa fa-spin fa-spinner' style='font-size: 30px'></i></div>";
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
        //autoclose alert
        $('div.alert').delay(3000).slideUp(300);
    })
    </script>
    @stack('scripts')

    @include('layouts.navbars.fixed-plugin-js')
</body>
</html>
