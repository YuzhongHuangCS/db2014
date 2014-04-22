<?php
	$conn = new mysqli('localhost', 'www-data', '', 'db2014');
	
	if($conn->connect_error) {
		die('Database connection failed: ' . $conn->connect_error);
	}

	$conn->query('set character set "utf8"');
	$conn->query('set names "utf8"');

	$sql = 'SELECT `id`, `name`, `politics`, `english`, `math`, `prof` FROM `score`';
	$select = $conn->prepare($sql);
	$select->execute();
	$select->store_result();
	$select->bind_result($id, $name, $score['politics'], $score['english'], $score['math'], $score['prof']);

	function checkScore($course, $expect){
		global $require, $pass, $score;

		if($score[$course] < $expect){
			if(($expect-$score[$course]) == 1){
				$require += 15;
			}
			if(($expect-$score[$course]) == 2){
				$require += 20;
			}
			if(($expect-$score[$course]) == 3){
				$require += 25;
			}
			if(($expect-$score[$course]) > 3){
				$pass = 0;
			}
		}
	}

	$content = '<p>复试学生信息<p><table border=1>';
	$content .= '<tr><th>准考证号</th><th>姓名</th><th>总分</th><th>政治</th><th>英语</th><th>数学</th><th>专业课</th></tr>';

	while($select->fetch()){
		$require = 315;
		$pass = 1;

		checkScore('politics', 60);
		checkScore('english', 50);
		checkScore('math', 80);
		checkScore('prof', 80);

		if(array_sum($score) < $require){
			$pass = 0;
		};

		if($pass){
			$content .= '<tr><td>' . $id . '</td><td>' . $name . '</td><td>' . array_sum($score) . '</td><td>' . $score['politics'] . '</td><td>' . $score['english'] . '</td><td>' . $score['math'] . '</td><td>' . $score['prof'] . '</td></tr>';
		};
	};
	$content .= '</table>';
	echo($content);
?>