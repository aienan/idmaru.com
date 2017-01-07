<?php
	include 'mysql_setting.php';
	$user_num = $_REQUEST["user_num"];
	$temp = $_REQUEST["temp"];
	$writetime = date("Y-m-d, H:i:s");
	$sql1 = "SELECT * FROM email_certify WHERE user_num=$user_num AND temp='$temp'";//인증코드를 제대로 가지고 있는지 검사
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count1){//인증코드가 맞을경우
		$sql2 = "DELETE FROM email_certify WHERE user_num=$user_num AND temp='$temp'";
		mysqli_query($conn, $sql2);//email_certify의 내용을 지운다
		$sql3 = "UPDATE user SET email_certify='1' WHERE user_num=$user_num";
		mysqli_query($conn, $sql3);//user 테이블에 이메일이 인증됐다고 등록한다
		echo '
			<script>
				alert("e-mail 인증이 완료되었습니다. 로그인해주세요.");
				location.href = "http://www.idmaru.com/";
			</script>
		';
		$sql4 = "SELECT * FROM manager_news WHERE count=0";
		$sql_query4 = mysqli_query($conn, $sql4);
		$sql_fetch_array4 = mysqli_fetch_array($sql_query4);
		$sql5 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($user_num, 'manager_news', 1, 0, '$sql_fetch_array4[title]', '$writetime')";
		mysqli_query($conn, $sql5);
	} else {
		echo '
			<script>alert("인증코드가 맞지 않습니다. 이드마루 관리자에 문의해주세요."); location.href = "http://www.idmaru.com/";</script>
		';
	}
?>