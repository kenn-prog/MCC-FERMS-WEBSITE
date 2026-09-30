@extends('layouts.app')
@section('title', 'Settings')

@section('content')
<div class="grid settings-l" style="grid-template-columns:220px 1fr;align-items:start">
    <div class="card stabs" style="padding:10px">
        @foreach ($tabs as $t)
            <a class="link {{ $tab === $t ? 'on' : '' }}" href="{{ route('admin.settings.show', ['tab' => $t]) }}">{{ $t }}</a>
        @endforeach
    </div>

    <div class="card">
        <h3 style="font-size:17px">{{ $tab }}</h3>

        @if ($items)
            <form method="POST" action="{{ route('admin.settings.update', $tab) }}">
                @csrf @method('PUT')

                @foreach ($items as $item)
                    @php
                        [$label, $desc, $type] = $item;
                        $slug    = \Illuminate\Support\Str::slug($label, '_');
                        $options = $type === 'select' ? $item[3] : null;
                        $default = $type === 'select' ? $item[4] : $item[3];
                        $value   = $saved[$slug] ?? $default;
                    @endphp
                    <x-setting-row :label="$label" :description="$desc">
                        @switch($type)
                            @case('toggle')
                                <x-toggle :name="'s['.$slug.']'" :on="(bool) $value" />
                                @break
                            @case('select')
                                <select name="s[{{ $slug }}]">
                                    @foreach ($options as $o)<option @selected($o === $value)>{{ $o }}</option>@endforeach
                                </select>
                                @break
                            @case('text')
                                <input name="s[{{ $slug }}]" value="{{ $value }}">
                                @break
                            @default
                                <span class="badge gr">{{ $value }}</span>
                        @endswitch
                    </x-setting-row>
                @endforeach

                <div class="acts">
                    <a class="btn" href="{{ route('admin.settings.show', ['tab' => $tab]) }}">Cancel</a>
                    <button type="submit" class="btn p">Save Changes</button>
                </div>
            </form>
        @else
            <dl class="dl" style="gap:16px">
                <dt>System Name</dt><dd>{{ config('ferms.name') }}</dd>
                <dt>Version</dt><dd>1.0.0 (Laravel Blade)</dd>
                <dt>Last Update</dt><dd>Sep 30, 2026</dd>
                <dt>Database</dt><dd><x-badge status="Not connected" /> <span class="mut">— mock data</span></dd>
                <dt>About</dt><dd class="sub">{{ config('ferms.full_name') }} of {{ config('ferms.school') }}.</dd>
            </dl>
        @endif
    </div>
</div>
@endsection
