<?php
	include 'header.php';
	include 'mysql_setting.php';
	$user_num = $_REQUEST["user_num"];
	$count_group = $_REQUEST["count_group"];
	$writetime = date("Y-m-d, H:i:s");
	$sql = "DELETE FROM club_group_member WHERE count_group = $count_group AND user_num = $user_num";//club_group_memeber에서 회원 지우기
	mysqli_query($conn, $sql);
	$sql2 = "SELECT * FROM club_group WHERE count_group = $count_group";//모임 이름을 출력하기 위함
	$sql_query2 = mysqli_query($conn, $sql2);
	$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
	$description = '회원님이 모임( '.$sql_fetch_array2[group_name].' )에서 탈퇴되셨습니다.';
	$sql1 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($user_num, 'club_group_member_deleted', $count_group, 0, '$description', '$writetime')";//지워진 사실을 회원에게 알리기
	mysqli_query($conn, $sql1);
	$club_group_member = $sql_fetch_array2["member"]-1;
	$sql3 = "UPDATE club_group SET member=$club_group_member WHERE count_group=$count_group";
	mysqli_query($conn, $sql3);
	
?>