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
<div id="adminStaff" ng-app ng-controller="adminStaffControl">
	<div id="updateBar">
		<span>编辑管理员信息:</span>
		<form ng-model="newAdmin">
			<input type="text" ng-model="newAdmin.loginName"  id="loginName" placeholder="用户名，注册后不能修改" />
			<input type="password" ng-model="newAdmin.password" placeholder="密码，留空不更改" />
			<input type="text" ng-model="newAdmin.name" placeholder="姓名" />
			<input type="text" ng-model="newAdmin.phone" placeholder="手机号" />
			<input type="text" ng-model="newAdmin.privilege" placeholder="权限" />
			<input type="submit" value="提交" ng-click="updateAdmin()"/>
		</form>
	</div>
	<div id="controlBar">
		<div id="search">搜索: <input placeholder="快速过滤" ng-model="query"></div>
		<div id="sort">点击表头排序</div>
	</div>
	<table>
		<tr>
			<th ng-click="orderProp = 'adminID'; reverse=!reverse">管理员ID</th>
			<th ng-click="orderProp = 'loginName'; reverse=!reverse">登录名</th>
			<th ng-click="orderProp = 'name'; reverse=!reverse">姓名</th>
			<th ng-click="orderProp = 'phone'; reverse=!reverse">手机号</th>
			<th ng-click="orderProp = 'privilege'; reverse=!reverse">权限</th>
			<th>编辑</th>
			<th>删除</th>
		</tr>
    	<tr ng-repeat="admin in admins | filter:query | orderBy:orderProp:reverse">
    		<td>{{admin.adminID}}</td>
			<td>{{admin.loginName}}</td>
			<td>{{admin.name}}</td>	
			<td>{{admin.phone}}</td>
			<td>{{admin.privilege}}</td>
			<td ng-click="editAdmin(admin.adminID)"><button>编辑</button></td>
			<td ng-click="deleteAdmin(admin.adminID)"><button>删除</button></td>
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