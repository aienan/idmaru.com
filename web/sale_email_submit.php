<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$count = $_REQUEST["count"];
	$title = $_REQUEST["mywrite_title"];
	$content = $_REQUEST["mywrite_content"];
	$sql2 = "SELECT * FROM sale WHERE count=$count";//장터의 글 작성자 번호 추출
	$sql_query2 = mysqli_query($conn, $sql2);
	$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
	$sql1 = "SELECT * FROM user WHERE user_num=$sql_fetch_array2[user_num]";//장터글 작성자의 Mail 주소 추출
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$sql3 = "SELECT * FROM user WHERE user_num=$user_num";//메일 보내는 사람의 Mail 주소 추출
	$sql_query3 = mysqli_query($conn, $sql3);
	$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
	$to = $sql_fetch_array1["email"];
	$subject = $title;
	$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
	$message = $email_top.$content.'<p style="margin:50px 0 0 0;">보낸 분의 E-Mail 주소 : '.$sql_fetch_array3["email"].'</p>'.$email_bottom;
	$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=utf-8'."\r\n".'From: norely@idmaru.com'."\r\n".'Reply-To: noreply@idmaru.com'."\r\n".'X-Mailer: PHP/'.phpversion();
	mail($to, $subject, $message, $headers);
	echo '<script>alert("이메일이 전송되었습니다"); window.close();</script>';
?>