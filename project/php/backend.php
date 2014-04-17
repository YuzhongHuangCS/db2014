<?php
	require('init.php');

	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

	switch($action){
		case 'selectAll':
			$sql = 'SELECT book.bookID, book.title, categories.categoryName, book.author, book.press, book.year, book.price, book.stock, book.total FROM book JOIN categories ON book.categoryID = categories.categoryID';
			$result = $conn->query($sql);
			$row = array();
			while($r = $result->fetch_assoc()){
				foreach ($r as $key => $value) {
					$r[$key] = urlencode($value);
				}
				$row[] = $r;
			}
			$json = urldecode(json_encode($row));
			header('Content-Type: application/json; charset=utf-8');
			echo($json);
			break;

		default:
			echo('illegal operation');
			break;
	}
?>