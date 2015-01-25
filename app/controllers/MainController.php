<?php
class MainController extends BaseController
{
	public function index()
	{
		$title="Các câu hỏi mới";
		$question=Question::with("tags","users", "answers")->orderBy("id","desc")->paginate(9);
		return View::make("minhquan.index")->with("title",$title)->with("questions",$question);
	}
	public function getParty($id)
	{
		return View::make('minhquan.chat')->with('id', $id)->with('title', 'Chat');
	}
	public function getChart()
	{
		return View::make("minhquan.chart")->with("title", "Thống kê website");
	}
	public function Search($cate, $text)
	{
		$text = str_replace("%20", " ", $text);
		
		if($cate == 0)
		{
			$question = Question::with("tags","users", "answers")
						->where("title", "like", "%".$text."%")
						->orWhere("content", "like", "%".$text."%")
						->orderBy("id","desc")->paginate(9);
			$title="Kết quả tìm kiếm các câu hỏi cho từ khoá : ".$text;
		}else
		{
			$question = Question::with("tags","users", "answers", "categories")
						->where("categorieID", $cate)
						->where("title", "like", "%".$text."%")
						->orWhere("content", "like", "%".$text."%")
						->orderBy("id","desc")->paginate(9);
			$cat = Categorie::find($cate);				
			$title="Kết quả tìm kiếm : chủ đề ".$cat->title." cho từ khoá \"".$text.'"';
		}
		return View::make("minhquan.index")->with("title",$title)->with("questions",$question);
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
					$date = Input::get('dateTo');
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
}