@extends('layouts.app')
@section('title', 'Facilities')

@section('content')
<x-page-head title="Facility Management">
    <button type="button" class="btn p" data-open="add-fac">+ Add Facility</button>
</x-page-head>

<form method="GET" class="tools">
    <input name="q" value="{{ $q }}" placeholder="Search facilities…" data-auto>
    <select name="status" data-auto>
        @foreach (array_merge(['All'], $statuses) as $o)<option @selected($st === $o)>{{ $o }}</option>@endforeach
    </select>
</form>

<x-data-table :heads="['Facility', 'Location', 'Capacity', 'Status', 'Actions']" :is-empty="$facilities->isEmpty()">
    @foreach ($facilities as $f)
        <tr>
            <td><b>{{ $f['name'] }}</b><div class="mut">{{ $f['category'] }}</div></td>
            <td>{{ $f['location'] }}</td>
            <td>{{ $f['capacity'] }}</td>
            <td><x-badge :status="$f['status']" /></td>
            <td class="row">
                <button type="button" class="btn sm" data-open="view-fac-{{ $f['id'] }}">View</button>
                <button type="button" class="btn sm" data-open="edit-fac-{{ $f['id'] }}">Edit</button>
            </td>
        </tr>
    @endforeach
</x-data-table>

<x-form-modal id="add-fac" title="Add Facility" :action="route('admin.facilities.store')">
    @include('admin.partials.facility-fields', ['modal' => 'add-fac'])
</x-form-modal>

@foreach ($facilities as $f)
    <x-modal :id="'view-fac-'.$f['id']" :title="$f['name']">
        <dl class="dl">
            <dt>Location</dt><dd>{{ $f['location'] }}</dd>
            <dt>Capacity</dt><dd>{{ $f['capacity'] }}</dd>
            <dt>Category</dt><dd>{{ $f['category'] }}</dd>
            <dt>Status</dt><dd><x-badge :status="$f['status']" /></dd>
            <dt>Description</dt><dd>{{ $f['description'] }}</dd>
        </dl>
        <div class="acts">
            <button type="button" class="btn p" data-open="edit-fac-{{ $f['id'] }}">Edit</button>
            <button type="button" class="btn" data-close>Close</button>
        </div>
    </x-modal>

    <x-form-modal :id="'edit-fac-'.$f['id']" title="Edit Facility" :action="route('admin.facilities.update', $f['id'])" method="PUT">
        @include('admin.partials.facility-fields', ['modal' => 'edit-fac-'.$f['id'], 'f' => $f])
    </x-form-modal>
@endforeach
@endsection
