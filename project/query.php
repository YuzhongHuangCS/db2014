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
<div id="content" ng-app ng-controller="BookListCtrl">
	<div id="controlBar">
		<div id="search">Search: <input ng-model="query"></div>
		<div id="sort">
			Sort by:
			<select ng-model="orderProp">
				<option value="bookID">bookID</option>
  				<option value="title">title</option>
  				<option value="categoryName">category</option>
  				<option value="author">author</option>
  				<option value="press">press</option>
  				<option value="year">year</option>
  				<option value="year">price</option>
  				<option value="stock">stock</option>
  				<option value="total">total</option>
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