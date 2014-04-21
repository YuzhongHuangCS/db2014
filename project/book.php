<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>图书信息管理系统</title>
	<meta name="description" content="图书, 管理">
	<link rel="stylesheet" href="css/plugin.css">
	<link rel="stylesheet" href="css/style.css">
	<script src="js/angular.min.js"></script>
</head>
<body class="font-hei">
<?php
	require('php/nav.php');
?>
<div id="book" ng-app ng-controller="bookControl">
	<div id="controlBar">
		<div id="search">搜索：<input ng-model="query" placeholder="快速过滤"></div>
		<div id="sort">点击表头排序</div>
	</div>
	<table>
		<tr>
			<th ng-click="orderProp = 'bookID'; reverse=!reverse">书号</th>
			<th ng-click="orderProp = 'title'; reverse=!reverse">书名<span></span></th>
			<th ng-click="orderProp = 'categoryName'; reverse=!reverse">类别</th>
			<th ng-click="orderProp = 'author'; reverse=!reverse">作者</th>
			<th ng-click="orderProp = 'press'; reverse=!reverse">出版社</th>
			<th ng-click="orderProp = 'year'; reverse=!reverse">年份</th>
			<th ng-click="orderProp = 'price'; reverse=!reverse">价格</th>
			<th ng-click="orderProp = 'stock'; reverse=!reverse">当前库存</th>
			<th ng-click="orderProp = 'total'; reverse=!reverse">总藏书量</th>
			<th>借书</th>
		</tr>
    	<tr ng-repeat="book in books | filter:query | orderBy:orderProp:reverse">
    		<td>{{book.bookID | number}}</td>
			<td>{{book.title}}</td>
			<td>{{book.categoryName}}</td>	
			<td>{{book.author}}</td>
			<td>{{book.press}}</td>
			<td>{{book.year}}</td>
			<td>{{book.price}}</td>
			<td>{{book.stock}}</td>
			<td>{{book.total}}</td>
			<td ng-click="borrow(book.bookID)"><button ng-if="book.stock">借书</button></td>
		</tr>
	</table>
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