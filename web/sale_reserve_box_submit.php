<?php
	include 'header.php';
	include 'mysql_setting.php';
	if($user_num==0){exit;}
	$count = $_REQUEST["count"];
	$writetime = date("Y-m-d, H:i:s");
	$sql1 = "SELECT * FROM sale_reserve_box WHERE count=$count AND user_num=$user_num";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count1){echo "already";}//이미 장바구니에 넣었을경우
	else if(!$count1){//장바구니에 없을경우
		$sql2 = "INSERT INTO sale_reserve_box (count, user_num, writetime) VALUES ($count, $user_num, '$writetime')";
		mysqli_query($conn, $sql2);
		echo "done";
	}
?>