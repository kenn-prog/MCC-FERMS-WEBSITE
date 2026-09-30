@props(['id', 'title', 'action', 'method' => 'POST', 'submit' => 'Save'])
<x-modal :id="$id" :title="$title">
    <form method="POST" action="{{ $action }}" novalidate>
        @csrf
        @if (strtoupper($method) !== 'POST') @method($method) @endif
        <input type="hidden" name="_modal" value="{{ $id }}">

        {{ $slot }}

        <div class="acts">
            <button type="button" class="btn" data-close>Cancel</button>
            <button type="submit" class="btn p">{{ $submit }}</button>
        </div>
    </form>
</x-modal>
