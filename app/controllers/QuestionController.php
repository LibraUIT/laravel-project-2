<?php
class QuestionController extends BaseController{
	public function getCreate()
	{
		$cate=Categorie::lists("title","id");
		return View::make(Device::make().".minhquan.createQuestion")->with("title", "Tạo câu hỏi mới")->with('cate', $cate);
	}
	public function postCreate()
	{
		$valid = Validator::make(Input::all(), Question::$create_rules, Question::$question_langs);
		if($valid->passes())
		{
			$textInput = str_replace('<?php','<pre>&lt;&#63;php', Input::get("content"));
			$textInput = str_replace('?>', '&#63;&gt;</pre>', $textInput);	
			$questionInsert=Question::create(array(
					"title" => Input::get("title"),
					"content" => $textInput,
					"categorieID" => Input::get("cate"),
					"userID" => Sentry::getUser()->id
				));
			$questionID = $questionInsert->id;
			$question  = Question::find($questionID);
			if(Str::length(Input::get("tag")))
			{
				$tag_array = explode(";", Input::get("tag"));
				if(count($tag_array))
				{
					foreach($tag_array as $tagData)
					{
						$tagData = trim(Str::lower($tagData));
						$tagAlias = Unicode::make($tagData);
						$tagCheck = Tag::where("alias", $tagAlias);
						if($tagCheck->count() == 0)
						{
							$tagInfo = Tag::create(array(
									"tag" => $tagData,
									"alias" => $tagAlias
								));
						}else
						{
							$tagInfo = $tagCheck->first();
						}
						$question->tags()->attach($tagInfo->id);
					}
				}
			}
			$link = URL::route("question_detail_get", array($question->id, Unicode::make($question->title).".html"));
			return Redirect::route("question_create_get")->with("success", "Câu hỏi mới được tạo thành công. Xem tại <a href='".$link."'>đây</a>");
		}else
		{
			return Redirect::route("question_create_get")->withInput()->with("error", $valid->errors()->first());
		}
	}
	public function getVotes($action, $id)
	{
		if(Request::ajax())
		{
			$question  = Question::find($id);
			if($action == "like")
			{
				$vote = $question->votes + 1;
			}else
			{
				$vote = $question->votes - 1;
			}
			$question->votes = $vote;
			$question->save();
			return $vote;
		}else
		{
			return Redirect::route("index");
		}
	}
	public function getDetail($id,$title){
		$question=Question::with("users","tags")->find($id);
		if($question){
			$ip = Request::getClientIp();
			if(Cache::has($ip."_view_".$id)){
				$question->viewed = Cache::get($ip."_view_".$id);

			}else{
				$view=$question->viewed + 1;
				$question->viewed=$view;
				$question->save();
				Cache::add($ip."_view_".$id, $view, 15);
			}
			$answer = Answer::with("users")->where("questionID", $id)->orderBy("correct", "desc")->get();
			return View::make(Device::make().".minhquan.detail")->with("title",$question->title)->with("question",$question)->with("answers", $answer);
		}else{
			return Redirect::route("index")->with("error","Câu hỏi không tồn tại");
		}

	}
	public function getDelete($id){
		$question=Question::find($id);
		if($question){
			$question->delete();
			return Redirect::route("index")->with("success","Xóa câu hỏi thành công");
		}else{
			return Redirect::route("index")->with("error","Câu hỏi không tồn tại");
		}
	}
	public function getQuestionByCate($id, $title)
	{
		$cate = Categorie::find($id);
		if($cate)
		{
			$today = date("M d , Y");
			$day = date('D', strtotime( $today));
			$week = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
			$pos = array_search ($day,$week);
			$firstday = date('Y-m-d H:i:s', strtotime("-$pos day"));
			$lastday = date('Y-m-d H:i:s');
				if(isset($_GET['tab']))
				{
					switch ($_GET['tab']) {
					case "active":
						$questions=$cate->questions()->with("users", "tags", "answers")->orderBy("id","desc")->paginate(9);
						break;
					case 'hot':
						$questions=$cate->questions()->with("users", "tags", "answers")->orderBy("viewed","desc")->paginate(9);
						break;
					case 'week':
						$questions=$cate->questions()->with("users", "tags", "answers")
						->where("questions.created_at" , "<=", $lastday)
						->where("questions.created_at", ">=", $firstday)
						->orderBy("id","desc")->paginate(9);
						break;
					case "month":
						$today = date("d")-1;
						$firstday = date('Y-m-d H:i:s', strtotime("-$today day"));
						$questions=$cate->questions()->with("users", "tags", "answers")
						->where("questions.created_at" , "<=", $lastday)
						->where("questions.created_at", ">=", $firstday)
						->orderBy("id","desc")->paginate(9);
						break;
					default;
						$questions=$cate->questions()->with("users", "tags", "answers")->orderBy("id","desc")->paginate(9);
						break;
				}
			}else
			{
				$questions=$cate->questions()->with("users", "tags", "answers")->orderBy("id","desc")->paginate(9);
			}
			return View::make(Device::make().".minhquan.index")->with("title", "Các câu hỏi thuộc chủ đề : $cate->title")->with("questions", $questions);
		}else
		{
			return Redirect::route("index")->with("error", "Chủ đề này không tồn tại");
		}
	}
	public function getQuestionByTag($tag)
	{
		$tags = Tag::where("alias", $tag)->first();
		if($tags)
		{
			$today = date("M d , Y");
			$day = date('D', strtotime( $today));
			$week = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
			$pos = array_search ($day,$week);
			$firstday = date('Y-m-d H:i:s', strtotime("-$pos day"));
			$lastday = date('Y-m-d H:i:s');
				if(isset($_GET['tab']))
				{
					switch ($_GET['tab']) {
					case "active":
						$questions = $tags->questions()->with("users", "tags", "answers")->orderBy("id", "desc")->paginate(9);
						break;
					case 'hot':
						$questions = $tags->questions()->with("users", "tags", "answers")->orderBy("viewed", "desc")->paginate(9);
						break;
					case 'week':
						$questions = $tags->questions()->with("users", "tags", "answers")
						->where("questions.created_at" , "<=", $lastday)
						->where("questions.created_at", ">=", $firstday)
						->orderBy("id","desc")->paginate(9);
						break;
					case "month":
						$today = date("d")-1;
						$firstday = date('Y-m-d H:i:s', strtotime("-$today day"));
						$questions = $tags->questions()->with("users", "tags", "answers")
						->where("questions.created_at" , "<=", $lastday)
						->where("questions.created_at", ">=", $firstday)
						->orderBy("id","desc")->paginate(9);
						break;
					default;
 						$questions = $tags->questions()->with("users", "tags", "answers")->orderBy("id", "desc")->paginate(9);
						break;
					}
				}else
				{
					$questions = $tags->questions()->with("users", "tags", "answers")->orderBy("id", "desc")->paginate(9);
				}
			return View::make(Device::make().".minhquan.index")->with("title", "Các câu hỏi theo từ khoá: $tags->tag")->with("questions", $questions);
		}else
		{
			return Redirect::route("index")->with("error", "Không tìm thấy từ khoá này");
		}
	}
	public function getQuestionByUser($user)
	{
		$user = User::where("username", $user)->first();
		if($user)
		{
			$today = date("M d , Y");
			$day = date('D', strtotime( $today));
			$week = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
			$pos = array_search ($day,$week);
			$firstday = date('Y-m-d H:i:s', strtotime("-$pos day"));
			$lastday = date('Y-m-d H:i:s');
			if(isset($_GET['tab']))
			{
				switch ($_GET['tab']) {
					case "active":
						$questions = $user->questions()->with("users", "answers", "tags")->orderBy("id", "desc")->paginate(9);
						break;
					case 'hot':
						$questions = $user->questions()->with("users", "answers", "tags")->orderBy("viewed", "desc")->paginate(9);

						break;
					case 'week':
						$questions = $user->questions()->with("users", "answers", "tags")
						->where("questions.created_at" , "<=", $lastday)
						->where("questions.created_at", ">=", $firstday)
						->orderBy("id","desc")->paginate(9);
						break;
					case "month":
						$today = date("d")-1;
						$firstday = date('Y-m-d H:i:s', strtotime("-$today day"));
						$questions = $user->questions()->with("users", "answers", "tags")
						->where("questions.created_at" , "<=", $lastday)
						->where("questions.created_at", ">=", $firstday)
						->orderBy("id","desc")->paginate(9);
						break;
					default;
 						$questions = $tags->questions()->with("users", "tags", "answers")->orderBy("id", "desc")->paginate(9);
						break;
					}
			}else
			{
				$questions = $user->questions()->with("users", "answers", "tags")->orderBy("id", "desc")->paginate(9);
			}	
			$userid = $user->id;
			return View::make(Device::make().".minhquan.index")->with("title", "Các câu hỏi của thành viên : $user->username")->with("questions", $questions)->with('userid', $userid);
		}else
		{
			return Redirect::route("index")->with("error", "Không tìm thấy  tên truy cập này");
		}
	}
	public function getQuestionToDay()
	{
		if(isset($_GET['tab']))
			{
				switch ($_GET['tab']) {
					case "active":
						$question = Question::with("users", "answers", "tags")->where("created_at", ">=", new DateTime('today'))->orderBy("id", "desc")->paginate(9);
						break;
					case 'hot':
						$question = Question::with("users", "answers", "tags")->where("created_at", ">=", new DateTime('today'))->orderBy("viewed", "desc")->paginate(9);

						break;
					default;
 						$question = Question::with("users", "answers", "tags")->where("created_at", ">=", new DateTime('today'))->orderBy("id", "desc")->paginate(9);
						break;
					}
			}else
			{
				$question = Question::with("users", "answers", "tags")->where("created_at", ">=", new DateTime('today'))->orderBy("id", "desc")->paginate(9);
		}	
		if(count($question) > 0){
			return View::make(Device::make().".minhquan.index")->with("title", "Các câu hỏi trong 24 giờ qua")->with("questions", $question);
		}else
		{
			return Redirect::route("index")->with("error", "Không có câu hỏi nào trong 24 giờ qua");
		}
	}
	public function getQuestionByDate($day, $month, $year, $id)
	{
		$date =  $day."-".$month."-".$year;
		$date1 = date('Y-m-d H:i:s',strtotime($date));
		$date2 = date('Y-m-d H:i:s',strtotime($date1 . "+1 days"));
		$cate = Categorie::find($id);
		if($cate)
		{
			$question = $cate->questions()->with("users", "answers", "tags")
								->where("created_at" , "<", $date2)
								->where("created_at", ">=", $date1)
								->orderBy("id", "desc")->paginate(9);
			if(count($question) > 0){
				return View::make(Device::make().".minhquan.index")->with("title", "Các câu hỏi ".$cate->title." ngày ".$day."-".$month."-".$year)->with("questions", $question);
			}else
			{
				return Redirect::route("index")->with("error", "Không có câu hỏi ".$cate->title." nào ngày ".$day."-".$month."-".$year);
			}
		}else
		{
			return Redirect::route("index")->with("error", "Chủ đề này không tồn tại");
		}
	}
	public function getQuestionByCateFollowDate($from, $to, $id)
	{
		$date1 = date('Y-m-d H:i:s',strtotime($from));
		$date2 = date('Y-m-d H:i:s',strtotime($to));
		$cate = Categorie::find($id);
		if($cate)
		{
			if($from != $to)
			{
					$question = $cate->questions()->with("users", "answers", "tags")
										->where("created_at" , "<=", $date2)
										->where("created_at", ">=", $date1)
										->orderBy("id", "desc")->paginate(9);
			}else
			{
				$date3 = date('Y-m-d H:i:s',strtotime($to."+1 days"));
				$question = $cate->questions()->with("users", "answers", "tags")
										->where("created_at" , "<", $date3)
										->where("created_at", ">=", $date1)
										->orderBy("id", "desc")->paginate(9);
			}

			if(count($question) > 0){
				return View::make(Device::make().".minhquan.index")->with("title", "Các câu hỏi ".$cate->title." từ ngày ".$from." đến ".$to)->with("questions", $question);
			}else
			{
				return Redirect::route("index")->with("error", "Không có câu hỏi ".$cate->title." từ ngày ".$from." đến ".$to);
			}
		}else
		{
			return Redirect::route("index")->with("error", "Chủ đề này không tồn tại");
		}
	}
}