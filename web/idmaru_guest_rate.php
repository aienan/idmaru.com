<?php
	include 'header.php';
	include 'mysql_setting.php';
	$count = $_REQUEST["count"];
	$updown = $_REQUEST["updown"];
	$sql1 = "SELECT * FROM idmaru_guest_updown WHERE count=$count AND user_num=$user_num";//투표 유무 체크
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count1){//투표를 이미 했을경우
		echo "exist";
	} else if(!$count1){//투표를 안했을경우
		$sql3 = "SELECT * FROM idmaru_guest WHERE count=$count";//updown_total의 현재 값을 구한다
		$sql_query3 = mysqli_query($conn, $sql3);
		$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
		if($sql_fetch_array3["user_num"]==$user_num){
			echo "myself";
		} else if($sql_fetch_array3["user_num"] != $user_num){
			$sql2 = "INSERT INTO idmaru_guest_updown (count, user_num, updown) VALUES ($count, $user_num, '$updown')";//투표를 저장한다
			mysqli_query($conn, $sql2);
			if($updown=="up"){//투표가 up일 경우
				$new_num = $sql_fetch_array3["updown_total"] + 1;
			} else if($updown=="down"){//투표가 down일 경우
				$new_num = $sql_fetch_array3["updown_total"] - 1;
			}
			$sql4 = "UPDATE idmaru_guest SET updown_total=$new_num WHERE count=$count";
			mysqli_query($conn, $sql4);
			echo "done";
		}
	}
	
?>