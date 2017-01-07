<?php
	//indexer --all 하기 전에 수행할 MySQL문
	include 'mysql_setting.php';
	$sql1 = "UPDATE writing SET index_update='1'";
	mysqli_query($conn, $sql1);
	$sql2 = "UPDATE photo SET index_update='1'";
	mysqli_query($conn, $sql2);
	$sql3 = "UPDATE sale SET index_update='1'";
	mysqli_query($conn, $sql3);
	$sql4 = "UPDATE club_event SET index_update='1'";
	mysqli_query($conn, $sql4);
	$sql5 = "UPDATE guest_private SET index_update='1'";
	mysqli_query($conn, $sql5);
	$sql6 = "UPDATE club_group_writing SET index_update='1'";
	mysqli_query($conn, $sql6);
	// $sql7 = "UPDATE writing_reply SET index_update='1'";
	// mysqli_query($conn, $sql7);
	$sql8 = "UPDATE about_question SET index_update='1'";
	mysqli_query($conn, $sql8);
	$sql9 = "UPDATE about_question_reply SET index_update='1'";
	mysqli_query($conn, $sql9);
	$sql10 = "UPDATE club_group SET index_update='1'";
	mysqli_query($conn, $sql10);
?>