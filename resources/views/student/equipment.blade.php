@extends('layouts.app')
@section('title', 'Equipment')

@section('content')
<form method="GET" class="tools">
    <input name="q" value="{{ $q }}" placeholder="Search equipment…" data-auto>
    @if ($cat !== 'All')<input type="hidden" name="cat" value="{{ $cat }}">@endif
</form>

<div class="tools">
    @foreach ($categories as $c)
        <a class="chip {{ $cat === $c ? 'on' : '' }}"
           href="{{ route('student.equipment.index', array_filter(['cat' => $c === 'All' ? null : $c, 'q' => $q ?: null])) }}">{{ $c }}</a>
    @endforeach
</div>

@if ($equipment->isEmpty())
    <x-empty>No equipment matches your search.</x-empty>
@else
    <div class="grid g3 f">
        @foreach ($equipment as $e)<x-eq-card :e="$e" />@endforeach
    </div>
@endif

@foreach ($equipment as $e)
    @if ($e['available'] > 0)
        @php $m = 'reserve-eq-'.$e['id']; @endphp
        <x-form-modal :id="$m" :title="'Request '.$e['name']" :action="route('student.reservations.store', ['equipment', $e['id']])" submit="Submit Request">
            @include('student.partials.reserve-fields', ['modal' => $m, 'withQty' => true])
        </x-form-modal>
    @endif
@endforeach
@endsection
