<?php
	include 'header.php';
	include 'mysql_setting.php';
	$count = $_REQUEST["count"];
	$sql1 = "SELECT * FROM photo_battle_type WHERE count=$count";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count1){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		echo $sql_fetch_array1["photo_type"];
	}
?>