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
<div id="adminCard" ng-app ng-controller="adminCardControl">
	<div id="updateBar">
		<span>编辑借书证信息:</span>
		<form ng-model="newCard">
			<input type="text" ng-model="newCard.cardID" placeholder="卡号, 添加后不能修改" />
			<input type="text" ng-model="newCard.name" placeholder="姓名" />
			<input type="text" ng-model="newCard.department" placeholder="院系" />
			<input type="text" ng-model="newCard.privilege" placeholder="权限" />
			<input type="submit" value="添加" ng-click="addCard()"/>
			<input type="submit" value="编辑" ng-click="updateCard()"/>
		</form>
	</div>
	<div id="controlBar">
		<div id="search">搜索: <input placeholder="快速过滤" ng-model="query"></div>
		<div id="sort">点击表头排序</div>
	</div>
	<table>
		<tr>
			<th ng-click="orderProp = 'cardID'; reverse=!reverse">卡号</th>
			<th ng-click="orderProp = 'name'; reverse=!reverse">姓名</th>
			<th ng-click="orderProp = 'borrowCount'; reverse=!reverse">已借数量</th>
			<th ng-click="orderProp = 'returnCount'; reverse=!reverse">已还数量</th>
			<th ng-click="orderProp = 'department'; reverse=!reverse">院系</th>
			<th ng-click="orderProp = 'privilege'; reverse=!reverse">权限</th>
			<th>编辑</th>
			<th>删除</th>
		</tr>
    	<tr ng-repeat="card in cards | filter:query | orderBy:orderProp:reverse">
    		<td>{{card.cardID}}</td>
			<td>{{card.name}}</td>
			<td>{{card.borrowCount}}</td>
			<td>{{card.returnCount}}</td>
			<td>{{card.department}}</td>
			<td>{{card.privilege}}</td>
			<td ng-click="editCard(card.cardID)"><button>编辑</button></td>
			<td ng-click="deleteCard(card.cardID)"><button>删除</button></td>
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