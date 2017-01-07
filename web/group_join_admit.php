<?php
	include 'header.php';
	include 'mysql_setting.php';
	$group_founder_num = $_REQUEST["group_founder_num"];
	$count_group = $_REQUEST["count_group"];
	$group_name = $_REQUEST["group_name"];
	$writetime = date("Y-m-d, H:i:s");
	$description = '( '.$user_name.' )님이 모임( '.$group_name.' )에 가입 신청 하셨습니다.';
	$sql1 = "INSERT INTO club_group_admit (user_num, count_group, user_num_admit) VALUES ($group_founder_num, $count_group, $user_num)";//테이블에 신청정보 입력
	mysqli_query($conn, $sql1);
	$sql2 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($group_founder_num, 'club_group_admit', $count_group, $user_num, '$description', '$writetime')";
	mysqli_query($conn, $sql2);
	
?>