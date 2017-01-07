<?php
	include 'header.php';
	include 'mysql_setting.php';
	$friend_num = $_REQUEST["friend_num"];
	$writetime = date("Y-m-d, H:i:s");
	$sql1 = "INSERT INTO friend (user_num, friend_num) VALUES ($user_num, $friend_num)";
	mysqli_query($conn, $sql1);//friend 테이블에 친구 등록하기
	$sql2 = "INSERT INTO friend (user_num, friend_num) VALUES ($friend_num, $user_num)";
	mysqli_query($conn, $sql2);//friend 테이블에 친구 2명 다 등록하기
	$sql3 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($friend_num, 'friend_submit_accept', $user_num, 0, '<a href=\"home_friend.php\">( $user_name )님이 친구로 등록되었습니다.</a>', '$writetime')";//친구 등록 사실을 신청인에게 알리기
	mysqli_query($conn, $sql3);
	$sql4 = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='friend_submit' AND count=$friend_num";//내 home_alarm 지우기
	mysqli_query($conn, $sql4);
	$_SESSION["friend_list"] .= $friend_num.";";
?>