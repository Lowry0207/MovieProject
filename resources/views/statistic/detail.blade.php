@extends('app')


@section('h1',$events->company->name)


@section('pagination')
@if($paginate->lastPage() > 1)
	<nav>
	  <ul class="pagination">  
		@for ($i = 1; $i <= $paginate->lastPage(); $i++)
	    	@if($paginate->currentPage() == $i)
	    	<li><a class="active" href="?page={{$i}}">{{$i}}</a></li>
	    	@else
	    	<li><a href="?page={{$i}}">{{$i}}</a></li>
			@endif
		@endfor
	</nav>
@endif

@stop

@section('breadcrumb')
	<a href="/">Общая статистика</a> /
	<a href="/company/list">Список кинотеатров</a>
@stop

@section('content')
<hr>

<table class="table table-striped">
  <tr style="font-weight:bold;">  	
  	<td>Время Event'a</td>
    <td>Название фильма</td>
  	<td>Продолжительность фильма</td>
  	<td>Тип события</td>
  	<td>Билеты</td>
  	<td>Выручка</td>
  </tr>
@foreach($events as $key => $event)
<tr>

 
  	<td>{{$event->created_at}}</td>
    <td>@if($event->type) {{$event->movie->name}} @endif</td>
  	<td>@if($event->type) {{$event->movie->time}} @else {{$event->emptyTime}} @endif</td>
  	<td>
  			<b>Просмотр фильма</b>
  	</td>
  	<td>{{$event->visited}}</td>
  	<td>{{$event->visited * 3.5}}</td>
    </tr>
@if(isset($events->emptyTime[$key]))
    <tr>
  
    <td> {{$events->emptyTime[$key]->dateTime}}</td>
    <td> - </td>
    <td>{{$events->emptyTime[$key]->time}}</td>
    <td>
       <span style="color:red;">Простой кинотеатра</span>
    </td>
    <td> - </td>
    <td> - </td>
  </tr>
@endif
@endforeach 
</table>
@stop