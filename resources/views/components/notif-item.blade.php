@props(['n'])
@if (! $n['read'])
    <form method="POST" action="{{ route('student.inbox.read', $n['id']) }}" class="li unread" style="cursor:pointer" data-click-submit>
        @csrf
        <div class="ico">{{ $n['icon'] }}</div>
        <div class="g1"><b>{{ $n['title'] }}</b><div class="sub">{{ $n['message'] }}</div><div class="mut">{{ $n['when'] }}</div></div>
        <span class="dotu"></span>
    </form>
@else
    <div class="li">
        <div class="ico">{{ $n['icon'] }}</div>
        <div class="g1"><b>{{ $n['title'] }}</b><div class="sub">{{ $n['message'] }}</div><div class="mut">{{ $n['when'] }}</div></div>
    </div>
@endif
