<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name')}} | @yield('title')</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('theme/global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/bootstrap_limitless.min.css') }} " rel="stylesheet">
    <link href="{{ asset('theme/assets/css/layout.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/components.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/colors.min.css') }}" rel="stylesheet">
  </head>
  <body>
    <div id="app">
      <main class="py-4">
        @yield('content_login')
      </main>
    </div>  
    <script src="{{ asset('theme/global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <script src="{{ asset('theme/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('theme/global_assets/js/plugins/ui/ripple.min.js') }}"></script>
    <script src="{{ asset('theme/global_assets/js/plugins/forms/inputs/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('theme/global_assets/js/plugins/forms/inputs/inputmask/inputmask.binding.js') }}"></script>
    <script src="{{ asset('theme/assets/js/custom_login.js') }}"></script>
  </body>
</html>