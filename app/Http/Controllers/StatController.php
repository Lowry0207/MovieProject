<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
# Models
use App\Event;
use App\Company;
use App\Movie;

class StatController extends Controller
{
	public $price = 3.5;



	public function index()
	{
		return view('statistic.index', ['company' => Company::all()]);
	}



	public function grafic()
	{
		return view('statistic.grafic',	['company' => Company::all()]);
	}
	

	public function jsonGrafic(Request $input,Event $event)
	{
		// Поля которые нужны нам для запроса
		$dataForm = [ 'dateStart', 'dateEnd', 'company','type_graf', 'group_date' ];

		// 
		if(!$input->has($dataForm))
			return response()->json(false);

		// Интервал времени для выборки
		$date = 
		[ 
			$input->dateStart,
			$input->dateEnd
		];	

		// Отправляем запрос с учетом всех заданных параметров формы
		$query = $event->getGroupData($input->type_graf,
						[
							'company'=>$input->company,
							'between'=>$date,
							'groupTime'=>$input->group_date
						]
					);
		
		// Форимруем полученные данные для графика
		foreach ($query as $key => $value) {
			$id = $value->company_id; # id задан для проверки
			$grafic[$id]->data[] = [$value->date, $value->data];
		}

		$query = $event->getAll($input->company, $date);


		$group_date = $input->group_date;		
		$seance = $query->count();		
		$people = $query->sum('visited');	
		$income = $people * $this->price;
		$company = Company::all();

		
		$data = [
			'seance' => $seance,
			'people' => $people,
			'income' => $income,
			'grafic' => $grafic,
			'date' =>  $date,
			'group_date' =>  $group_date,
			'print_price' =>  $this->price,
		];

		
return response()->json($data);
}


// Детальный просмотр
	public function show($id){
		
		$events = new Event();
		$events = $events->getEventsCompany($id);


	    return view('statistic.detail',
	    	[
		    	'events' => $events,
		    	'paginate' => $events->paginate
	    	]);
	}




}
