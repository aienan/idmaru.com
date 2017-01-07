<?php
	include 'header.php';
	include 'mysql_setting.php';
	$table_name = $_REQUEST["table_name"];
	$count = $_REQUEST["count"];
	$count2 = $_REQUEST["count2"];
	$writetime = $_REQUEST["writetime"];
	if(isset($_REQUEST["delete_type"])){$delete_type = $_REQUEST["delete_type"];}//home_alarm에서 모두확인을 눌렀을때 "all_confirm"
	else {$delete_type=0;}
	if(!$delete_type){//delete_type가 없을때
		$sql = "DELETE FROM home_alarm WHERE user_num = $user_num AND table_name = '$table_name' AND count = $count AND count2 = $count2 AND writetime='$writetime'";
		mysqli_query($conn, $sql);
		$sql1 = "SELECT * FROM home_alarm WHERE user_num=$user_num";//알람이 남아있는지 확인
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
		if(!$count1){//알람이 없을경우
			echo "none";
		}
	} else if($delete_type=="all_confirm"){//home_alarm에서 모두확인을 눌렀을때
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='club_group_invite_accept'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='club_group_invite_refuse'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='club_group_member_deleted'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='club_group_member_quit'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='club_group_dismissed'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='friend_submit_accept'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='friend_submit_refuse'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='friend_delete'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='club_group_admit_refuse'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='club_group_admit_accept'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='sale_trader_refuse'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='market_deal_new'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='market_deal_modify'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='reply_submit_idmaru_guest'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='reply_submit_writing'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='reply_submit_photo'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='reply_submit_sale'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='reply_submit_club_event'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='reply_submit_club_group_writing'";
		mysqli_query($conn, $sql);
		$sql = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='reply_submit_about_question'";
		mysqli_query($conn, $sql);
	}
?>