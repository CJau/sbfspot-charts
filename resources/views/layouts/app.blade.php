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
<body class="h-screen antialiased bg-gray-300">
    <div id="app">
        <nav class="py-6 mb-4 bg-gray-400">

            <div class="container px-6 mx-auto md:px-0">
                <div class="flex items-center justify-space">
                    <div class="items-start mr-6">
                        <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-900 no-underline">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>
                    <div class="items-center flex-1 text-right">
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
        @guest
            <a href="{{ route('login') }}">Login</a>
        @else
            <form action="{{ route('logout')  }}" method="POST" class="inline">
                @csrf
                <button class="p-0 m-0 border-0" type="submit">Logout</button>
            </form>
        @endguest
    </div>

    <!-- Scripts -->
    <script src="{{ url('js/app.js') }}"></script>
    @stack('footer-scripts')
</body>
</html>
