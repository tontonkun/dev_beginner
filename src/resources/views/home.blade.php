@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')

<div class="titleArea">
    <div class="title">
        {{ $userName }}さん　お疲れ様です！
    </div>
</div>

<div class="buttonArea">
    <form class="form" action="/start_work" method="POST">
        @csrf
        <button id="startWorkButton" class="workStart" type="submit" {{ $workStartDisabled ? 'disabled' : '' }}>勤務開始</button>
    </form>

    <form class="form" action="/end_work" method="POST">
        @csrf
        <button id="endWorkButton" class="workEnd" type="submit" {{ $workEndDisabled ? 'disabled' : '' }}>勤務終了</button>
    </form>
</div>

<div class="buttonArea">
    <form class="form" action="/start_rest" method="POST">
        @csrf
        <button id="startRestButton" class="restStart" type="submit" {{ $restStartDisabled ? 'disabled' : '' }}>休憩開始</button>
    </form>

    <form class="form" action="/end_rest" method="POST">
        @csrf
        <button id="endRestButton" class="restEnd" type="submit" {{ $restEndDisabled ? 'disabled' : '' }}>休憩終了</button>
    </form>
</div>
@endsection