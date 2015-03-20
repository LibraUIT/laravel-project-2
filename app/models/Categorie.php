<?php
class Categorie extends Eloquent{
	protected $fillable=array("title");
	public function questions(){
		return $this->hasMany("Question","categorieID");
	}
	public static function boot()
	{
		parent::boot();
		static::deleted(function($cate){
			Cache::forget("menu");
		});
		static::created(function($cate){
			Cache::forget("menu");
		});
		static::updated(function($cate){
			Cache::forget("menu");
		});
	}
}