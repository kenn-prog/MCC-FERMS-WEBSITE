@extends('layouts.app')
@section('title', 'Requests')

@section('content')
<div class="tools">
    @foreach ($tabs as $t)
        <a class="chip {{ $tab === $t ? 'on' : '' }}" href="{{ route('admin.requests.index', ['tab' => $t]) }}">{{ $t }} ({{ $counts[$t] ?? 0 }})</a>
    @endforeach
</div>

<form method="GET" class="tools">
    <input type="hidden" name="tab" value="{{ $tab }}">
    <input name="q" value="{{ $q }}" placeholder="Search requests…" data-auto>
</form>

<x-data-table :heads="['Requester', 'Facility / Equipment', 'Date & Time', 'Purpose', 'Org / Class', 'Status', 'Actions']" :is-empty="$requests->isEmpty()">
    @foreach ($requests as $r)
        <tr>
            <td><b>{{ $r['who'] }}</b></td>
            <td>{{ $r['item'] }}</td>
            <td>{{ \Carbon\Carbon::parse($r['date'])->format('M j, Y') }}<div class="mut">{{ $r['time'] }}</div></td>
            <td>{{ $r['purpose'] }}</td>
            <td>{{ $r['org'] }}</td>
            <td><x-badge :status="$r['status']" /></td>
            <td>
                <div class="row wrap">
                    @include('admin.partials.decision-buttons')
                    <button type="button" class="btn sm" data-open="req-{{ $r['id'] }}">Details</button>
                </div>
            </td>
        </tr>
    @endforeach
</x-data-table>

@foreach ($requests as $r)
    <x-modal :id="'req-'.$r['id']" title="Request Details">
        <dl class="dl">
            <dt>Requester</dt><dd>{{ $r['who'] }}</dd>
            <dt>Item</dt><dd>{{ $r['item'] }}</dd>
            <dt>Date</dt><dd>{{ \Carbon\Carbon::parse($r['date'])->format('M j, Y') }}</dd>
            <dt>Time</dt><dd>{{ $r['time'] }}</dd>
            <dt>Purpose</dt><dd>{{ $r['purpose'] }}</dd>
            <dt>Organization</dt><dd>{{ $r['org'] }}</dd>
            <dt>Status</dt><dd><x-badge :status="$r['status']" /></dd>
        </dl>
        <div class="acts">
            @include('admin.partials.decision-buttons')
            <button type="button" class="btn" data-close>Close</button>
        </div>
    </x-modal>
@endforeach
@endsection
