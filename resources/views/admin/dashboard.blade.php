@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="grid g6">
    @foreach ($stats as [$label, $value, $hl])
        <x-stat :label="$label" :value="$value" :hl="$hl" />
    @endforeach
</div>

<div class="card mt">
    <h3>Pending Requests</h3>
    <x-data-table :heads="['Requester', 'Item', 'Date', 'Actions']" :is-empty="$pending->isEmpty()" :card="false">
        @foreach ($pending as $r)
            <tr>
                <td>{{ $r['who'] }}</td>
                <td>{{ $r['item'] }}</td>
                <td>{{ \Carbon\Carbon::parse($r['date'])->format('M j, Y') }}</td>
                <td><div class="row">@include('admin.partials.decision-buttons')</div></td>
            </tr>
        @endforeach
    </x-data-table>
</div>

<div class="grid g2 mt">
    <div class="card">
        <h3>Recent Reservations</h3>
        @foreach ($recent as $r)
            <div class="li">
                <div class="g1"><b>{{ $r['item'] }}</b><div class="mut">{{ $r['who'] }} · {{ \Carbon\Carbon::parse($r['date'])->format('M j, Y') }}</div></div>
                <x-badge :status="$r['status']" />
            </div>
        @endforeach
    </div>
    <div class="card">
        <h3>Equipment Requiring Attention</h3>
        @foreach ($attention as $a)
            <div class="li"><div class="ico">⚠</div><div class="g1"><b>{{ $a['name'] }}</b><div class="mut">{{ $a['why'] }}</div></div></div>
        @endforeach
    </div>
</div>

<div class="card mt">
    <h3>Recent System Activity</h3>
    @foreach ($activity as $a)
        <div class="li"><span class="dotu"></span><div class="sub g1">{{ $a }}</div></div>
    @endforeach
</div>
@endsection
