<!--
=========================================================
 Paper Dashboard - v2.0.0
=========================================================

 Product Page: https://www.creative-tim.com/product/paper-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 UPDIVISION (https://updivision.com)
 Licensed under MIT (https://github.com/creativetimofficial/paper-dashboard/blob/master/LICENSE)

 Coded by Creative Tim

=========================================================

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images') }}/logo.webp">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Extra details for Live View on GitHub Pages -->

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <script src="{{asset('atlantis')}}/js/plugin/webfont/webfont.min.js"></script>
	<link rel="stylesheet" href="{{asset('atlantis')}}/plugins/summernote/summernote-bs4.min.css">
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../atlantis/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- jQuery UI CSS -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- CSS Files -->
	<link rel="stylesheet" href="{{asset('atlantis')}}/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{asset('atlantis')}}/css/atlantis.min.css">
	<link rel="stylesheet" href="{{asset('atlantis')}}/css/global.css">

    {{-- <link rel="stylesheet" href="{{asset('atlantis')}}/css/demo.css"> --}}

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
	
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>

	<!-- FullCalendar -->
	<link href='https://cdn.jsdelivr.net/npm/fullcalendar/core/main.min.css' rel='stylesheet' />
	<link href='https://cdn.jsdelivr.net/npm/fullcalendar/daygrid/main.min.css' rel='stylesheet' />

	<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
	<script src='https://cdn.jsdelivr.net/npm/fullcalendar/core@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
	<script src='https://cdn.jsdelivr.net/npm/fullcalendar/interaction/main.min.js'></script>
	
     <!-- daterange picker -->
  	<link rel="stylesheet" href="{{asset('atlantis')}}/plugins/daterangepicker/daterangepicker.css">
</head>

<x-head.tinymce-config />
<body class="{{ $class }}">

    @auth()
        @include('layouts.page_templates.auth')
    @endauth

    @guest
    	@include('layouts.page_templates.guest')
    @endguest

    <script>
        var base_url = "{{ url('/') }}";
    </script>
    <script src="{{ asset('service-worker.js') }}"></script>
    <script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("service-worker.js").then(function(reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
    </script>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- jQuery UI -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- REQUIRED SCRIPTS -->
    <!--   Core JS Files   -->
	{{-- <script src="{{ asset('atlantis') }}/js/core/jquery.3.2.1.min.js"></script> --}}
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
    
	<!-- smartwizard -->
    <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>

	<!-- InputMask -->
	<script src="{{ asset('atlantis') }}/plugins/moment/moment.min.js"></script>
	<script src="{{ asset('atlantis') }}/plugins/inputmask/jquery.inputmask.min.js"></script>

	<!-- date-range-picker -->
	<script src="{{ asset('atlantis') }}/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Atlantis JS -->
	<script src="{{ asset('atlantis') }}/js/atlantis.min.js"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('atlantis') }}/js/setting-demo.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
	<script>
		Circles.create({
			id:'circles-1',
			radius:45,
			value:60,
			maxValue:100,
			width:7,
			text: 5,
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-2',
			radius:45,
			value:70,
			maxValue:100,
			width:7,
			text: 36,
			colors:['#f1f1f1', '#2BB930'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-3',
			radius:45,
			value:40,
			maxValue:100,
			width:7,
			text: 12,
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		$('#lineChart').sparkline([105,103,123,100,95,105,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#ffa534',
			fillColor: 'rgba(255, 165, 52, .14)'
		});
	</script>

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
