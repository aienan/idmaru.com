<?php
	include 'declare_php.php';
	$find_password_id = $_REQUEST["find_password_id"];
	$find_password_email = $_REQUEST["find_password_email"];
	$sql1 = "SELECT * FROM user WHERE id='$find_password_id' AND email = '$find_password_email'";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count1){
		$temp = '';
		$pick_list = "0123456789abcdefghijklmnopqrstuvwxyz";
		for($i=0;$i<6;$i++){$temp .= $pick_list[rand(0,35)];}//6자리의 임시인증번호를 만든다
		$password_hashed = hash('sha256', $temp);
		$sql2 = "UPDATE user SET password_='$password_hashed' WHERE id='$find_password_id'";//비밀번호를 교체한다
		mysqli_query($conn, $sql2);
		$to = $find_password_email;
		$subject = 'idmaru 회원님('.$find_password_id.')의 임시 비밀번호를 보내드립니다.';
		$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
		$message = $email_top.'회원님의 임시 비밀번호는 <span style="background-color:#FFF286;">'.$temp.'</span> 입니다.'.$email_bottom;
		$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=utf-8'."\r\n".'From: noreply@idmaru.com'."\r\n".'Reply-To: noreply@idmaru.com'."\r\n".'X-Mailer: PHP/'.phpversion();
		mail($to, $subject, $message, $headers);
	} else if(!$count1){
		echo "notcorrectinfo";
	}
	
?>