<?php
	include 'header.php';
	$id=$_POST['id'];
	$password_=$_POST['password_'];
	$password_confirm=$_POST['password_confirm'];
	$email=$_POST['email'];
	$familyname=$_POST['familyname'];
	$firstname=$_POST['firstname'];
	$sex=$_POST['sex'];
	$birthday_y=$_POST['birthday_y'];
	$birthday_m=$_POST['birthday_m'];
	$birthday_d=$_POST['birthday_d'];
	$add_country=$_POST['add_country'];
	$add_region=$_POST['add_region'];
	$add_detail=$_POST['add_detail'];
	$clause_agree=$_POST['clause_agree'];
	echo "<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js\"></script>";
	if (strlen($id) < 4 || strlen($id) > 12) {	// 값이 제대로 입력되었는지를 검사
		echo"
			<script>
				alert(\"ID를 양식에 맞게 입력해주세요.\");
				location.href=\"join.php\";
			</script>
		";
		exit;
	} elseif (strlen($password_) < 4) {
		echo"
			<script>
				alert(\"비밀번호의 길이는 4자 이상이어야 합니다.\");
				location.href=\"join.php\";
			</script>
		";
		exit;
	} elseif ($password_ != $password_confirm) {
		echo"
			<script>
				alert(\"비밀번호가 같은지 확인해주세요.\");
				location.href=\"join.php\";
			</script>
		";
		exit;
	} elseif (!$email) {
		echo"
			<script>
				alert(\"E-Mail을 입력해주세요.\");
				location.href=\"join.php\";
			</script>
		";
		exit;
	} elseif (!$clause_agree) {
		echo"
			<script>
				alert(\"회원 약관에 동의해주셔야 가입할 수 있습니다.\");
				location.href=\"join.php\";
			</script>
		";
		exit;
	}
	$password_hashed = hash('sha256', $password_);
	include 'mysql_setting.php';
	$sql = "INSERT INTO counter (name, value) VALUES('user', LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE value = LAST_INSERT_ID(value+1)";
	mysqli_query($conn, $sql);
	$sql = "INSERT INTO user (user_num, id, password_, email, email_certify, familyname, firstname, sex, birthday_y, birthday_m, birthday_d, add_country, add_region, add_detail, user_name, email_refuse, user_stop) VALUES (LAST_INSERT_ID(), '$id', '$password_hashed', '$email', '0', '$familyname', '$firstname', '$sex', '$birthday_y', '$birthday_m', '$birthday_d', '$add_country', '$add_region', '$add_detail', '$id', '0', '0')";
	mysqli_query($conn, $sql); 
	$temp = "";
	$pick_list = "0123456789abcdefghijklmnopqrstuvwxyz";
	for($i=0;$i<6;$i++){$temp .= $pick_list[rand(0,35)];}//6자리의 임시인증번호를 만든다
	$sql2 = "INSERT INTO email_certify (user_num, temp) VALUES (LAST_INSERT_ID(), '$temp')";
	mysqli_query($conn, $sql2);
	$sql3 = "SELECT * FROM email_certify WHERE user_num=LAST_INSERT_ID()";
	$sql_query3 = mysqli_query($conn, $sql3);
	$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
	$to = $email;
	$subject = 'idmaru 회원님('.$id.')의 가입 인증 메일입니다.';
	$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
	$message = $email_top.'<a href="http://www.idmaru.com/web/email_certify.php?user_num='.$sql_fetch_array3["user_num"].'&temp='.$temp.'">이 문장을 누르시면 자동으로 인증 과정이 진행됩니다.</a>'.$email_bottom;
	$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=utf-8'."\r\n".'From: noreply@idmaru.com'."\r\n".'Reply-To: noreply@idmaru.com'."\r\n".'X-Mailer: PHP/'.phpversion();
	mail($to, $subject, $message, $headers);
	$sql6 = "SELECT * FROM user WHERE id='$id'";
	$sql_query6 = mysqli_query($conn, $sql6);
	$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
	$writetime = date("Y-m-d, H:i:s");
	$message_content = "이드마루에 가입해주셔서 감사합니다~\r\n더욱더 좋은 웹사이트로 성원에 보답하겠습니다. ^^";
	$sql4 = "INSERT INTO counter (name, value) VALUES('guest_private', LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE value = LAST_INSERT_ID(value+1)";
	mysqli_query($conn, $sql4);
	$sql5 = "INSERT INTO guest_private (count, user_num_receive, user_num_send, content, writetime, read_check, receiver_dont_see, sender_dont_see, index_update) VALUES (LAST_INSERT_ID(), $sql_fetch_array6[user_num], 1, '$message_content', '$writetime', '0', '0', '0', '0')";
	mysqli_query($conn, $sql5);
	unset($_SESSION["auto_prevent"]);//자동가입방지 확인용 session 변수 제거
	echo"
		<script>location.href=\"join_confirm.php\";</script>
	";
	
?>