@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<div class="grid gm">
    <div class="card center">
        <div class="av xl" style="margin:8px auto 14px">{{ $me['initials'] }}</div>
        <h2 style="margin:0">{{ $me['name'] }}</h2>
        <div class="mut" style="margin-bottom:16px">{{ $me['email'] }}</div>
        <dl class="dl" style="text-align:left">
            <dt>Student ID</dt><dd>{{ $me['student_id'] }}</dd>
            <dt>Program</dt><dd>{{ $me['course'] }}</dd>
            <dt>Year / Section</dt><dd>{{ $me['year'] }}</dd>
            <dt>Organization</dt><dd>{{ $me['organization'] }}</dd>
        </dl>
    </div>

    <div class="card">
        <h3>Account</h3>
        <a class="li" style="cursor:pointer" data-open="personal-info"><div class="g1"><b>Personal Information</b></div><span class="mut">›</span></a>
        <a class="li" href="{{ route('student.reservations.index') }}"><div class="g1"><b>My Reservations</b></div><span class="mut">›</span></a>
        <a class="li" href="{{ route('student.inbox.index') }}"><div class="g1"><b>Inbox</b></div><span class="mut">›</span></a>
        <a class="li" style="cursor:pointer" data-open="student-settings"><div class="g1"><b>Settings</b></div><span class="mut">›</span></a>
        <a class="li" style="cursor:pointer" data-open="help-support"><div class="g1"><b>Help &amp; Support</b></div><span class="mut">›</span></a>
        <form method="POST" action="{{ route('logout') }}" class="li" style="cursor:pointer;color:#ff6b74" data-click-submit>
            @csrf
            <div class="g1"><b>Log Out</b></div>
        </form>
    </div>
</div>

<x-form-modal id="personal-info" title="Personal Information" :action="route('student.profile.update')" method="PUT">
    <x-field name="name" label="Full Name" :value="$me['name']" modal="personal-info" :required="true" />
    <x-field name="course" label="Course / Program" :value="$me['course']" modal="personal-info" :required="true" />
    <x-field name="year" label="Year / Section" :value="$me['year']" modal="personal-info" :required="true" />
    <x-field name="organization" label="Organization / Class" :value="$me['organization']" modal="personal-info" />
</x-form-modal>

<x-form-modal id="student-settings" title="Settings" :action="route('student.profile.settings')" submit="Save Changes">
    <x-setting-row label="Email notifications" description="Reservation and reminder alerts">
        <x-toggle name="email_notifications" :on="$settings['email_notifications'] ?? true" />
    </x-setting-row>
    <x-setting-row label="Return reminders" description="Alert before equipment is due">
        <x-toggle name="return_reminders" :on="$settings['return_reminders'] ?? true" />
    </x-setting-row>
    <x-setting-row label="Sign-in" description="Managed by MCC Microsoft account"><span class="mut">Microsoft</span></x-setting-row>
</x-form-modal>

<x-modal id="help-support" title="Help & Support">
    <dl class="dl">
        <dt>Office</dt><dd>Property &amp; Facilities Office</dd>
        <dt>Email</dt><dd>fermssupport@mcc.edu.ph</dd>
        <dt>Hours</dt><dd>Mon–Fri, 8:00 AM – 5:00 PM</dd>
    </dl>
    <div class="acts"><button type="button" class="btn" data-close>Close</button></div>
</x-modal>
@endsection
