<?php
class Answer extends Eloquent{
	protected $fillable = array("content", "votes", "correct", "questionID", "userID");
	public function questions()
	{
		return $this->belongsTo("Question", "questionID");
	}
	public function users()
	{
		return $this->belongsTo("User", "userID");
	}
	public static $answer_rules = array(
			"answer" => "required|min:10"
		);
	public static $answer_langs = array(
			"answer.required" => "Vui lòng nhập vào câu trả lời của bạn",
			"answer.min" => "Vui lòng nhập vào câu trả lời có ít nhất :min ky tu"
		);
	public function getTimeagoAttribute(){
		$date=\Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
		return $date;
	}
}