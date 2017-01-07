<?php
	include 'header.php';
	include 'mysql_setting.php';
	if($user_num==0){exit;}
	$sql = "SELECT * FROM idcard_photo WHERE user_num=$user_num";
	$sql_query = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($sql_query);
	$sql_fetch_array = mysqli_fetch_array($sql_query);
	$remove_file = $sql_fetch_array[idcard_photo_path];
	if(file_exists($remove_file)){//파일이 존재할 경우
		unlink($remove_file);//파일 제거
	}
	$sql1 = "DELETE FROM idcard_photo WHERE user_num=$user_num";
	$sql_query1 = mysqli_query($conn, $sql1);
	
?>