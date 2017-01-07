<?php
	include 'declare_php.php';
	$type = $_REQUEST["type"];
	$battle_round_total = $_REQUEST["battle_round_total"];
	$battle_round_step = $_REQUEST["battle_round_step"];
	$battle_round_count = $_REQUEST["battle_round_count"];
	$count1 = $_REQUEST["count1"];
	$count2 = $_REQUEST["count2"];
	$battle_stage = $battle_round_total / pow(2, $battle_round_step - 1);
	if($battle_stage==16){$battle_round_word = '<span class="font11 c_FF4200" style="color:#FF4200;">'.$battle_stage.'강</span> - '.$battle_round_count.' 대결';}
	else if($battle_stage==8){$battle_round_word = '<span class="font11 c_FF4200" style="color:#FF4200;">'.$battle_stage.'강</span> - '.$battle_round_count.' 대결';}
	else if($battle_stage==4){$battle_round_word = '<span class="font11 c_FF4200" style="color:#FF4200;">준결승</span> - '.$battle_round_count.' 대결';}
	else if($battle_stage==2){$battle_round_word = '<span class="font12" style="color:#FF4200;">결승전</span>';}
	$img_length = 350;
	$padding = 2;
	$img_area = $img_length + $padding * 2;
	$sql1 = "SELECT * FROM photo WHERE count=$count1";
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$sql2 = "SELECT * FROM photo WHERE count=$count2";
	$sql_query2 = mysqli_query($conn, $sql2);
	$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
	$photo1 = img_adjust($sql_fetch_array1["photo_path"], $img_length, $img_length);
	$photo2 = img_adjust($sql_fetch_array2["photo_path"], $img_length, $img_length);
	echo '
		<div id="photo_battle_stage" class="bold center" style="margin:0 0 30px 0;">'.$battle_round_word.'</div>
		<div id="photo_battle_random" class="pointer absolute" style="right:0px; top:0px;" onclick="random_select('.$count1.', '.$count2.', '.$battle_round_step.', '.$battle_round_count.')" title="임의선택"><img src="../image/photo_battle_random.png"/></div>
		<div id="photo_battle_container">
		<div id="photo_battle_A" style="width:'.$img_area.'px;">
			<div id="photo_battle_A_pic" style="position:relative; width:'.$img_length.'px; height:'.$img_length.'px;" onclick="next_round('.$count1.', '.$count2.', '.$battle_round_step.', '.$battle_round_count.')">'.$photo1.'</div>
			<div id="photo_battle_A_desc" style="height:100px;">'.$sql_fetch_array1["content"].'<div class="stranger_call inline" onclick="stranger_call('.$sql_fetch_array1["user_num"].', \'photo\', '.$sql_fetch_array1["count"].')" style="margin:0 0 0 10px; top:1px;" title="신고"><img src="../image/stranger_call.png"/></div></div>
		</div>
		<div class="absolute" style="left:361px; top:157px;"><img src="../image/photo_battle_vs.png"/></div>
		<div id="photo_battle_B" style="width:'.$img_area.'px;">
			<div id="photo_battle_B_pic" class="" style="position:relative; width:'.$img_length.'px; height:'.$img_length.'px;" onclick="next_round('.$count2.', '.$count1.', '.$battle_round_step.', '.$battle_round_count.')">'.$photo2.'</div>
			<div id="photo_battle_B_desc" style="height:100px;">'.$sql_fetch_array2["content"].'<div class="stranger_call inline" onclick="stranger_call('.$sql_fetch_array2["user_num"].', \'photo\', '.$sql_fetch_array2["count"].')" style="margin:0 0 0 10px; top:1px;" title="신고"><img src="../image/stranger_call.png"/></div></div>
		</div>
		</div>
	';
?>