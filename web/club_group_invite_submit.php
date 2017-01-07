<?php
	include 'header.php';
	include 'mysql_setting.php';
	$keyword=$_REQUEST["keyword"];
	$count_group = $_REQUEST["count_group"];
	$writetime = date("Y-m-d, H:i:s");
	$sql1 = "SELECT * FROM user WHERE id = '$keyword' OR nickname = '$keyword'";//회원이 있는지 검색
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count1 == 0){//회원이 없을 때
		echo "none";
	} else if($count1==1){//회원이 존재할 때
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql3 = "SELECT * FROM club_group_member WHERE count_group = $count_group AND user_num = $sql_fetch_array1[user_num]";//사용자모임에 등록돼 있는지 검색
		$sql_query3 = mysqli_query($conn, $sql3);
		$count3 = mysqli_num_rows($sql_query3);
		if($count3==1){//사용자가 모임에 등록돼 있을때
			echo "already";
		} else if($count3==0){//사용자가 모임에 등록돼있지 않을때
			$sql4 = "SELECT * FROM club_group_invite WHERE user_num = $sql_fetch_array1[user_num] AND count_group = $count_group";//사용자모임에 이미 초대돼 있는지 검색
			$sql_query4 = mysqli_query($conn, $sql4);
			$count4 = mysqli_num_rows($sql_query4);
			if($count4==1){//이미 사용자가 초대되어 있을 때
				echo "invited";
			} else if($count4==0){//사용자가 초대되어 있지 않을 때
				$sql2 = "INSERT INTO club_group_invite (user_num, count_group, user_num_invite) VALUES ($sql_fetch_array1[user_num], $count_group, $user_num)";
				mysqli_query($conn, $sql2);
				$sql5 = "SELECT * FROM club_group WHERE count_group = $count_group";//모임 정보 보기
				$sql_query5 = mysqli_query($conn, $sql5);
				$sql_fetch_array5 = mysqli_fetch_array($sql_query5);
				$description = '( '.$user_name.' )님이 모임( '.$sql_fetch_array5["group_name"].' )에 초대하셨습니다.';
				$sql5 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array1[user_num], 'club_group_invite', $count_group, 0, '$description', '$writetime')";
				mysqli_query($conn, $sql5);
				echo "done";
			}
		}
	}
	
?>