<?php
	include 'mysql_setting.php';
	$find_id_email = $_REQUEST["find_id_email"];
	$sql1 = "SELECT * FROM user WHERE email = '$find_id_email'";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count1){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		echo $sql_fetch_array1["id"];
	} else if(!$count1){
		echo "thereisnoid";
	}
	
?>