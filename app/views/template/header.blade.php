@if(Session::has("success"))
<div class="alert alert-success success">{{Session::get('success')}}</div>
@endif
@if(Session::has("error"))
<div class="alert alert-danger error">{{Session::get('error')}}</div>
@endif
<div class="header">
	<div class="header-container pull-left">
	<b><a id="title-page" href="{{URL::route('index')}}">Việt Stackoverflow</a></b>
	<a id="today" href="{{URL::route('question_today_get')}}">Mới</a>
	</div>
	<div class="form-login pull-left">
		@if(!Sentry::check())
		{{Form::open(array("route"=>"login_post", "class"=>"form-inline"))}}

		<form class="form-inline">
		  <div class="form-group">
		    {{Form::text('username', '', array("class"=>"form-control", "placeholder"=>"Tên truy cập"))}}
		  </div>
		  <div class="form-group">
		    {{Form::password("password", array("class"=>"form-control", "placeholder"=>"Mật khẩu"))}}
		  </div>
		  {{Form::submit("Đăng nhập", array("class"=>"btn btn-primary"))}}
		  <div class="form-group">
		  <a href="{{URL::route('register_get')}}">Đăng kí</a> - <a href="{{URL::route('forgot_get')}}">Quên mật khẩu</a>
		  </div>
		{{Form::close()}}
		@else
		<div class="dropdown dropdown-alert">
		  <button class="btn btn-default dropdown-toggle bnt-drop-alert" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
		    <span style="color:#FFF" class="glyphicon glyphicon-bell dropdown-alert-bell" aria-hidden="true"></span>
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu dropdown-menu-alert" role="menu" aria-labelledby="dropdownMenu1">
		  <li class="no-alert" role="presentation"><a role="menuitem" tabindex="-1" href="#">Không có thông báo nào</a>
		  </ul>
		</div>
		<!-- -->
		 
		 <div class="image-avatar"><img width="30" src="{{asset(Sentry::getUser()->avatar)}}"></div>
		 <div class="dropdown dropdown-profile">
		  <button class="btn btn-default dropdown-toggle avatar-drop" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
		    {{Sentry::getUser()->username}}
		    <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::route('question_create_get')}}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Đặt câu hỏi</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::route('profile_get', array(Sentry::getUser()->id))}}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Trang cá nhân</a></li>
		    @if(Sentry::getUser()->hasAccess("admin"))
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::to('categorie/list')}}"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Quản lý chủ đề</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::route('get_group')}}"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> Quản lý group</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::route('get_chart')}}"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Thống kê</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::route('get_report')}}"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Tạo báo cáo</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::route('get_all_pdf')}}"><span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span> Các báo cáo đã lưu</a></li>
		    @endif
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::route('changepass_get')}}"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Đổi mật khẩu</a></li>
		    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{URL::route('logout_get')}}"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>  Thoát</a></li>
		  </ul>
		</div> 
		@endif
	</div>
</div>