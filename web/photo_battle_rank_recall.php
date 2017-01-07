<?php
	include 'header.php';
	include 'declare_php.php';
	$type = $_REQUEST["type"];
	$user = $_REQUEST["user"];
	$start_number = $_REQUEST["start_number"];
	$print_number = $_REQUEST["print_number"];
	if($user=="all"){
		$user_title = "전체 회원 순위";
		$sql1 = "SELECT count, AVG(score) AS average FROM photo_battle_score WHERE photo_type='$type' GROUP BY count ORDER BY average DESC LIMIT $start_number, $print_number";
	} else if($user=="mine"){
		$user_title = "나의 순위";
		$sql1 = "SELECT count, score FROM photo_battle_score WHERE photo_type='$type' AND user_num=$user_num ORDER BY score DESC LIMIT $start_number, $print_number";
	}
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM photo WHERE count=$sql_fetch_array1[count]";
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$rank_number = $start_number + $i + 1;
		$img_tag = img_adjust(get_thumbnail_path($sql_fetch_array2["photo_path"]), 102, 122);
		if($i % 5==0){echo '<div class="relative">';}
		echo '
			<div class="photo_battle_rank_item">
				<div class="photo_battle_rank_number">'.$rank_number.' 위</div>
				<div class="photo_battle_path input_gray" onclick="photo_click(\''.$sql_fetch_array2["photo_path"].'\', \'photo\', '.$sql_fetch_array1["count"].')"><div class="relative">'.$img_tag.'</div></div>
			</div>
		';
		if( ($i == ($count1 - 1)) || ($i % 5==4) ){echo '</div>';}
	}
	echo '<script>
			if(user=="all"){
				$("#user_title").css({"color":"#377EB6"});
				$("#photo_battle_list").css({"border":"#98C0E2 1px solid"});
				$(".photo_battle_divide1").css({"border-bottom":"#98C0E2 2px solid"});
				$(".photo_battle_path").hover(function(){
					$(this).css({"border":"#98C0E2 1px solid"});
				}, function(){
					$(this).css({"border":"#CCCCCC 1px solid"});
				});
			} else if(user=="mine"){
				$("#user_title").css({"color":"#A2BA45"});
				$("#photo_battle_list").css({"border":"#A3D964 1px solid"});
				$(".photo_battle_divide1").css({"border-bottom":"#A3D964 2px solid"});
				$(".photo_battle_path").hover(function(){
					$(this).css({"border":"#A3D964 1px solid"});
				}, function(){
					$(this).css({"border":"#CCCCCC 1px solid"});
				});
			}
		</script>
	';
	if($count1==$print_number){$start_number += $print_number; echo '<div id="article_moreB" onclick="photo_battle_more('.$start_number.')">더 보 기</div>';}
	if($count1==0){echo 'x';}
?>