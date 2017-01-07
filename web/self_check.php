<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-정보확인</title>
	<link type="text/css" rel="stylesheet" href="../css/login.css" />
</head>
<body>
	<h5>※ 회원 확인을 위해 아이디와 비밀번호를 입력해주세요.</h5>
	<div id="loginbox">
		<form action="self_check_confirm.php" method="post">
			<div id="idbox"><input id="id" type="text" name="id" value="" maxlength="12" tabindex="1"/></div>
			<script>document.getElementById("id").focus();//로그인박스에 focus설정</script>
			<div id="password_box"><input id="password_" type="password" name="password_" value="" maxlength="20" tabindex="2"/></div>
			<input id="enter" type="submit" value="" tabindex="3"/>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>