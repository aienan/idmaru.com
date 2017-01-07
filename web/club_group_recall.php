<?php
	include 'mysql_setting.php';
	$output = '';
	$sql4 = "SELECT * FROM club_group_member WHERE user_num = $user_num";//사용자가 가입한 모임 검색
	$sql_query4 = mysqli_query($conn, $sql4);
	$count4 = mysqli_num_rows($sql_query4);
	$output .= '<div id="list_box">';
	if($count4 != 0){
		$output .= '
			<div id="list_head">
				<div id="club_group_list_founder">모&nbsp;임&nbsp;장</div>
				<div id="club_group_list_title">모&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;임</div>
				<div id="club_group_list_status">회원수</div>
			</div>
		';
	} else if($count4==0){
		$output .= '<div class="empty_list">등록한 모임이 없습니다</div>';
	}
	for($i=0; $i<$count4; $i++){//검색결과 출력
		$sql_fetch_array4 = mysqli_fetch_array($sql_query4);
		$sql1 = "SELECT * FROM club_group WHERE count_group = '$sql_fetch_array4[count_group]'";//모임장의 user_num을 알아본다
		$sql_query1 = mysqli_query($conn, $sql1);
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM user WHERE user_num = $sql_fetch_array1[user_num]";//모임장의 아이디를 알아본다
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$html = '
			<div id="club_group_area_article'.$sql_fetch_array4["count_group"].'" style="position:relative;">
				<div class="club_group_founder">'.$sql_fetch_array2["id"].'</div>
				<a href="club_group_one.php?count_group='.$sql_fetch_array4["count_group"].'"><div class="club_title_group">'.$sql_fetch_array1["group_name"].'</div></a>
				<div class="club_status_group">'.$sql_fetch_array1["member"].'</div>
			</div>
			<script>
				var height = $("#club_group_area_article'.$sql_fetch_array4["count_group"].' .club_title_group").height();
				$("#club_group_area_article'.$sql_fetch_array4["count_group"].' .club_group_founder").height(height);
				$("#club_group_area_article'.$sql_fetch_array4["count_group"].' .club_status_group").height(height);
				$("#club_group_area_article'.$sql_fetch_array4["count_group"].'").height(height+10);
			</script>
		';
		$output .= $html;
	}
	$output .= '</div>';
	echo $output;//결과물과 list를 함께 출력
	
?>