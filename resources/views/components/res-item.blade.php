@props(['r'])
<div class="li">
    <div class="ico">📅</div>
    <div class="g1">
        <b>{{ $r['item'] }}</b>
        <div class="mut">{{ \Carbon\Carbon::parse($r['date'])->format('M j, Y') }} · {{ $r['time'] }}</div>
        <div class="sub">{{ $r['purpose'] }}</div>
    </div>
    <x-badge :status="$r['status']" :label="$r['status'] === 'Approved' ? 'Confirmed' : null" />
    @if ($r['status'] === 'Pending')
        <form method="POST" action="{{ route('student.reservations.cancel', $r['id']) }}" class="inline">
            @csrf @method('PATCH')
            <button class="btn sm no">Cancel</button>
        </form>
    @endif
</div>
