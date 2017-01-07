<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$content=$_REQUEST["mywrite_content"];
	$content = replace_symbols($content);
	$exist=$_REQUEST["exist"];
	if($exist==1){//전에 쓴 메모가 있을경우
		$sql1 = "UPDATE user_memo SET content='$content' WHERE user_num=$user_num";
	} else if($exist==0){//처음 쓰는 메모일경우
		$sql1 = "INSERT INTO user_memo (user_num, content) VALUES ($user_num, '$content')";
	}
	mysqli_query($conn, $sql1); 
?>