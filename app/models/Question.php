<?php
class Question extends Eloquent{
	protected $fillable=array("title","content","viewed","votes","userID","categorieID");
	public function users(){
		return $this->belongsTo("User","userID");
	}
	public function categories(){
		return $this->belongsTo("Categorie","categorieID");
	}
	public function tags(){
		return $this->belongsToMany("Tag","question_tags")->withTimestamps();
	}
	public function answers()
	{
		return $this->hasMany("Answer", "questionID");
	}
	public static $create_rules=array(
			"title" => "required|min:5",
			"content" => "required|min:10"
		);
	public static $question_langs=array(
			"title.required" => "Vui lòng nhập tiêu đề câu hỏi",
			"content.required" => "Vui lòng nhập nội dung câu hỏi",
			"title.min"  => "Tiêu đề tối thiểu là :min ký tự",
			"content.min" => "Nội dung tối thiểu là :min ký tự"
		);
	public function getTimeagoAttribute(){
		$date=\Carbon\Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
		return $date;
	}
}