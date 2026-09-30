@props(['title'])
<div class="row wrap" style="margin-bottom:18px">
    <div><h2 style="margin:0;font-size:18px">{{ $title }}</h2></div>
    <span class="sp"></span>
    {{ $slot }}
</div>
