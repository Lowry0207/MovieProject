@section('filter')
<div class="panel panel-default">
 <div class="panel-heading">Фильтр</div>
  <div class="panel-body">

<form method="POST" action="/grafic">
	<label>Дата</label>
	<input type="text" id="date-from" placeholder="2015-09-01" name="dateStart">
	<label> - </label>
	<input type="text" id="date-to" placeholder="2015-09-02" name="dateEnd">

<br>
Выбор кинотеатра<br>
<select id="company" name="company[]" class="selectpicker" multiple >
@foreach($company as $only)
    <option value="{{$only->id}}">{{$only->name}}</option>
@endforeach
  </select>
<br>
Поле по которуму будет построен график:<br>
<select id="type_graf" name="type_graf" class="selectpicker" >
    <option value="income">Выручка</option>
    <option value="visited">Количеству зрителей</option>
    <option value="seance_count">Количество сеансов</option>
    <option value="seance_time">По продолжительности сеансов</option>
    <option value="event_empty">По простою кинотеатров</option>
</select>
<br>
Группировать информацию по кванту:<br>
<select id="group_date" name="group_date" class="selectpicker" >
    <option value="hour">в часах</option>
    <option value="day">в днях</option>
    <option value="week">в неделях</option>
    <option value="month">в месяцах</option>
</select>

	<input id="jsonbutt" type="submit" class="btn btn-primary" value="Применить" style="float:right;">
</form>


  </div>
 </div>

@stop