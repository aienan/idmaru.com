<?php
	include 'header.php';
	include 'mysql_setting.php';
	$seller_num = $_REQUEST["seller_num"];//판매자 번호
	$decision = $_REQUEST["decision"];//승낙여부
	$writetime = date("Y-m-d, H:i:s");
	$table_name = "sale_trader";
	if($decision=="accept"){//승낙했을때
		$sql2 = "INSERT INTO $table_name (seller_num, buyer_num, writetime) VALUES ($seller_num, $user_num, '$writetime')";
		mysqli_query($conn, $sql2);
		$sql3 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($seller_num, 'sale_trader_accept', $user_num, 0, '$user_name 님이 거래자로 등록되었습니다. 거래자 목록에서 확인할 수 있습니다.', '$writetime')";
		mysqli_query($conn, $sql3);
	} else if($decision=="refuse"){//거절했을때
		$sql3 = "INSERT INTO home_alarm (user_num, table_name, description, writetime) VALUES ($seller_num, 'sale_trader_refuse', '$user_name 님이 거래신청을 거절하셨습니다.', '$writetime')";
		mysqli_query($conn, $sql3);
	}
	$sql1 = "DELETE FROM home_alarm WHERE user_num=$user_num AND table_name='sale_trader_admit' AND count=$seller_num";//home_alarm에서 지운다
	mysqli_query($conn, $sql1);
	
?>