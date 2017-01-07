<?php
	include 'header.php';
	include 'mysql_setting.php';
	if($user_num==0){exit;}
	$table_name_reply = $_REQUEST["table_name_reply"];
	$count_upperwrite = $_REQUEST["count_upperwrite"];
	$count = $_REQUEST["count"];
	if($table_name_reply=="writing_reply"){
		$table_name_reply_updown = $table_name_reply."_updown";
		$updown = $_REQUEST["updown"];
		$sql2 = "SELECT * FROM $table_name_reply_updown WHERE count_upperwrite = $count_upperwrite AND count = $count AND user_num = $user_num";//이미 투표했는지 확인
		$sql_query2 = mysqli_query($conn, $sql2);
		$count2 = mysqli_num_rows($sql_query2);
		if($count2==1){//이미 투표했을경우
			echo "already";
		} else if($count2==0){//투표를 안했을경우
			$sql1 = "INSERT INTO $table_name_reply_updown (count_upperwrite, count, user_num, updown) VALUES ($count_upperwrite, $count, $user_num, '$updown')";//updown 테이블에 정보 입력
			mysqli_query($conn, $sql1);
			echo "done";
		}
	}
?>