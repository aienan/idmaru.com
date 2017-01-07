<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$title=$_REQUEST["mywrite_title"];
	$title = replace_symbols($title);
	$content=$_REQUEST["mywrite_content"];
	$content = error_modify($content);
	$status=$_REQUEST["status"];
	if($status=="all"){
		$status = 1;
	} else if($status=="friend"){
		$status = 2;
	} else if($status=="private"){
		$status = 3;
	}
	$write_new=$_REQUEST["write_new"];
	$type=$_REQUEST["news_type"];
	$writetime = date("Y-m-d, H:i:s");
	$table_name = "writing";
	include 'photo_check.php';
	$sql = "INSERT INTO writing (count, user_num, type, title, content, status, writetime, read_count, updown_total, index_update) VALUES (LAST_INSERT_ID(), $user_num, $type, '$title', '$content', '$status', '$writetime', 0, 0, '0')";//글 내용 입력
	mysqli_query($conn, $sql); 
	$sql2 = "INSERT INTO writing_read_counter (count, status, type, read_count_1, read_count_7, read_count_30) VALUES (LAST_INSERT_ID(), '$status', $type, 0, 0, 0)";
	mysqli_query($conn, $sql2);
	echo '
		<script>
			alert("글이 입력되었습니다");
			if(window.parent.opener.location.href.search(/writing/) != -1){window.parent.opener.location.reload();}//글쓰기에 있을때 페이지 새로고침
			window.parent.close();
		</script>
	';
?>