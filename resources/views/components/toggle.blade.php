@props(['name', 'on' => false])
<span>
    <input type="hidden" name="{{ $name }}" value="{{ $on ? 1 : 0 }}">
    <button type="button" class="tog {{ $on ? 'on' : '' }}" data-toggle aria-label="Toggle"></button>
</span>
