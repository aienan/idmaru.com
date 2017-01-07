<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-회원가입</title>
	<link type="text/css" rel="stylesheet" href="../css/join.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript">
		var RecaptchaOptions = {theme : 'clean'};
	</script>
	<script>
		$(document).ready(function () {
		});
	</script>
</head>
<body>
	<form method="POST" action="join_auto_prevent_confirm.php">
		<div class="title">자동 가입 방지</div>
		<div>※ 두 단어를 입력해주세요. 두 단어를 붙여써도 되고 대소문자는 구분하지 않아도 됩니다.<br/>단어가 어려울경우 <a href="javascript:Recaptcha.reload()"><img src="../image/auto_prevent_refresh.png"/> <span style="font-size:11pt;">(보안문자 새로 받기)</span></a> 버튼을 눌러보세요.</div><br/>
		<div class="item">
<?php
	require_once('../plugin/recaptchalib.php');
	$publickey_localhost = "6Le3SdcSAAAAAAZkY9GwM_rcuQK01eQuyP2N_7jQ";
	$publickey_idmaru = "6LetSdcSAAAAADv9dFdwsUSOHSNvfKHm5OXA7_UA";
	echo recaptcha_get_html($publickey_idmaru);
?>
		</div>
		<input id="auto_prevent_submit" type="submit" value="다음 단계" class="button_gb"/>
	</form>
	<div id="temp_target"></div>
</body>
</html>