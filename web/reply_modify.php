<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$table_name_reply = $_REQUEST["table_name_reply"];
	$count_upperwrite = $_REQUEST["count_upperwrite"];
	$count = $_REQUEST["count"];
	$content = $_REQUEST["content"];
	$writetime = date("Y-m-d, H:i:s");
	$sql1 = "UPDATE $table_name_reply SET content = '$content', writetime = '$writetime', index_update='0' WHERE count_upperwrite = $count_upperwrite AND count = $count";
	mysqli_query($conn, $sql1);
?>