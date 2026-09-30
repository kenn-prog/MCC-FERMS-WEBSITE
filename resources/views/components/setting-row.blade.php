@props(['label', 'description' => ''])
<div class="srow">
    <div><b>{{ $label }}</b><small>{{ $description }}</small></div>
    {{ $slot }}
</div>
