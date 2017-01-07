<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$title=$_REQUEST["mywrite_title"];
	$title = replace_symbols($title);
	$content=$_REQUEST["mywrite_content"];
	$content = error_modify($content);
	$status=$_REQUEST["status"];
	$write_new=$_REQUEST["write_new"];
	if($status=="party"){
		$status = 1;
	} else if($status=="social"){
		$status = 2;
	} else if($status=="volunteer"){
		$status = 3;
	}
	$start_time_y=$_REQUEST["start_time_y"];
	if($start_time_y==0){$start_time_y = '';}
	$start_time_m=$_REQUEST["start_time_m"];
	$start_time_d=$_REQUEST["start_time_d"];
	$end_time_y=$_REQUEST["end_time_y"];
	if($end_time_y==9999){$end_time_y = '';}
	$end_time_m=$_REQUEST["end_time_m"];
	$end_time_d=$_REQUEST["end_time_d"];
	$table_name = "club_event";
	include 'photo_check.php';
	$sql = "INSERT INTO club_event (count, user_num, title, content, status, start_time_y, start_time_m, start_time_d, end_time_y, end_time_m, end_time_d, read_count, up_total, index_update) VALUES (LAST_INSERT_ID(), $user_num, '$title', '$content', '$status', '$start_time_y', '$start_time_m', '$start_time_d', '$end_time_y', '$end_time_m', '$end_time_d', 0, 0, '0')";//글 내용 입력
	mysqli_query($conn, $sql); 
	echo '
		<script>
			alert("글이 입력되었습니다");
			if(window.parent.opener.location.href.search(/club/) != -1){window.parent.opener.location.reload();}
			window.parent.close();
		</script>
	';
	
?>

