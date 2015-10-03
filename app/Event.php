<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database;
use DB;

class Event extends Model
{
    // Лимит пагинации
    private $limit = 50;
    private $paginate = null;
    public $updated_at  =false;



    public function company()
    {
        // Связь один к одному (Модель Событий->Модель компании)
        return $this->hasOne('App\Company','id');
    }

    public function movie()
    {
        // Связь один к одному (Модель Событий->Модель фильмов)
        return $this->hasOne('App\Movie','id','movie_id');
    }

/*	getEventsCompany
* countPage - количество страниц для пагинации
* query - подготовка ORM запроса 
* events - конечный обьект с событиями, пагинацией
* $events->load('movie') - Ленивая,жадная загрузка связанной таблицы  
*/
    public function getEventsCompany($company)
    {
		$query = $this
                 ->where('company_id',$company)->orderBy('id', 'desc');

		$query = $query->paginate(50);
		$events = $query->load('movie');
		$events->paginate = $query;
		$events->company = $this->find($company)->company()->get()->first();

      $events->emptyTime = $this->getEmptyTimeCompany($events->company->id,$events->paginate->lastPage());    
       
 		return $events;
	}


public function getAll(Array $company, Array $between)
{

    $query = $this->select('id,created_at,visited')
                  ->whereIn('company_id', $company)
                  ->whereBetween('created_at',$between)
                  ->limit(0,50);

    return $query;
  }





  public function getGroupData($type,$data)
  {
    switch ($type) {
        case 'income':
        case 'visited':
           return $this->getGroupVisited($data['company'], $data['between'], $data['groupTime']);
        case 'seance_count':
           return $this->getGroupSeanseCount($data['company'], $data['between'], $data['groupTime']);
        case 'seance_time':
           return $this->getGroupSeanseTime($data['company'], $data['between'], $data['groupTime']);
        case 'event_empty':
           return $this->getGroupSeanseEmpty($data['company'], $data['between'], $data['groupTime']);

    }
  }

  

/*
    Этот громоздкий запрос возвращает нам сгруппированную информацию по дням
    (количество билетов, день создание евента, сумму посетителей, и имя конторы, в нашем случае кинотеатра)
    при условии, что тип не равен 0(просмотр фильма), дата Event-a входит в рамки массива $between
    
*/



  public function getGroupVisited(Array $company, Array $between, $groupTime)
  {
    
    // Костылик, возвращает тип группировки, пилим его прямиком в запрос
    $groupTime = $this->getGroupTime($groupTime);
    $query = $this->select(
     \DB::raw("company_id, `created_at` as 'date',  sum(`visited`) as 'data'")
    )
        ->groupBy(\DB::raw( $groupTime ))
        ->orderBy('created_at')
        ->whereIn('company_id', $company)
        ->whereBetween('created_at',$between);
        
    return $query->get();
  }



 public function getGroupSeanseCount(Array $company, Array $between, $groupTime)
 {
    // Костылик, возвращает тип группировки, пилим его прямиком в запрос
    $groupTime = $this->getGroupTime($groupTime);

    $query =
    $this->select("company_id",DB::raw("`created_at` as 'date',COUNT(*) as 'data'"))
        ->groupBy(\DB::raw( $groupTime ))
        ->orderBy('created_at')
        ->whereIn('company_id', $company)
        ->whereBetween('created_at',$between);
        
    return $query->get();
 }


 public function getGroupSeanseTime(Array $company, Array $between, $groupTime)
 {
    // Костылик, возвращает тип группировки, пилим его прямиком в запрос
    $groupTime = $this->getGroupTime($groupTime);

    $query =
    $this
        ->join('movies', 'events.movie_id', '=', 'movies.id')
        ->select("company_id",DB::raw("`created_at` as 'date',
         (COUNT(events.`movie_id`)*MINUTE(movies.`time`)) as 'data'"))
        ->groupBy(\DB::raw( $groupTime ))
        ->orderBy('created_at')
        ->whereIn('company_id', $company)
        ->whereBetween('created_at',$between);
        
    return $query->get();
 }



 public function getGroupSeanseEmpty( $company, Array $between, $groupTime)
 {
    // Костылик, возвращает тип группировки, пилим его прямиком в запрос
    $groupTime = $this->getGroupTime($groupTime,'prevEvent');

$company = explode(',', $company[0]);
$query = 
\DB::select("SELECT prevEvent.`company_id` as `company_id`,prevEvent.`id`,
DATE_FORMAT( 
DATE_SUB( 
    currEvent.`created_at` , INTERVAL DATE_FORMAT( 
        @dateTime :=  DATE_ADD( prevEvent.`created_at` , INTERVAL movies.time HOUR_SECOND ) ,  '%H:%i:%S' ) 
    HOUR_SECOND ) ,  '%H' ) AS `data`,
-- Текущая запись - (Предыдущая запись + длительность фильма) = простой кинотеатра
 @dateTime AS `date`
FROM  `events` AS currEvent
JOIN  `events` AS prevEvent ON prevEvent.`id` = currEvent.id -1
JOIN  `movies` AS movies ON movies.`id` = currEvent.`movie_id` 
WHERE currEvent.`company_id` IN(?) AND prevEvent.`company_id` = 1 
AND prevEvent.`created_at` BETWEEN '{$between[0]}' AND '{$between[1]}'
GROUP BY {$groupTime}
ORDER BY currEvent.`created_at` DESC 
",$company);


return $query;        
    return $query->get();
 }




/*
$company - список компаний для которых надо вычеслить простой кинотеатра
$paginate - количество страниц пагинации, для установки LIMIT
*/
private function getEmptyTimeCompany( $company , $paginate){

$page[0] = $paginate*50-50;
$page[1] = $paginate*50;

$company = explode(',', $company);
$query = 
\DB::select("SELECT prevEvent.`company_id`,prevEvent.`id`,
DATE_FORMAT( 
DATE_SUB( 
    currEvent.`created_at` , INTERVAL DATE_FORMAT( @dateTime :=  DATE_ADD( prevEvent.`created_at` , INTERVAL movies.time
    HOUR_SECOND ) ,  '%H:%i:%S' ) 
    HOUR_SECOND ) ,  '%H:%i:%S' ) 
-- Текущая запись - (Предыдущая запись + длительность фильма) = простой кинотеатра
AS `time`, @dateTime AS `dateTime`
FROM  `events` AS currEvent
JOIN  `events` AS prevEvent ON prevEvent.`id` = currEvent.id -1
JOIN  `movies` AS movies ON movies.`id` = currEvent.`movie_id` 
WHERE currEvent.`company_id` IN(?) AND prevEvent.`company_id` = 1 
ORDER BY currEvent.`created_at` DESC 
LIMIT {$page[0]} , {$page[1]}",$company);

return $query;
}


private function getGroupTime($groupTime,$table='')
{
   if($table) $table = $table.'.';
    // Параметры группировки
    switch ($groupTime) {
        case 'day':
            $groupTime = "DATE($table`created_at`)"; // 
            break;
        case 'hour':
            $groupTime = "HOUR($table`created_at`)"; // 
            break;
        case 'week':
            $groupTime = "WEEK($table`created_at`)"; // 
            break;
        case 'month':
            $groupTime = "MONTH($table`created_at`)"; // 
            break;
    }

    return $groupTime;
} 

/*
  Получаем время окончание последнего сеанса $company - кинотеатра
*/
public function getMovieEnd( $company)
{

    $query = $this->select(
        \DB::raw('@movieEnd := UNIX_TIMESTAMP(
            DATE_ADD( events.`created_at` , INTERVAL movies.time HOUR_SECOND )
            ) AS movieEnd ')
        ) 
         ->join('movies', 'movies.id', '=', 'events.movie_id')
         ->where('company_id',$company)
         ->orderBy('created_at','desc')
         ->first();
   
return $query;
}
}

