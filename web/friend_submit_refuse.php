<?php
	include 'header.php';
	include 'mysql_setting.php';
	$friend_num = $_REQUEST["friend_num"];
	$writetime = date("Y-m-d, H:i:s");
	$sql3 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($friend_num, 'friend_submit_refuse', $user_num, 0, '( $user_name )님이 친구 신청을 거절하셨습니다.', '$writetime')";//친구 거절 사실을 신청인에게 알리기
	mysqli_query($conn, $sql3);
	$sql4 = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='friend_submit' AND count=$friend_num";//내 home_alarm 지우기
	mysqli_query($conn, $sql4);
?>