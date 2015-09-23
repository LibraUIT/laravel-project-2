<div class="bottom">
	Copyright &copy; 2014 - Quan Nguyen
</div>
<a title="Hỏi & đáp công nghệ" href="#" class="scrollToTop"><span style="font-size:24px" class="glyphicon glyphicon-circle-arrow-up" aria-hidden="true"></span></a>
<style>
.scrollToTop{
	position:fixed;
	bottom: 50px;
	right: 10px;	
}
.scrollToTop:hover{
	text-decoration:none;
}
</style>
{{HTML::script('public/js/jquery-1.9.1.min.js')}}
<script type="text/javascript">
	$('.scrollToTop').click(function(){
		$('html,body').animate({ scrollTop: 0 }, 'slow', function () {
                 
                    });
		}); 
</script>