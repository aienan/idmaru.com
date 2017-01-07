<?php
	$sql = "SELECT * FROM home_alarm WHERE user_num=$user_num";//새소식이 있는지 확인
	$sql_query = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($sql_query);
	if($count){//새소식이 있을경우
		$_SESSION["home_alarm"] = 1;
	} else if(!$count){//새소식이 없을경우
		$_SESSION["home_alarm"] = 0;
	}
	$sql1 = "SELECT * FROM guest_private WHERE user_num_receive=$user_num AND read_check='0'";//새 방명록이 있는지 확인
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count1){//새 방명록이 있을경우
		$_SESSION["guest_private_not_read"] = 1;
	} else if(!$count1){//새 방명록이 없을경우
		$_SESSION["guest_private_not_read"] = 0;
	}
?>