<?php
class AnswerController extends BaseController{
	public function postReply($id, $title)
	{
		$question = Question::find($id);
		if($question)
		{
			$valid = Validator::make(Input::all(), Answer::$answer_rules, Answer::$answer_langs);
			if($valid->passes())
			{
				$textInput = str_replace('<?php','<pre>&lt;&#63;php', Input::get("answer"));
				$textInput = str_replace('?>', '&#63;&gt;</pre>', $textInput);	
				$dataInsert = array(
						"content" => $textInput,
						"userID" => Sentry::getUser()->id,
						"questionID" => $id
					);
				Answer::create($dataInsert);
				return Redirect::route("question_detail_get", array($id, $title))->with("success", "Trả lời thành công ! Cảm ơn bạn !");
			}else
			{
				return Redirect::route("question_detail_get", array($id, $title))->with("error", $valid->errors()->first());
			}
		}else
		{
			return Redirect::route("index")->with("error", "Câu hỏi này không tồn tại");
		}
	}
	public function getVotes($action, $id)
	{
		if(Request::ajax())
		{
			$answer  = Answer::find($id);
			if($action == "like")
			{
				$vote = $answer->votes + 1;
			}else
			{
				$vote = $answer->votes - 1;
			}
			$answer->votes = $vote;
			$answer->save();
			return $vote;
		}else
		{
			return Redirect::route("index");
		}
	}
	public function getDelete($id){
		$answer  = Answer::with("questions")->find($id);
		if($answer)
		{
			$answer->delete();
			return Redirect::route("question_detail_get", array($answer->questionID, Unicode::make($answer->questions->title).".html"))->with("success", "Xoá thành công");
		}else
		{
			return Redirect::route("question_detail_get", array($answer->questionID, Unicode::make($answer->questions->title).".html"))->with("error", "Câu hỏi này không tồn tại");
		}
	}
	public function getCorrect($id)
	{
		$answer = Answer::with("questions")->find($id);
		if($answer)
		{
			$admin = Sentry::findGroupByName('Administrator');
			$mod = Sentry::findGroupByName('Moderator');
			if( Sentry::getUser()->inGroup($admin) || Sentry::getUser()->inGroup($mod) ||$answer->questions->userID == Sentry::getUser()->id)
			{
				Answer::where("questionID", $answer->questionID)->update(array("correct"=>"0"));
				$answer->correct = "1";
				$answer->save();
				return Redirect::route("question_detail_get", array($answer->questionID, Unicode::make($answer->questions->title).".html"))->with("success", "Thành công");
			}else
			{
				return Redirect::route("question_detail_get", array($answer->questionID, Unicode::make($answer->questions->title).".html"))->with("error", "Bạn không có quyền truy cập chức năng này");
			}
		}else
		{
			return Redirect::route("question_detail_get", array($answer->questionID, Unicode::make($answer->questions->title).".html"))->with("error", "Không tìm thấy câu trả lời này");
		}
	}
}