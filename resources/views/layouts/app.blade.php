<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.head')
    <title>@yield('title') · {{ config('ferms.name') }}</title>
</head>
<body>
<div class="app">
    <div class="scrim" data-scrim></div>

    @include('layouts.partials.sidebar')

    <div class="main">
        @include('layouts.partials.topbar')

        <div class="content">
            @yield('content')
        </div>
    </div>
</div>

@if (session('status'))
    <div class="toast" data-toast>{{ session('status') }}</div>
@endif

<script src="{{ asset('js/ferms.js') }}" defer></script>
</body>
</html>
