<?php
	require('init.php');
	
	$loginName = filter_input(INPUT_POST, 'loginName', FILTER_SANITIZE_STRING);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

	$sql = 'SELECT * FROM `admin` WHERE `loginName` = "' . $loginName . '"';

	$result = $conn->query($sql);
	$row = $result->fetch_object();
	$result->close();

	if($row){
		if($row->password === md5($loginName . $row->adminID . $row->adminID . $password)){
			session_start();
			session_regenerate_id();
			$_SESSION['adminID'] = $row->adminID;
			$_SESSION['privilege'] = $row->privilege;
			setrawcookie('name', $row->name, 0, '/');
			setcookie('privilege', $row->privilege, 0, '/');
		} else{
			setcookie('name', '', time()-3600, '/');
			setcookie('privilege', '', time()-3600, '/');
		}
	} else{
		setcookie('name', '', time()-3600, '/');
		setcookie('privilege', '', time()-3600, '/');
	}
?>