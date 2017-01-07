<?php
	include 'header.php';
	include 'mysql_setting.php';
	$count_group = $_REQUEST["count_group"];
	$decision = $_REQUEST["decision"];
	$group_name = $_REQUEST["group_name"];
	$member = $_REQUEST["member"];
	$writetime = date("Y-m-d, H:i:s");
	$sql3 = "SELECT * FROM club_group_invite WHERE user_num = $user_num AND count_group = $count_group";//초대한 사람의 user_num을 알아보기 위함
	$sql_query3 = mysqli_query($conn, $sql3);
	$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
	if($decision=="accept"){
		$sql2 = "INSERT INTO club_group_member (count_group, user_num) VALUES ($count_group, $user_num)";//club_group_member에 회원 등록한다
		mysqli_query($conn, $sql2);
		$sql5 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array3[user_num_invite], 'club_group_invite_accept', $user_num, 0, '<a href=\"club_group_one.php?count_group=".$count_group."\" class='link'>( $user_name )님이 모임( $group_name )에 가입하셨습니다.</a>', '$writetime')";//초대한 사람에게 승인 사실을 알려주기 위함
		mysqli_query($conn, $sql5);
		$member_new = $member + 1;
		$sql7 = "UPDATE club_group SET member=$member_new WHERE count_group=$count_group";
		mysqli_query($conn, $sql7);
		$sql8 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array3[user_num_invite], 'club_group_invite_refuse', $user_num, 0, '<a href=\"club_group_one.php?count_group=".$count_group."\" class='link'>( $user_name )님이 모임( $group_name )에 가입하셨습니다.</a>', '$writetime')";//초대한 사람에게 가입 사실을 알려주기 위함
		mysqli_query($conn, $sql8);
	} else if($decision=="refuse"){
		$sql6 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array3[user_num_invite], 'club_group_invite_refuse', $user_num, 0, '( $user_name )님이 모임( $group_name )에 가입을 거절하셨습니다.', '$writetime')";//초대한 사람에게 거절 사실을 알려주기 위함
		mysqli_query($conn, $sql6);
	}
	$sql = "DELETE FROM club_group_invite WHERE user_num=$user_num AND count_group=$count_group";
	mysqli_query($conn, $sql);//club_group_invite에서 지운다
	$sql1 = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='club_group_invite' AND count=$count_group";//home_alarm에서 지운다
	$sql_query1 = mysqli_query($conn, $sql1);
	
?>