<?php
	include 'declare_php.php';
	if(isset($_REQUEST["id"])){$id = $_REQUEST["id"];}
	if(isset($_REQUEST["send_all"])){$send_all = $_REQUEST["send_all"];}
	else {$send_all = 0;}
	if($send_all==0){
	$sql1 = "SELECT * FROM user WHERE id='$id' AND email_certify='0'";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if(!$count1){
		echo '<script>alert("인증할 수 있는 아이디가 없습니다");</script>';
	} else {
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$temp = '';
		$pick_list = "0123456789abcdefghijklmnopqrstuvwxyz";
		for($i=0;$i<6;$i++){$temp .= $pick_list[rand(0,35)];}//6자리의 임시인증번호를 만든다
		$sql4 = "SELECT * FROM email_certify WHERE user_num=$sql_fetch_array1[user_num]";//이미 보낸 인증메일이 있는지 확인한다
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);
		if(!$count4){//예전에 보낸 인증메일이 없을경우
			$sql2 = "INSERT INTO email_certify (user_num, temp) VALUES ($sql_fetch_array1[user_num], '$temp')";
		} else if($count4){//예전에 보낸 인증메일이 있을경우
			$sql2 = "UPDATE email_certify SET temp='$temp' WHERE user_num=$sql_fetch_array1[user_num]";
		}
		mysqli_query($conn, $sql2);
		$to = $sql_fetch_array1["email"];
		$subject = 'idmaru 회원님('.$id.') 가입 인증 메일입니다.';
		$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
		$message = $email_top.'<a href="http://www.idmaru.com/web/email_certify.php?user_num='.$sql_fetch_array1["user_num"].'&temp='.$temp.'">이 문장을 누르시면 자동으로 인증 과정이 진행됩니다.</a>'.$email_bottom;
		$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=utf-8'."\r\n".'From: noreply@idmaru.com'."\r\n".'Reply-To: noreply@idmaru.com'."\r\n".'X-Mailer: PHP/'.phpversion();
		mail($to, $subject, $message, $headers);
		echo '<script>alert("인증메일이 '.$sql_fetch_array1["email"].'로 발송되었습니다.");</script>';
	}
	} else if($send_all==1){
		$sql3 = "SELECT * FROM user WHERE email_certify='0'";
		$sql_query3 = mysqli_query($conn, $sql3);
		$count3 = mysqli_num_rows($sql_query3);
		for($i=0; $i < $count3; $i++){
			$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
			$temp = '';
			$pick_list = "0123456789abcdefghijklmnopqrstuvwxyz";
			for($i=0;$i<6;$i++){$temp .= $pick_list[rand(0,35)];}//6자리의 임시인증번호를 만든다
			$sql4 = "SELECT * FROM email_certify WHERE user_num=$sql_fetch_array3[user_num]";//이미 보낸 인증메일이 있는지 확인한다
			$sql_query4 = mysqli_query($conn, $sql4);
			$count4 = mysqli_num_rows($sql_query4);
			if(!$count4){//예전에 보낸 인증메일이 없을경우
				$sql2 = "INSERT INTO email_certify (user_num, temp) VALUES ($sql_fetch_array3[user_num], '$temp')";
			} else if($count4){//예전에 보낸 인증메일이 있을경우
				$sql2 = "UPDATE email_certify SET temp='$temp' WHERE user_num=$sql_fetch_array3[user_num]";
			}
			mysqli_query($conn, $sql2);
			$to = $sql_fetch_array3["email"];
			$subject = 'idmaru 회원님('.$sql_fetch_array3["id"].') 가입 인증 메일입니다.';
			$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
			$message = $email_top.'<a href="http://www.idmaru.com/web/email_certify.php?user_num='.$sql_fetch_array3["user_num"].'&temp='.$temp.'">이 문장을 누르시면 자동으로 인증 과정이 진행됩니다.</a>'.$email_bottom;
			$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=utf-8'."\r\n".'From: noreply@idmaru.com'."\r\n".'Reply-To: noreply@idmaru.com'."\r\n".'X-Mailer: PHP/'.phpversion();
			mail($to, $subject, $message, $headers);
		}
		echo '<script>alert("인증메일이 발송되었습니다.");</script>';
	}
?>