<?php
	include 'header.php';
	include 'mysql_setting.php';
	$id = $_REQUEST["id"];
	$sql1 = "SELECT * FROM user WHERE id='$id'";
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$sql2 = "DELETE FROM email_certify WHERE user_num=$sql_fetch_array1[user_num]";
	mysqli_query($conn, $sql2);
	$sql3 = "DELETE FROM user WHERE id='$id'";
	mysqli_query($conn, $sql3);
?>