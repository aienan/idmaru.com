<?php
	//main과 delta merge 후 수행할 MySQL문
	include 'mysql_setting.php';
	$sql1 = "UPDATE writing SET index_update='1'";
	mysqli_query($conn, $sql1);
	$sql2 = "UPDATE photo SET index_update='1'";
	mysqli_query($conn, $sql2);
	$sql3 = "UPDATE sale SET index_update='1'";
	mysqli_query($conn, $sql3);
	$sql4 = "UPDATE club_event SET index_update='1'";
	mysqli_query($conn, $sql4);
	$sql5 = "UPDATE guest_private SET index_update='1'";
	mysqli_query($conn, $sql5);
	$sql6 = "UPDATE club_group_writing SET index_update='1'";
	mysqli_query($conn, $sql6);
	// $sql7 = "UPDATE writing_reply SET index_update='1'";
	// mysqli_query($conn, $sql7);
	$sql8 = "UPDATE about_question SET index_update='1'";
	mysqli_query($conn, $sql8);
	$sql9 = "UPDATE about_question_reply SET index_update='1'";
	mysqli_query($conn, $sql9);
	$sql10 = "UPDATE club_group SET index_update='1'";
	mysqli_query($conn, $sql10);
	
	//조회수 테이블을 하루가 지날때마다 업데이트해준다
	$sql11 = "SELECT * FROM writing_read_counter";//read_counter의 정보 선택
	$sql_query11 = mysqli_query($conn, $sql11);
	$count11 = mysqli_num_rows($sql_query11);
	for($i=0; $i < $count11; $i++){
		$sql_fetch_array11 = mysqli_fetch_array($sql_query11);
		$id = $sql_fetch_array11["count"];
		$read_count_1_new = (int)($sql_fetch_array11["read_count_1"]/2);//1일 조회수를 계산한다
		$read_count_7_new = (int)($sql_fetch_array11["read_count_7"]*7/8);//7일 조회수를 계산한다
		$read_count_30_new = (int)($sql_fetch_array11["read_count_30"]*30/31);//30일 조회수를 계산한다
		$sql12 = "UPDATE writing_read_counter SET read_count_1=$read_count_1_new, read_count_7=$read_count_7_new, read_count_30=$read_count_30_new WHERE count=$id";//read_counter에 업데이트한다
		mysqli_query($conn, $sql12);
	}
	$sql13 = "SELECT * FROM photo_read_counter";//read_counter의 정보 선택
	$sql_query13 = mysqli_query($conn, $sql13);
	$count13 = mysqli_num_rows($sql_query13);
	for($i=0; $i < $count13; $i++){
		$sql_fetch_array13 = mysqli_fetch_array($sql_query13);
		$id = $sql_fetch_array13["count"];
		$read_count_1_new = (int)($sql_fetch_array13["read_count_1"]/2);//1일 조회수를 계산한다
		$read_count_7_new = (int)($sql_fetch_array13["read_count_7"]*7/8);//7일 조회수를 계산한다
		$read_count_30_new = (int)($sql_fetch_array13["read_count_30"]*30/31);//30일 조회수를 계산한다
		$sql14 = "UPDATE photo_read_counter SET read_count_1=$read_count_1_new, read_count_7=$read_count_7_new, read_count_30=$read_count_30_new WHERE count=$id";//read_counter에 업데이트한다
		mysqli_query($conn, $sql14);
	}
?>