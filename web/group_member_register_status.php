<?php
	include 'header.php';
	include 'mysql_setting.php';
	$count_group = $_REQUEST["count_group"];
	$sql1 = "SELECT * FROM home_alarm WHERE table_name='club_group_invite' AND count=$count_group";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$output = "";
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num]";
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$output .= '<div id="write_friend_name_'.$i.'" class="write_friend_name mouseover">'.$sql_fetch_array2["user_name"].' ('.$sql_fetch_array2["familyname"].' '.$sql_fetch_array2["firstname"].')</div><script>$("#write_friend_name_'.$i.'").click(function(){$("#id_yours_input").val("'.$sql_fetch_array2["user_name"].'");})</script>';
	}
	if($count1==0){$output .= '<div class="write_friend_name">초대된 회원이 없습니다</div>';}
	echo $output;
	
?>