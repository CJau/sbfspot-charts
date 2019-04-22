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
                <div class="flex items-center justify-space">
                    <div class="mr-6 items-start">
                        <a href="{{ url('/') }}" class="text-xl font-semibold text-grey-darkest no-underline">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <div class="flex-1 text-right items-center">
                        <responsive-nav-component :items="{{ json_encode([
                          ['url' => route('graphs.day'), 'label' => __('Daily') ],
                          ['url' => route('graphs.month'), 'label' => __('Monthly') ],
                          ['url' => route('graphs.year'), 'label' => __('Yearly') ],
                        ]) }}"></responsive-nav-component>
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
