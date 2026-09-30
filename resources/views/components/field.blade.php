@props(['name', 'label', 'modal', 'type' => 'text', 'value' => '', 'options' => null, 'required' => false, 'rows' => 3])
@php
    $active = old('_modal') === $modal;
    $val    = $active ? old($name, $value) : $value;
    $err    = $active ? $errors->first($name) : '';
    $id     = $modal.'-'.$name;
    $cls    = $err ? 'bad' : '';
@endphp
<div class="fld">
    <label for="{{ $id }}">{{ $label }}{{ $required ? ' *' : '' }}</label>

    @if ($options)
        <select id="{{ $id }}" name="{{ $name }}" class="{{ $cls }}">
            @foreach ($options as $o)
                <option value="{{ $o }}" @selected((string) $o === (string) $val)>{{ $o }}</option>
            @endforeach
        </select>
    @elseif ($type === 'textarea')
        <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}" class="{{ $cls }}">{{ $val }}</textarea>
    @else
        <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" value="{{ $val }}" class="{{ $cls }}">
    @endif

    <div class="err">{{ $err }}</div>
</div>
