$(document).ready(function(){
	checkLogin();
	$('.unlogin').click(function(){
		$('#loginView').css({"left":"0", "opacity": "0.9"});	
	});
	$('.logined').click(function(event) {
		if(confirm('退出当前账户？')){
			$.removeCookie('name', {path: '/'});
			$.removeCookie('privilege', {path: '/'});
			$('#login').addClass('unlogin');
			$('#login').removeClass('logined');
			checkLogin();
		}
	});
	$('#loginButton').click(function(){
		var loginName = $('[name="loginName"]').val();
		var password = $('[name="password"]').val();

		$.post('php/login.php', {
			loginName: loginName, 
			password: password
		});
		$.post('php/login.php', {loginName: loginName, password: password}, function() {
			if($.cookie('privilege') > 0){
				$('#tip').fadeOut('400', function() {
					$('#tip').text('登录成功');
					checkLogin();
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
			};
		});
	});
	$('#cancelButton').click(function(){
		$('#loginView').css({"left":"100%", "opacity": "0"});
	});
});

function checkLogin(){
	if($.cookie('name')){
		$('#login').text($.cookie('name'));
		$('#login').removeClass('unlogin');
		$('#login').addClass('logined');
	} else{
		$('#login').text('注册 / 登录');
		$('#login').removeClass('logined');
		$('#login').addClass('unlogin');
	}
}

function BookListCtrl($scope, $http) {
	$http.get('php/backend.php?action=selectAll').success(function(data) {
		$scope.books = data;
	});
	$scope.orderProp = 'bookID';
}