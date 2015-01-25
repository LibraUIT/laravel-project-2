<?php
class Tag extends Eloquent{
	protected $fillable=array("tag","alias");
	public function questions(){
		return $this->belongsToMany("Question","question_tags")->withTimestamps();
	}
}