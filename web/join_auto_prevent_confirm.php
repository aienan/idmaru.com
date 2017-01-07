<?php
	include 'header.php';
	require_once('../plugin/recaptchalib.php');
	$privatekey_localhost = "6Le3SdcSAAAAAA9KUHw9Q6r_IfV_rtdeHkitFcFV";
	$privatekey_idmaru = "6LetSdcSAAAAANoUcqtaw2oyxM3YZbSaFgXuN7oe";
	$resp = recaptcha_check_answer ($privatekey_idmaru, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
	if (!$resp->is_valid) {// What happens when the CAPTCHA was entered incorrectly
		echo '
			<script>
				alert("자동가입방지 코드를 정확히 입력해주세요");
				location.href = "join_auto_prevent.php";
			</script>
		';
		die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." ."(reCAPTCHA said: " . $resp->error . ")");
	} else {//자동가입방지 코드를 제대로 입력했을경우
		$_SESSION["auto_prevent"]=1;
		echo '<script>location.href = "join.php";</script>';
	}
?>