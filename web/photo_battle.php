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
<?php include 'declare.php';?>
<?php include 'personal.php';?>
<?php
	$url = "photo_battle.php?";
	$type = 'main_list';
	$ad_fixbar_cond = "photo_battle";
	$ad_pop_cond = "photo_battle";
	$ad_side_cond = "photo_battle";
?>
	<script>
		var url = "<?php echo $url;?>";
		var table_name = "photo_battle";
		$(document).ready(function () {
			blueStyle();
			menuPhotoBattle();
			$("#photo_battle_list").css({"border":"#98C0E2 1px solid"});
			$("#photo_battle_category_enroll").click(function(){
				window.open("photo_battle_category_enroll.php", "photo_battle_category_enroll", "width=770,height=685,resizable=yes,scrollbars=yes,location=no");
			});
		});
		function photo_battle_start(type){
			location.href="photo_battle_ing.php?type="+type;
		}
		function photo_battle_rank(type, user){
			if(user=="mine" && user_name=="Guest"){
				alert("로그인 후 이용해주세요");
			}else {
				window.open("photo_battle_rank.php?type="+type+"&user="+user, "_self", "");
			}
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
				<div class="relative">
				<div class="bold c_FF8383 center" style="margin:30px 0;">이상형월드컵은 여러분이 더 좋아하는 것을 선택하고 순위를 매기는 경기입니다. <br/> 여러분이 순위를 매기고 싶은 것들을 자유롭게 올리고 선택해주세요 ! ^^</div>
				<div id="photo_battle_category_enroll" class="inline pointer" style="margin:0 0 0 20px;"><img src="../image/battle_category_enroll.png"/></div>
				<div id="photo_battle_submit" class="inline"><img src="../image/button_photo_battle.jpg"/></div>
				</div>
				<div id="photo_battle_list">
					<div class="relative font11 bold photo_battle_divide1" style="margin:0 0 20px 0; height:22px; border-bottom:#98C0E2 2px solid; line-height:1.4;"><div class="absolute" style="padding:0 15px 0 5px; left:0px; bottom:-2px; color:#F24141; border-bottom:#F24141 2px solid;"><img src="../image/photo_battle_iconA.png" style="position:absolute; left:0px; top:0px;"/> <span style="padding:0 60px 0 40px;">이상형월드컵</span></div></div>
<?php include 'photo_battle_category_recall.php';?>
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