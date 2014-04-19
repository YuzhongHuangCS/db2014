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
	<div id="cardInfo" ng-model="cardInfo">
		<ul>
			<li>卡号: {{cardInfo[0].cardID}}</li>
			<li>姓名: {{cardInfo[0].name}}</li>
			<li>院系: {{cardInfo[0].department}}</li>
			<li>权限: {{cardInfo[0].privilege}}</li>
		</ul>
	</div>
	<div id="controlBar">
		<div id="search">搜索: <input ng-model="query" placeholder="快速过滤"></div>
		<div id="sort">
			排序：
			<select ng-model="orderProp">
    			<option value="bookID">书号</option>
    			<option value="borrowID">借书号</option>
				<option value="title">书名</option>
				<option value="author">作者</option>
				<option value="categoryName">分类</option>
				<option value="press">出版社</option>
				<option value="price">价格</option>
				<option value="year">年份</option>
				<option value="stock">库存</option>
				<option value="total">总量</option>
				<option value="name">经手人</option>
				<option value="borrow_date">借书日期</option>
				<option value="return_date">还书日期</option>
			</select>
		</div>
	</div>
	<table>
		<tr>
			<th>书号</th>
			<th>借书号</th>
			<th>书名</th>
			<th>作者</th>
			<th>分类</th>
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
			<td ng-click="return(borrow.borrowID)"><button ng-if="!borrow.return_date">还书</button></td>
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