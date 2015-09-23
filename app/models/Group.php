<?php
class Group extends Eloquent{
	protected $fillable=array("name", "permissions");
	public static $create_rules=array(
			"add_group_name" => "required",
			"add_group_permissions" => "required",
	);
	public static $group_langs=array(
			"add_group_name.required" => "Vui lòng nhập vào tên group",
			"add_group_permissions.required" => "Vui lòng nhập vào  permissions",
	);
}