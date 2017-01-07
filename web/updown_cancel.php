<?php
	include 'header.php';
	include 'mysql_setting.php';
	$table_name = $_REQUEST["table_name"];
	$count = $_REQUEST["count"];
	if($table_name=="writing"){
		$table_name_updown = $table_name."_updown";
		$sql2 = "DELETE FROM $table_name_updown WHERE count = $count AND user_num = $user_num";
		mysqli_query($conn, $sql2);
		$sql3 = "UPDATE $table_name SET updown_total=updown_total-1 WHERE count = $count";
		mysqli_query($conn, $sql3);
	} else if($table_name=="photo" || $table_name=="club_event"){
		$table_name_up = $table_name."_up";
		$sql2 = "DELETE FROM $table_name_up WHERE count = $count AND user_num = $user_num";
		mysqli_query($conn, $sql2);
		$sql3 = "UPDATE $table_name SET up_total=up_total-1 WHERE count = $count";
		mysqli_query($conn, $sql3);
	}
	
?>