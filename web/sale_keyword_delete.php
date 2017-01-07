<?php
	include 'header.php';
	include 'mysql_setting.php';
	$keyword = $_REQUEST["keyword"];
	$sql1 = "DELETE FROM sale_keyword WHERE user_num = $user_num AND keyword = '$keyword'";
	$sql_query1 = mysqli_query($conn, $sql1);
	
?>