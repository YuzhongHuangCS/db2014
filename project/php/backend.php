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
			session_id($_COOKIE['PHPSESSID']);
			session_start();
			$sql = 'INSERT INTO `borrow` (`borrowID`, `bookID`, `cardID`, `adminID`, `borrow_date`, `return_date`) VALUES (NULL, ' . $bookID . ', ' . $cardID . ', ' . $_SESSION['adminID'] .', CURRENT_TIMESTAMP, NULL)';
			$conn->query($sql);
			echo($conn->insert_id);
			break;

		case 'return':
			$sql = 'UPDATE `borrow` SET `return_date` = CURRENT_TIMESTAMP WHERE `borrowID` = ' . $borrowID;
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'addCategory':
			$sql = 'INSERT INTO `library`.`categories` (`categoryID`, `categoryName`) VALUES (NULL, "' . $categoryName . '")';
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'updateBook':
			if($bookID){
				$sql = 'UPDATE `library`.`book` SET `categoryID` = ' . $categoryID . ', `title` = "' . $title . '" , `press` = "' . $press . '" , `year`=' . $year . ', `author` = "' . $author . '" , `price`= ' . $price . ', `stock`= ' . $stock . ', `total`=' . $total . ' WHERE `book`.`bookID` = ' . $bookID;
			} else{
				$sql = 'INSERT INTO `library`.`book` (`bookID`, `categoryID`, `title`, `press`, `year`, `author`, `price`, `stock`, `total`) VALUES (NULL, ' . $categoryID . ', "' . $title. '", "' . $press. '", '. $year . ', "'. $author . '", '. $price . ', ' . $stock . ', '. $total . ')';
			}
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'deleteBook':
			$sql = 'DELETE FROM `library`.`book` WHERE `book`.`bookID` = ' . $bookID;
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'updateAdmin':
			if($adminID){
				if($password){
					$md5 = md5($loginName . $adminID . $adminID . $password);
					$sql = 'UPDATE `library`.`admin` SET `loginName` = "' . $loginName . '", `password` = "' . $md5 . '", `name` = "' . $name . '" , `phone` = "' . $phone . '" , `privilege`= ' . $privilege . ' WHERE `admin`.`adminID` = ' . $adminID ;
				}else{
					$sql = 'UPDATE `library`.`admin` SET `loginName` = "' . $loginName . '", `name` = "' . $name . '" , `phone` = "' . $phone . '" , `privilege`= ' . $privilege . ' WHERE `admin`.`adminID` = ' . $adminID ;
				}
			} else{
				$sql = 'INSERT INTO `library`.`admin` (`adminID`, `loginName`, `password`, `name`, `phone`, `privilege`) VALUES (NULL, "' . $loginName . '", "' . $password . '", "' . $name . '", "' . $phone . '", ' . $privilege . ')';
				$conn->query($sql);
				$adminID = $conn->insert_id;
				$md5 = md5($loginName . $adminID . $adminID . $password);
				$sql = 'UPDATE `library`.`admin` SET `password` = "' . $md5 . '" WHERE `admin`.`password` = "' . $password . '"';
			}
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'deleteAdmin':
			$sql = 'DELETE FROM `library`.`admin` WHERE `admin`.`adminID` = ' . $adminID;
			$conn->query($sql);
			echo($conn->sqlstate);
			break;
		
		case 'updateCard':
			if($cardID){
					$sql = 'UPDATE `library`.`card` SET `name` = "' . $name . '", `department` = "' . $department . '" , `privilege`= ' . $privilege . ' WHERE `card`.`cardID` = ' . $cardID ;
			} else{
				$sql = 'INSERT INTO `library`.`card` (`cardID`, `name`, `department`, `privilege`) VALUES (NULL, "' . $name . '", "' . $department . '", ' . $privilege . ')';
			}
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		case 'deleteCard':
			$sql = 'DELETE FROM `library`.`card` WHERE `card`.`cardID` = ' . $cardID;
			$conn->query($sql);
			echo($conn->sqlstate);
			break;

		default:
			echo('illegal operation');
			break;
	}
?>