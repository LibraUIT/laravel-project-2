<?php
class MainController extends BaseController
{
	public function index()
	{
		$title="Việt Stackoverflow";
		$today = date("M d , Y");
		$day = date('D', strtotime( $today));
		$week = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
		$pos = array_search ($day,$week);
		if($day == "Mon")
			{
				$firstday = date('Y-m-d');
				$firstday = date('Y-m-d', strtotime($firstday." 00:00:00"));
				$lastday = date('Y-m-d H:i:s');
			}else{
				$firstday = date('Y-m-d', strtotime("-$pos day"));
				$lastday = date('Y-m-d H:i:s');
			}
		if(isset($_GET['tab']))
		{
			switch ($_GET['tab']) {
				case "active":
					$question=Question::with("tags","users", "answers")->orderBy("id","desc")->paginate(20);
					break;
				case 'hot':
					$question=Question::with("tags","users", "answers")->orderBy("viewed","desc")->paginate(20);
					break;
				case 'week':
					$question=Question::with("tags","users", "answers")
					->where("created_at" , "<=", $lastday)
					->where("created_at", ">=", $firstday)
					->orderBy("id","desc")->paginate(20);
					break;
				case "month":
					$today = date("d")-1;
					$firstday = date('Y-m-d H:i:s', strtotime("-$today day"));
					$question=Question::with("tags","users", "answers")
					->where("created_at" , "<=", $lastday)
					->where("created_at", ">=", $firstday)
					->orderBy("id","desc")->paginate(20);
					break;
				default;
					$question=Question::with("tags","users", "answers")->orderBy("id","desc")->paginate(20);
					break;
			}

		}else{
			$question=Question::with("tags","users", "answers")->orderBy("id","desc")->paginate(20);
		}
		return View::make(Device::make().".minhquan.index")->with("title",$title)->with("questions",$question);
	}
	public function getParty($id)
	{
		return View::make(Device::make().'.minhquan.chat')->with('id', $id)->with('title', 'Chat');
	}
	public function getChart()
	{
		return View::make(Device::make().".minhquan.chart")->with("title", "Thống kê website");
	}
	public function getReport()
	{
		return View::make(Device::make().".minhquan.report")->with("title", "Tạo báo cáo");
	}
	public function Search($cate, $text)
	{
		$text = str_replace("%20", " ", $text);
		$today = date("M d , Y");
		$day = date('D', strtotime( $today));
		$week = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
		$pos = array_search ($day,$week);
		if($day == "Mon")
			{
				$firstday = date('Y-m-d');
				$firstday = date('Y-m-d', strtotime($firstday." 00:00:00"));
				$lastday = date('Y-m-d H:i:s');
			}else{
				$firstday = date('Y-m-d', strtotime("-$pos day"));
				$lastday = date('Y-m-d H:i:s');
			}
		if($cate == 0)
		{
			if(isset($_GET['tab']))
			{
				switch ($_GET['tab']) {
					case 'active':
							$question = Question::with("tags","users", "answers")
							->where("title", "like", "%".$text."%")
							->orWhere("content", "like", "%".$text."%")
							->orderBy("id","desc")->paginate(20);
						break;
					case "hot":
							$question = Question::with("tags","users", "answers")
							->where("title", "like", "%".$text."%")
							->orWhere("content", "like", "%".$text."%")
							->orderBy("viewed","desc")->paginate(20);
						break;
					case "week":
							$question = Question::with("tags","users", "answers")
							->where("title", "like", "%".$text."%")
							->where("created_at" , "<=", $lastday)
							->where("created_at", ">=", $firstday)
							->orWhere("content", "like", "%".$text."%")
							->where("created_at" , "<=", $lastday)
							->where("created_at", ">=", $firstday)
							->orderBy("id","desc")->paginate(20);
						break;
					case "month":
							$today = date("d")-1;
							$firstday = date('Y-m-d H:i:s', strtotime("-$today day"));
							$question = Question::with("tags","users", "answers")
							->where("title", "like", "%".$text."%")
							->where("created_at" , "<=", $lastday)
							->where("created_at", ">=", $firstday)
							->orWhere("content", "like", "%".$text."%")
							->where("created_at" , "<=", $lastday)
							->where("created_at", ">=", $firstday)
							->orderBy("id","desc")->paginate(20);
						break;
					default:
							$question = Question::with("tags","users", "answers")
							->where("title", "like", "%".$text."%")
							->orWhere("content", "like", "%".$text."%")
							->orderBy("id","desc")->paginate(20);
						break;
				}
			}else
			{
				$question = Question::with("tags","users", "answers")
							->where("title", "like", "%".$text."%")
							->orWhere("content", "like", "%".$text."%")
							->orderBy("id","desc")->paginate(9);
			}
			$title="Kết quả tìm kiếm các câu hỏi cho từ khoá : ".$text;
		}else
		{
			if(isset($_GET['tab']))
			{
				switch ($_GET['tab']) {
					case 'active':
							$question = Question::with("tags","users", "answers", "categories")
							->where("categorieID", $cate)
							->where("title", "like", "%".$text."%")
							->orWhere("content", "like", "%".$text."%")
							->orderBy("id","desc")->paginate(20);
						break;
					case "hot":
							$question = Question::with("tags","users", "answers", "categories")
							->where("categorieID", $cate)
							->where("title", "like", "%".$text."%")
							->orWhere("content", "like", "%".$text."%")
							->orderBy("viewed","desc")->paginate(20);
						break;
					case "week":
							$question = Question::with("tags","users", "answers", "categories")
							->where("categorieID", $cate)
							->where("title", "like", "%".$text."%")
							->where("created_at" , "<=", $lastday)
							->where("created_at", ">=", $firstday)
							->orWhere("content", "like", "%".$text."%")
							->where("created_at" , "<=", $lastday)
							->where("created_at", ">=", $firstday)
							->orderBy("id","desc")->paginate(20);
						break;
					case "month":
							$today = date("d")-1;
							$firstday = date('Y-m-d H:i:s', strtotime("-$today day"));
							$question = Question::with("tags","users", "answers", "categories")
							->where("categorieID", $cate)
							->where("title", "like", "%".$text."%")
							->where("created_at" , "<=", $lastday)
							->where("created_at", ">=", $firstday)
							->orWhere("content", "like", "%".$text."%")
							->where("created_at" , "<=", $lastday)
							->where("created_at", ">=", $firstday)
							->orderBy("id","desc")->paginate(20);
						break;
					default:
							$question = Question::with("tags","users", "answers", "categories")
							->where("categorieID", $cate)
							->where("title", "like", "%".$text."%")
							->orWhere("content", "like", "%".$text."%")
							->orderBy("id","desc")->paginate(20);
						break;
				}
			}else
			{
				$question = Question::with("tags","users", "answers", "categories")
						->where("categorieID", $cate)
						->where("title", "like", "%".$text."%")
						->orWhere("content", "like", "%".$text."%")
						->orderBy("id","desc")->paginate(20);
			}
			$cat = Categorie::find($cate);
			$title="Kết quả tìm kiếm : chủ đề ".$cat->title." cho từ khoá \"".$text.'"';
		}
		return View::make(Device::make().".minhquan.index")->with("title",$title)->with("questions",$question);
	}
	public function getCate()
	{
		if(Request::ajax()){
			$cates = Categorie::all();
			$arr = array();
			foreach ($cates as $cate) {
				$arr[$cate->title] = $cate->id;
			}
			return Response::Json($arr);
		}
	}
	public function getQuestionChartByCate()
	{
		if(Request::ajax()){
			if(Input::get('dateFrom') != Input::get('dateTo'))
			{
					$total_question = count(Question::with("users")
									->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))), date('Y-m-d H:i:s',strtotime(Input::get('dateTo')))))->get());
			}else
			{
					$date = Input::get('dateFrom');
					$date1 = str_replace('-', '/', $date);
					$tomorrow = date('Y-m-d H:i:s',strtotime($date1 . "+1 days"));
					$total_question = count(Question::with("users")
								->where("created_at", ">=", date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))) )
								->where("created_at", "<", $tomorrow)
								->get());
			}
			$cates = Categorie::all();
			$arr1 = array();
			$stt= 1;
			foreach ($cates as $cate) {
				//$q = Question::with("categories")->where("categorieID", $cate->id)->get();
				if(Input::get('dateFrom') != Input::get('dateTo'))
				{
					$q = Question::with("categories")->where("categorieID", $cate->id)
															  ->where(function($where){
															  	 $where->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))), date('Y-m-d H:i:s',strtotime(Input::get('dateTo')))));
															  })
															  ->get();
				}else
				{


					$q = Question::with("categories")->where("categorieID", $cate->id)
													 ->where("created_at", ">=", date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))) )
													 ->where("created_at", "<", $tomorrow)
													 ->get();
				}
				$arr2 = array();
				if($stt == 1)
				{
					$v = (count($q)/$total_question)*100;
					$arr2 = array(
							"name" => $cate->title,
							"y" => $v,
							"sliced" => true,
							"selected" => true
						);
					$arr1[] = $arr2;
					$stt++;

				}else{
					$arr2[] = $cate->title;
					$arr2[] = (count($q)/$total_question)*100;
					$arr1[] = $arr2;
				}
			}
			return Response::Json($arr1);
		}
	}
	public function getQuestionChartByDate()
	{
		if(Request::ajax()){
			date_default_timezone_set('UTC');
			// Start date
			$date = date('Y-m-d',strtotime(Input::get('dateFrom')));
			// End date
			$end_date = date('Y-m-d',strtotime(Input::get('dateTo')));
			$cates = Categorie::all();
			$arr = array();
			$arr1 = array();
			$arrDate = array();
			$series = array();
			foreach ($cates as $cate) {
				$arr2 = array();
				$arr2['name'] = $cate->title;
				$series[$cate->title] = $cate->id;
				if(Input::get('dateFrom') != Input::get('dateTo'))
				{
					$q = Question::with("categories")->select(array('created_at'))->where("categorieID", $cate->id)
																				  ->where(function($where){
																				  	 $where->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))), date('Y-m-d H:i:s',strtotime(Input::get('dateTo')))));
																				  })
																				  ->groupBy('created_at')->get();
				}else
				{
					$date2 = Input::get('dateTo');
					$date3 = str_replace('-', '/', $date2);
					$tomorrow = date('Y-m-d H:i:s',strtotime($date3 . "+1 days"));
					$q = Question::with("categories")->select(array('created_at'))->where("categorieID", $cate->id)
																				  ->where("created_at", ">=", date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))) )
																				  ->where("created_at", "<", $tomorrow)
																				  ->get();
				}
				$arr3 = array();
				foreach ($q as $key => $value) {
					$arr3[] = date('Y-m-d', strtotime($value['created_at']));
				}
				$arr4 = array_count_values($arr3);
				$arr5 = array();
				$arrDateChild = array();
				while (strtotime($date) <= strtotime($end_date)) {
					$arrDateChild[] = date('d-M',strtotime($date));
					if(array_key_exists( $date, $arr4 ))
					{
						$arr5[] = $arr4[$date];
					}else
					{
						$arr5[] = 0;
					}
					$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
				}
				$arrDate = $arrDateChild;
				$arr2['data'] = $arr5;
				$arr1[] = $arr2;
				$date = date('Y-m-d',strtotime(Input::get('dateFrom')));

			}
			$arr['data'] = $arr1;
			$arr['date'] = $arrDate;
			$arr['series'] = $series;
			return Response::Json($arr);
		}
	}
	public function getAnswerChartByCate()
	{
		if(Request::ajax()){
			if(Input::get('dateFrom') != Input::get('dateTo'))
			{
				$total_answer = count(Answer::with("users")
				->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))), date('Y-m-d H:i:s',strtotime(Input::get('dateTo')))))->get());
			}else
			{
				$date2 = Input::get('dateTo');
				$date3 = str_replace('-', '/', $date2);
				$tomorrow = date('Y-m-d H:i:s',strtotime($date3 . "+1 days"));
				$total_answer = count(Answer::with("users")
								->where("created_at", ">=", date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))) )
								->where("created_at", "<", $tomorrow)
								->get());
			}
			$cates = Categorie::all();
			$arr1 = array();
			$stt= 1;
			if($total_answer)
			{
			foreach ($cates as $cate) {
					$arr2 = array();

					$q = $cate->questions()->where("categorieID", $cate->id)->get();

					$c = 0;
					foreach ($q as $q1) {
						if(Input::get('dateFrom') != Input::get('dateTo'))
						{
							$answer = Answer::with("users")->where("questionID", $q1->id)->orderBy("correct", "desc")
							->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))), date('Y-m-d H:i:s',strtotime(Input::get('dateTo')))))
							->get();
						}else
						{
							$answer = Answer::with("users")->where("questionID", $q1->id)->orderBy("correct", "desc")
							->where("created_at", ">=", date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))) )
							->where("created_at", "<", $tomorrow)
							->get();
						}
						$c = $c +count($answer);
					}
					if($stt ==1)
					{
						$arr2['name'] = $cate->title;
						$arr2['sliced'] = true;
						$arr2['selected'] =true;
						$arr2['y'] = ($c/$total_answer)*100;

					}else
					{
						$arr2[] = $cate->title;
						$arr2[] = ($c/$total_answer)*100;
					}

					$arr1[] = $arr2;
					$stt++;

			}
			}else
			{
				$arr1 = null;
			}

			return Response::Json($arr1);

		}
	}
	public function getQuesAndAnsChart()
	{
		if(Request::ajax())
		{
			$arr1  = array();
			$cates = Categorie::all();
			$categories = array();
			$arr2 = array();
			$arr2['name'] = 'Câu hỏi';
			$arr3 = array();
			$arr3['name'] = 'Trả lời';
			foreach ($cates as $cate) {
				$categories[] = $cate->title;
				if(Input::get('dateFrom') != Input::get('dateTo'))
				{
					$questions = Question::with("categories")->where("categorieID", $cate->id)
									->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))), date('Y-m-d H:i:s',strtotime(Input::get('dateTo')))))
									->get();
				}else
				{
					$date2 = Input::get('dateTo');
					$date3 = str_replace('-', '/', $date2);
					$tomorrow = date('Y-m-d H:i:s',strtotime($date3 . "+1 days"));
					$questions = Question::with("categories")->where("categorieID", $cate->id)
									->where("created_at", ">=", date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))) )
									->where("created_at", "<", $tomorrow)
									->get();
				}
				$arr2['data'][] = count($questions);
				$dem = 0;
				foreach ($questions as $question) {
					if(Input::get('dateFrom') != Input::get('dateTo'))
					{
						$answers = Answer::where("questionID", $question->id)
										->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))), date('Y-m-d H:i:s',strtotime(Input::get('dateTo')))))
										->get();
					}else
					{
						$answers = Answer::where("questionID", $question->id)
										->where("created_at", ">=", date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))) )
										->where("created_at", "<", $tomorrow)
										->get();
					}
					$dem = $dem + count($answers);
				}
				$arr3['data'][] = $dem;


			}
			$arr1['data'][] = $arr2;
			$arr1['data'][] = $arr3;
			$arr1['categories'] = $categories;
			return Response::Json($arr1);
		}
	}
	public function getAnswerChartByDate()
	{
		if(Request::ajax())
		{
			date_default_timezone_set('UTC');
			// Start date
			$date = date('Y-m-d',strtotime(Input::get('dateFrom')));
			// End date
			$end_date = date('Y-m-d',strtotime(Input::get('dateTo')));
			$cates = Categorie::all();
			$arr = array();
			$arr1 = array();
			$arrDate = array();
			$series = array();
			foreach ($cates as $cate) {
				$arr2 = array();
				$arr2['name'] = $cate->title;
				$series[$cate->title] = $cate->id;
				$q = Question::with("categories")->where("categorieID", $cate->id)->groupBy('created_at')->get();
				$arr3 = array();
				foreach ($q as $key => $q1) {
					if(Input::get('dateFrom') != Input::get('dateTo'))
					{
						$answers = Answer::with("questions")->select(array('created_at'))->where("questionID", $q1->id)
									->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))), date('Y-m-d H:i:s',strtotime(Input::get('dateTo')))))
									->get();
					}else
					{
						$date2 = Input::get('dateTo');
						$date3 = str_replace('-', '/', $date2);
						$tomorrow = date('Y-m-d H:i:s',strtotime($date3 . "+1 days"));
						$answers = Answer::with("questions")->select(array('created_at'))->where("questionID", $q1->id)
										->where("created_at", ">=", date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))) )
										->where("created_at", "<", $tomorrow)
										->get();
					}
					foreach ($answers as $ans) {
						$arr3[] = date('Y-m-d', strtotime($ans['created_at']));
					}
				}
				$arr4 = array_count_values($arr3);
				$arr5 = array();
				$arrDateChild = array();
				while (strtotime($date) <= strtotime($end_date)) {
					$arrDateChild[] = date('d-M',strtotime($date));
					if(array_key_exists( $date, $arr4 ))
					{
						$arr5[] = $arr4[$date];
					}else
					{
						$arr5[] = 0;
					}
					$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
				}
				$arrDate = $arrDateChild;
				$arr2['data'] = $arr5;
				$arr1[] = $arr2;
				$date = date('Y-m-d',strtotime(Input::get('dateFrom')));

			}
			$arr['data']=$arr1;
			$arr['categories']=$arrDate;
			return Response::Json($arr);
		}
	}
	public function getUserLastloginChartByDate()
	{
		if(Request::ajax())
		{
			date_default_timezone_set('UTC');
			// Start date
			$date = date('Y-m-d',strtotime(Input::get('dateFrom')));
			// End date
			$end_date = date('Y-m-d',strtotime(Input::get('dateTo')));

			if(Input::get('dateFrom') != Input::get('dateTo'))
			{
				$users = User::select(array('last_login'))
									->whereBetween('last_login', array(date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))), date('Y-m-d H:i:s',strtotime(Input::get('dateTo')))))
									->get();
			}else
			{
				$date2 = Input::get('dateTo');
				$date3 = str_replace('-', '/', $date2);
				$tomorrow = date('Y-m-d H:i:s',strtotime($date3 . "+1 days"));
				$users = User::select(array('last_login', 'id'))
									->where("last_login", ">=", date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))) )
									->where("last_login", "<", $tomorrow)
									->get();
			}
			$arr1 = array();
			foreach ($users as $user) {
				$arr1[] = date('Y-m-d', strtotime($user['last_login']));
			}
			$arr2 = array_count_values($arr1);
			$arr3 = array();
			$arrDateChild = array();
			while (strtotime($date) <= strtotime($end_date)) {
					$arrDateChild[] = date('d-M',strtotime($date));
					if(array_key_exists( $date, $arr2 ))
					{
						$arr3[] = $arr2[$date];
					}else
					{
						$arr3[] = 0;
					}
					$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
			}
			$date = date('Y-m-d',strtotime(Input::get('dateFrom')));
			$arr4 = array();
			$arr4['categories']=$arrDateChild;
			$arr5 = array();
			$arr5['name'] = 'Số lượt';
			$arr5['data'] = $arr3;
			$arr4['data'][] = $arr5;
			return Response::Json($arr4);
		}
	}
	public function getUserLastLogin()
	{
			date_default_timezone_set('UTC');
			// Start date
			$date = date('Y-m-d',strtotime(Input::get('dateFrom')));
			// End date
			$date2 = date('Y-m-d',strtotime(Input::get('dateTo')));
			$date3 = str_replace('-', '/', $date2);
			$tomorrow = date('Y-m-d H:i:s',strtotime($date3 . "+1 days"));
			$users = User::where("last_login", ">=", date('Y-m-d H:i:s',strtotime($date)) )
									->where("last_login", "<", $tomorrow)
									->get();

			$arr1 = array();
			foreach ($users as $user) {
				$arr1[] = $user->username;
			}
			return Response::Json($arr1);
	}
	public function getQuesAndAnsChartVs()
	{
		if(Request::ajax())
		{
			$arr1  = array();
			$cates = array();
			$cates[] = Input::get('cate1');
			$cates[] = Input::get('cate2');
			$categories = array();
			$arr2 = array();
			$arr2['name'] = 'Câu hỏi';
			$arr3 = array();
			$arr3['name'] = 'Trả lời';
			foreach ($cates as $key => $value) {
				$title = Categorie::find($value);
				$categories[] = $title->title;
				if(Input::get('dateFrom') != Input::get('dateTo'))
				{
					$questions = Question::with("categories")->where("categorieID", $value)
									->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))), date('Y-m-d H:i:s',strtotime(Input::get('dateTo')))))
									->get();
				}else
				{
					$date2 = Input::get('dateTo');
					$date3 = str_replace('-', '/', $date2);
					$tomorrow = date('Y-m-d H:i:s',strtotime($date3 . "+1 days"));
					$questions = Question::with("categories")->where("categorieID", $value)
									->where("created_at", ">=", date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))) )
									->where("created_at", "<", $tomorrow)
									->get();
				}
				$arr2['data'][] = count($questions);
				$dem = 0;
				foreach ($questions as $question) {
					if(Input::get('dateFrom') != Input::get('dateTo'))
					{
						$answers = Answer::where("questionID", $question->id)
										->whereBetween('created_at', array(date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))), date('Y-m-d H:i:s',strtotime(Input::get('dateTo')))))
										->get();
					}else
					{
						$answers = Answer::where("questionID", $question->id)
										->where("created_at", ">=", date('Y-m-d H:i:s',strtotime(Input::get('dateFrom'))) )
										->where("created_at", "<", $tomorrow)
										->get();
					}
					$dem = $dem + count($answers);
				}
				$arr3['data'][] = $dem;


			}
			$arr1['data'][] = $arr2;
			$arr1['data'][] = $arr3;
			$arr1['categories'] = $categories;
			return Response::Json($arr1);
		}
	}
	public function getAllPdf()
	{
		$pdfs = Pdf::with('users')->get();
		return View::make(Device::make().".minhquan.pdf")->with('title', 'Các báo cáo đã lưu')->with('pdfs', $pdfs);
	}
	public function deletePdf($id)
	{
		if(Request::ajax())
		{
			$pdf = Pdf::find($id);
			if($pdf)
			{
				$pdf->delete();
				return "OK";
			}else
			{
				return Response::Json(array("status"=>"error","mess"=>"Tài liệu này không tồn tại"));
			}
		}
	}
	public function getViewPdf($id)
	{
		$pdf = Pdf::find($id);
		$docTitle = $pdf->title;
		$docName = $pdf->name;
		$docData = $pdf->data;
		$docId = $pdf->id;
		if($pdf)
		{
			return View::make(Device::make().".minhquan.report")->with("title", "Chỉnh sửa báo cáo")->with(array("docTitle"=>$docTitle, "docName"=>$docName, "docData"=>$docData, "docId"=>$docId));
		}else
		{
			return Redirect::route("index")->with("error","Tài liệu này không tồn tại");
		}
	}
	public function getApiAllPdf()
	{
		$pdfs = Pdf::with('users')->orderBy('id', 'DESC')->get();
		return Response::Json($pdfs);
	}
	public function deleteApiPdf()
	{
		$data = Input::get('data');
		$data = explode(',', $data);
		foreach ($data as $item) {
			$pdf = Pdf::find($item);
			if($pdf)
			{
				$pdf->delete();
			}
		}
	}
	public function getApiEditTitlePdf()
	{
		$id = Input::get('data');
		$pdf = Pdf::find($id);
		return $pdf->title;
	}
	public function getApiEditDataPdf()
	{
		$id = Input::get('data');
		$pdf = Pdf::find($id);
		return $pdf->data;
	}
}