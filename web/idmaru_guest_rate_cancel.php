<?php
	include 'header.php';
	include 'mysql_setting.php';
	$count = $_REQUEST["count"];
	$updown = $_REQUEST["updown"];
	$sql1 = "SELECT * FROM idmaru_guest_updown WHERE count=$count AND user_num=$user_num";//투표 유무 체크
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	echo $sql_fetch_array1["updown"];
	$sql2 = "DELETE FROM idmaru_guest_updown WHERE count=$count AND user_num=$user_num";
	mysqli_query($conn, $sql2);
	
?>