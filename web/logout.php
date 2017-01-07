<?php
	header("Cache-Control: public, max-age=0");
	session_start();
	$_SESSION["user_num"] = 0;
	$_SESSION["user_name"] = "Guest";
	$_SESSION["id"] = "Guest";
	$_SESSION["home_alarm"] = 0;
	$_SESSION["guest_private_not_read"] = 0;
	$_SESSION["friend_list"] = "";
	setcookie("auto_login", "", time()-1, "/", "");
	if(!isset($_COOKIE["save_id"])){setcookie("secd", "", time()-1, "/", "");}//아이디저장이 아니면 아이디를 지운다
	setcookie("secs", "", time()-1, "/", "");
	$url = $_REQUEST["url"];
	$after_logout = strtok($url, "?");
	if(isset($_REQUEST["email_change"])){//이메일 정보 수정 후 로그아웃될때
		if($_REQUEST["email_change"]==1){
			echo '<script>location.href = "idmaru.php";</script>';
		}
	} else {
		echo '<script>location.href="'.$after_logout.'";</script>';
	}
?>