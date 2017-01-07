<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$title=$_REQUEST["mywrite_title"];
	$title = replace_symbols($title);
	$content=$_REQUEST["mywrite_content"];
	$status=$_REQUEST["status"];
	if($status=="all"){
		$status = 1;
	} else if($status=="private"){
		$status = 2;
	} else if($status=="admin"){
		$status = 3;
	}
	$write_new=$_REQUEST["write_new"];
	$writetime = date("Y-m-d, H:i:s");
	$table_name = "about_question";
	include 'photo_check.php';
	$sql = "INSERT INTO about_question (count, user_num, title, content, status, writetime, read_count, index_update) VALUES (LAST_INSERT_ID(), $user_num, '$title', '$content', '$status', '$writetime', 0, '0')";//글 내용 입력
	mysqli_query($conn, $sql);
	$sql2 = "SELECT * FROM about_question WHERE count=LAST_INSERT_ID()";
	$sql_query2 = mysqli_query($conn, $sql2);
	$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
	$description = '<a href="about_question.php?count_link='.$sql_fetch_array2["count"].'" class="link">이드마루 문의하기 게시판에 새 글이 올라왔습니다.</a>';
	$sql1 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($idmaru_user_num, 'about_question_write', LAST_INSERT_ID(), 0, '$description', '$writetime')"; // idMaru에게 새 글이 올라온 사실을 알리기
	mysqli_query($conn, $sql1);
	echo '
		<script>
			alert("글이 입력되었습니다");
			window.parent.opener.location.reload();
			window.parent.close();
		</script>
	';
?>