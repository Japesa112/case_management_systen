@extends('layouts.default', [
	'paceTop' => true,
	'videoBackground' => true,
	'appSidebarHide' => true,
	'appHeaderHide' => true,
	'appContentClass' => 'p-0',
	'showVideo' => true 
])

@section('title', 'Home Page')
@section('content')
    <div class="home-content">
        <h1>This is the home</h1>
    </div>
@endsection