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
		<div id="sort">
			排序：
			<select ng-model="orderProp">
				<option value="bookID">书号</option>
  				<option value="title">书名</option>
  				<option value="categoryName">分类</option>
  				<option value="author">作者</option>
  				<option value="press">出版社</option>
  				<option value="year">年份</option>
  				<option value="year">价格</option>
  				<option value="stock">库存</option>
  				<option value="total">总量</option>
			</select>
		</div>
	</div>
	<table>
		<tr>
			<th>书号</th>
			<th>书名</th>
			<th>类别</th>
			<th>作者</th>
			<th>出版社</th>
			<th>年份</th>
			<th>价格</th>
			<th>当前库存</th>
			<th>总藏书量</th>
			<th>借书</th>
		</tr>
    	<tr ng-repeat="book in books | filter:query | orderBy:orderProp">
    		<td>{{book.bookID}}</td>
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