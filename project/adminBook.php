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
				<span>分类：</span>
				<select ng-model="newBook.categoryID">
					<option ng-repeat="category in categories" value={{category.categoryID}}>{{category.categoryName}}</option>
				</select>
				<input type="text" ng-model="newBook.title" placeholder="书名" />
				<input type="text" ng-model="newBook.author" placeholder="作者" />
				<input type="text" ng-model="newBook.press" placeholder="出版社" />
				<input type="text" ng-model="newBook.year" placeholder="年份" />
				<input type="text" ng-model="newBook.price" placeholder="价格" />
				<input type="text" ng-model="newBook.stock" placeholder="库存" />
				<input type="text" ng-model="newBook.total" placeholder="总数" />
				<input type="submit" value="提交" ng-click="updateBook()"/>
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
		<div id="sort">
			排序:
			<select ng-model="orderProp">
				<option value="bookID">书号</option>
  				<option value="title">标题</option>
  				<option value="categoryName">分类</option>
  				<option value="author">作者</option>
  				<option value="press">出版社</option>
  				<option value="year">年丰</option>
  				<option value="price">价格</option>
  				<option value="stock">库存</option>
  				<option value="total">总数</option>
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
			<th>编辑</th>
			<th>删除</th>
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