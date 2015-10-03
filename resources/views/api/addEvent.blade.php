@extends('app')
@include('form.addEvent')


@section('h1','Добавить новое событие')



@section('breadcrumb')
	<a href="/">Общая статистика</a> /
	<a href="/grafic">График</a>
@stop
@section('content')
<hr>
	@yield('form')
@stop