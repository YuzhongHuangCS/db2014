$(document).ready(function(){
	$('#login').click(function(){
		$('#loginView').css({"left":"0", "opacity": "0.9"});	
	});
	$('#loginButton').click(function(){
		var loginName = $('[name="loginName"]').val();
		var password = $('[name="password"]').val();

		$.post('php/login.php', {
			loginName: loginName, 
			password: password
		});

		console.log($.cookie('privilege'));
		if($.cookie('privilege') > 0){
			$('#tip').fadeOut('400', function() {
				$('#tip').text('登录成功');
				$('#tip').css({
					color: '#76CC1E',
					border: '2px solid #76CC1E'
				});
				$('#tip').fadeIn('400', function() {
					setTimeout(function(){
						$('#loginView').css({"left":"100%", "opacity": "0"});
					}, 400);
				});
			});;
		} else{
			$('#tip').fadeOut('400', function() {
				$('#tip').text('登录失败');
				$('#tip').fadeIn();
			});
		}
	});
	$('#cancelButton').click(function(){
		$('#loginView').css({"left":"100%", "opacity": "0"});
	});
});