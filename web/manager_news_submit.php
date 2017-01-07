<?php
	include 'header.php';
	include 'mysql_setting.php';
	$title = $_REQUEST["mywrite_title"];
	$content = $_REQUEST["mywrite_content"];
	$writetime = date("Y-m-d, H:i:s");
	$sql1 = "SELECT * FROM user WHERE user_stop='0'";//회원 user_num
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$sql3 = "INSERT INTO counter (name, value) VALUES('manager_news', LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE value = LAST_INSERT_ID(value+1)";
	mysqli_query($conn, $sql3);
	$sql4 = "INSERT INTO manager_news (count, title, content, writetime) VALUES (LAST_INSERT_ID(), '$title', '$content', '$writetime')";
	mysqli_query($conn, $sql4);
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql5 = "SELECT * FROM manager_news WHERE count=LAST_INSERT_ID()";
		$sql_query5 = mysqli_query($conn, $sql5);
		$sql_fetch_array5 = mysqli_fetch_array($sql_query5);
		$sql2 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array1[user_num], 'manager_news', 1, LAST_INSERT_ID(), '$title', '$writetime')";
		mysqli_query($conn, $sql2);
	}
	echo '<script>alert("공지가 전송되었습니다"); location.href = "manager_news_send.php";</script>';
	
?>