@extends('layouts.app')
@section('title', 'Schedule')

@section('content')
@php
    $label = match ($view) {
        'Month' => $sel->format('F Y'),
        'Day'   => $sel->format('M j, Y'),
        default => 'Week of '.$sel->copy()->subDays($sel->dayOfWeek)->format('M j'),
    };
    $link = fn ($date, $v = null) => route('student.schedule', ['view' => $v ?? $view, 'date' => $date]);
@endphp

<div class="tools">
    @foreach (['Day', 'Week', 'Month'] as $v)
        <a class="chip {{ $view === $v ? 'on' : '' }}" href="{{ $link($sel->toDateString(), $v) }}">{{ $v }}</a>
    @endforeach
    <span class="sp"></span>
    <a class="btn sm" href="{{ $link($prev) }}">‹</a>
    <b style="min-width:150px;text-align:center;font-size:14px">{{ $label }}</b>
    <a class="btn sm" href="{{ $link($next) }}">›</a>
    <a class="btn sm" href="{{ $link($today->toDateString()) }}">Today</a>
</div>

@if ($view === 'Day')
    <div style="max-width:640px">@include('student.partials.day-panel')</div>

@elseif ($view === 'Week')
    <div class="week">
        @foreach ($cells as $d)
            <a class="card {{ $d->isSameDay($sel) ? 'sel' : '' }}" href="{{ $link($d->toDateString()) }}">
                <small>{{ $d->format('D') }}</small>
                <b style="font-size:18px">{{ $d->day }}</b>
                @foreach ($bookings->get($d->toDateString(), collect()) as $r)
                    <div class="ev">{{ $r['item'] }}<br>{{ explode(' – ', $r['time'])[0] }}</div>
                @endforeach
            </a>
        @endforeach
    </div>
    <div class="mt">@include('student.partials.day-panel')</div>

@else
    <div class="cal-wrap">
        <div class="card">
            <div class="cal-grid">
                @foreach (str_split('SMTWTFS') as $dow)<div class="cal-dow">{{ $dow }}</div>@endforeach
                @foreach ($cells as $d)
                    @php
                        $c = ['cal-day'];
                        if ($d->month !== $sel->month) $c[] = 'muted';
                        if ($d->isSameDay($today)) $c[] = 'today';
                        if ($bookings->has($d->toDateString())) $c[] = 'reserved';
                        elseif ($d->gte($today) && $d->dayOfWeek !== 0) $c[] = 'available';
                        if ($d->isSameDay($sel)) $c[] = 'selected';
                    @endphp
                    <a class="{{ implode(' ', $c) }}" href="{{ $link($d->toDateString()) }}">{{ $d->day }}</a>
                @endforeach
            </div>
            <div class="legend">
                <span><i style="background:var(--green)"></i>Available</span>
                <span><i style="background:var(--amber)"></i>Reserved</span>
                <span><i style="background:var(--red)"></i>Selected</span>
                <span><i style="background:var(--gray)"></i>Unavailable</span>
            </div>
        </div>
        @include('student.partials.day-panel')
    </div>
@endif
@endsection
