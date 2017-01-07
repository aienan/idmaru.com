<?php
	include 'header.php';
	include 'declare_php.php';
	$friend_num = $_REQUEST["friend_num"];
	$writetime = date("Y-m-d, H:i:s");
	$sql1 = "DELETE FROM friend WHERE user_num=$user_num AND friend_num=$friend_num";
	mysqli_query($conn, $sql1);
	$sql2 = "DELETE FROM friend WHERE user_num=$friend_num AND friend_num=$user_num";
	mysqli_query($conn, $sql2);
	$sql3 = "INSERT INTO home_alarm (table_name, user_num, count, count2, description, writetime) VALUES ('friend_delete', $friend_num, $user_num, 0, '( $user_name )님이 친구 관계를 중단하셨습니다.', '$writetime')";//친구 삭제 사실을 신청인에게 알리기
	mysqli_query($conn, $sql3);
	friend_list_delete($friend_num);//friend_num에 해당하는 번호를 friend_list에서 지운다
?>