<?php

	$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
	$categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_SANITIZE_NUMBER_INT);
	$categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);
	$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
	$press = filter_input(INPUT_POST, 'press', FILTER_SANITIZE_STRING);
	$year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);
	$author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);
	$year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT);
	$price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT);
	$loginName = filter_input(INPUT_POST, 'loginName', FILTER_SANITIZE_STRING);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

	switch($action){
		case 'login': 
	}