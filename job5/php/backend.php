<?php
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$id		= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$name	= filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);
$age	= filter_input(INPUT_GET, 'age', FILTER_SANITIZE_NUMBER_INT);

$con = mysql_connect('localhost','www-data');
if (!$con){
	die(mysql_error());
}
mysql_query("set character set 'utf8'");
mysql_select_db("db2014", $con);

switch ($action) {
	case 'select':
		$sql = 'SELECT * FROM student ORDER BY id';
		$result = mysql_query($sql, $con);
		
		$row = array();
		while($r = mysql_fetch_assoc($result)){
			foreach ($r as $key => $value) {
				$r[$key] = urlencode($value);
			}
			$row[] = $r;
		}
		
		$json = urldecode(json_encode($row));
		header('Content-Type: application/json; charset=utf-8');
		echo($json);
		break;

	case 'insert':
		if(($id == NULL) || ($name == NULL) || ($age == NULL)){
			echo('Parameter incomplete.');
			break;
		}
		$sql = 'INSERT INTO student(id, name, age) VALUES (' . $id . ', ' . $name . ', ' . $age . ')';
		$result = mysql_query($sql, $con);
		
		//use 1 for success, and 2 for fail
		if($result){
			echo('1');
		} else{
			echo('2');
		}
		break;

	case 'update':
		if(($id == NULL) || ($name == NULL) || ($age == NULL)){
			echo('Parameter incomplete.');
			break;
		}
		$sql = 'UPDATE student SET name = ' . $name . ', age = ' . $age . ' WHERE id = ' . $id ;
		$result = mysql_query($sql, $con);
		
		if($result){
			echo('1');
		} else{
			echo('2');
		}
		break;

	case 'delete':
		if($id == NULL){
			echo('Parameter incomplete.');
			break;
		}
		$sql = 'DELETE FROM student WHERE id = ' . $id; 
		$result = mysql_query($sql, $con);
		
		if($result){
			echo('1');
		} else{
			echo('2');
		}
		break;

	default:
		echo('No proper parameter.');
		break;
}
mysql_close($con);
?>