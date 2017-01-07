<?php
	include 'header.php';
	include 'mysql_setting.php';
	$table_name = $_REQUEST["table_name"];
	$count = $_REQUEST["count"];
	if($table_name=="writing"){
		$table_name_updown = $table_name."_updown";
		$updown = $_REQUEST["updown"];
		$sql2 = "SELECT * FROM $table_name_updown WHERE count = $count AND user_num = $user_num";//이미 투표했는지 확인
		$sql_query2 = mysqli_query($conn, $sql2);
		$count2 = mysqli_num_rows($sql_query2);
		if($count2==1){//이미 투표했을경우
			echo "already";
		} else if($count2==0){//투표를 안했을경우
			$sql1 = "INSERT INTO $table_name_updown (count, user_num, updown) VALUES ($count, $user_num, '$updown')";//updown 테이블에 정보 입력
			mysqli_query($conn, $sql1);
			$sql2 = "SELECT * FROM $table_name WHERE count=$count";
			$sql_query2 = mysqli_query($conn, $sql2);
			$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
			if($updown=="up"){
				$updown_total_new = $sql_fetch_array2["updown_total"]+1;
			} else if($updown=="down"){
				$updown_total_new = $sql_fetch_array2["updown_total"]-1;
			}
			$sql3 = "UPDATE $table_name SET updown_total=$updown_total_new WHERE count=$count";
			mysqli_query($conn, $sql3);
			echo "done";
		}
	} else if($table_name=="photo" || $table_name=="club_event"){
		$num_before = $_REQUEST["num_before"];
		$table_name_up = $table_name."_up";
		$updown_total_new = $num_before + 1;
		$sql2 = "SELECT * FROM $table_name_up WHERE count = $count AND user_num = $user_num";//이미 투표했는지 확인
		$sql_query2 = mysqli_query($conn, $sql2);
		$count2 = mysqli_num_rows($sql_query2);
		if($count2==1){//이미 투표했을경우
			echo "already";
		} else if($count2==0){//투표를 안했을경우
			$sql1 = "INSERT INTO $table_name_up (count, user_num) VALUES ($count, $user_num)";//updown 테이블에 정보 입력
			mysqli_query($conn, $sql1);
			$sql3 = "UPDATE $table_name SET up_total=$updown_total_new WHERE count=$count";
			mysqli_query($conn, $sql3);
			echo "done";
		}
	}
	
?>