<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$count_group = $_REQUEST["count_group"];
	$title=$_REQUEST["mywrite_title"];
	$title = replace_symbols($title);
	$content=$_REQUEST["mywrite_content"];
	$content = error_modify($content);
	$write_new=$_REQUEST["write_new"];
	$writetime = date("Y-m-d, H:i:s");
	$table_name = "club_group_writing";
	include 'photo_check.php';
	$sql = "INSERT INTO club_group_writing (count, count_group, user_num, title, content, writetime, read_count, index_update) VALUES (LAST_INSERT_ID(), $count_group, $user_num, '$title', '$content', '$writetime', 0, '0')";//글 내용 입력
	mysqli_query($conn, $sql); 
	echo '
		<script>
			alert("글이 입력되었습니다");
			window.parent.opener.location.reload();
			window.parent.close();
		</script>
	';
	
?>

