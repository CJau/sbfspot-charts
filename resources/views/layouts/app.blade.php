<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ url('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-grey-lighter h-screen antialiased">
    <div id="app">
        <nav class="bg-grey-light mb-4 py-6">
            <div class="container mx-auto px-6 md:px-0">
                <div class="flex items-center justify-center">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-xl font-semibold text-grey-darkest no-underline">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <div class="flex-1 text-right">
                        <a class="no-underline text-grey-darkest text-sm font-semibold hover:text-grey-dark p-3" href="{{ route('graphs.day') }}">{{ __('Daily') }}</a>
                        <a class="no-underline text-grey-darkest text-sm font-semibold hover:text-grey-dark p-3" href="{{ route('graphs.month') }}">{{ __('Monthly') }}</a>
                        <a class="no-underline text-grey-darkest text-sm font-semibold hover:text-grey-dark p-3" href="{{ route('graphs.year') }}">{{ __('Yearly') }}</a>
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ url('js/app.js') }}"></script>
    @stack('footer-scripts')
</body>
</html>
