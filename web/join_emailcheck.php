<?php
	include 'header.php';
	$email=$_REQUEST["email"];
	include 'mysql_setting.php';
	
	$sql = "SELECT user_num FROM user WHERE email='$email'";
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