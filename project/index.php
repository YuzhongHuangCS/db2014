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
<?php
	require('php/nav.php');
?>

<div id="actionRow">
	<div id="query" class="actionButton" onclick="location.href='query.php'">图书查询</div>
	<div id="borrow" class="actionButton">借书</div>
	<div id="return" class="actionButton">还书</div>
</div>
<div id="adminRow">
	<div id="import" class="actionButton">图书入库</div>
	<div id="admin" class="actionButton">人员管理</div>
</div>

<?php
	require('php/loginView.php');
	require('php/filter.php');
?>

<script src="js/jquery.min.js"></script>
<script src="js/plugin.js"></script>
<script src="js/script.js"></script>
</body>
</html>