<?php
class Pdf extends Eloquent{
	protected $fillable=array("title","name","data","userID");
	public function users(){
		return $this->belongsTo("User","userID");
	}
}