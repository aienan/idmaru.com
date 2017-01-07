<?php
	if(!isset($conn)){include 'mysql_setting.php';}
	if(isset($_REQUEST["type"])){$type = $_REQUEST["type"];}
	$sql1 = "SELECT * FROM photo_battle_category ORDER BY number DESC, photo_type ASC";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($type=="select"){
		$html = '<option selected value="">선택</option>';
		for($i=0; $i < $count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$html .= '<option value="'.$sql_fetch_array1["photo_type"].'">'.$sql_fetch_array1["photo_type"].' ('.$sql_fetch_array1["number"].')</option>';
		}
	} else if($type=="main_list"){
		$display_number = 100;
		if(isset($_REQUEST["start_number"])){$start_number = $_REQUEST["start_number"];}
		else {$start_number = 0;}
		$html = '';
		$sql1 = "SELECT * FROM photo_battle_category ORDER BY number DESC, photo_type ASC LIMIT $start_number, $display_number";
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
		for($i=0; $i < $count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$html .= '<div style="position:relative; height:30px;"><div class="photo_battle_item mouseover" onclick="photo_battle_start(\''.$sql_fetch_array1["photo_type"].'\')">'.$sql_fetch_array1["photo_type"].' ('.$sql_fetch_array1["number"].')</div><div class="photo_battle_rank_all button_blue" onclick="photo_battle_rank(\''.$sql_fetch_array1["photo_type"].'\', \'all\')">전체회원순위</div><div class="photo_battle_rank_mine button_green" onclick="photo_battle_rank(\''.$sql_fetch_array1["photo_type"].'\', \'mine\')">나의순위</div></div>';
		}
		if($count1==$display_number){
			$start_number_next = $start_number + $display_number;
			$html .= '
			<div id="article_moreB" onclick="photoBattleCategoryRecall(\'main_list\', '.$start_number_next.')">더 보 기</div>
			';
		}
	} else if($type=="select_list"){
		$html = '';
		for($i=0; $i < $count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$html .= '<div class="photo_battle_category_item">'.$sql_fetch_array1["photo_type"].' ('.$sql_fetch_array1["number"].')</div>';
		}
	}
	echo $html;
?>