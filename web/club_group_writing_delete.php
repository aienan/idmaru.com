<?php
	include 'header.php';
	include 'mysql_setting.php';
	if($user_num==0){exit;}
	$count = $_REQUEST["count"];
	$sql = "DELETE FROM club_group_writing WHERE count=$count";
	mysqli_query($conn, $sql);
	$sql1 = "SELECT * FROM club_group_writing_photo WHERE count=$count";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	for($i=1; $i <= $count1; $i++){//글에 있는 사진 제거
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		unlink($sql_fetch_array1["photo_path"]);
	}
	$sql2 = "DELETE FROM club_group_writing_photo WHERE count=$count";
	mysqli_query($conn, $sql2);
	$sql10 = "INSERT INTO sphinx_delete_list (table_name, count) VALUES('club_group_writing', $count)";//sphinx_delete_list에 지워진 row를 등록한다
	$sql_query10 = mysqli_query($conn, $sql10);
	$sql3 = "DELETE FROM club_group_writing_reply WHERE count_upperwrite = $count";//글에 딸린 댓글 지우기
	mysqli_query($conn, $sql3);
	
?>