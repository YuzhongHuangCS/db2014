<?php
	require('init.php');

	$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
	$bookID = filter_input(INPUT_GET, 'bookID', FILTER_SANITIZE_NUMBER_INT);
	$cardID = filter_input(INPUT_GET, 'cardID', FILTER_SANITIZE_NUMBER_INT);
	$borrowID = filter_input(INPUT_GET, 'borrowID', FILTER_SANITIZE_NUMBER_INT);
	$adminID = filter_input(INPUT_GET, 'adminID', FILTER_SANITIZE_NUMBER_INT);
	$categoryID = filter_input(INPUT_GET, 'categoryID', FILTER_SANITIZE_NUMBER_INT);
	$title = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_STRING);
	$author = filter_input(INPUT_GET, 'author', FILTER_SANITIZE_STRING);
	$categoryName = filter_input(INPUT_GET, 'categoryName', FILTER_SANITIZE_STRING);
	$press = filter_input(INPUT_GET, 'press', FILTER_SANITIZE_STRING);
	$year = filter_input(INPUT_GET, 'year', FILTER_SANITIZE_NUMBER_INT);
	$price = filter_input(INPUT_GET, 'price', FILTER_SANITIZE_NUMBER_INT);
	$stock = filter_input(INPUT_GET, 'stock', FILTER_SANITIZE_NUMBER_INT);
	$total = filter_input(INPUT_GET, 'total', FILTER_SANITIZE_NUMBER_INT);
	$loginName = filter_input(INPUT_GET, 'loginName', FILTER_SANITIZE_STRING);
	$password = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_STRING);
	$name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);
	$phone = filter_input(INPUT_GET, 'phone', FILTER_SANITIZE_STRING);
	$privilege = filter_input(INPUT_GET, 'privilege', FILTER_SANITIZE_NUMBER_INT);
	$department = filter_input(INPUT_GET, 'department', FILTER_SANITIZE_STRING);
	$fileName = filter_input(INPUT_GET, 'fileName', FILTER_SANITIZE_STRING);

	function checkPrivilege($expect){
		session_id($_COOKIE['PHPSESSID']);
		session_start();
		if($_SESSION['privilege'] < $expect){
			die('No enough privilege');
		} else{
			return 1;
		}
	};

	switch($action){
		case 'showCategory':
			$sql = 'SELECT categoryID, categoryName FROM categories';
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
			$result->close();
			break;

		case 'showBook':
			$sql = 'SELECT book.bookID, book.title, categories.categoryID, categories.categoryName, book.author, book.press, book.year, book.price, book.stock, book.total FROM book JOIN categories ON book.categoryID = categories.categoryID';
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
			$result->close();
			break;
		
		case 'showCardInfo':
			checkPrivilege(10);

			$sql = 'SELECT cardID, name, department, privilege FROM card WHERE cardID = ' . $cardID;
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
			$result->close();
			break;

		case 'showCard':
			checkPrivilege(60);
			
			$sql = 'SELECT cardID, name, department, privilege FROM card';
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
			$result->close();
			break;

		case 'showAdmin':
			checkPrivilege(100);

			$sql = 'SELECT adminID, loginName, name, phone, privilege FROM admin';
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
			$result->close();
			break;

		case 'showBorrow':
			checkPrivilege(10);

			$sql = 'SELECT book.bookID, borrow.borrowID, book.title, book.author, categories.categoryName, book.press, book.price, book.year, book.stock, book.total, admin.name, borrow.borrow_date, borrow.return_date';
			$sql .= 	' FROM borrow ';
			$sql .= 	' JOIN admin ON borrow.adminID = admin.adminID AND borrow.cardID =' . $cardID;
			$sql .=		' JOIN book ON borrow.bookID = book.bookID';
			$sql .=		' JOIN categories ON book.categoryID = categories.categoryID';

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
			$result->close();
			break;

		case 'borrow':
			checkPrivilege(10);

			$sql = 'INSERT INTO `borrow` (`borrowID`, `bookID`, `cardID`, `adminID`, `borrow_date`, `return_date`) VALUES (NULL, ' . $bookID . ', ' . $cardID . ', ' . $_SESSION['adminID'] .', CURRENT_TIMESTAMP, NULL)';
			$conn->query($sql);
			echo($conn->insert_id);
			break;

		case 'return':
			checkPrivilege(10);

			$sql = 'UPDATE `borrow` SET `return_date` = CURRENT_TIMESTAMP WHERE `borrowID` = ' . $borrowID;
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'addCategory':
			checkPrivilege(60);

			$sql = 'INSERT INTO `categories` (`categoryID`, `categoryName`) VALUES (NULL, "' . $categoryName . '")';
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'updateBook':
			checkPrivilege(60);

			if($bookID){
				$sql = 'UPDATE `book` SET `categoryID` = ' . $categoryID . ', `title` = "' . $title . '" , `press` = "' . $press . '" , `year`=' . $year . ', `author` = "' . $author . '" , `price`= ' . $price . ', `stock`= ' . $stock . ', `total`=' . $total . ' WHERE `book`.`bookID` = ' . $bookID;
			} else{
				$sql = 'INSERT INTO `book` (`bookID`, `categoryID`, `title`, `press`, `year`, `author`, `price`, `stock`, `total`) VALUES (NULL, ' . $categoryID . ', "' . $title. '", "' . $press. '", '. $year . ', "'. $author . '", '. $price . ', ' . $stock . ', '. $total . ')';
			}
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'deleteBook':
			checkPrivilege(60);

			$sql = 'DELETE FROM `book` WHERE `book`.`bookID` = ' . $bookID;
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'updateAdmin':
			checkPrivilege(100);

			if($adminID){
				if($password){
					$md5 = md5($loginName . $adminID . $adminID . $password);
					$sql = 'UPDATE `admin` SET `loginName` = "' . $loginName . '", `password` = "' . $md5 . '", `name` = "' . $name . '" , `phone` = "' . $phone . '" , `privilege`= ' . $privilege . ' WHERE `admin`.`adminID` = ' . $adminID ;
				}else{
					$sql = 'UPDATE `admin` SET `loginName` = "' . $loginName . '", `name` = "' . $name . '" , `phone` = "' . $phone . '" , `privilege`= ' . $privilege . ' WHERE `admin`.`adminID` = ' . $adminID ;
				}
			} else{
				$sql = 'INSERT INTO `admin` (`adminID`, `loginName`, `password`, `name`, `phone`, `privilege`) VALUES (NULL, "' . $loginName . '", "' . $password . '", "' . $name . '", "' . $phone . '", ' . $privilege . ')';
				$conn->query($sql);
				$adminID = $conn->insert_id;
				$md5 = md5($loginName . $adminID . $adminID . $password);
				$sql = 'UPDATE `admin` SET `password` = "' . $md5 . '" WHERE `admin`.`password` = "' . $password . '"';
			}
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'deleteAdmin':
			checkPrivilege(100);

			$sql = 'DELETE FROM `admin` WHERE `admin`.`adminID` = ' . $adminID;
			$conn->query($sql);
			echo($conn->sqlstate);
			break;
		
		case 'updateCard':
			checkPrivilege(60);

			if($cardID){
					$sql = 'UPDATE `card` SET `name` = "' . $name . '", `department` = "' . $department . '" , `privilege`= ' . $privilege . ' WHERE `card`.`cardID` = ' . $cardID ;
			} else{
				$sql = 'INSERT INTO `card` (`cardID`, `name`, `department`, `privilege`) VALUES (NULL, "' . $name . '", "' . $department . '", ' . $privilege . ')';
			}
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'deleteCard':
			checkPrivilege(60);

			$sql = 'DELETE FROM `card` WHERE `card`.`cardID` = ' . $cardID;
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'massAdd':
			checkPrivilege(60);

			$file=fopen('../upload/' . $fileName, 'r')  or die('Unable to open file!');
			$row = array();
			while(!feof($file)) {
				$row[] = explode(', ', fgets($file));
			}
			fclose($file);

			unlink('../upload/' . $fileName);

			$errorCount = 0;
			$conn->query('START TRANSACTION');

			foreach ($row as $key => $value) {
				if($value[0]){
					$sql = 'INSERT INTO `book` (`bookID`, `categoryID`, `title`, `press`, `year`, `author`, `price`, `stock`, `total`) VALUES (NULL, ' . $value[0] . ', "' . $value[1] . '", "' . $value[2] . '", ' . $value[3] . ', "' . $value[4] . '", ' . $value[5] . ', ' . $value[6] . ', ' . $value[7] . ')';
					$conn->query($sql);
					if($conn->error){
						$errorCount++;
					}
				}
			}

			if($errorCount == 0){
				$conn->query('COMMIT');
				echo('success');
			} else{
				$conn->query('ROLLBACK');
				echo('failed');
			}
			break;

		default:
			echo('illegal operation');
			break;
	}
?>