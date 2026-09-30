@extends('layouts.app')
@section('title', 'Equipment')

@section('content')
<x-page-head title="Equipment Management">
    <button type="button" class="btn p" data-open="add-eq">+ Add Equipment</button>
</x-page-head>

<form method="GET" class="tools">
    <input name="q" value="{{ $q }}" placeholder="Search equipment…" data-auto>
    <select name="cat" data-auto>
        @foreach ($filterCategories as $o)<option @selected($cat === $o)>{{ $o }}</option>@endforeach
    </select>
    <select name="status" data-auto>
        @foreach (array_merge(['All'], $statuses) as $o)<option @selected($st === $o)>{{ $o }}</option>@endforeach
    </select>
</form>

<x-data-table :heads="['Equipment', 'Category', 'Available / Total', 'Condition', 'Status', 'Actions']" :is-empty="$equipment->isEmpty()">
    @foreach ($equipment as $e)
        <tr>
            <td><b>{{ $e['name'] }}</b></td>
            <td>{{ $e['category'] }}</td>
            <td>{{ $e['available'] }} / {{ $e['total'] }}</td>
            <td><x-badge :status="$e['condition']" /></td>
            <td><x-badge :status="$e['status']" /></td>
            <td class="row">
                <button type="button" class="btn sm" data-open="view-eq-{{ $e['id'] }}">View</button>
                <button type="button" class="btn sm" data-open="edit-eq-{{ $e['id'] }}">Edit</button>
            </td>
        </tr>
    @endforeach
</x-data-table>

<x-form-modal id="add-eq" title="Add Equipment" :action="route('admin.equipment.store')">
    @include('admin.partials.equipment-fields', ['modal' => 'add-eq'])
</x-form-modal>

@foreach ($equipment as $e)
    <x-modal :id="'view-eq-'.$e['id']" :title="$e['name']">
        <dl class="dl">
            <dt>Category</dt><dd>{{ $e['category'] }}</dd>
            <dt>Available</dt><dd>{{ $e['available'] }} of {{ $e['total'] }}</dd>
            <dt>Condition</dt><dd><x-badge :status="$e['condition']" /></dd>
            <dt>Status</dt><dd><x-badge :status="$e['status']" /></dd>
        </dl>
        <div class="acts">
            <button type="button" class="btn p" data-open="edit-eq-{{ $e['id'] }}">Edit</button>
            <button type="button" class="btn" data-close>Close</button>
        </div>
    </x-modal>

    <x-form-modal :id="'edit-eq-'.$e['id']" title="Edit Equipment" :action="route('admin.equipment.update', $e['id'])" method="PUT">
        @include('admin.partials.equipment-fields', ['modal' => 'edit-eq-'.$e['id'], 'e' => $e])
    </x-form-modal>
@endforeach
@endsection
