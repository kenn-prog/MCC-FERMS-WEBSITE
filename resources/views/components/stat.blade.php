@props(['label', 'value', 'hl' => false])
<div class="card stat {{ $hl ? 'hl' : '' }}"><span>{{ $label }}</span><b>{{ $value }}</b></div>
