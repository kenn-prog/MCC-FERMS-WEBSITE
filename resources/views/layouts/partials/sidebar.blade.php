<aside class="sidebar" id="sidebar">
    <div class="brand">
        <div class="mark">MCC</div>
        <div><b>{{ config('ferms.name') }}</b><span>{{ config('ferms.school') }}</span></div>
    </div>

    <div class="lbl">{{ $role === 'admin' ? 'Administration' : 'Menu' }}</div>

    @foreach (config("ferms.nav.$role") as [$icon, $label, $routeName, $pattern])
        <a class="link {{ request()->routeIs($pattern) ? 'on' : '' }}" href="{{ route($routeName) }}">
            <x-icon :name="$icon" />{{ $label }}
            @if ($icon === 'inbox' && $unreadCount)<span class="bd">{{ $unreadCount }}</span>@endif
            @if ($icon === 'req' && $pendingCount)<span class="bd">{{ $pendingCount }}</span>@endif
        </a>
    @endforeach

    <div class="sfoot">
        <a class="mp {{ request()->routeIs($role.'.profile.*') ? 'on' : '' }}" href="{{ route($role.'.profile.show') }}">
            <div class="av">{{ $me['initials'] }}</div>
            <div><b>{{ $me['name'] }}</b><span>{{ $me['subtitle'] }}</span></div>
        </a>
    </div>
</aside>
