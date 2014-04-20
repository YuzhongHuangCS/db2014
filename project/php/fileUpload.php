<?php
	if ($_FILES['file']['type'] != 'text/plain'){
		die('Invalid file type, only *.txt are allowed');
	}
	if ($_FILES['file']['size'] > 200000){
		die('Invalid file, max size 200000');
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
	
	require('init.php');

	$content = '<p>已入库的书籍</p>';
	$content .= '<table border=1>';
	$content .= '<tr><th>类别代号</th><th>标题</th><th>出版社</th><th>年份</th><th>作者</th><th>价格</th><th>库存</th><th>总量</th></tr>';
	foreach ($row as $key => $value) {
		if($value[0]){
			$sql = 'INSERT INTO `book` (`bookID`, `categoryID`, `title`, `press`, `year`, `author`, `price`, `stock`, `total`) VALUES (NULL, ' . $value[0] . ', "' . $value[1] . '", "' . $value[2] . '", ' . $value[3] . ', "' . $value[4] . '", ' . $value[5] . ', ' . $value[6] . ', ' . $value[7] . ')';
			$conn->query($sql);
			if($conn->sqlstate == 0){
				$content .= '<tr>' . '<td>' . $value[0] . '</td><td>' . $value[1] .'</td><td>' . $value[2]. '</td><td>' . $value[3].  '</td><td>' . $value[4].  '</td><td>' . $value[5] . '</td><td>' . $value[6] . '</td><td>' . $value[7] . '</td></tr>' ;
			} else{
				echo($conn->error);
			}
		}
	}

	$content .='</table>';
	echo ($content);
?>
<button onclick="localtion.href='index.php'">返回</button>