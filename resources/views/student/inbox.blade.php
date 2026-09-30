@extends('layouts.app')
@section('title', 'Inbox')

@section('content')
<x-page-head title="Notifications">
    <form method="POST" action="{{ route('student.inbox.read-all') }}" class="inline">
        @csrf
        <button class="btn sm">Mark all as read</button>
    </form>
</x-page-head>

<div class="card">
    @foreach ($notifications as $n)<x-notif-item :n="$n" />@endforeach
</div>
@endsection
