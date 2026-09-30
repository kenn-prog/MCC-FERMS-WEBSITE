@extends('layouts.app')
@section('title', 'Reservations')

@section('content')
<div class="tools">
    @foreach ($tabs as $t)
        <a class="chip {{ $tab === $t ? 'on' : '' }}" href="{{ route('student.reservations.index', ['tab' => $t]) }}">{{ $t }}</a>
    @endforeach
</div>

<div class="card">
    @forelse ($reservations as $r)
        <x-res-item :r="$r" />
    @empty
        <div class="mut center" style="padding:20px">Nothing here yet.</div>
    @endforelse
</div>
@endsection
