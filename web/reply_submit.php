<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$table_name_reply = $_REQUEST["table_name_reply"];
	$count_upperwrite = $_REQUEST["count_upperwrite"];
	$content = $_REQUEST["content"];
	$regExp = "/_reply/";
	$table_name = preg_replace($regExp, "", $table_name_reply);
	$reply_submit_table_name = "reply_submit_".$table_name;
	if($table_name_reply=="writing_reply" || $table_name_reply=="about_question_reply"){//글쓰기, 문의하기의 댓글일 경우
		$status = $_REQUEST["status"];
	}
	$writetime = date("Y-m-d, H:i:s");
	$sql3 = "SELECT * FROM $table_name WHERE count = $count_upperwrite"; // 본문 정보
	$sql_query3 = mysqli_query($conn, $sql3);
	$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
	if($table_name_reply=="photo_reply"){
		$description = '<a href="'.$table_name.'.php?count_link='.$count_upperwrite.'" class="link">회원님의 사진에 "'.$user_name.'" 님이 댓글을 입력하셨습니다.</a>';
	} else if($table_name_reply=="club_group_writing_reply"){
		$description = '<a href="club_group_one.php?count_group='.$sql_fetch_array3["count_group"].'&count_link='.$count_upperwrite.'" class="link">"'.$sql_fetch_array3["title"].'" 글에 "'.$user_name.'" 님이 댓글을 입력하셨습니다.</a>';
	} else {
		$description = '<a href="'.$table_name.'.php?count_link='.$count_upperwrite.'" class="link">"'.$sql_fetch_array3["title"].'" 글에 "'.$user_name.'" 님이 댓글을 입력하셨습니다.</a>';
	}
	if($table_name_reply=="writing_reply" || $table_name_reply=="about_question_reply"){//글쓰기, 문의하기의 댓글일 경우
		$sql = "INSERT INTO counter (name, value) VALUES('$table_name_reply', LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE value = LAST_INSERT_ID(value+1)";
		mysqli_query($conn, $sql);
		$sql1 = "INSERT INTO $table_name_reply (count, count_upperwrite, user_num, content, status, writetime, index_update) VALUES (LAST_INSERT_ID(), $count_upperwrite, $user_num, '$content', '$status', '$writetime', '0')";//글 안의 사진, DB에 입력
		mysqli_query($conn, $sql1); 
		if($sql_fetch_array3["user_num"] != $user_num){//댓글쓴 이가 본인이 아닐때
			$sql4 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array3[user_num], '$reply_submit_table_name', LAST_INSERT_ID(), $count_upperwrite, '$description', '$writetime')";
			mysqli_query($conn, $sql4);
		}
	} else {//그 외 게시판 댓글
		$sql1 = "SELECT MAX(count) AS count_max FROM $table_name_reply WHERE count_upperwrite=$count_upperwrite";//댓글 count의 최대값 알아내기
		$sql_query1 = mysqli_query($conn, $sql1);
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$new_count = $sql_fetch_array1[count_max]+1;
		$sql2 = "INSERT INTO $table_name_reply (count_upperwrite, count, user_num, content, writetime, index_update) VALUES ($count_upperwrite, $new_count, $user_num, '$content', '$writetime', '0')";//댓글 입력
		mysqli_query($conn, $sql2);
		if($sql_fetch_array3["user_num"] != $user_num){//댓글쓴 이가 본인이 아닐때
			$sql4 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array3[user_num], '$reply_submit_table_name', $count_upperwrite, $new_count, '$description', '$writetime')";
			mysqli_query($conn, $sql4);
		}
	}
	if($table_name_reply=="about_question_reply" && $idmaru_user_num != $user_num && $idmaru_user_num != $sql_fetch_array3["user_num"]){ // 문의하기 게시판 댓글을 idMaru 운영진에 전달
		$description = '<a href="about_question.php?count_link='.$count_upperwrite.'" class="link">이드마루 문의하기 게시판에 댓글이 올라왔습니다.</a>';
		$sql5 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($idmaru_user_num, 'about_question_write', $count_upperwrite, LAST_INSERT_ID(), '$description', '$writetime')"; // idMaru에게 새 글이 올라온 사실을 알리기
		mysqli_query($conn, $sql5);
	}
?>