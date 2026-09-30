@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="card" style="background:linear-gradient(135deg,rgba(223,37,49,.22),rgba(255,255,255,.04));margin-bottom:16px">
    <h2 style="margin:0 0 4px;font-size:22px">Welcome back, {{ explode(' ', $me['name'])[0] }} 👋</h2>
    <div class="sub">{{ $me['name'] }} · {{ $me['subtitle'] }}</div>
    <div class="row wrap" style="margin-top:16px">
        <a class="btn p" href="{{ route('student.facilities.index') }}">Reserve Facility</a>
        <a class="btn" href="{{ route('student.equipment.index') }}">Request Equipment</a>
    </div>
</div>

<div class="grid g4">
    <x-stat label="Upcoming" :value="$upcoming->count()" :hl="true" />
    <x-stat label="Pending" :value="$pending" />
    <x-stat label="Available Facilities" :value="$availableFac->count()" />
    <x-stat label="Available Equipment" :value="$availableUnits" />
</div>

<div class="grid gm mt">
    <div class="card">
        <h3>Upcoming Reservations</h3>
        @forelse ($upcoming as $r)
            <x-res-item :r="$r" />
        @empty
            <div class="mut">None scheduled.</div>
        @endforelse
    </div>
    <div class="card">
        <h3>Recent Notifications</h3>
        @foreach ($notifications as $n)<x-notif-item :n="$n" />@endforeach
    </div>
</div>

<div class="grid g2 mt">
    <div class="card">
        <h3>Available Facilities</h3>
        @foreach ($availableFac->take(3) as $f)
            <div class="li"><div class="ico">🏛</div><div class="g1"><b>{{ $f['name'] }}</b><div class="mut">{{ $f['location'] }}</div></div><x-badge :status="$f['status']" /></div>
        @endforeach
    </div>
    <div class="card">
        <h3>Available Equipment</h3>
        @foreach ($availableEq->take(3) as $e)
            <div class="li"><div class="ico">📦</div><div class="g1"><b>{{ $e['name'] }}</b><div class="mut">{{ $e['available'] }} of {{ $e['total'] }} available</div></div><x-badge :status="$e['status']" /></div>
        @endforeach
    </div>
</div>
@endsection
