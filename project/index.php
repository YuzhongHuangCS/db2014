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
	<div id="book" class="actionButton" onclick="location.href='book.php'">查询图书信息</div>
	<div id="card" class="actionButton" onclick="location.href='card.php'">查询借书证信息</div>
</div>
<div id="adminRow">
	<div id="adminBook" class="actionButton" onclick="location.href='adminBook.php'">图书管理</div>
	<div id="adminCard" class="actionButton" onclick="location.href='adminCard.php'">借书证管理</div>
	<div id="adminStaff" class="actionButton" onclick="location.href='adminStaff.php'">人员管理</div>
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