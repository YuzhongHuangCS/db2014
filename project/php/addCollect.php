<?php
	require('init.php');
	if(isset($_COOKIE['PHPSESSID'])){
		session_id($_COOKIE['PHPSESSID']);
	}
	session_start();

	$categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_SANITIZE_NUMBER_INT);
	$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
	$press = filter_input(INPUT_POST, 'press', FILTER_SANITIZE_STRING);
	$year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);
	$author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);
	$year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);
	$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT);
	
	try{
		if(!isset($_SESSION['adminID'])){
			throw new Exception("You haven't login yet");
		}
		if($_SESSION['privilege'] < 60){
			throw new Exception("You don't have enough privileges");
		}
	}
	catch(Exception $e) {
 		die($e->getMessage());
 	}

 	$sql = 'INSERT INTO `collect` (`collectID`, `categoryID`, `title`, `press`, `year`, `author`, `price`) VALUES (NULL, "' . $categoryID . '", "' . $title . '", "' . $press . '", "' . $year . '", "' . $author . '", "' . $price . '")';
	$result=$conn->query($sql);
	echo($conn->insert_id);
	
?>	