<?php
	include 'header.php';
	include 'mysql_setting.php';
	$buyer_num = $_REQUEST["buyer_num"];
	$count = $_REQUEST["count"];
	$writetime = date("Y-m-d, H:i:s");
	$table_name = "sale_trader";
	if($user_num!=0 && $buyer_num!=$user_num){//Guest가 아니고 본인이 아닐경우
		$sql1 = "SELECT * FROM $table_name WHERE (seller_num=$user_num AND buyer_num=$buyer_num) OR (seller_num=$buyer_num AND buyer_num=$user_num)";//이미 거래자로 등록되어 있는지 확인
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
		if($count1){//거래자로 등록되어 있을때
			echo 'already';
		} else if(!$count1){//거래자로 등록되어 있지 않을때
			$sql3 = "SELECT * FROM home_alarm WHERE user_num=$buyer_num AND table_name='sale_trader_admit' AND count=$user_num";//이미 거래신청 했는지 확인
			$sql_query3 = mysqli_query($conn, $sql3);
			$count3 = mysqli_num_rows($sql_query3);
			if($count3){//이미 거래신청했을때
				echo 'yet';
			} else if(!$count3){//아직 거래신청하지 않았을때
				$sql4 = "SELECT * FROM home_alarm WHERE user_num=$user_num AND table_name='sale_trader_admit' AND count=$buyer_num";//거래신청을 받았는지 확인
				$sql_query4 = mysqli_query($conn, $sql4);
				$count4 = mysqli_num_rows($sql_query4);
				if($count4){//거래신청을 받았을때
					echo 'received';
				} else {//거래신청을 받지 않았을때
					$sql2 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($buyer_num, 'sale_trader_admit', $user_num, $count, '$user_name 님께서 거래를 신청하셨습니다.', '$writetime')";
					mysqli_query($conn, $sql2);
					echo 'done';
				}
			}
		}
	}
	
?>