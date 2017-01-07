<?php
	include 'header.php';
	include 'mysql_setting.php';
	$count_group = $_REQUEST["count_group"];//모임 번호
	$user_num_admit = $_REQUEST["user_num_admit"];//신청자 번호
	$decision = $_REQUEST["decision"];//결정
	$writetime = date("Y-m-d, H:i:s");
	$sql3 = "SELECT * FROM club_group WHERE count_group=$count_group";
	$sql_query3 = mysqli_query($conn, $sql3);
	$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
	if($decision=="accept"){
		$sql2 = "INSERT INTO club_group_member (count_group, user_num) VALUES ($count_group, $user_num_admit)";//club_group_member에 회원 등록한다
		mysqli_query($conn, $sql2);
		$sql5 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($user_num_admit, 'club_group_admit_accept', $count_group, 0, '<a href=\"club_group_one.php?count_group=".$count_group."\" class='link'>모임( $sql_fetch_array3[group_name] )에 가입이 승인되셨습니다.', '$writetime')";//신청한 사람에게 승인 사실을 알려주기 위함
		mysqli_query($conn, $sql5);
		$member_new = $sql_fetch_array3["member"] + 1;
		$sql7 = "UPDATE club_group SET member=$member_new WHERE count_group=$count_group";
		mysqli_query($conn, $sql7);
	} else if($decision=="refuse"){
		$sql6 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($user_num_admit, 'club_group_admit_refuse', $count_group, 0, '모임( $sql_fetch_array3[group_name] )에 가입이 거절되셨습니다.', '$writetime')";//신청한 사람에게 거절 사실을 알려주기 위함
		mysqli_query($conn, $sql6);
	}
	$sql = "DELETE FROM club_group_admit WHERE count_group=$count_group AND user_num_admit=$user_num_admit";
	mysqli_query($conn, $sql);//club_group_invite에서 지운다
	$sql1 = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='club_group_admit' AND count=$count_group AND count2=$user_num_admit";//home_alarm에서 지운다
	$sql_query1 = mysqli_query($conn, $sql1);
	
?>