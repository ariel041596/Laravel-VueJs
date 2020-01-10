@extends('layouts.app')

@section('content')
<div class="container">
    <chat-apps :user="{{ auth()->user() }}"></chat-apps>
</div>
@endsection