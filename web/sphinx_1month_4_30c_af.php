<?php
	//indexer --all을 하고 난 후에 수행할 MySQL문
	include 'mysql_setting.php';
	$sql1 = "DELETE FROM sphinx_delete_list WHERE table_name = 'writing'";
	mysqli_query($conn, $sql1);
	$sql2 = "DELETE FROM sphinx_delete_list WHERE table_name = 'photo'";
	mysqli_query($conn, $sql2);
	$sql3 = "DELETE FROM sphinx_delete_list WHERE table_name = 'sale'";
	mysqli_query($conn, $sql3);
	$sql4 = "DELETE FROM sphinx_delete_list WHERE table_name = 'club_event'";
	mysqli_query($conn, $sql4);
	$sql5 = "DELETE FROM sphinx_delete_list WHERE table_name = 'guest_private'";
	mysqli_query($conn, $sql5);
	$sql6 = "DELETE FROM sphinx_delete_list WHERE table_name = 'club_group_writing'";
	mysqli_query($conn, $sql6);
	// $sql7 = "DELETE FROM sphinx_delete_list WHERE table_name = 'writing_reply'";
	// mysqli_query($conn, $sql7);
	$sql8 = "DELETE FROM sphinx_delete_list WHERE table_name = 'about_question'";
	mysqli_query($conn, $sql8);
	$sql9 = "DELETE FROM sphinx_delete_list WHERE table_name = 'about_question_reply'";
	mysqli_query($conn, $sql9);
	$sql10 = "DELETE FROM sphinx_delete_list WHERE table_name = 'club_group'";
	mysqli_query($conn, $sql10);
?>