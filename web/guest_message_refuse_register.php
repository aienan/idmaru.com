<?php
	include 'header.php';
	include 'mysql_setting.php';
	$type = $_REQUEST["type"];
	$refuse_user_name = $_REQUEST["refuse_user_name"];
	if($user_num==0){exit;}
	$sql2 = "SELECT * FROM user WHERE user_name = '$refuse_user_name'";//등록된 회원인지 확인
	$sql_query2 = mysqli_query($conn, $sql2);
	$count2 = mysqli_num_rows($sql_query2);
	if($type=="insert"){//차단자를 등록할 때
		if(!$count2){echo "none";}//차단자가 없을때
		else {//차단자가 있을때
			$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
			$sql1 = "SELECT * FROM guest_message_refuse WHERE user_num=$user_num AND refuse_user_num=$sql_fetch_array2[user_num]";//이미 등록되어 있는지 확인
			$sql_query1 = mysqli_query($conn, $sql1);
			$count1 = mysqli_num_rows($sql_query1);
			if($count1){echo "already";}//이미 등록되었을때
			else{//등록되지 않았을때
				$sql3 = "INSERT INTO guest_message_refuse (user_num, refuse_user_num) VALUES ($user_num, $sql_fetch_array2[user_num])";//차단자 등록
				mysqli_query($conn, $sql3);
				echo "done";
			}
		}
	} else if($type=="delete"){//차단자를 삭제할 때
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$sql4 = "SELECT * FROM guest_message_refuse WHERE user_num=$user_num AND refuse_user_num=$sql_fetch_array2[user_num]";//차단자가 등록되어 있는지 확인
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);
		if(!$count4){echo "already";}//등록되어있지 않을때
		else {//등록되어 있을때
			$sql5 = "DELETE FROM guest_message_refuse WHERE user_num=$user_num AND refuse_user_num=$sql_fetch_array2[user_num]";//차단자 지우기
			mysqli_query($conn, $sql5);
			echo "done";
		}
	}
	
?>