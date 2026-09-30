@extends('layouts.app')
@section('title', 'Facilities')

@section('content')
<form method="GET" class="tools">
    <input name="q" value="{{ $q }}" placeholder="Search facilities…" data-auto>
    @if ($cat !== 'All')<input type="hidden" name="cat" value="{{ $cat }}">@endif
</form>

<div class="tools">
    @foreach ($categories as $c)
        <a class="chip {{ $cat === $c ? 'on' : '' }}"
           href="{{ route('student.facilities.index', array_filter(['cat' => $c === 'All' ? null : $c, 'q' => $q ?: null])) }}">{{ $c }}</a>
    @endforeach
</div>

@if ($facilities->isEmpty())
    <x-empty>No facilities match your search.</x-empty>
@else
    <div class="grid g3 f">
        @foreach ($facilities as $f)<x-fac-card :f="$f" />@endforeach
    </div>
@endif

{{-- Modals live outside the cards (cards use backdrop-filter, which would trap fixed overlays). --}}
@foreach ($facilities as $f)
    @if (in_array($f['status'], ['Available', 'Limited'], true))
        @php $m = 'reserve-fac-'.$f['id']; @endphp
        <x-form-modal :id="$m" :title="'Reserve '.$f['name']" :action="route('student.reservations.store', ['facility', $f['id']])" submit="Submit Request">
            @include('student.partials.reserve-fields', ['modal' => $m, 'withQty' => false])
        </x-form-modal>
    @endif
@endforeach
@endsection
