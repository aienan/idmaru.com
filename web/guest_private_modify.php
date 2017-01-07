<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$content=$_REQUEST["mywrite_modify_content"];
	$content = replace_symbols($content);
	$write_modify_date=$_REQUEST["write_modify_date"];
	$write_modify_count=$_REQUEST["write_modify_count"];
	$writetime = date("Y-m-d, H:i:s");
	$sql = "UPDATE guest_private SET content='$content', writetime='$writetime', read_check='0', index_update='0' WHERE writetime='$write_modify_date' AND user_num_send=$user_num";
	mysqli_query($conn, $sql); 
	
	echo $writetime;
?>
