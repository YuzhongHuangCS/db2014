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
		<div id="sort">点击表头排序</div>
	</div>
	<table>
		<tr>
			<th ng-click="orderProp = 'bookID'; reverse=!reverse">书号</th>
			<th ng-click="orderProp = 'borrowID'; reverse=!reverse">借书号</th>
			<th ng-click="orderProp = 'title'; reverse=!reverse">书名</th>
			<th ng-click="orderProp = 'author'; reverse=!reverse">作者</th>
			<th ng-click="orderProp = 'categoryName'; reverse=!reverse">分类</th>
			<th ng-click="orderProp = 'press'; reverse=!reverse">出版社</th>
			<th ng-click="orderProp = 'price'; reverse=!reverse">价格</th>
			<th ng-click="orderProp = 'year'; reverse=!reverse">年份</th>
			<th ng-click="orderProp = 'stock'; reverse=!reverse">当前库存</th>
			<th ng-click="orderProp = 'total'; reverse=!reverse">总藏书量</th>
			<th ng-click="orderProp = 'name'; reverse=!reverse">经手人</th>
			<th ng-click="orderProp = 'borrow_date'; reverse=!reverse">借书时间</th>
			<th ng-click="orderProp = 'return_date'; reverse=!reverse">还书时间</th>
			<th>还书</th>
		</tr>
    	<tr ng-repeat="borrow in borrows | filter:query | orderBy:orderProp:reverse">
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