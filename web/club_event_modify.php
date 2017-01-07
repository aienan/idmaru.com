<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$count=$_REQUEST["count"];
	$title=$_REQUEST["mywrite_title"];
	$title = replace_symbols($title);
	$content=$_REQUEST["mywrite_modify_content"];
	$content = error_modify($content);
	$status=$_REQUEST["status"];
	if($status=="party"){
		$status = 1;
	} else if($status=="social"){
		$status = 2;
	} else if($status=="volunteer"){
		$status = 3;
	}
	$write_new=$_REQUEST["write_new"];
	$table_name = "club_event";
	$writetime = date("Y-m-d, H:i:s");
	$location = $_REQUEST["location"];
	$start_time_y = $_REQUEST["start_time_y"];
	if($start_time_y==0){$start_time_y = '';}
	$start_time_m = $_REQUEST["start_time_m"];
	$start_time_d = $_REQUEST["start_time_d"];
	$end_time_y = $_REQUEST["end_time_y"];
	if($end_time_y==9999){$end_time_y = '';}
	$end_time_m = $_REQUEST["end_time_m"];
	$end_time_d = $_REQUEST["end_time_d"];
	include 'photo_check.php';
	$sql = "UPDATE club_event SET title='$title', content='$content', status='$status', start_time_y='$start_time_y', start_time_m='$start_time_m', start_time_d='$start_time_d', end_time_y='$end_time_y', end_time_m='$end_time_m', end_time_d='$end_time_d', index_update='0' WHERE count=$count AND user_num=$user_num";
	mysqli_query($conn, $sql); 
	echo "
		<script>window.parent.location.href = '$location';</script>
	";
	
?>
