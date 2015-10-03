<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Company;
use App\Movie;
use App\Event;
use Validator;

class ApiController extends Controller
{
    //
	public function index(){
	    return 'test new script';
	}


	public function addEvent()
	{
		return view('api.addEvent',['company' => Company::all(),'movies' => Movie::all()]);
	}

	public function store(Request $request)
	{
		if($this->validator($request->all())){
			$event = new Event();

			$event->company_id = $request->company;
			$event->movie_id = $request->movie;
			$event->visited = $request->visited;

			$event->save();

			dd($event);
		}
		return dd('false');
	}


private function validator($data)
{
	$validator = Validator::make(
		    $data,
		    [
		        'company' => 'exists:company,id',
		        'movie' => 'exists:movies,id',
		        'visited' => 'min:0,max:250'
		    ]
		);

	if ($validator->fails())
	{
	   return false;
	}
	else{
		
		// Проверяем закончился ли предыдущий сеанс, и можно ли начинать новый
		$event = new Event();
		$timeEnd = $event->getMovieEnd( 1 );
		
		if(time() > $timeEnd->movieEnd)
			return true;
		

	}
}

}
