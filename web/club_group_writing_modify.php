<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$count=$_REQUEST["count"];
	$count_group = $_REQUEST["count_group"];
	$title=$_REQUEST["mywrite_title"];
	$title = replace_symbols($title);
	$content=$_REQUEST["mywrite_modify_content"];
	$content = error_modify($content);
	$write_new=$_REQUEST["write_new"];
	$table_name = "club_group_writing";
	$writetime = date("Y-m-d, H:i:s");
	$location = $_REQUEST["location"];
	include 'photo_check.php';
	$sql = "UPDATE club_group_writing SET title='$title', content='$content', writetime='$writetime', index_update='0' WHERE count=$count AND count_group=$count_group AND user_num=$user_num";
	mysqli_query($conn, $sql); 
	echo "
		<script>window.parent.location.href = '$location';</script>
	";
	
?>
