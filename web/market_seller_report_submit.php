<?php
	include 'header.php';
	include 'declare_php.php';
	$type = $_REQUEST["type"];
	$seller_num = $_REQUEST["seller_num"];
	$comment = $_REQUEST["comment"];
	$comment = replace_symbols($comment);
	$writetime = date("Y-m-d, H:i:s");
	$table_name = "market_seller_report";
	if($type=="new"){//판매자평을 새로 쓰는 것일경우
		$sql = "INSERT INTO $table_name (seller_num, reporter_num, comment, writetime) VALUES ($seller_num, $user_num, '$comment', '$writetime')";
		mysqli_query($conn, $sql);
	} else if($type=="modify"){
		$sql = "UPDATE $table_name SET comment='$comment', writetime='$writetime' WHERE seller_num=$seller_num AND reporter_num=$user_num";
		mysqli_query($conn, $sql);
	} else if($type=="delete"){
		$sql = "DELETE FROM $table_name WHERE seller_num=$seller_num AND reporter_num=$user_num";
		mysqli_query($conn, $sql);
	}
	
?>