<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-집</title>
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
<?php //광고 문구 조건 설정
	$ad_fixbar_cond = "home";
	$ad_pop_cond = "home";
	$ad_side_cond = "home";
?>
	<script>
		var home_type = 'home';
		$(document).ready(function () {
			greenStyle();
			menuHome();
			if(user_name != "Guest"){
				$.ajax({
					url:'home_alarm.php',
					data: {},
					success: function(getdata){
						$('#home_alarm').append(getdata);
						$(".loading24x24").css("display", "none");
					}
				});
			}
			$("#home_alarm_delete").click(function(){
				if(user_num==0){alert("로그인 후 이용해주세요");}
				else {
					if(home_alarm_none==1){//알람이 없을때
						alert("확인할 메세지가 없습니다");
					} else if ($(".home_alarm_one_delete").length == 0){//알림이나 공지는 있지만 확인용 메세지가 없을때
						alert("알림과 공지를 제외하고 확인할 메세지가 없습니다");
					} else {//알림이나 공지가 있고 확인용 메세지가 있을때
						var reply = confirm("알림과 공지를 제외한 메세지를 모두 확인하셨습니까?");
						if(reply==true){
							var delete_type = "all_confirm";
							$.ajax({
								url:'home_alarm_delete.php',
								data: {delete_type:delete_type},
								success: function(getdata){
									location.reload();
								}
							});
						}
					}
				}
			});
		});
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
				<header id="page_title"></header>
				<nav class="menu_square">
					<a href="home.php"><div id="menu_square_home" class="menu_square_item">새소식</div></a>
					<a href="home_friend.php"><div id="menu_square_friend" class="menu_square_item">친구관리</div></a>
				</nav>
				<div class="content_area">
				<div id="home_alarm">
					<div class="content_title_green" style="margin:0 0 10px 0;">&nbsp; 새로운 소식<div id="home_alarm_delete" class="button_gb">모두확인</div></div>
<?php
	if($user_name!="Guest"){
		echo '
					<div class="loading24x24" style="left:350px;"></div>
		';
	}
	if($user_name=="Guest"){
		echo '
					<div class="home_alarm_one">  회원 가입 후, 새로운 소식을 받아보실 수 있습니다.</div>
		';
	}
?>
				</div>
				<div style="margin:20px 0 0 0;"><?php include 'ad_textA.php';?></div>
				</div>
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