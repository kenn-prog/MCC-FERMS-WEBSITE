<div class="top">
    <div class="ib menu" data-menu><x-icon name="menu" /></div>
    <div>
        <h1>@yield('title')</h1>
        <small>{{ config('ferms.full_name') }}</small>
    </div>
    <div class="sp"></div>

    @if ($role === 'student')
        <a class="ib" href="{{ route('student.inbox.index') }}">
            <x-icon name="inbox" />
            @if ($unreadCount)<i class="ping"></i>@endif
        </a>
    @endif

    <a class="av" style="color:inherit" href="{{ route($role.'.profile.show') }}">{{ $me['initials'] }}</a>
</div>
