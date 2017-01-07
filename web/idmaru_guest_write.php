<?php
	include 'header.php';
	include 'declare_php.php';
	$content=$_REQUEST["mywrite_content"];
	$content = replace_symbols($content);
	$upperwrite=$_REQUEST["upperwrite"];
	$writetime = date("Y-m-d, H:i:s");
	$table_name = "idmaru_guest";
	$sql = "INSERT INTO counter (name, value) VALUES('$table_name', LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE value = LAST_INSERT_ID(value+1)";
	mysqli_query($conn, $sql);
	$sql = "INSERT INTO $table_name (count, upperwrite, user_num, content, writetime, updown_total) VALUES (LAST_INSERT_ID(), $upperwrite, $user_num, '$content', '$writetime', 0)";
	mysqli_query($conn, $sql); 
	if($upperwrite != 0){
		$sql3 = "SELECT * FROM $table_name WHERE count = $upperwrite";
		$sql_query3 = mysqli_query($conn, $sql3);
		$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
		if($sql_fetch_array3["user_num"] != $user_num && $sql_fetch_array3["user_num"] != 0){//댓글쓴 이가 본인이 아니고 게스트도 아닐때. 
			$description = '"모두에게 한마디"에서 회원님의 글에 "'.$user_name.'" 님이 댓글을 달으셨습니다.';
			$sql2 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array3[user_num], 'reply_submit_idmaru_guest', LAST_INSERT_ID(), $upperwrite, '$description', '$writetime')";
			mysqli_query($conn, $sql2);
		}
	}
?>