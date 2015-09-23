<!DOCTYPE html>
<html>
<head>
	<title>{{$title}}</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	{{HTML::style('public/mobile/jquery.mobile-1.4.5.min.css')}}
	{{HTML::script('public/js/jquery-1.9.1.min.js')}}
	{{HTML::script('public/mobile/jquery.mobile-1.4.5.min.js')}}
	{{HTML::style('public/css/bootstrap.css')}}
</head>
<body class="ui-mobile-viewport ui-overlay-a">
<div tabindex="0" class="ui-page ui-page-theme-a ui-page-footer-fixed ui-page-active" style="padding-bottom: 35px;">
	@include("Mobile.template.header")
	<div id="index" class="ui-content" role="main">
	@include("Mobile.template.menu")
	@yield("content")
	</div></div>
</body>
</html>