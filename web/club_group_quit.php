<?php
	include 'header.php';
	include 'mysql_setting.php';
	$status_position = $_REQUEST["status_position"];
	$count_group = $_REQUEST["count_group"];
	$writetime = date("Y-m-d, H:i:s");
	if($status_position=="member"){//회원일 경우 (club_group_one_recall.php)
		$sql = "DELETE FROM club_group_member WHERE count_group = $count_group AND user_num = $user_num";//club_group_memeber에서 회원 지우기
		mysqli_query($conn, $sql);
		$sql2 = "SELECT * FROM club_group WHERE count_group = $count_group";//모임장의 user_num을 알아내기 위해
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$member_new = $sql_fetch_array2["member"] - 1;
		$sql13 = "UPDATE club_group SET member=$member_new WHERE count_group=$count_group";
		mysqli_query($conn, $sql13);
		$sql1 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array2[user_num], 'club_group_member_quit', $count_group, 0, '( $user_name )님이 모임( $sql_fetch_array2[group_name] )에서 탈퇴하셨습니다.', '$writetime')";//탈퇴한 사실을 모임장에게 알리기
		mysqli_query($conn, $sql1);
	} else if($status_position=="host"){//모임장일 경우 (club_group_modify.php)
		$sql3 = "SELECT * FROM club_group_member WHERE count_group = $count_group";//모임 회원의 user_num을 알아낸다
		$sql_query3 = mysqli_query($conn, $sql3);
		$count3 = mysqli_num_rows($sql_query3);
		$sql5 = "SELECT * FROM club_group WHERE count_group = $count_group";//모임의 이름을 알아낸다
		$sql_query5 = mysqli_query($conn, $sql5);
		$sql_fetch_array5 = mysqli_fetch_array($sql_query5);
		for($i=0; $i < $count3; $i++){//회원들에게 모임해체를 알림
			$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
			if($user_num != $sql_fetch_array3[user_num]){//해체한 본인에게는 home_alarm을 하지 않는다
				$sql4 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($sql_fetch_array3[user_num], 'club_group_dismissed', $count_group, 0, '모임( $sql_fetch_array5[group_name] )이 모임장에 의해 해체되었습니다.', '$writetime')";//모임 회원들에게 home_alarm을 통해 알린다
				mysqli_query($conn, $sql4);
			}
		}
		$sql = "DELETE FROM club_group_member WHERE count_group = $count_group";//club_group_memeber에서 count_group의 모든 회원 지우기
		mysqli_query($conn, $sql);
		$sql21 = "DELETE FROM club_group WHERE count_group = $count_group AND user_num = $user_num";
		mysqli_query($conn, $sql21);
		$sql22 = "INSERT INTO sphinx_delete_list (table_name, count) VALUES ('club_group', $count_group)";
		mysqli_query($conn, $sql22);
		$sql11 = "SELECT * FROM club_group_writing WHERE count_group = $count_group";//sphinx_delete_list에 글 번호를 넣기 위함
		$sql_query11 = mysqli_query($conn, $sql11);
		$count11 = mysqli_num_rows($sql_query11);
		for($i=0; $i < $count11; $i++){
			$sql_fetch_array11 = mysqli_fetch_array($sql_query11);
			$sql10 = "INSERT INTO sphinx_delete_list (table_name, count) VALUES('club_group_writing', $sql_fetch_array11[count])";//sphinx_delete_list에 지워질 row를 등록한다
			$sql_query10 = mysqli_query($conn, $sql10);
		}
		$sql6 = "DELETE FROM club_group_writing WHERE count_group = $count_group";
		mysqli_query($conn, $sql6);
		$sql7 = "DELETE FROM club_group_invite WHERE count_group = $count_group";
		mysqli_query($conn, $sql7);
		$sql9 = "SELECT * FROM club_group_writing_photo WHERE count_group=$count_group";//사진 경로 찾아내기
		$sql_query9 = mysqli_query($conn, $sql9);
		$count9 = mysqli_num_rows($sql_query9);
		for($i=0; $i < $count9; $i++){//글에 있는 사진 제거
			$sql_fetch_array9 = mysqli_fetch_array($sql_query9);
			unlink($sql_fetch_array9[photo_path]);
		}
		$sql8 = "DELETE FROM club_group_writing_photo WHERE count_group = $count_group";
		mysqli_query($conn, $sql8);
		$sql12 = "DELETE FROM home_alarm WHERE table_name='club_group_invite' AND count=$count_group";
		mysqli_query($conn, $sql12);
	}
	
?>