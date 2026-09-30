@props(['heads', 'isEmpty' => false, 'card' => true])
<div class="{{ $card ? 'card ' : '' }}tw" @if ($card) style="padding:6px 10px" @endif>
    <table>
        <thead><tr>@foreach ($heads as $h)<th>{{ $h }}</th>@endforeach</tr></thead>
        <tbody>
            @if ($isEmpty)
                <tr><td colspan="{{ count($heads) }}" class="mut center">No results found</td></tr>
            @else
                {{ $slot }}
            @endif
        </tbody>
    </table>
</div>
