<?php
include 'header.php';
include 'declare_php.php';
if($user_num==0){exit;}
$table_name = $_REQUEST["table_name"];
$writetime = date("Y-m-d, H:i:s");
$table_name_photo = $table_name."_photo";
$table_name_reply = $table_name."_reply";
$count = $_REQUEST["count"];
if($table_name=="writing" || $table_name=="photo" || $table_name=="sale" || $table_name=="club_event" || $table_name=="guest_private" || $table_name=="club_group_writing" || $table_name=="about_question"){//sphinx에 등록된 테이블을 sphinx_delete_list에 넣는다 || $table_name=="writing_reply"
	$sql10 = "INSERT INTO sphinx_delete_list (table_name, count) VALUES('$table_name', $count)";//sphinx_delete_list에 지워진 row를 등록한다
	mysqli_query($conn, $sql10);
}
// if($table_name=="writing"){//sphinx에 댓글이 등록된 것만 선택. 지워야 할 댓글을 sphinx리스트에 넣는다.
	// $sql4 = "SELECT * FROM $table_name_reply WHERE count_upperwrite = $count";//댓글을 sphinx_delete_list에 등록하기
	// $sql_query4 = mysqli_query($conn, $sql4);
	// $count4 = mysqli_num_rows($sql_query4);
	// for($i=0; $i < $count4; $i++){
		// $sql_fetch_array4 = mysqli_fetch_array($sql_query4);
		// $sql11 = "INSERT INTO sphinx_delete_list (table_name, count) VALUES('$table_name_reply', $sql_fetch_array4[count])";//sphinx_delete_list_reply에 지워진 row를 등록한다
		// $sql_query11 = mysqli_query($conn, $sql11);
	// }
// }
if($table_name=="writing"){//updown 테이블이 있는 것들
	$table_name_updown = $table_name."_updown";
	$sql6 = "DELETE FROM $table_name_updown WHERE count = $count";//글의 updown 정보 지우기
	mysqli_query($conn, $sql6);
} else if($table_name=="photo" || $table_name=="club_event"){//up 테이블이 있는것들
	$table_name_up = $table_name."_up";
	$sql6 = "DELETE FROM $table_name_up WHERE count = $count";//글의 up 정보 지우기
	mysqli_query($conn, $sql6);
}
if($table_name=="writing" || $table_name=="sale" || $table_name=="club_event" || $table_name=="club_group_writing" || $table_name=="about_question"){//$table_name_photo 테이블이 만들어진 것만 선택
	$sql1 = "SELECT * FROM $table_name_photo WHERE count=$count";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	for($i=0; $i < $count1; $i++){//글에 있는 사진 제거
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		unlink($sql_fetch_array1["photo_path"]);
		unlink(get_thumbnail_path($sql_fetch_array1["photo_path"]));//썸네일 삭제
	}
	$sql2 = "DELETE FROM $table_name_photo WHERE count=$count";
	mysqli_query($conn, $sql2);
}
if($table_name=="writing" || $table_name=="photo" || $table_name=="sale" || $table_name=="club_event" || $table_name=="club_group_writing" || $table_name=="about_question"){//글에 딸린 댓글 지우기
	$sql3 = "DELETE FROM $table_name_reply WHERE count_upperwrite = $count";
	mysqli_query($conn, $sql3);
}
if($table_name=="writing"){//reply_updown이 있는 것들
	$table_name_reply_updown = $table_name_reply."_updown";
	$sql5 = "DELETE FROM $table_name_reply_updown WHERE count_upperwrite = $count";//댓글의 updown 정보들을 지운다.
	mysqli_query($conn, $sql5);
}
if($table_name=="writing" || $table_name=="photo"){//read_counter 테이블이 있는것들
	$table_name_read_counter = $table_name."_read_counter";
	$sql7 = "DELETE FROM $table_name_read_counter WHERE count=$count";
	mysqli_query($conn, $sql7);
}
if($table_name=="sale"){//sale 테이블에서
	$sql8 = "DELETE FROM market_deal WHERE count=$count";//거래자정보를 지운다
	mysqli_query($conn, $sql8);
	$sql15 = "SELECT * FROM sale_reserve_box WHERE count=$count";
	$sql_query15 = mysqli_query($conn, $sql15);
	$sql_fetch_array15 = mysqli_fetch_array($sql_query15);
	$sql16 = "SELECT * FROM $table_name WHERE count=$count";
	$sql_query16 = mysqli_query($conn, $sql16);
	$sql_fetch_array16 = mysqli_fetch_array($sql_query16);
	$description = "장바구니에 담으신 \"".$sql_fetch_array16["title"]."\"이 판매자에 의해 삭제되었습니다.";
	$sql14 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array15[user_num], 'sale_reserve_box_delete', $count, 0, '$description', '$writetime')";
	mysqli_query($conn, $sql14);
	$sql13 = "DELETE FROM sale_reserve_box WHERE count=$count";
	mysqli_query($conn, $sql13);
	$sql9 = "DELETE FROM sale WHERE count=$count";
	mysqli_query($conn, $sql9);
}
if($table_name=="photo"){//photo의 사진 지우기
	$sql12 = "SELECT * FROM $table_name WHERE count=$count";
	$sql_query12 = mysqli_query($conn, $sql12);
	$sql_fetch_array12 = mysqli_fetch_array($sql_query12);
	unlink($sql_fetch_array12["photo_path"]);
	unlink(get_thumbnail_path($sql_fetch_array12["photo_path"]));
	$sql17 = "SELECT * FROM photo_battle_type WHERE count=$count";
	$sql_query17 = mysqli_query($conn, $sql17);
	$sql_fetch_array17 = mysqli_fetch_array($sql_query17);
	$sql18 = "DELETE FROM photo_battle_score WHERE photo_type='$sql_fetch_array17[photo_type]' AND count=$count";
	mysqli_query($conn, $sql18);
	$sql19 = "UPDATE photo_battle_category SET number=number - 1 WHERE photo_type='$sql_fetch_array17[photo_type]'";
	mysqli_query($conn, $sql19);
	$sql20 = "DELETE FROM photo_battle_type WHERE count=$count";
	mysqli_query($conn, $sql20);
}
$sql = "DELETE FROM $table_name WHERE count=$count";//글 지우기
mysqli_query($conn, $sql);
?>