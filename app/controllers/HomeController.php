<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}
	public function getApiServer()
	{
		date_default_timezone_set("Asia/Saigon");
		$host = $_SERVER['HTTP_HOST'];
		$bowser = $_SERVER['HTTP_USER_AGENT'];
		$bytes = disk_free_space("."); 
    	$si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    	$base = 1024;
    	$class = min((int)log($bytes , $base) , count($si_prefix) - 1);
    	$disk_free = sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
    	$disk_total = sprintf('%1.2f' , disk_total_space("/") / pow($base,$class)) . ' ' . $si_prefix[$class];
    	$server_info = array(
    			"hostname" => $host,
    			"bowser" => $bowser,
    			"disk_total" => $disk_total,
    			"disk_free" => $disk_free,
    			"timezone" => date_default_timezone_get(),
    			"category" => count(Categorie::all()),
    			"report" => count(Pdf::all()),
    			"users" => count(User::all()),
    			"question" => count(Question::all()),
    			"answer" => count(Answer::all())
    		);
    	return Response::Json($server_info);
	}

}
