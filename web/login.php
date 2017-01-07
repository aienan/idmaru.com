<?php
	include 'header.php';
	include 'declare_php.php';
	$auto_login_set = $_REQUEST["auto_login_set"];
	$save_id_set = $_REQUEST["save_id_set"];
	if($auto_login_set!="agree"){
		$id=$_REQUEST['id'];
		$password_=$_REQUEST['password_'];
		$password_hashed = hash('sha256', $password_);//비밀번호 암호화
	} else if($auto_login_set=="agree"){
		if(isset($_REQUEST["id"])){$id=$_REQUEST["id"];}
		else{$id = $_REQUEST["secd"];}
		if(isset($_REQUEST["password_"])){$password_ = $_REQUEST["password_"]; $password_hashed = hash('sha256', $password_);}
		else{$password_hashed = $_REQUEST["secs"];}
	}
	if($save_id_set=="agree"){//아이디저장 여부
		setcookie("save_id", "agree", time()+31536000, "/", "");//아이디저장 승인
		setcookie("secd", $id, time()+31536000, "/", "");//아이디 저장
	}else if($save_id_set!="agree"){
		setcookie("save_id", "", time()-1, "/", "");
		setcookie("secd", "", time()-1, "/", "");
	}
	if($auto_login_set=="agree"){//자동로그인 여부
		setcookie("auto_login", "agree", time()+31536000, "/", "");//자동로그인 승인
		setcookie("secd", $id, time()+31536000, "/", "");//아이디 저장
		setcookie("secs", $password_hashed, time()+31536000, "/", "");//비밀번호 저장
	}else{
		setcookie("auto_login", "", time()-1, "/", "");
		setcookie("secs", "", time()-1, "/", "");
	}
	$sql = "SELECT * FROM user WHERE id='$id'";
	$sql_query = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($sql_query);
	$sql_fetch_array = mysqli_fetch_array($sql_query);
	if(!$count) {//아이디가 존재하지 않을경우
		echo "no_id";
		exit;
	} else if($sql_fetch_array["user_stop"]=='1'){//회원탈퇴한 계정일경우
		echo "user_stop";
		exit;
	} else if($sql_fetch_array["user_stop"]=='2'){//강제정지된 계정일경우
		echo "user_banned";
		exit;
	} else if($sql_fetch_array["email_certify"]=='0'){
		echo "email_certify";
		exit;
	} else if ($password_hashed != $sql_fetch_array["password_"]) {//비밀번호가 맞지 않을경우
		echo "no_password";
		exit;
	} else if ($password_hashed==$sql_fetch_array["password_"]) {//모든 검사를 통과할경우
		$_SESSION['user_num'] = $sql_fetch_array["user_num"];
		$_SESSION['user_name'] = $sql_fetch_array["user_name"];
		$_SESSION['id'] = $id;
		$_SESSION['remote_addr'] = get_ip();
		$_SESSION["friend_list"] = friend_list($sql_fetch_array["user_num"]);
		$manager_id_true = 0;
		foreach(array("aienan", "funnyguy") as $manager_id) {
			if($manager_id == $id){
				$manager_id_true = 1;
				break;
			}
		}
		$idmaru_id = '/^idmaru/';
		if(!preg_match($idmaru_id, $id) && ($manager_id_true==0)){
			$fp = fopen("../files/login.txt", "a");
			$fp_string = date("Y-m-d, H:i:s")."\t".$id."\t\t".$_SESSION["remote_addr"]."\n";
			fputs($fp, $fp_string);
			fclose($fp);
		}
		$sql1 = "SELECT * FROM home_alarm WHERE user_num=$sql_fetch_array[user_num]";//사용자에게 온 알람이 있는지 확인
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
		if($count1){//알람이 있을경우
			$_SESSION["home_alarm"] = 1;
		} else if(!$count1){//알람이 없을경우
			$_SESSION["home_alarm"] = 0;
		}
		$sql2 = "SELECT * FROM guest_private WHERE user_num_receive=$sql_fetch_array[user_num] AND read_check='0'";
		$sql_query2 = mysqli_query($conn, $sql2);
		$count2 = mysqli_num_rows($sql_query2);
		if($count2){//아직 읽지 않은 것이 있을경우
			$_SESSION["guest_private_not_read"] = 1;
		} else if(!$count2){// 모두 읽었을경우
			$_SESSION["guest_private_not_read"] = 0;
		}
		$sql3 = "INSERT INTO user_analyze (user_num, login) VALUES ($sql_fetch_array[user_num], 1) ON DUPLICATE KEY UPDATE login=login+1";
		mysqli_query($conn, $sql3);
		echo "success";
	}
?>