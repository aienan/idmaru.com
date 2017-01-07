<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>idMaru-이상형 월드컵</title>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<link rel="stylesheet" href="../plugin/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script type="text/javascript" src="../plugin/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>
<?php 
	$url = "photo_battle.php?";
	$ad_fixbar_cond = "photo_battle";
	$ad_pop_cond = "photo_battle";
	$ad_side_cond = "photo_battle";
	 include 'declare.php';
	 include 'personal.php';
	$type = $_REQUEST["type"];
	$user = $_REQUEST["user"];
	$print_number = 100;
	$print_number_start = $print_number - 2;
	$start_number = 0;
	$start_number_box = $start_number + 4;
	if($user=="all"){
		$user_title = "전체 회원 순위";
		$sql1 = "SELECT count, AVG(score) AS average FROM photo_battle_score WHERE photo_type='$type' GROUP BY count ORDER BY average DESC LIMIT $start_number, $print_number_start";
	} else if($user=="mine"){
		$user_title = "나의 순위";
		$sql1 = "SELECT count, score FROM photo_battle_score WHERE photo_type='$type' AND user_num=$user_num ORDER BY score DESC LIMIT $start_number, $print_number_start";
	}
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
?>
	<script>
		var url = "<?php echo $url;?>";
		var table_name = "photo_battle";
		var type = "<?php echo $type;?>";
		var user = "<?php echo $user;?>";
		$(document).ready(function () {
			blueStyle();
			menuPhotoBattle();
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
			start_number_box = $("#photo_battle_start_num").val();
			print_number = <?php echo $print_number;?>;
			$("#photo_battle_start_num").blur(function(){
				var photo_battle_start_num = $("#photo_battle_start_num").val();
				var photo_battle_start_numB = photo_battle_start_num - 1;
				if(isNumber(photo_battle_start_num)==false){
					alert("숫자만 입력 가능합니다");
					$("#photo_battle_start_num").val(start_number_box);
				} else if(photo_battle_start_num==start_number_box){
				} else if(photo_battle_start_num < 4){
					alert("4 이상의 숫자만 가능합니다");
					$("#photo_battle_start_num").val(start_number_box);
				} else {
					$.ajax({
						url: "photo_battle_rank_recall.php",
						data: {type:type, user:user, start_number:photo_battle_start_numB, print_number:<?php echo $print_number;?>},
						success: function(getdata){
							if(getdata == 'x'){
								alert(photo_battle_start_num+"위 이상의 순위가 없습니다");
								$("#photo_battle_start_num").val(start_number_box);
							} else {
								$("#photo_battle_listB").html(getdata);
								start_number_box = photo_battle_start_num;
							}
						}
					});
				}
			});
			enterAndBlur("#photo_battle_start_num");
		});
		function photo_battle_more(start_number){
			$("#article_moreB").remove();
			$.ajax({
				url: 'photo_battle_rank_recall.php',
				data: {type:type, user:user, start_number:start_number, print_number:<?php echo $print_number;?>},
				success: function(getdata){
					if(getdata != "x"){$("#photo_battle_listB").append(getdata);}
				}
			});
		}
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body>
	<div id="toparea">
<?php include 'toparea.php'; ?>
	</div>
	<div id="bodyarea">
		<div id="mainbar">
			<div id="mainbody">
				<a href="photo_battle.php"><div id="page_title" title="이상형월드컵 메인가기"></div></a>
				<div class="bold c_FF8383  ">* 위의 그림을 누르시면 메인으로 돌아갑니다</div>
				<div id="photo_battle_submit"><img src="../image/button_photo_battle.jpg"/></div>
				<div class="relative font11 bold photo_battle_divide1" style="margin:20px; height:22px; border-bottom:#98C0E2 2px solid; line-height:1.4;"><div class="absolute" style="padding:0 15px 0 5px; left:0px; bottom:-2px; color:#F24141; border-bottom:#F24141 2px solid;"><img src="../image/photo_battle_iconA.png" style="position:absolute; left:0px; top:0px;"/> <span style="padding:0 0 0 33px;"><?php echo $type.' 순위보기';?></span></div><div id="user_title" class="absolute font10" style="right:0px; bottom:0px;"><?php echo $user_title;?></div></div>
				<div id="photo_battle_list" class="relative">
<?php
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM photo WHERE count=$sql_fetch_array1[count]";
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$rank_number = $i + 1;
		$img_tag = img_adjust(get_thumbnail_path($sql_fetch_array2["photo_path"]), 102, 122);
		if($i==0){echo '<div class="relative" style="padding:0 0 0 10px;"><img src="../image/photo_battle_iconB.png" style="margin:0 10px 0 0;"/><img src="../image/photo_battle_iconC.png" style="margin:0 10px 0 0;"/><img src="../image/photo_battle_iconD.png"/></div>';}
		if( ($i==0) || (($i - 3) % 5==0) ){echo '<div class="relative">';}
		echo '
			<div class="photo_battle_rank_item">
				<div class="photo_battle_rank_number">'.$rank_number.' 위</div>
				<div class="photo_battle_path input_gray" onclick="gallery_one('.$sql_fetch_array1["count"].')"><div class="relative">'.$img_tag.'</div></div>
			</div>
		';
		if( ($i==2) || ($i == ($count1 - 1)) || (($i - 3) % 5==4) ){echo '</div>';}
		if($i==2){
			echo '
			<div id="photo_battle_divide1" class="relative photo_battle_divide1" style="margin:40px 0 0 0;"></div>
			<div class="relative" style="margin:0 0 40px 0;"><input id="photo_battle_start_num" class="absolute input_gray center" type="text" name="photo_battle_start_num" value="'.$start_number_box.'" maxlength="4" style="padding:2px; width:28px; right:2px; top:0px;" title="시작순위"/></div>
			<div id="photo_battle_listB">
		';}
	}
	if($count1==$print_number_start){$start_number += $print_number_start; echo '<div id="article_moreB" onclick="photo_battle_more('.$start_number.')">더 보 기</div>';}
	if($count1==0){echo '집계된 결과가 없습니다.';}
?>
					</div>
				</div>
<?php include 'ad_textA.php';?>
			</div>
		</div>
<?php include 'sidebar.php'; ?>
	</div>
	<div id="endarea">
<?php include 'pineforest.php'; ?>
	</div>
	<div id="temp_target"></div>
</body>
</html>