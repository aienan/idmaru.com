<?php
	include 'header.php';
	$id=$_POST['id'];
	$password_=$_POST['password_'];
	echo "<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js\"></script>";
	if(!$id) {
		echo"
			<script>
				$(document).ready(function() {
					alert('아이디를 입력해주세요.');
					history.go(-1);
				});
			</script>
		";
		exit;
	} elseif (!$password_) {
		echo"
			<script>
				$(document).ready(function() {
					alert('비밀번호를 입력해주세요.');
					history.go(-1);
				});
			</script>
		";
		exit;
	}
	$password_hashed = hash('sha256', $password_);
	include 'mysql_setting.php';
	$sql = "SELECT * FROM user WHERE user_num=$user_num";
	$sql_query = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($sql_query);
	$sql_fetch_array = mysqli_fetch_array($sql_query);
	
	if(!$count) {
		echo"
			<script>
				$(document).ready(function() {
					alert(\"존재하지 않는 아이디입니다.\");
					history.go(-1);
				});
			</script>
		";
		exit;
	} else if(strtolower($_POST["id"]) != strtolower($sql_fetch_array["id"])){
		echo"
			<script>
				$(document).ready(function() {
					alert(\"아이디가 일치하지 않습니다.\");
					history.go(-1);
				});
			</script>
		";
		exit;
	} else if ($password_hashed != $sql_fetch_array["password_"]) {
		echo"
			<script>
				$(document).ready(function() {
					alert(\"비밀번호를 정확히 입력해주세요.\");
					history.go(-1);
				});
			</script>
		";
		exit;
	} else if ($password_hashed == $sql_fetch_array["password_"]) {
		$_SESSION['myinfo_modify'] = "yes";
		echo"
			<script>
				$(document).ready(function() {
					parent.parent.location.href = 'myinfo_modify.php';
					parent.$.fancybox.close();
				});
			</script>
		";
		exit;
	}
?>