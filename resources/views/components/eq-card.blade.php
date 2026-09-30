@props(['e'])
<div class="card">
    <div class="row">
        <div class="ico">📦</div>
        <div style="flex:1"><b>{{ $e['name'] }}</b><div class="mut">{{ $e['category'] }}</div></div>
        <x-badge :status="$e['status']" />
    </div>
    <div class="bar"><i style="width:{{ $e['total'] ? $e['available'] / $e['total'] * 100 : 0 }}%"></i></div>
    <div class="row mut">
        <span><b style="color:var(--t0)">{{ $e['available'] }}</b> of {{ $e['total'] }} available</span>
        <span class="sp"></span>
        <x-badge :status="$e['condition']" />
    </div>
    <button type="button" class="btn sm p w" style="margin-top:12px{{ $e['available'] ? '' : ';opacity:.4' }}"
            @if ($e['available']) data-open="reserve-eq-{{ $e['id'] }}" @else disabled @endif>Request Equipment</button>
</div>
