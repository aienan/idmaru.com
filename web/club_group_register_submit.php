<?php
	include 'header.php';
	include 'declare_php.php';
	$keyword=$_REQUEST["keyword"];
	$description = $_REQUEST["description"];
	$keyword = replace_symbols($keyword);
	$description = replace_symbols($description);
	$status = $_REQUEST["status"];
	$max_num = $_REQUEST["max_num"];
	$sql1 = "SELECT * FROM club_group WHERE group_name = '$keyword'";//모임 이름이 이미 있는지 검색
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count1 >= 1){//모임이름이 등록되어 있을 때
		echo "already";
	} else if($count1==0){//그룹이름이 없을 때
		$sql3 = "SELECT * FROM club_group WHERE user_num = $user_num";//사용자가 등록한 모임 수를 검색
		$sql_query3 = mysqli_query($conn, $sql3);
		$count3 = mysqli_num_rows($sql_query3);
		if($count3 >= $max_num){//사용자가 등록한 모임수가 max_num을 넘었을 때
			echo "max_num";
		} else if($count3 < $max_num){//사용자가 등록한 모임수가 max_num을 넘지 않았을 때
			$sql = "INSERT INTO counter (name, value) VALUES('club_group', LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE value = LAST_INSERT_ID(value+1)";
			mysqli_query($conn, $sql);
			$sql2 = "INSERT INTO club_group (count_group, user_num, member, group_name, description, status) VALUES (LAST_INSERT_ID(), $user_num, 1, '$keyword', '$description', '$status')";
			mysqli_query($conn, $sql2);
			$sql2 = "INSERT INTO club_group_member (count_group, user_num) VALUES (LAST_INSERT_ID(), $user_num)";
			mysqli_query($conn, $sql2);
			echo "done";
		}
	}
	
?>