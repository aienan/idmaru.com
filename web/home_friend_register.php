<?php
	include 'header.php';
	include 'mysql_setting.php';
	$friend_name=$_REQUEST["friend_name"];
	$writetime = date("Y-m-d, H:i:s");
	$sql4 = "SELECT * FROM user WHERE user_name='$user_name'";
	$sql_query4 = mysqli_query($conn, $sql4);
	$sql_fetch_array4 = mysqli_fetch_array($sql_query4);
	if($user_name==$friend_name || $sql_fetch_array4["id"]==$friend_name){//친구등록이 본인id일 경우
		echo "
			{ \"register\": \"myself\" }
		";
		exit;
	} else if($user_name!=$friend_name && $sql_fetch_array4["id"]!=$friend_name) {//친구등록이 본인id가 아닐경우
		$sql1 = "SELECT * FROM user WHERE id='$friend_name' OR nickname='$friend_name'";//친구의 신상정보
		$sql_query1 = mysqli_query($conn, $sql1);	// SQL 질의 수행
		$count1 = mysqli_num_rows($sql_query1);
		if ($count1) {//친구가 등록된 회원일 경우,
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);//친구의 신상정보
			$sql2 = "SELECT friend_num FROM friend WHERE user_num='$user_num' AND friend_num='$sql_fetch_array1[user_num]'";//친구가 이미 등록됐는지 확인
			$sql_query2 = mysqli_query($conn, $sql2);
			$count2 = mysqli_num_rows($sql_query2);
			if($sql_fetch_array1["email_certify"]=='0'){//email 인증을 하지 않았을경우
				echo '{"register" : "not_certified"}';
			} else {
				if($sql_fetch_array1["user_stop"]=='1'){//탈퇴한 경우
					echo '{"register" : "user_stop"}';
					exit;
				} else if($count2) {//친구가 이미 등록된 경우
					echo "
						{ \"register\": \"exist\" }
					";
					exit;
				} else if (!$count2){//친구로 아직 등록되지 않은 경우
					$sql5 = "SELECT * FROM home_alarm WHERE user_num=$sql_fetch_array1[user_num] AND table_name='friend_submit' AND count=$user_num";
					$sql_query5 = mysqli_query($conn, $sql5);
					$count5 = mysqli_num_rows($sql_query5);
					if($count5){//이미 친구신청을 한 경우
						echo '{"register" : "on_request"}';
						exit;
					} else if(!$count5){
						$sql6 = "SELECT * FROM home_alarm WHERE user_num=$user_num AND table_name='friend_submit' AND count=$sql_fetch_array1[user_num]";
						$sql_query6 = mysqli_query($conn, $sql6);
						$count6 = mysqli_num_rows($sql_query6);
						if($count6){//친구신청을 받은 경우
							echo '{"register" : "on_receiving"}';
							exit;
						} else if(!$count6){
							$sql3 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array1[user_num], 'friend_submit', $user_num, 0, '( $user_name )님이 친구 신청하셨습니다.', '$writetime')";
							mysqli_query($conn, $sql3);
							echo "
								{ \"register\": \"submit\" }
							";
							exit;
						}
					}
				}
			}
		} else if (!$count1) {//등록된 회원이 아닐 경우,
			echo "
				{ \"register\": \"cannot\" }
			";
			exit;
		}
	}
	
?>