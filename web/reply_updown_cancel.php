<?php
	include 'header.php';
	include 'mysql_setting.php';
	if($user_num==0){exit;}
	$table_name_reply = $_REQUEST["table_name_reply"];
	$count_upperwrite = $_REQUEST["count_upperwrite"];
	$count = $_REQUEST["count"];
	if($table_name_reply=="writing_reply"){
		$table_name_reply_updown = $table_name_reply."_updown";
		$sql2 = "DELETE FROM $table_name_reply_updown WHERE count_upperwrite = $count_upperwrite AND count = $count AND user_num = $user_num";
		mysqli_query($conn, $sql2);
	}
?>