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
		<form ng-model="newCard">
			<input type="text" ng-model="newCard.name" placeholder="姓名" />
			<input type="text" ng-model="newCard.department" placeholder="院系" />
			<input type="text" ng-model="newCard.privilege" placeholder="权限" />
			<input type="submit" value="提交" ng-click="updateCard()"/>
		</form>
	</div>
	<div id="controlBar">
		<div id="search">Search: <input ng-model="query"></div>
		<div id="sort">
			Sort by:
			<select ng-model="orderProp">
				<option value="cardID">cardID</option>
  				<option value="name">name</option>
  				<option value="phone">department</option>
  				<option value="privilege">privilege</option>
			</select>
		</div>
	</div>
	<table>
		<tr>
			<th>cardID</th>
			<th>name</th>
			<th>department</th>
			<th>privilege</th>
			<th>编辑</th>
			<th>删除</th>
		</tr>
    	<tr ng-repeat="card in cards | filter:query | orderBy:orderProp">
    		<td>{{card.cardID}}</td>
			<td>{{card.name}}</td>	
			<td>{{card.department}}</td>
			<td>{{card.privilege}}</td>
			<td ng-click="editCard(card.cardID)">编辑</td>
			<td ng-click="deleteCard(card.cardID)">删除</td>
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