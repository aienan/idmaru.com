<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$count=$_REQUEST["count"];
	$type=$_REQUEST["news_type_mod"];
	$title=$_REQUEST["mywrite_title"];
	$title = replace_symbols($title);
	$content=$_REQUEST["mywrite_modify_content"];
	$content = error_modify($content);
	$status=$_REQUEST["status"];
	if($status=="all"){
		$status = 1;
	} else if($status=="friend"){
		$status = 2;
	} else if($status=="private"){
		$status = 3;
	}
	$write_new=$_REQUEST["write_new"];
	$table_name = "writing";
	$writetime = date("Y-m-d, H:i:s");
	$location = $_REQUEST["location"];
	include 'photo_check.php';
	$sql = "UPDATE writing SET type=$type, title='$title', content='$content', status='$status', writetime='$writetime', index_update='0' WHERE count=$count AND user_num=$user_num";
	mysqli_query($conn, $sql); 
	$sql3 = "UPDATE writing_reply SET status='$status', index_update='0' WHERE count_upperwrite = $count";
	mysqli_query($conn, $sql3);
	$sql4 = "UPDATE writing_read_counter SET status='$status', type=$type WHERE count=$count";
	mysqli_query($conn, $sql4);
	echo "
		<script>window.parent.location.href = '$location';</script>
	";
	
?>