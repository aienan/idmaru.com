<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$content=$_REQUEST["mywrite_content"];
	$content = replace_symbols($content);
	$writetime = date("Y-m-d, H:i:s");
	if(!$_REQUEST["name_receive"]){//아이디를 직접 쳐서 쪽지를 보내지 않은 경우
		$user_num_receive=$_REQUEST["user_num_receive"];
		$sql2 = "SELECT * FROM guest_message_refuse WHERE user_num=$user_num_receive AND refuse_user_num=$user_num";
		$sql_query2 = mysqli_query($conn, $sql2);
		$count2 = mysqli_num_rows($sql_query2);
		if($count2){echo '<script>alert("쪽지보내기가 차단 당하신 상태입니다");</script>';}
		else {
			$sql = "INSERT INTO counter (name, value) VALUES('guest_private', LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE value = LAST_INSERT_ID(value+1)";
			mysqli_query($conn, $sql);
			$sql = "INSERT INTO guest_private (count, user_num_receive, user_num_send, content, writetime, read_check, receiver_dont_see, sender_dont_see, index_update) VALUES (LAST_INSERT_ID(), $user_num_receive, $user_num, '$content', '$writetime', '0', '0', '0', '0')";
			mysqli_query($conn, $sql);
			echo '<script>alert("쪽지가 전송되었습니다");</script>';
		}
	} else if($name_receive = $_REQUEST["name_receive"]){//아이디를 직접 쳐서 쪽지를 보낸 경우
		$sql1 = "SELECT * FROM user WHERE nickname='$name_receive' OR id='$name_receive'";//아이디가 일치하는지 확인
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
		if($count1){//닉네임과 아이디가 일치하는 경우
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$user_num_receive = $sql_fetch_array1["user_num"];
			$sql2 = "SELECT * FROM guest_message_refuse WHERE user_num=$user_num_receive AND refuse_user_num=$user_num";
			$sql_query2 = mysqli_query($conn, $sql2);
			$count2 = mysqli_num_rows($sql_query2);
			if($count2){echo '<script>alert("쪽지보내기가 차단 당하신 상태입니다");</script>';}
			else {
				$sql = "INSERT INTO counter (name, value) VALUES('guest_private', LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE value = LAST_INSERT_ID(value+1)";
				mysqli_query($conn, $sql);
				$sql = "INSERT INTO guest_private (count, user_num_receive, user_num_send, content, writetime, read_check, receiver_dont_see, sender_dont_see, index_update) VALUES (LAST_INSERT_ID(), $user_num_receive, $user_num, '$content', '$writetime', '0', '0', '0', '0')";
				mysqli_query($conn, $sql); 
				echo '<script>alert("쪽지가 전송되었습니다");</script>';
			}
		} else if(!$count1){//닉네임과 아이디가 일치하지 않는 경우
			echo '<script>alert("수신자를 다시 한번 확인해주세요");</script>';
		}
	}
	
?>