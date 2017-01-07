<?php
	include 'header.php';
	include 'declare_php.php';
	$total_array = $_REQUEST["total_array"];
	$type = $_REQUEST["type"];
	$total_array_num = count($total_array);
	echo '
		<div class="relative font11 bold photo_battle_divide1" style="margin:20px; height:22px; border-bottom:#98C0E2 2px solid; line-height:1.4;"><div class="absolute" style="padding:0 15px 0 5px; left:0px; bottom:-2px; color:#F24141; border-bottom:#F24141 2px solid;"> <img src="../image/photo_battle_iconA.png" style="position:absolute; left:0px; top:0px;"/> <span style="padding:0 0 0 33px;"> '.$type.' 경기 결과</span></div></div>
		<div id="photo_battle_result_area" style="margin:10px 20px;">
	';
	$border = 2; // image div의 border
	for($i = ($total_array_num - 1); $i >= 0 ; $i--){
		if($i==($total_array_num - 1)){
			$image_width = 105;
			$left_end_space = 310;
			$margin_pic = 0; // image 간의 margin
		} else if($i==($total_array_num - 2)){
			$image_width = 90;
			$left_end_space = 243;
			$margin_pic = 56;
		} else if($i==($total_array_num - 3)){
			$image_width = 74;
			$left_end_space = 136;
			$margin_pic = 50;
		} else if($i==($total_array_num - 4)){
			$image_width = 60;
			$left_end_space = 21;
			$margin_pic = 26;
		} else if($i==($total_array_num - 5)){
			$image_width = 40;
			$left_end_space = 4;
			$margin_pic = 3;
		}
		$image_height = (int)($image_width * 1.2);
		$relative_box_height = $image_height + $border;
		if($i==($total_array_num - 1)){echo '<div class="relative" style="padding:20px 0 0 348px;"><img src="../image/photo_battle_4result.png"/></div>';}
		else if($i==($total_array_num - 2)){echo '<div class="relative" style="padding:0 0 0 9px;"><img src="../image/photo_battle_3result.jpg"/></div>';}
		else if($i==($total_array_num - 3)){echo '<div class="relative" style="padding:0 0 0 13px;"><img src="../image/photo_battle_2result.jpg"/></div>';}
		else if($i==($total_array_num - 4)){echo '<div class="relative" style="padding:0 0 0 12px;"><img src="../image/photo_battle_1result.jpg"/></div>';}
		else if($i==($total_array_num - 5)){echo '<div class="relative" style="padding:0 0 0 10px;"><img src="../image/photo_battle_0result.jpg"/></div>';}
		echo '
			<div class="relative" style="padding:0 0 0 '.$left_end_space.'px; height:'.$relative_box_height.'px;">
		';
		foreach($total_array[$i] as $key => $value){
			$sql1 = "SELECT * FROM photo WHERE count=$value";
			$sql_query1 = mysqli_query($conn, $sql1);
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			if($i==($total_array_num - 1)){echo '<div class="result_image relative input_gray inline_block" style="margin:0 '.$margin_pic.'px 0 0; width:'.$image_width.'px; height:'.$image_height.'px;" onclick="gallery_one('.$value.')"><img src="../image/photo_battle_iconE.png" class="absolute zindex1" style="left:-1px; top:-1px;"/><img src="../image/photo_battle_iconF.png" class="absolute zindex1" style="right:-1px; top:-1px;"/>'.img_adjust(get_thumbnail_path($sql_fetch_array1["photo_path"]), $image_width, $image_height).'</div>';}
			else {echo '<div class="result_image relative input_gray inline_block" style="margin:0 '.$margin_pic.'px 0 0; width:'.$image_width.'px; height:'.$image_height.'px;" onclick="gallery_one('.$value.')">'.img_adjust(get_thumbnail_path($sql_fetch_array1["photo_path"]), $image_width, $image_height).'</div>';}
		}
		echo '</div>';
	}
	echo '
		</div>
		<script>
			$("#photo_battle_type").html("");
			$("#photo_battle_alarm").html("");
		</script>
	';
?>