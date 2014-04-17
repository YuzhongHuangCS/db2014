<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>图书信息管理系统</title>
	<meta name="description" content="图书, 管理">
	<link rel="stylesheet" href="css/plugin.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body class="font-hei">
<nav>
	<span id="title">图书信息管理系统</span>
	<span id="login">注册 / 登录</span>
</nav>

<div id="actionRow">
	<div id="query" class="actionButton">图书查询</div>
	<div id="borrow" class="actionButton">借书</div>
	<div id="return" class="actionButton">还书</div>
</div>
<div id="loginView">
	<div id="tip">
		管理员登录
	</div>
	<div id="loginArea">
		<p>账号: <input type="text" name="loginName" placeholder="请输入账号"/></p>
		<p>密码: <input type="password" name="password" placeholder="请输入密码"/></p>
		<div id="cancelButton">返回</div>
		<div id="loginButton">登录</div>
	</div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/plugin.js"></script>
<script src="js/script.js"></script>
</body>
</html>