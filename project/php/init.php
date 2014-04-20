<?php
	$conn = new mysqli('localhost', 'www-data', '', 'db2014');
	
	if($conn->connect_error) {
		die('Database connection failed: ' . $conn->connect_error);
	}

	$conn->query('set character set "utf8"');
	$conn->query('set names "utf8"');
?>