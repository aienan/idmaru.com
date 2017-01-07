<?php
	include 'header.php';
	include 'mysql_setting.php';
	$user_num_other = $_REQUEST["user_num_other"];
	$writetime = date("Y-m-d, H:i:s");
	$sql = "DELETE FROM sale_trader WHERE (seller_num=$user_num AND buyer_num=$user_num_other) OR (seller_num=$user_num_other AND buyer_num=$user_num)";//거래자 지우기
	mysqli_query($conn, $sql);
	$description = $user_name.'님이 회원님을 거래자 목록에서 삭제하셨습니다.';
	$sql1 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($user_num_other, 'sale_trader_delete', $user_num, 0, '$description', '$writetime')";//지워진 사실을 회원에게 알리기
	mysqli_query($conn, $sql1);
	
?>