@php $items = $bookings->get($sel->toDateString(), collect()); @endphp
<div>
    <h3 style="margin:0 0 12px;font-size:15px">{{ $sel->format('M j') }} · {{ $sel->format('l') }}</h3>
    <div class="card">
        @forelse ($items as $r)
            <x-res-item :r="$r" />
        @empty
            <div class="mut center" style="padding:18px">No reservations on this day.</div>
        @endforelse
    </div>
    <a class="btn p w" style="margin-top:12px" href="{{ route('student.facilities.index') }}">Reserve for this date</a>
</div>
