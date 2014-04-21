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
<div id="adminBook" ng-app ng-controller="adminBookControl">
	<div id="updateBar">
		<div id="newCategory">
			<span>添加新分类:</span> 
			<form>
				<input type="text" ng-model="newCategory" placeholder="新分类" />
				<input type="submit" value="提交" ng-click="addCategory()"/>
			</form>
		</div>

		<div id="editArea">
			<span>添加/编辑图书：</span>
			<form ng-model="newBook">
				<input type="text" ng-model="newBook.bookID" placeholder="书号, 添加后不能修改" />
				<input type="text" ng-model="newBook.title" placeholder="书名" />
				<span>分类：</span>
				<select ng-model="newBook.categoryID">
					<option ng-repeat="category in categories" value={{category.categoryID}}>{{category.categoryName}}</option>
				</select>
				<input type="text" ng-model="newBook.author" placeholder="作者" />
				<input type="text" ng-model="newBook.press" placeholder="出版社" />
				<input type="text" ng-model="newBook.year" placeholder="年份" />
				<input type="text" ng-model="newBook.price" placeholder="价格" />
				<input type="text" ng-model="newBook.stock" placeholder="库存" />
				<input type="text" ng-model="newBook.total" placeholder="总数" />
				<input type="submit" id="action" value="添加" ng-click="addBook()" />
				<input type="submit" id="action" value="编辑" ng-click="updateBook()" />
			</form>
		</div>

		<div id="massAdd">
			<span>批量添加:</span>
			<form action="fileUpload.php" method="post" enctype="multipart/form-data">
				<input type="file" name="file" id="file"/> 
				<input type="submit" name="submit" value="上传" />
			</form>
		</div>
	</div>
	<div id="controlBar">
		<div id="search">搜索: <input placeholder="快速过滤" ng-model="query"></div>
		<div id="sort">点击表头排序</div>
	</div>
	<table>
		<tr>
			<th ng-click="orderProp = 'bookID'; reverse=!reverse">书号</th>
			<th ng-click="orderProp = 'title'; reverse=!reverse">标题</th>
			<th ng-click="orderProp = 'categoryName'; reverse=!reverse">类别</th>
			<th ng-click="orderProp = 'author'; reverse=!reverse">作者</th>
			<th ng-click="orderProp = 'press'; reverse=!reverse">出版社</th>
			<th ng-click="orderProp = 'year'; reverse=!reverse">年份</th>
			<th ng-click="orderProp = 'price'; reverse=!reverse">价格</th>
			<th ng-click="orderProp = 'stock'; reverse=!reverse">当前库存</th>
			<th ng-click="orderProp = 'total'; reverse=!reverse">总藏书量</th>
			<th>编辑</th>
			<th>删除</th>
		</tr>
    	<tr ng-repeat="book in books | filter:query | orderBy:orderProp:reverse">
    		<td>{{book.bookID}}</td>
			<td>{{book.title}}</td>
			<td>{{book.categoryName}}</td>	
			<td>{{book.author}}</td>
			<td>{{book.press}}</td>
			<td>{{book.year}}</td>
			<td>{{book.price}}</td>
			<td>{{book.stock}}</td>
			<td>{{book.total}}</td>
			<td ng-click="editBook(book.bookID)"><button>编辑</button></td>
			<td ng-click="deleteBook(book.bookID)"><button>删除</button></td>
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