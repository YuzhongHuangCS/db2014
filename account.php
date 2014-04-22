<html>
	<style>
	input{
		font-size: 1.2rem;
	}
	</style>
<body>
	<form action="account.php" method="post">
		<input type="text" name="x" placeholder="临界借款值x" /><br />
		<input type="text" name="y"placeholder="增加的存款账户金额y" /><br />
		<input type="submit" value="提交" /> 
	</form>
</body>
</html>
<?php
	$conn = new mysqli('localhost', 'www-data', '', 'db2014');
	
	if($conn->connect_error) {
		die('Database connection failed: ' . $conn->connect_error);
	}

	$conn->query('set character set "utf8"');
	$conn->query('set names "utf8"');

	$x = filter_input(INPUT_POST, 'x', FILTER_SANITIZE_NUMBER_INT);
	$y = filter_input(INPUT_POST, 'y', FILTER_SANITIZE_NUMBER_INT);

	if($x){
		$sql = 'SELECT `id`, `name`, `amount` FROM `loan` WHERE `amount` > ?';
		$select = $conn->prepare($sql);
		$select->bind_param('d', $x);
		$select->execute();
		$select->store_result();
		$select->bind_result($id, $name, $amount);

		$sql = 'INSERT INTO `depositor`(`id`, `name`, `amount`) VALUES (?, ?, ?)';
		$insert = $conn->prepare($sql);
		$insert->bind_param('isd', $id, $name, $y);

		$content = '<p>借款账号</p><table border=1>';
		$content .= '<tr><th>账号</th><th>姓名</th><th>余额</th></tr>';
		while($select->fetch()){
			if($y){
				$insert->execute();
			}
			$content .= '<tr><td>' . $id . '</td><td>' . $name . '</td><td>' . $amount . '</td></tr>';
		};
		$content .= '</table>';
		echo($content);
		echo('<br />');

		if($y){
			$sql = 'SELECT `id`, `name`, `amount` FROM `depositor`';
			$select = $conn->prepare($sql);
			$select->execute();
			$select->store_result();
			$select->bind_result($id, $name, $amount);

			$content = '<p>存款账号</p><table border=1>';
			$content .= '<tr><th>账号</th><th>姓名</th><th>余额</th></tr>';
			while($select->fetch()){
				$content .= '<tr><td>' . $id . '</td><td>' . $name . '</td><td>' . $amount . '</td></tr>';
			};
			$content .= '</table>';
			echo($content);
		}
	}
?>