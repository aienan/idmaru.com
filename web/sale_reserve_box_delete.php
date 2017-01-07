<?php
	include 'header.php';
	include 'mysql_setting.php';
	if($user_num==0){exit;}
	$count = $_REQUEST["count"];
	$sql1 = "DELETE FROM sale_reserve_box WHERE count=$count AND user_num=$user_num";
	mysqli_query($conn, $sql1);
?>