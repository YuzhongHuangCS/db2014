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
<body class="font-hei" id="fileUpload">
<?php
	require('php/nav.php');
?>
<?php
	if ($_FILES['file']['type'] != 'text/plain'){
		die('<script>alert("Invalid file type, only *.txt are allowed");history.back();</script>');
	}
	if ($_FILES['file']['size'] > 200000){
		die('<script>alert("Invalid file, max size 200000");history.back();</script>');
	}
	if ($_FILES["file"]["error"] > 0){
		die("Error: " . $_FILES["file"]["error"] . "<br />");
	}

	session_id($_COOKIE['PHPSESSID']);
	session_start();
	if($_SESSION['privilege'] < 60){
		die('No enough privilege');
	};

	$file=fopen($_FILES["file"]["tmp_name"], 'r');
	$row = array();
	
	while(!feof($file)) {
		$row[] = explode(', ', fgets($file));
	}
	fclose($file);
	
    move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
	
	$content = '<p id="tip">将要批量入库的书籍信息</p>';
	$content .= '<table>';
	$content .= '<tr><th>书号</th><th>标题</th><th>分类</th><th>出版社</th><th>年份</th><th>作者</th><th>价格</th><th>库存</th><th>总量</th></tr>';
	foreach ($row as $key => $value) {
		if($value[0]){
			$content .= '<tr>' . '<td>' . $value[0] . '</td><td>' . $value[1] .'</td><td>' . $value[2] .'</td><td>' . $value[3]. '</td><td>' . $value[4].  '</td><td>' . $value[5].  '</td><td>' . $value[6] . '</td><td>' . $value[7] . '</td><td>' . $value[8] . '</td></tr>' ;
		}
	}

	$content .='</table>';
	echo ($content);
	
	$content = '<div id="confirmBar">';
	$content .=		'<button onclick=location.href="index.php">返回</button>';
	$content .=		'<button onclick=confirmMassAdd("' . $_FILES["file"]["name"] . '")>确认入库</button>';
	$content .= '</div>';
	echo ($content);

	require('php/loginView.php');
	require('php/filter.php');
?>

<script src="js/jquery.min.js"></script>
<script src="js/plugin.js"></script>
<script src="js/script.js"></script>
</body>
</html>