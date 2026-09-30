@props(['f'])
@php $open = in_array($f['status'], ['Available', 'Limited'], true); @endphp
<div class="card">
    <div class="row">
        <div class="ico">🏛</div>
        <div class="g1" style="flex:1"><b>{{ $f['name'] }}</b><div class="mut">📍 {{ $f['location'] }}</div></div>
        <x-badge :status="$f['status']" />
    </div>
    <p class="sub" style="margin:12px 0">{{ $f['description'] }}</p>
    <div class="row">
        <span class="mut">👥 Capacity {{ $f['capacity'] }}</span>
        <span class="sp"></span>
        <button type="button" class="btn sm p" @if ($open) data-open="reserve-fac-{{ $f['id'] }}" @else disabled style="opacity:.4" @endif>Reserve</button>
    </div>
</div>
