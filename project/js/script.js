$(document).ready(function(){

	checkLogin();

	var navElement = document.querySelector("nav");
	var headroom = new Headroom(navElement, {
  		"tolerance": 5,
  		"offset": 205,
 		"classes": {
  		 	"initial": "animated",
    		"pinned": "slideInDown",
    		"unpinned": "slideOutUp"
  		}
	});
	headroom.init();

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
			window.location.reload();
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
							setTimeout(function(){
								window.location.reload();
							}, 600);
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
		$('#adminRow').fadeIn();
	} else{
		$('#login').text('注册 / 登录');
		$('#login').removeClass('logined');
		$('#login').addClass('unlogin');
		$('#adminRow').fadeOut();
	}
}

function bookControl($scope, $http) {
	$http.get('php/backend.php?action=showBook').success(function(data) {
		$scope.books = data;
	});
	$scope.orderProp = 'bookID';

	$scope.borrow = function(bookID) {

		if(!($.cookie('privilege') >= 10)){
			alert('值班员尚未登录');
			return;
		}

    	var send, cardID;
    	cardID = prompt("请输入借书证号");
    	
		if ((cardID != null) && (cardID != "")){
    		send = 'php/backend.php?action=borrow&bookID=' + bookID + '&cardID=' + cardID ;
    		$http.get(send).success(function(data) {
    			if(data > 0){
    				alert('借书成功');
    				$http.get('php/backend.php?action=showBook').success(function(data) {
						$scope.books = data;
					});
    			} else{
    				alert('借书失败');
    			}
    		})
    	}
  	}
}
function cardControl($scope, $http) {

	if(!($.cookie('privilege') >= 10)){
		alert('值班员尚未登录');
		history.back();
		return;
	}

	var send, cardID;
	window.cardID = cardID = prompt("请输入借书证号");

	if ((cardID != null) && (cardID != "")){
		send = 'php/backend.php?action=showCardInfo&cardID=' + cardID;
		$http.get(send).success(function(data) {
			if((data.length) > 0){
				$scope.cardInfo = data;
				$('#cardInfo').slideDown();
			} else{
				alert('该借书卡不存在');
			}
		});
	};

	send = 'php/backend.php?action=showBorrow&cardID=' + cardID;
	$http.get(send).success(function(data) {
		$scope.borrows = data;
	});
	$scope.orderProp = 'bookID';

	$scope.return = function(borrowID) {
    	var send;

    	send = 'php/backend.php?action=return&borrowID=' + borrowID;
    	$http.get(send).success(function(data) {
    		if(data == 0){
    			alert('还书成功');
    			send = 'php/backend.php?action=showBorrow&cardID=' + cardID;
    			$http.get(send).success(function(data) {
					$scope.borrows = data;
				});
    		} else{
    			alert('还书失败');
    		}
    	})
  	}
}

function adminBookControl($scope, $http) {

	if(!($.cookie('privilege') >= 60)){
		alert('你没有权限访问本功能');
		history.back();
		return;
	}

	$scope.addCategory = function() {
		var send;

		send='php/backend.php?action=addCategory&categoryName=' + $scope.newCategory;
		$http.get(send).success(function(data) {
			if(data == 0){
				alert('添加分类成功');
			} else{
				alert('添加分类失败');
			}
		});
	}

	$http.get('php/backend.php?action=showCategory').success(function(categoryData) {
		$scope.categories = categoryData;
	});

	$scope.updateBook = function(){
		var send;

		send='php/backend.php?action=updateBook&bookID=' + $scope.newBook.bookID  + '&categoryID=' + $scope.newBook.categoryID + '&title=' + $scope.newBook.title + '&press=' + $scope.newBook.press + '&year=' + $scope.newBook.year + '&author=' + $scope.newBook.author + '&price=' + $scope.newBook.price + '&stock='+ $scope.newBook.stock + '&total=' + $scope.newBook.total;
		$http.get(send).success(function(data) {
			if(data == 0){
				alert('更新图书成功');
			} else{
				alert('更新图书失败');
			}
		});
	}

	$http.get('php/backend.php?action=showBook').success(function(data) {
		$scope.books = data;
	});
	$scope.orderProp = 'bookID';

	$scope.editBook = function(bookID){
		$.each($scope.books, function(key, value) {
			if((value['bookID'] == bookID)){
				$scope.newBook = value;
			}
		});
		$('html,body').animate({scrollTop: 0});
	}

	$scope.deleteBook = function(bookID) {
		if(confirm("你真的要删除这本书吗？")){
			var send;
			send = 'php/backend.php?action=deleteBook&bookID=' + bookID;
			
			$http.get(send).success(function(data) {
				if(data == 0){
					alert('删除成功');
						$http.get('php/backend.php?action=showBook').success(function(data) {
						$scope.books = data;
					});
				} else{
					alert('删除失败');
				}
			});
		}
	}
}

function adminCardControl($scope, $http){
	if(!($.cookie('privilege') >= 60)){
		alert('你没有权限访问本功能');
		history.back();
		return;
	}

	$http.get('php/backend.php?action=showCard').success(function(data) {
		$scope.cards = data;
	});
	$scope.orderProp = 'cardID';

	$scope.editCard = function(CardID){
		$.each($scope.cards, function(key, value) {
			if((value['cardID'] == CardID)){
				$scope.newCard = value;
			}
		});
		$('html,body').animate({scrollTop: 0});
	}

	$scope.updateCard = function(){
		var send;

		send='php/backend.php?action=updateCard&cardID=' + $scope.newCard.cardID  + '&name=' + $scope.newCard.name + '&department=' + $scope.newCard.department + '&privilege=' + $scope.newCard.privilege ;


		$http.get(send).success(function(data) {
			if(data == 0){
				alert('更新借书证成功');
			} else{
				alert('更新借书证失败');
			}
		});
	}

	$scope.deleteCard = function(cardID) {
		if(confirm("你真的要删除这张借书证吗？")){
			var send;
			send = 'php/backend.php?action=deleteCard&cardID=' + cardID;
			
			$http.get(send).success(function(data) {
				if(data == 0){
					alert('删除成功');
				} else{
					alert('删除失败');
				}
			});
		}
	}
}

function adminStaffControl($scope, $http){
	if(!($.cookie('privilege') >= 100)){
		alert('你没有权限访问本功能');
		history.back();
		return;
	}

	$http.get('php/backend.php?action=showAdmin').success(function(data) {
		$scope.admins = data;
	});
	$scope.orderProp = 'adminID';

	$scope.deleteAdmin = function(adminID) {
		if(confirm("你真的要删除这个管理员吗？")){
			var send;
			send = 'php/backend.php?action=deleteAdmin&adminID=' + adminID;
			
			$http.get(send).success(function(data) {
				if(data == 0){
					alert('删除成功');
				} else{
					alert('删除失败');
				}
			});
		}
	}

	$scope.editAdmin = function(adminID){
		$.each($scope.admins, function(key, value) {
			if((value['adminID'] == adminID)){
				$scope.newAdmin = value;
			}
		});
		$('#loginName').attr('disabled', 'disabled');
		$('html,body').animate({scrollTop: 0});
	}

	$scope.updateAdmin = function(){
		var send;

		send='php/backend.php?action=updateAdmin&adminID=' + $scope.newAdmin.adminID  + '&loginName=' + $scope.newAdmin.loginName + '&password=' + $scope.newAdmin.password + '&name=' + $scope.newAdmin.name + '&phone=' + $scope.newAdmin.phone + '&privilege=' + $scope.newAdmin.privilege ;

		$http.get(send).success(function(data) {
			if(data == 0){
				alert('更新管理员成功');
			} else{
				alert('更新管理员失败');
			}
		});
	}
}