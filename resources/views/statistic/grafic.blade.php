@extends('app')
@include('form.filter')

@section('h1','Общая информация')



@section('content')

@yield('filter')

<div class="row col-md-3 col-xs-12 col-sm-12">

<div class="panel panel-default">
 <div class="panel-heading">Количество сеансов</div>
  <div class="panel-body">
  	<div class="main-info" id="seance">0</div>
  </div>
</div>


	<div class="panel panel-default">
	 <div class="panel-heading">Продано билетов</div>
	  <div class="panel-body">
	  	<div class="main-info" id="people">0</div>
	  </div>
	</div>


	<div class="panel panel-default">
	 <div class="panel-heading">Выручка</div>
	  <div class="panel-body">
	  	<div class="main-info" id="income">0</div>
	  </div>
	 </div>
</div>
  <div id="chart_div" class="row col-md-9 col-xs-12 col-sm-12" style="margin-right:40px; height: 400px;">
  	<div style="width:850px;height:300px;" id="placeholder"></div>
  </div>


@stop