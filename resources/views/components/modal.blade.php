@props(['id', 'title'])
{{-- Re-opens automatically after a failed validation (the form posts its own id as _modal). --}}
<div class="ov" id="{{ $id }}" data-modal @unless (old('_modal') === $id) hidden @endunless>
    <div class="modal">
        <h2>{{ $title }}</h2>
        {{ $slot }}
    </div>
</div>
