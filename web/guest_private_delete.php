<?php
	include 'header.php';
	include 'mysql_setting.php';
	if($user_num==0){exit;}
	$count = $_REQUEST["count"];
	$delete_type = $_REQUEST["delete_type"];
	if($delete_type=="sender_dont_see"){//보낸사람이 삭제할경우
		$sql2 = "UPDATE guest_private SET sender_dont_see='1', index_update='0' WHERE count=$count";
		mysqli_query($conn, $sql2);
	} else if($delete_type=="receiver_dont_see"){//받는사람이 삭제할경우
		$sql1 = "UPDATE guest_private SET receiver_dont_see='1', index_update='0' WHERE count=$count";
		mysqli_query($conn, $sql1);
	}
	$sql3 = "SELECT * FROM guest_private WHERE count=$count";
	$sql_query3 = mysqli_query($conn, $sql3);
	$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
	if($sql_fetch_array3["sender_dont_see"]=='1' && $sql_fetch_array3["receiver_dont_see"]=='1'){//보낸사람과 받는사람 모두 삭제했을경우
		$sql = "DELETE FROM guest_private WHERE count=$count";
		mysqli_query($conn, $sql);
		$sql10 = "INSERT INTO sphinx_delete_list (table_name, count) VALUES('guest_private', $count)";//sphinx_delete_list에 지워진 row를 등록한다
		mysqli_query($conn, $sql10);
	}
	
?>