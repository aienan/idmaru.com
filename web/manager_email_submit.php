<?php
	include 'header.php';
	include 'declare_php.php';
	$title = $_REQUEST["mywrite_title"];
	$content = $_REQUEST["mywrite_content"];
	$sql1 = "SELECT * FROM user WHERE user_stop='0' AND email_refuse='0'";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	// $count1 = 1;
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$to = $sql_fetch_array1["email"];
		// $to = 'seraff@hanmail.net';
		$subject = $title;
		$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
		$message = $email_top.$content.$email_bottom;
		$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=utf-8'."\r\n".'From: noreply@idmaru.com'."\r\n".'Reply-To: noreply@idmaru.com'."\r\n".'X-Mailer: PHP/'.phpversion();
		mail($to, $subject, $message, $headers);
	}
	echo '<script>alert("공지 이메일이 전송되었습니다"); location.href = "manager_email.php";</script>';
?>