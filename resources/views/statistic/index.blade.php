@extends('app')
@include('form.filter')

@section('h1','Общая информация')

@section('pagination')
<a href="/add/event">Добавить событие</a><br><a href="/grafic">Добавить кинотеатр</a>
@stop

@section('content')


<div class="panel panel-default">
 <div class="panel-heading">Список кинотеатров</div>
  <div class="panel-body">

		<table class="table table-striped">
		<tr style="font-weight:bold;">  	
		  	<td>ID</td>
		  	<td>Название кинотеатра</td>
		  	<td> </td>
		</tr> 
		
		@foreach($company as $only)
			<tr>  	
				<td>{{$only->id}}</td>
				<td>{{$only->name}}</td>
				<td><a href="/company/detail/{{$only->id}}">Детали</a></td>
			</tr> 
		@endforeach

		</table>
  	</div>
  </div>
 </div>
@stop