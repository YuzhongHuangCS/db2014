<?php
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$id		= filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$name	= filter_input(INPUT_GET, 'name', FILTER_SANITIZE_STRING);
$age	= filter_input(INPUT_GET, 'age', FILTER_SANITIZE_NUMBER_INT);

require('init.php');

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
			echo('输入不完整');
			break;
		}
		$sql = 'INSERT INTO student(id, name, age) VALUES (' . $id . ', "' . $name . '", ' . $age . ')';
		$result = mysql_query($sql, $con);
		
		if($result){
			echo('保存成功');
		} else{
			echo('保存失败，请检查输入');
		}
		break;

	case 'update':
		if(($id == NULL) || ($name == NULL) || ($age == NULL)){
			echo('输入不完整');
			break;
		}
		$sql = 'UPDATE student SET name = "' . $name . '", age = ' . $age . ' WHERE id = ' . $id ;
		$result = mysql_query($sql, $con);
		
		if($result){
			echo('保存成功');
		} else{
			echo('保存失败，请检查输入');
		}
		break;

	case 'delete':
		if($id == NULL){
			echo('输入不完整');
			break;
		}
		$sql = 'DELETE FROM student WHERE id = ' . $id; 
		$result = mysql_query($sql, $con);
		
		if($result){
			echo('删除成功');
		} else{
			echo('删除失败，请检查输入');
		}
		break;

	default:
		echo('非法操作');
		break;
}
mysql_close($con);
?>