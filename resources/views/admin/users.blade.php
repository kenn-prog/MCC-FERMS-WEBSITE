@extends('layouts.app')
@section('title', 'Users')

@section('content')
<x-page-head title="User Management">
    <button type="button" class="btn p" data-open="add-user">+ Add User</button>
</x-page-head>

<form method="GET" class="tools">
    <input name="q" value="{{ $q }}" placeholder="Search users…" data-auto>
    <select name="type" data-auto>
        @foreach (array_merge(['All'], $types) as $o)<option @selected($type === $o)>{{ $o }}</option>@endforeach
    </select>
</form>

<x-data-table :heads="['Name', 'ID', 'Type', 'Org / Class', 'MCC Email', 'Role', 'Actions']" :is-empty="$users->isEmpty()">
    @foreach ($users as $u)
        <tr>
            <td><b>{{ $u['name'] }}</b></td>
            <td>{{ $u['student_id'] }}</td>
            <td>{{ $u['type'] }}</td>
            <td>{{ $u['organization'] }}</td>
            <td>{{ $u['email'] }}</td>
            <td><x-badge :status="$u['role']" /></td>
            <td><button type="button" class="btn sm" data-open="view-user-{{ $u['id'] }}">View</button></td>
        </tr>
    @endforeach
</x-data-table>

<x-form-modal id="add-user" title="Add User" :action="route('admin.users.store')" submit="Add User">
    <x-field name="name" label="Full Name" modal="add-user" :required="true" />
    <x-field name="student_id" label="ID Number" modal="add-user" :required="true" />
    <x-field name="type" label="User Type" :options="$types" modal="add-user" />
    <x-field name="organization" label="Organization / Class" modal="add-user" :required="true" />
    <x-field name="email" label="MCC Email" type="email" modal="add-user" :required="true" />
    <x-field name="role" label="Role" :options="$roles" modal="add-user" />
</x-form-modal>

@foreach ($users as $u)
    <x-modal :id="'view-user-'.$u['id']" :title="$u['name']">
        <dl class="dl">
            <dt>ID</dt><dd>{{ $u['student_id'] }}</dd>
            <dt>Type</dt><dd>{{ $u['type'] }}</dd>
            <dt>Org / Class</dt><dd>{{ $u['organization'] }}</dd>
            <dt>MCC Email</dt><dd>{{ $u['email'] }}</dd>
            <dt>Role</dt><dd>{{ $u['role'] }}</dd>
        </dl>
        <div class="acts"><button type="button" class="btn" data-close>Close</button></div>
    </x-modal>
@endforeach
@endsection
