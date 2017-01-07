<?php
	include 'header.php';
	include 'declare.php';
	if($user_num==0){exit;}
	$stranger_num=$_REQUEST["stranger_num"];
	$table_name=$_REQUEST["table_name"];
	$count=$_REQUEST["count"];
	$count_upperwrite = $_REQUEST["count_upperwrite"];
	$content=$_REQUEST["mywrite_content"];
	$writetime=date("Y-m-d, H:i:s");
	$exist = $_REQUEST["exist"];
	if($exist==0){//이전의 신고내용이 없을때
		$sql1 = "INSERT INTO stranger_call (caller_num, stranger_num, table_name, count, count_upperwrite, content, writetime) VALUES ($user_num, $stranger_num, '$table_name', $count, $count_upperwrite, '$content', '$writetime')";
	} else if($exist==1){//이전의 신고내용이 있을때
		$sql1 = "UPDATE stranger_call SET content='$content', writetime='$writetime' WHERE caller_num=$user_num AND table_name='$table_name' AND count=$count";
	}
	mysqli_query($conn, $sql1); 
	
	echo '<script>alert("신고가 접수되었습니다"); window.close();</script>';
?>