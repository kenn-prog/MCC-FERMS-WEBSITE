<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.head')
    <title>@yield('title', 'Sign in') · {{ config('ferms.name') }}</title>
</head>
<body>
    @yield('content')

    @if (session('status'))
        <div class="toast" data-toast>{{ session('status') }}</div>
    @endif
    <script src="{{ asset('js/ferms.js') }}" defer></script>
</body>
</html>
