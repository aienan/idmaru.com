<?php
	include 'header.php';
	include 'mysql_setting.php';
	if($user_num==0){exit;}
	$table_name_reply = $_REQUEST["table_name_reply"];
	$count_upperwrite = $_REQUEST["count_upperwrite"];
	$count = $_REQUEST["count"];
	$sql1 = "DELETE FROM $table_name_reply WHERE count_upperwrite = $count_upperwrite AND count = $count";
	mysqli_query($conn, $sql1);
	if($table_name_reply=="writing_reply"){
		$table_name_reply_updown = $table_name_reply.'_updown';
		$sql2 = "DELETE FROM $table_name_reply_updown WHERE count_upperwrite = $count_upperwrite AND count = $count";
		mysqli_query($conn, $sql2);
		// $sql10 = "INSERT INTO sphinx_delete_list (table_name, count) VALUES('$table_name_reply', $count)";//sphinx_delete_list에 지워진 row를 등록한다
		// $sql_query10 = mysqli_query($conn, $sql10);
	}
?>