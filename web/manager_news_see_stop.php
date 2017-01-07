<?php
	include 'header.php';
	include 'mysql_setting.php';
	$count = $_REQUEST["count"];
	$sql1 = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='manager_news' AND count2=$count";
	mysqli_query($conn, $sql1);
	
?>