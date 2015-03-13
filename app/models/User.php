<?php
class User extends Cartalyst\Sentry\Users\Eloquent\User {
	public static $login_rules=array(
			"username" => "required",
			"password" => "required",
		);
	public static $user_langs=array(
			"first_name.required" => "Vui lòng nhập tên gọi của bạn",
			"last_name.required"  => "Vui lòng nhập họ của bạn",
			"email.required"      => "Vui lòng nhập email của bạn",
			"username.required" => "Vui lòng nhập tên truy cập của bạn",
			"password.required" => "Vui lòng nhập mật khẩu của bạn",
			"username.min"      => "Tên truy cập tối thiểu là :min ký tự",
			"password.min"      => "Mật khẩu tối thiểu la :min ký tự",
			"email"             => "Địa chỉ email của bạn không hợp lệ",
			"email.unique"      => "Địa chỉ email của bạn đã tồn tại",
			"username.unique"   => "Tên truy cập của bạn đã tồn tại",
			"repassword.required" => "Vui lòng nhập xác nhận mật khẩu",
			"repassword.same"   => "Mật khẩu và xác nhận mật khẩu, không chính xác",
			"recaptcha_response_field.required" => "Vui lòng nhập mã xác nhận",
			"recaptcha_response_field.recaptcha" => "Mã xác nhận không chính xác",
			"oldpassword.required"  => "Vui lòng nhập mật khẩu cũ",
			"newpassword.required"  => "Vui lòng nhập mật khẩu mới",
			"renewpassword.required" => "Vui lòng nhập xác nhận mật khẩu mới",
			"newpassword.min"        => "Mật khẩu mới tối thiểu là :min ký tự",
			"renewpassword.same"  => "Xác nhận mật khẩu mới và mật khẩu mới không chính xác",
			"name.required" => "Họ tên không được để trống",
			"name.min" => "Họ tên tối thiểu :min ký tự",
			"img.image" => "Vui lòng chọn đúng định dạng là ảnh",
			"img.min" => "Kích thước ảnh tối thiểu tải lên là 10KB",
		);
	public static $register_rules=array(
			"first_name" => "required",
			"last_name"  => "required",
			"email"      => "required|email|unique:users,email",
			"username"   => "required|min:4|unique:users,username",
			"password"   => "required|min:5",
			"repassword" => "required|same:password",
			'recaptcha_response_field' => 'required|recaptcha',
		);
	public static $changepass_rules=array(
			"oldpassword" => "required",
			"newpassword" => "required|min:5",
			"renewpassword" => "required|same:newpassword",
			'recaptcha_response_field' => 'required|recaptcha',			
		);
	public static $forgot_rules=array(
			"username"  => "required",
			'recaptcha_response_field' => 'required|recaptcha',			
		);
	public function questions(){
		return $this->hasMany("Question","userID");
	}
	public function answers()
	{
		return $this->hasMany("Answer", "userID");
	}
	//
	public static $rename_rules = array(
			"name" => "required|min:6"
		);
	public static $upload_rules = array(
			"img" => "image | min:10"
		);
}