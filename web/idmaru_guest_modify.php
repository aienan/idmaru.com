<?php
	include 'header.php';
	include 'declare_php.php';
	$write_modify_count=$_REQUEST["write_modify_count"];
	$content=$_REQUEST["content"];
	$content = replace_symbols($content);
	$writetime = date("Y-m-d, H:i:s");
	$sql = "UPDATE idmaru_guest SET content='$content', writetime='$writetime' WHERE count=$write_modify_count";
	echo "
		{\"writetime\": \"$writetime\"}
	";
	mysqli_query($conn, $sql); 
	
?>