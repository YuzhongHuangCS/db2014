<?php
	require('init.php');
	if(isset($_COOKIE['PHPSESSID'])){
		session_id($_COOKIE['PHPSESSID']);
	}
	session_start();

	$categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);

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

	$sql = 'INSERT INTO `categories` (`categoryID`, `categoryName`) VALUES (NULL, "' . $categoryName . '")';
	$result=$conn->query($sql);
	echo($conn->insert_id);
?>