<?php
	include 'header.php';
	include 'mysql_setting.php';
	$sql1 = "SELECT * FROM home_alarm WHERE table_name='friend_submit' AND count=$user_num";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$output = "";
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num]";
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$output .= '<div class="friend_waiting_name">'.$sql_fetch_array2["user_name"].' ('.$sql_fetch_array2["familyname"].' '.$sql_fetch_array2["firstname"].')</div>';
	}
	if($count1==0){$output .= '<div class="friend_waiting_name">신청 대기자가 없습니다</div>';}
	echo $output;
	
?>