<?php
	include 'header.php';
	$id=$_GET['id'];
	include 'mysql_setting.php';
	$sql = "SELECT user_num FROM user WHERE id='$id'";
	$sql_query = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($sql_query);
	if ($count) {
		echo "
			{ \"check\": \"exist\" }
		";
	} elseif (!$count) {
		echo "
			{ \"check\": \"notyet\" }
		";
	}
	
?>