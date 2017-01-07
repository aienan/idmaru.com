<?php
	include 'header.php';
	include 'mysql_setting.php';
	include 'declare_php.php';
	$group_name=$_REQUEST["group_name"];
	$description = $_REQUEST["description"];
	$group_name = replace_symbols($group_name);
	$description = replace_symbols($description);
	$count_group = $_REQUEST["count_group"];
	$status = $_REQUEST["status"];
	$sql = "UPDATE club_group SET group_name = '$group_name', description = '$description', status='$status', index_update='0' WHERE count_group = $count_group AND user_num = $user_num";
	mysqli_query($conn, $sql);
	echo "done";
	
?>