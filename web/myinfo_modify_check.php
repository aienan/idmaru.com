<?php
	include 'header.php';
	include 'declare_php.php';
	$password_=$_POST['password_'];
	$password_confirm=$_POST['password_confirm'];
	$email=$_POST['email'];
	$email_before=$_POST['email_before'];
	$familyname=$_POST['familyname'];
	$firstname=$_POST['firstname'];
	$sex=$_POST['sex'];
	$birthday_y=$_POST['birthday_y'];
	$birthday_m=$_POST['birthday_m'];
	$birthday_d=$_POST['birthday_d'];
	$add_country=$_POST['add_country'];
	$add_region=$_POST['add_region'];
	$add_detail=$_POST['add_detail'];
	$email_refuse=$_POST["email_refuse"];
	// $phone=$_POST['phone'];
	if (strlen($password_) < 4) {
		echo"
			<script>
				alert(\"비밀번호의 길이는 4자 이상이어야 합니다.\");
				history.go(-1);
			</script>
		";
		exit;
	} else if ($password_ != $password_confirm) {
		echo"
			<script>
				alert(\"비밀번호가 같은지 확인해주세요.\");
				history.go(-1);
			</script>
		";
		exit;
	} else if (!$email) {
		echo"
			<script>
				alert(\"E-Mail을 입력해주세요.\");
				history.go(-1);
			</script>
		";
		exit;
	}
	$password_hashed = hash('sha256', $password_);
	if($email==$email_before){//email 주소가 바뀌지 않았을경우
		$sql = "UPDATE user SET password_='$password_hashed', familyname='$familyname', firstname='$firstname', sex='$sex', birthday_y='$birthday_y', birthday_m='$birthday_m', birthday_d='$birthday_d', add_country='$add_country', add_region='$add_region', add_detail='$add_detail', email_refuse='$email_refuse' WHERE user_num=$user_num";
		mysqli_query($conn, $sql);
		echo"
			<script>
				alert(\"회원정보가 수정되었습니다\");
				location.href=\"myinfo.php\";
			</script>
		";
	} else {//email 주소가 바뀌었을경우
		$sql = "UPDATE user SET password_='$password_hashed', email='$email', email_certify='0', familyname='$familyname', firstname='$firstname', sex='$sex', birthday_y='$birthday_y', birthday_m='$birthday_m', birthday_d='$birthday_d', add_country='$add_country', add_region='$add_region', add_detail='$add_detail', email_refuse='$email_refuse' WHERE user_num=$user_num";
		mysqli_query($conn, $sql);
		$pick_list = "0123456789abcdefghijklmnopqrstuvwxyz";
		for($i=0;$i<6;$i++){$temp .= $pick_list[rand(0,35)];}//6자리의 임시인증번호를 만든다
		$sql4 = "SELECT * FROM email_certify WHERE user_num=$user_num";//이미 보낸 인증메일이 있는지 확인한다
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);
		if(!$count4){//예전에 보낸 인증메일이 없을경우
			$sql2 = "INSERT INTO email_certify (user_num, temp) VALUES ($user_num, '$temp')";
		} else if($count4){//예전에 보낸 인증메일이 있을경우
			$sql2 = "UPDATE email_certify SET temp='$temp' WHERE user_num=$user_num";
		}
		mysqli_query($conn, $sql2);
		$to = $email;
		$subject = 'idmaru 회원님('.$user_name.') 이메일 정보 인증 메일입니다.';
		$subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
		$message = $email_top.'<a href="http://www.idmaru.com/web/email_certify.php?user_num='.$user_num.'&temp='.$temp.'">이 문장을 누르시면 자동으로 인증 과정이 진행됩니다.</a>'.$email_bottom;
		$headers = 'MIME-Version: 1.0'."\r\n".'Content-type: text/html; charset=utf-8'."\r\n".'From: noreply@idmaru.com'."\r\n".'Reply-To: noreply@idmaru.com'."\r\n".'X-Mailer: PHP/'.phpversion();
		mail($to, $subject, $message, $headers);
		echo '
			<script>
				alert("회원정보가 수정되고 인증용 이메일이 '.$email.'로 발송되었습니다. 이메일 인증을 진행해 주시기 바랍니다.");
				location.href="logout.php?email_change=1";
			</script>
		';
	}
	
	exit;
?>