<?php
	include 'header.php';
	include 'mysql_setting.php';
	$sql2 = "SELECT * FROM user WHERE user_num=$user_num";
	$sql_query2 = mysqli_query($conn, $sql2);
	$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
	$sql1 = "UPDATE user SET password_=NULL, email=NULL, email_certify=NULL, familyname=NULL, firstname=NULL, nickname=NULL, sex=NULL, birthday_y=NULL, birthday_m=NULL, birthday_d=NULL, add_country=NULL, add_region=NULL, add_detail=NULL, phone=NULL, user_name='$sql_fetch_array2[id]', user_stop='1' WHERE user_num=$user_num";
	mysqli_query($conn, $sql1);
	$sql3 = "SELECT * FROM sale WHERE user_num=$user_num";//장터에 등록된 글 삭제
	$sql_query3 = mysqli_query($conn, $sql3);
	$count3 = mysqli_num_rows($sql_query3);
	for($i=0; $i < $count3; $i++){
		$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
		echo '
			<script>
				$.ajax({
					url: "delete_write.php",
					data: {table_name:"sale", count:'.$sql_fetch_array3["count"].'},
					success: function(getdata){}
				});
			</script>
		';
	}
	$sql4 = "DELETE FROM sale_reserve_box WHERE user_num=$user_num";//장바구니 정보 지우기
	mysqli_query($conn, $sql4);
	$sql5 = "DELETE FROM user_memo WHERE user_num=$user_num";//메모장 글 지우기
	mysqli_query($conn, $sql5);
	$sql6 = "DELETE FROM club_group_admit WHERE user_num_admit=$user_num";//가입 신청한 모임 정보 지우기
	mysqli_query($conn, $sql6);
	
	$_SESSION["user_num"] = 0;
	$_SESSION["user_name"] = "Guest";
	$_SESSION["id"] = "Guest";
	$_SESSION["home_alarm"] = 0;
	$_SESSION["guest_private_not_read"] = 0;
	$_SESSION["friend_list"] = "";
?>