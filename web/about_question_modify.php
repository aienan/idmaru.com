<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$count=$_REQUEST["count"];
	$title=$_REQUEST["mywrite_title"];
	$title = replace_symbols($title);
	$content=$_REQUEST["mywrite_modify_content"];
	$status=$_REQUEST["status"];
	if($status=="all"){
		$status = 1;
	} else if($status=="private"){
		$status = 2;
	}
	$write_new=$_REQUEST["write_new"];
	$table_name = "about_question";
	$writetime = date("Y-m-d, H:i:s");
	$location = $_REQUEST["location"];
	include 'photo_check.php';
	$sql = "UPDATE about_question SET title='$title', content='$content', status='$status', writetime='$writetime', index_update='0' WHERE count=$count AND user_num=$user_num";
	mysqli_query($conn, $sql); 
	$sql3 = "UPDATE about_question_reply SET status='$status' WHERE count_upperwrite = $count";
	mysqli_query($conn, $sql3);
	echo "
		<script>window.parent.location.href = '$location';</script>
	";
	
?>
