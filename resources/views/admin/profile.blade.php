@extends('layouts.app')
@section('title', 'Admin Profile')

@section('content')
<div class="grid gm">
    <div class="card center">
        <div class="av xl" style="margin:8px auto 14px">{{ $me['initials'] }}</div>
        <h2 style="margin:0">{{ $me['name'] }}</h2>
        <div class="mut">{{ $me['role'] }}</div>
        <div style="margin:12px 0"><x-badge status="Active" /></div>

        <form method="POST" action="{{ route('admin.profile.picture') }}">
            @csrf
            <button class="btn w" style="margin-bottom:8px">Change Profile Picture</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn no w">Log Out</button>
        </form>
    </div>

    <div class="card">
        <h3>Profile Information</h3>
        <dl class="dl" style="gap:14px">
            <dt>Full Name</dt><dd>{{ $me['name'] }}</dd>
            <dt>MCC Email</dt><dd>{{ $me['email'] }}</dd>
            <dt>Employee ID</dt><dd>{{ $me['student_id'] }}</dd>
            <dt>Department</dt><dd>{{ $me['department'] }}</dd>
            <dt>Role</dt><dd>{{ $me['role'] }}</dd>
            <dt>Account</dt><dd>Microsoft Account</dd>
            <dt>Status</dt><dd><x-badge status="Active" /></dd>
        </dl>
        <div class="acts" style="justify-content:flex-start">
            <button type="button" class="btn p" data-open="edit-admin">Edit Profile</button>
        </div>
    </div>
</div>

<x-form-modal id="edit-admin" title="Edit Profile" :action="route('admin.profile.update')" method="PUT">
    <x-field name="name" label="Full Name" :value="$me['name']" modal="edit-admin" :required="true" />
    <x-field name="department" label="Department / Office" :value="$me['department']" modal="edit-admin" :required="true" />
</x-form-modal>
@endsection
