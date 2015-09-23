<?php
class AuthController extends BaseController{
	public function postLogin()
	{
		$valid = Validator::make(Input::all(), User::$login_rules, User::$user_langs);
		if($valid->passes())
		{
			try{
					$datalogin = array(
							"username" => Input::get('username'),
							"password" => Input::get('password'),
						);
					Sentry::Authenticate($datalogin, false);
					$user = Sentry::findUserByCredentials($datalogin);
					$user->status=1;
					$user->save();
					return Redirect::route('index')->with("success", "Đăng nhập thành công");
			}catch(Cartalyst\Sentry\Users\WrongPasswordException $e)
			{
				return Redirect::route('index')->with("error", "Mật khẩu không chính xác");
			}catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				return Redirect::route('index')->with("error", "Không tồn tại tên truy cập này");
			}catch(Cartalyst\Sentry\Users\UserNotActivatedException $e)
			{
				return Redirect::route('index')->with("error", "Tài khoản này chưa được kích hoạt");
			}
		}else
		{
			return Redirect::route("index")->with('error', $valid->errors()->first());
		}
	}
	public function getLogout()
	{
		$datalogout = array(
							"username" => Sentry::getUser()->username,
						);
		$user = Sentry::findUserByCredentials($datalogout);
		$user->status=0;
		$user->save();
		Sentry::logout();
		return Redirect::route('index')->with("success", "Đăng xuất thành công");
	}
	public function getRegister()
	{
		return View::make(Device::make().'.minhquan.register')->with('title', 'Đăng kí thành viên');
	}
	public function postRegister()
	{
		$valid = Validator::make(Input::all(), User::$register_rules, User::$user_langs);
		if($valid->passes())
		{
			$dataInsert = array(
					"first_name" => Input::get('first_name'),
					"last_name" => Input::get('last_name'),
					"username" => Input::get('username'),
					"email" => Input::get('email'),
					"password" => Input::get('password'),
					"activated" => 1,
					"status" => 1,
					'avatar' => "uploads/default.png",
				);
			$dataLogin = array(
					"username" => Input::get('username'),
					"password" => Input::get('password'),
				);
			Sentry::getUserProvider()->create($dataInsert);
			Sentry::Authenticate($dataLogin, false);
			$memberGroup = Sentry::findGroupById(2);
			$userCurrent = Sentry::getUser();
			$userCurrent->addGroup($memberGroup);
			return Redirect::route("index")->with("success", "Chúc mừng bạn đã đăng kí thành viên thành công");
		}else
		{
			return Redirect::route('register_get')->withInput(Input::except("password", "repassword"))->with('error', $valid->errors()->first());
		}
	}
	public function getChangePass()
	{
		return View::make(Device::make().'.minhquan.changepass')->with('title', 'Đổi mật khẩu');
	}
	public function postChangePass()
	{
		$valid = Validator::make(Input::all(), User::$changepass_rules, User::$user_langs);
		if($valid->passes())
		{
			try
			{
				$user = Sentry::findUserByCredentials(array(
				        'username'      => Sentry::getUser()->username,
				        'password'   => Input::get("oldpassword"),
				    ));
				$user->password=Input::get("newpassword");
				$user->save();
				return Redirect::route('changepass_get')->with('success', 'Đổi mật khẩu thành công');
			}catch(Cartalyst\Sentry\Users\WrongPasswordException $e)
			{
				return Redirect::route('changepass_get')->with('error', 'Mật khẩu cũ không chính xác');
			}
		}else
		{
			return Redirect::route("changepass_get")->with('error', $valid->errors()->first());
		}
	}
	public function getForgot()
	{
		return View::make(Device::make().".minhquan.forgot")->with("title", "Quên mật khẩu ?");
	}
	public function postForgot()
	{
		$valid = Validator::make(Input::all(), User::$forgot_rules, User::$user_langs);
		if($valid->passes())
		{
			try{
				$user = Sentry::findUserByLogin(Input::get('username'));
				$reset = $user->getResetPasswordCode();
				$dataEmail = array(
					"user" => $user->username,
					"code" => $reset,
					"name" => $user->first_name." ".$user->last_name,
					"email" => $user->email,

					);
				Mail::send(Device::make().".mail.activecode",$dataEmail,function($mess) use ($dataEmail){
					$mess->from("quan.li2609@gmail.com","No-reply Email");
					$mess->to($dataEmail["email"],$dataEmail["name"]);
					$mess->subject("Yeu cau lay lai mat khau");
				});
				return Redirect::route("forgot_get")->with("success","Một email chứa liên kết xác nhận đã gửi tới email của bạn. Vui lòng kiểm tra và hoàn tất yêu cầu này");

			}catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				return Redirect::route('forgot_get')->with('error', 'Không tồn tại tên truy cập này');
			}
		}else
		{
			return Redirect::route('forgot_get')->with('error', $valid->errors()->first());
		}
	}
	public function getActiveReset($user, $code)
	{
		try{
			$user = Sentry::findUserByLogin(Input::get('username'));
			if($user->checkResetPasswordCode($code))
			{
				$newpass = Str::random(6);
				$user->attempResetPassword($code, $newpass);
				$dataEmail = array(
						"user" => $user->username,
						"name" => $user->first_name." ".$user->last_name,
						"email" => $user->email,
						"pass" => $newpass
					);
				Mail::send(Device::make().".mail.resetpass",$dataEmail,function($mess) use ($dataEmail){
					$mess->from("quan.li2609@gmail.com","No-reply Email");
					$mess->to($dataEmail["email"],$dataEmail['name']);
					$mess->subject("Mat khau moi cua ban tren qhonline.edu.vn");
				});
				return Redirect::route("index")->with("success","Mật khẩu mới đã được gởi tới email của bạn");
			}else
			{
				return Redirect::route('forgot_get')->with('error','Không thể lấy lại mật khẩu vui lòng thử lại' );
			}

		}catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return Redirect::route('forgot_get')->with('error', 'Không tồn tại tên truy cập này');
		}
	}
	public function getProfile($id)
	{
		$user = User::find($id);
		if($user)
		{
			return View::make(Device::make().".minhquan.profile")->with("title", "Trang cá nhân của ".$user->username)->with("users", $user);
		}else
		{
			return Redirect::route("index")->with("error", "Không tồn tại tên truy cập này");
		}
	}
	public function postNameProfile()
	{
		$valid = Validator::make(Input::all(), User::$rename_rules, User::$user_langs);
		if($valid->passes())
		{
			try
			{
				$user = Sentry::findUserByCredentials(array(
				       'username'      => Input::get('username'),
				       'id'      => Input::get('id')
				    ));
				$name = explode(' ', Input::get('name'));
				if(count($name) > 1)
				{
					$user->last_name = $name['0'];
					$n  = $name['1'];
					for($i = 2; $i < count($name); $i++)
					{
						$n .= ' '.$name[$i];
					}
					$user->first_name = $n;
				}else
				{
					$user->last_name = '';
					$user->first_name = Input::get('name');
				}
				$user->save();
				return Redirect::route('profile_get', array(Input::get('id')))->with('success', 'Họ tên đã được thay đổi thành công');
			}catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				return Redirect::route('profile_get', array(Input::get('id')))->with('error', 'Không tồn tại tên truy cập này');
			}
		}else
		{
			return Redirect::route('profile_get', array(Input::get('id')))->with('error', $valid->errors()->first());
		}
	}
	public function uploadProfile($id)
	{
		$user = User::find($id);
		if($user)
		{
			return View::make(Device::make().".minhquan.upload")->with("title", "Thay đổi ảnh đại diện")->with("users", $user);
		}else
		{
			return Redirect::route("index")->with("error", "Không tồn tại tên truy cập này");
		}
	}
	public function doUploadProfile()
	{
		$valid = Validator::make(Input::all(), User::$upload_rules, User::$user_langs);
		if($valid->passes())
		{
			if(Sentry::getUser()->hasAccess("admin") || Sentry::getUser()->id == Input::get('id'))
			{
				$data = Input::all();
				if($data['img'] != NULL)
				{
					$isUpload = $data['img']->move('uploads/images', Input::get('id').Input::get('username').$data['img']->getClientOriginalName());
					if($isUpload)
					{
						$url = '/uploads/images/'.Input::get('id').Input::get('username').$data['img']->getClientOriginalName();
						Session::put('image', Input::get('id').Input::get('username').$data['img']->getClientOriginalName());
						Session::put('url', $url);
						Session::put('userid', Input::get('id'));
						Session::put('username', Input::get('username'));
						return Redirect::route('profile_get_upload', array(Input::get('id')));

					}else
					{
						return Redirect::route('profile_get_upload', array(Input::get('id')))->with('error', 'Tải hình ảnh lên thất bại');
					}
				}else
				{
					return Redirect::route('profile_get_upload', array(Input::get('id')))->with('error', 'Vui lòng chọn hình ảnh để tải lên ');
				}
			}else
			{
				return Redirect::route("index")->with("error", "Bạn không có quyền thực hiện chức năng này");
			}
		}else
		{
			return Redirect::route('profile_get_upload', array(Input::get('id')))->with('error', $valid->errors()->first());
		}
	}
	public function cropUpload()
	{
		if(Sentry::getUser()->hasAccess("admin") || Sentry::getUser()->id == Input::get('id'))
		{
			$name = Input::get('image');
			$image = imagecreatefromjpeg(URL::to('/')."/uploads/images/$name");
			$des = ImageCreateTrueColor(Input::get('w'), Input::get('h'));
			imagecopyresampled($des, $image, 0, 0, Input::get('x'), Input::get('y'), Input::get('w'), Input::get('h'), Input::get('w'), Input::get('h'));
			imagejpeg($des, "uploads/crops/".$name, 90);
			try
					{
						$user = Sentry::findUserByCredentials(array(
						       'username'      => Input::get('username'),
						       'id'      => Input::get('id')
						    ));

						$user->avatar = "uploads/crops/$name";
						$user->save();
						Session::forget('image');
						Session::forget('url');
						Session::forget('userid');
						Session::forget('username');
						return Redirect::route('profile_get_upload', array(Input::get('id')))->with('success', 'Hình ảnh đại diện đã được thay đổi thành công');
					}catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
					{
						return Redirect::route('profile_get_upload', array(Input::get('id')))->with('error', 'Không tồn tại tên truy cập này');
					}
		}else
		{
			return Redirect::route("index")->with("error", "Bạn không có quyền thực hiện chức năng này");
		}

	}
	public function getGroup()
	{
		$groups = Group::all();
		return View::make(Device::make().'.minhquan.group')->with('title', 'Quản lý group')->with('groups', $groups);
	}
	public function postCreateGroup()
	{
		$valid = Validator::make(Input::all(), Group::$create_rules, Group::$group_langs);
		if($valid->passes())
		{
			try
			{
			    // Create the group
			    $group = Sentry::createGroup(array(
			        'name'        => Input::get('add_group_name'),
			        'permissions' => array(
			            Input::get('add_group_permission') => 1,
			        ),
			    ));
			    return Redirect::route('get_group')->with('success', 'Thêm group thành công');
			}
			catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
			{
			    return Redirect::route('get_group', array(Input::get('add_group_name'), Input::get('add_group_permission')))->with('error', 'Tên không được để trống');
			}
			catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
			{
			    return Redirect::route('get_group', array(Input::get('add_group_name'), Input::get('add_group_permission')))->with('error', 'Group đã tồn tại');
			}

		}else
		{
			return Redirect::route('get_group', array(Input::get('add_group_name'), Input::get('add_group_permission')))->with('error', $valid->errors()->first());
		}
	}
	public function postDeleteGroup($id)
	{
		if(Request::ajax())
		{
			$group = Group::find($id);
			if($group)
			{
				$group->delete();
				return "OK";
			}else
			{
				return Response::Json(array("status"=>"error","mess"=>"Group này không tồn tại"));
			}
		}
	}
	public function postApiLogin()
	{
		$valid = Validator::make(Input::all(), User::$login_rules, User::$user_langs);
		if($valid->passes())
		{
			try{
					$datalogin = array(
							"username" => Input::get('username'),
							"password" => Input::get('password'),
						);
					Sentry::Authenticate($datalogin, false);
					$user = Sentry::findUserByCredentials($datalogin);
					$user->status=1;
					$user->save();
					//return Redirect::route('index')->with("success", "Đăng nhập thành công");
					return Response::Json(array('status'=>'success', 'data' => $user));
			}catch(Cartalyst\Sentry\Users\WrongPasswordException $e)
			{
				//return Redirect::route('index')->with("error", "Mật khẩu không chính xác");
				return Response::Json(array('status' => 'error', 'mess' => 'Password not match .'));
			}catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				//return Redirect::route('index')->with("error", "Không tồn tại tên truy cập này");
				return Response::Json(array('status'=>'error', 'mess'=>'User not exits .'));
			}catch(Cartalyst\Sentry\Users\UserNotActivatedException $e)
			{
				//return Redirect::route('index')->with("error", "Tài khoản này chưa được kích hoạt");
				return Response::Json(array('status'=>'error', 'mess'=>'User not active, please contact with Administrator .'));
			}
		}else
		{
			//return Redirect::route("index")->with('error', $valid->errors()->first());
			return Response::Json(array('status'=>'error', 'mess'=> $valid->errors()->first()));
		}
	}
	public function postApiUser()
	{
		$id = Input::get('id');
		$user = User::find($id);
		return Response::Json($user);
	}
	public function getApiChecklogin()
	{
		
		if(Sentry::getUser())
		{
			return Response::Json(array('mess'=> TRUE));
		}else
		{
			return Response::Json(array('mess'=> FALSE));
		}
		
	}
}