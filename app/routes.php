<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
View::composer(array("template.menu", "minhquan.index"), function($view){
	//$menu = Categorie::all();
	$menu = Cache::rememberForever("menu", function(){
		return Categorie::all();
	});

	$tagcloud = Cache::rememberForever("tagcloud", function(){
		return Tag::all();
	});

	$view->with(array("menus" => $menu, "tagcloud" => $tagcloud));
});


Route::get('/', array("as"=>"index","uses"=>"MainController@index"));

Route::get('member/test',array("as"=>"test","uses"=>"AuthController@test"));

/*Route::get('create_user', function(){
	$user = Sentry::getUserProvider()->create(array(
			"email" => "minhquan84080@gmail.com",
			"password" => "123456",
			"username" => "minhquan8080",
			"first_name" => "Minh Quan",
			"last_name" => "Nguyen",
			"activated" => 1,
			"permissions" => array(
				"admin" => 1
				),
		));
	return "Done";
});*/
Route::get('create_cate', function(){
	/*Categorie::create(array(
			"title" => "Midle PHP"
		));
	Categorie::create(array(
			"title" => "PHP Framework"
		));*/
	return "Done";
});

Route::post('member/login',array("as"=>"login_post", "before"=>"csrf|is_login", "uses"=>"AuthController@postLogin"));

Route::get('member/register',array("as"=>"register_get", "before"=>"is_login", "uses"=>"AuthController@getRegister"));

Route::get('member/logout',array("as"=>"logout_get", "before"=> "check_user","uses"=>"AuthController@getLogout"));

Route::post('member/register', array('as'=>"register_post", "before"=>"csrf|is_login", "uses"=>"AuthController@postRegister"));

Route::get('member/changepass', array('as'=>"changepass_get", "before"=>"checkuser", "uses"=>"AuthController@getChangePass"));

Route::post('member/changepass', array('as'=>"changepass_post", "before"=>"csrf|check_user", "uses"=>"AuthController@postChangePass"));

Route::get('member/forgot', array("as"=>"forgot_get", "before"=>"is_login", "uses"=>"AuthController@getForgot"));

Route::post('member/forgot', array("as"=>"forgot_post", "before"=>"csrf|is_login", "uses"=>"AuthController@postForgot"));

Route::get('member/active/{user}/{code}', array("as"=>"active_reset", "before"=>"is_login", "uses"=>"AuthController@getActiveReset"));

Route::get("question/create", array("as"=>"question_create_get", "before"=>"check_user", "uses"=>"QuestionController@getCreate"));

Route::post("question/create", array("as"=>"question_create_post", "before"=>"csrf|check_user", "uses"=>"QuestionController@postCreate"));

Route::get('question/tag/{tag}', array("as"=>"question_tags_get", "uses"=>"QuestionController@getQuestionByTag"));

Route::get('question/vote/{action}/{id}', array("as"=>"question_vote_get", "before"=>"check_user", "uses"=>"QuestionController@getVotes"))->where(array("action"=>"(like|dislike)", "id"=>"[0-9]+"));

Route::get("question/detail/{id}/{title}",array("as"=>"question_detail_get","uses"=>"QuestionController@getDetail"))->where(array("id"=>"[0-9]+","title"=>"[a-zA-Z0-9._\-]+"));

Route::get("question/delete/{id}",array("as"=>"question_delete_get","before"=>"check_access:admin","uses"=>"QuestionController@getDelete"))->where(array("id"=>"[0-9]+"));

Route::post("question/detail/{id}/{title}",array("as"=>"question_reply_post","before"=>"csrf|check_user","uses"=>"AnswerController@postReply"))->where(array("id"=>"[0-9]+","title"=>"[a-zA-Z0-9._\-]+"));

Route::get('answer/vote/{action}/{id}', array("as"=>"answer_vote_get", "before"=>"check_user", "uses"=>"AnswerController@getVotes"))->where(array("action"=>"(like|dislike)", "id"=>"[0-9]+"));

Route::get('answer/correct/{id}', array("as"=>"answer_correct_get", "before"=>"check_user", "uses"=>"AnswerController@getCorrect"))->where(array("id"=>"[0-9]+"));

Route::get('answer/vote/{action}/{id}', array("as"=>"question_user_get", "before"=>"check_user", "uses"=>"AnswerController@getVotes"))->where(array("action"=>"(like|dislike)", "id"=>"[0-9]+"));

Route::get('answer/delete/{id}', array("as"=>"answer_delete_get", "before"=>"check_user", "uses"=>"AnswerController@getDelete"))->where(array("id"=>"[0-9]+"));

Route::get('categorie/{id}/{title}', array("as"=>"categorie_question_get", "uses"=>"QuestionController@getQuestionByCate"))->where(array("id"=>"[0-9]+","title"=>"[a-zA-Z0-9._\-]+"));

Route::get('question/user/{user}', array("as"=>"question_user_get", "uses"=>"QuestionController@getQuestionbyUser"))->where(array("id"=>"[0-9]+","title"=>"[a-zA-Z0-9._\-]+"));

Route::get('question/today', array("as"=>"question_today_get", "uses"=>"QuestionController@getQuestionToDay"));

Route::group(array("before"=>"check_access:admin"), function(){
	Route::get("categorie/list", array("categorie_index_get", "uses"=>"CategorieController@getIndex"));

	Route::post("categorie/create", array("as"=>"categorie_create_post", "uses"=>"CategorieController@postCreate"));
	Route::post("categorie/update", array("as"=>"categorie_update_post", "uses"=>"CategorieController@postUpdate"));
	Route::get("categorie/delete/{id}", array("as"=>"categorie_delete_get", "uses" => "CategorieController@getDelete"))->where(array("id"=>"[0-9]+"));
	Route::get('cache/clear', function(){
		Cache::flush();
		return "Done";
	});

	Route::get('chart', array("as"=>"get_chart", "uses"=>"MainController@getChart"));
});

//Phan mo rong 

Route::get('member/profile/{id}', array("as"=>"profile_get", "uses"=>"AuthController@getProfile"))->where(array("id"=>"[0-9]+"));

Route::post("member/profile/name", array("as"=>"profile_post_name", "before"=>"csrf", "uses"=>"AuthController@postNameProfile"));

Route::get('member/profile/upload/{id}', array("as"=>"profile_get_upload", "before"=>"check_user", "uses"=> "AuthController@uploadProfile"))->where(array("id"=>"[0-9]+"));

Route::post('member/profile/upload', array("as"=>"profile_post_upload", "before"=>"csrf|check_user", "uses"=>"AuthController@doUploadProfile"));

Route::get('remove/session/img/{id}', function($id){
	Session::forget('image');
	Session::forget('url');
	Session::forget('userid');
	Session::forget('username');
	return Redirect::route('profile_get_upload', array($id));
});

Route::post('member/profile/upload/crop', array("as"=>"profile_crop_upload", "before"=>"csrf|check_user", "uses"=>"AuthController@cropUpload"));


//Demo chat

Route::get('chat', function(){
	return View::make("chat");
});

Route::get('member/chat/{id}', array("as"=>"chat_get_party", "before"=>"check_user", "uses"=>"MainController@getParty"))->where(array("id"=>"[0-9]+"));
//Hightcharts js
Route::post('chart/question/getchartbycate/', array("as"=>"draw_chart_question_by_cate", "before"=>"check_user", "uses" => "MainController@getQuestionChartByCate"));

Route::post('chart/question/getchartbydate', array("as"=>"draw_chart_question_by_date", "before"=>"check_user", "uses"=>"MainController@getQuestionChartByDate"));

Route::get('question/date/{day}/{month}/{year}/{id}', array("as"=>"get_question_by_date", "uses"=>"QuestionController@getQuestionByDate"))->where(array("day"=>"[0-9]+", "month"=>"[0-9]+", "year"=>"[0-9]+", "id"=>"[0-9]+"));

Route::get('question/cate/date/{from}/{to}/{id}', array("uses"=>"QuestionController@getQuestionByCateFollowDate"))->where(array("from"=>"[0-9\-]+", "to"=>"[0-9\-]+", "id"=>"[0-9]+"));

Route::post('chart/answer/getchartbycate', array("as"=>"draw_chart_answer_by_cate", "before"=>"check_user", "uses"=>"MainController@getAnswerChartByCate"));

Route::post("cate/getcate", array("as"=>"get_cate", "before"=>"check_user", "uses"=>"MainController@getCate"));

Route::post("chart/qanda", array("as"=>"draw_chart_ques_ans", "before"=>"check_user", "uses"=>"MainController@getQuesAndAnsChart"));

Route::get("search/question/{cate}/{text}", array("uses"=>"MainController@search"))->where(array("cate"=>"[0-9]+"));

Route::get('testsql', function(){
	$arr1  = array();
	$cates = Categorie::all();
	$categories = array();
	$arr2 = array();
	$arr2['name'] = 'Câu hỏi';
	$arr3 = array();
	$arr3['name'] = 'Trả lời';
	foreach ($cates as $cate) {
		$categories[] = $cate->title;
		$questions = Question::with("categories")->where("categorieID", $cate->id)->get();
		
		$arr2['data'][] = count($questions);
		$dem = 0;
		foreach ($questions as $question) {
			$answers = Answer::where("questionID", $question->id)->get();
			$dem = $dem + count($answers);
		}
		$arr3['data'][] = $dem;


	}
	$arr1['data'][] = $arr2;
	$arr1['data'][] = $arr3;
	$arr1['categories'] = $categories;	
	return Response::Json($arr1);
});
