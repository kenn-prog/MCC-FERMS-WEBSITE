@extends('layouts.guest')
@section('title', 'Sign in')

@section('content')
<div class="login">
    <div class="card">
        <div class="center">
            <div class="mark" style="margin:0 auto 14px;width:54px;height:54px;font-size:18px;border-radius:16px">MCC</div>
            <h2 style="margin:0 0 6px;font-size:22px">Welcome to {{ config('ferms.name') }}</h2>
            <div class="sub">{{ config('ferms.full_name') }}<br><span class="mut">{{ config('ferms.school') }}</span></div>
        </div>

        <p class="sub center" style="margin:20px 0 16px">Sign in using your authorized MCC Microsoft account.</p>

        <form method="POST" action="{{ route('login.store') }}" novalidate>
            @csrf
            <div class="fld">
                <label for="email">MCC Microsoft Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="name@mcc.edu.ph" class="{{ $errors->has('email') ? 'bad' : '' }}">
                <div class="err">{{ $errors->first('email') }}</div>
            </div>
            <div class="fld">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="••••••••" class="{{ $errors->has('password') ? 'bad' : '' }}">
                <div class="err">{{ $errors->first('password') }}</div>
            </div>

            <div class="row" style="justify-content:space-between;margin-bottom:16px">
                <label class="ck"><input type="checkbox" name="remember">Remember me</label>
                <span class="mut">Password reset is handled by your MCC Microsoft account.</span>
            </div>

            <button class="btn p w" type="submit">Log In</button>
        </form>

        <div class="or">or</div>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <input type="hidden" name="microsoft" value="1">
            <button class="btn ms w" type="submit">
                <i><s style="background:#f25022"></s><s style="background:#7fba00"></s><s style="background:#00a4ef"></s><s style="background:#ffb900"></s></i>
                Continue with Microsoft
            </button>
        </form>

        <div class="hint">Prototype demo: emails starting with “admin” open the Admin interface; any other @mcc.edu.ph email opens the Student interface.</div>
        <p class="mut center" style="margin:0">Only authorized MCC accounts may access {{ config('ferms.name') }}.</p>
    </div>
</div>
@endsection
