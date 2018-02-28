<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/normalize/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/trirong/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>

    <script>
        window.pmfSelectedMenu = '{{ isset($menu) ? $menu : "" }}';
        window.pmfAppName = "{{env('APP_NAME')}}";
    </script>

    <script>
        @php echo 'window.pmfSettings = '.'"'.base64_encode(json_encode(config('setting'))).substr(csrf_token(),5, 15).'";'; //it is the system settings @endphp
        @php echo 'window.pmfLicenseInfo = '.'"'.base64_encode(json_encode(authUserInfo())).substr(csrf_token(),5, 15).'";'; //it is permission info but i want to hide variable name @endphp
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
