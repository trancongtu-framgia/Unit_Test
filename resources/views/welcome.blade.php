<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!--begin::Web font -->
        <script src="{{ asset('js/webfont.js') }}"></script>
		<script src="{{ asset('js/loadwebfont.js') }}"></script>
		
		<link href="{{ asset(config('api.vendors') . 'vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="{{ asset(config('api.base') . 'style.bundle.css') }}" type="text/css">
		<link rel="stylesheet" href="{{ asset('css/master.css') }}">
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
		<div id="app">
			<vue-app></vue-app>
		</div>
		<script src="{{ asset(config('api.vendors') . 'vendors.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset(config('api.base') . 'scripts.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/app.js') }}"></script>		
</html>
