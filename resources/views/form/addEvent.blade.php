@section('form')

<div class="panel panel-default col-md-6 col-md-offset-3">
 <div class="panel-heading">Добавить событие</div>
  <div class="panel-body">

<form method="POST" action="">
Кинотеатр:<br>
<select name="company" class="selectpicker"  >
@foreach($company as $only)
    <option value="{{$only->id}}">{{$only->name}}</option>
@endforeach
  </select>
<hr>
Фильм:<br>
<select name="movie" class="selectpicker"  >
@foreach($movies as $only)
    <option value="{{$only->id}}">{{$only->name}}</option>
@endforeach
  </select>
  <hr>
  Количество купленных билетов:<br>
 <input placeholder="0 - 255" name="visited" class="form-control">
  <hr>

<hr>
	<input type="submit" class="btn btn-primary" value="Добавить событие">
</form>
  </div>
 </div>

@stop