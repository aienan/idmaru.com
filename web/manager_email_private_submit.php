<?php
	include 'header.php';
	include 'declare_php.php';
	$mywrite_from = $_REQUEST["mywrite_from"];
	$mywrite_to = $_REQUEST["mywrite_to"];
	$title = $_REQUEST["mywrite_title"];
	$content = $_REQUEST["mywrite_content"];
	$subject = $title;
	$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
	$message = $email_top.$content.$email_bottom;
	$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=utf-8'."\r\n".'From: '.$mywrite_from."\r\n".'Reply-To: '.$mywrite_from."\r\n".'X-Mailer: PHP/'.phpversion();
	mail($mywrite_to, $subject, $message, $headers);
	echo '<script>alert("개별 이메일이 전송되었습니다"); location.href = "manager_email_private.php";</script>';
	
?>