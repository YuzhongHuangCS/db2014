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
<div id="card" ng-app ng-controller="cardControl">
	<div id="cardInfo">
		<div ng-model="cardInfo">
			<span>卡号: {{cardInfo[0].cardID}} 姓名: {{cardInfo[0].name}} 院系: {{cardInfo[0].department}} 权限: {{cardInfo[0].privilege}}</span>
		</div>
	</div>
	<div id="controlBar">
		<div id="search">Search: <input ng-model="query"></div>
		<div id="sort">
			Sort by:
			<select ng-model="orderProp">
    			<option value="bookID">bookID</option>
    			<option value="borrowID">borrowID</option>
				<option value="title">title</option>
				<option value="author">author</option>
				<option value="categoryName">categoryName</option>
				<option value="press">press</option>
				<option value="price">price</option>
				<option value="year">year</option>
				<option value="stock">stock</option>
				<option value="total">total</option>
				<option value="name">name</option>
				<option value="borrow_date">borrow_date</option>
				<option value="return_date">return_date</option>
			</select>
		</div>
	</div>
	<table>
		<tr>
			<th>书号</th>
			<th>借书号</th>
			<th>书名</th>
			<th>作者</th>
			<th>类别</th>
			<th>出版社</th>
			<th>价格</th>
			<th>年份</th>
			<th>当前库存</th>
			<th>总藏书量</th>
			<th>经手人</th>
			<th>借书时间</th>
			<th>还书时间</th>
			<th>还书</th>
		</tr>
    	<tr ng-repeat="borrow in borrows | filter:query | orderBy:orderProp">
    		<td>{{borrow.bookID}}</td>
    		<td>{{borrow.borrowID}}</td>
			<td>{{borrow.title}}</td>
			<td>{{borrow.author}}</td>
			<td>{{borrow.categoryName}}</td>
			<td>{{borrow.press}}</td>
			<td>{{borrow.price}}</td>
			<td>{{borrow.year}}</td>
			<td>{{borrow.stock}}</td>
			<td>{{borrow.total}}</td>
			<td>{{borrow.name}}</td>
			<td>{{borrow.borrow_date}}</td>
			<td>{{borrow.return_date}}</td>
			<td ng-click="return(borrow.borrowID)">还书</td>
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