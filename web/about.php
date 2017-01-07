<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="이드마루, customer center, 고객센터, customer, 고객, member, member center" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-고객센터</title>
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
	$ad_fixbar_cond = "about";
	$ad_pop_cond = "about";
	$ad_side_cond = "about";
?>
	<script>
		var about_type = "idmaru";
		$(document).ready(function () {
			blueStyle();
			menuAbout();
			$("#send_to_idmaru").click(function(){
				if(user_name=="Guest"){
					alert("로그인 후 이용해주세요");
				} else {
					window.open("guest_private_write.php?user_num_receive=1", "guest_private_write", "width=770,height=500,resizable=no,scrollbars=yes,location=no");
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
<?php
	if(is_idmaru_id($user_name)==1){
		echo '
			<a href="manager_page.php"><div id="manager_page" class="button_gb" style="position:absolute; right:0px; top:0px;">관리자 화면</div></a>
		';
	}
?>
				<div class="contentArea c_00274E">
					<fieldset class="about_idmaru round_border" style="height:140px;">
						<legend class="about_idmaru_title">idMaru (이드마루) 란?</legend>
							<div id="about_idmaru_maru">마루</div>
							<div id="about_idmaru_maru1">어떤 사물의 첫째. 또는 어떤 일의 기준.</div>
							<div id="about_idmaru_maru2">[하늘]을 뜻하는 순 우리말.</div>
							<div id="about_idmaru_desc">세상의 기준(마루)이 되는 생각(idea)과 자아의 근원(이드, id).</div>
					</fieldset>
					<fieldset class="about_idmaru round_border" style="margin:30px 0; height:480px;">
						<legend class="about_idmaru_title">이드마루 이야기</legend>
						<div class="story_member" style="margin:25px 0 0 0; height:210px;">
							<div class="story_photo"><img src="../image/hur.jpg" width="250";  /></div>
							<div class="story_info" style="padding:15px 0 0 25px;">
									안녕하세요~ 이드마루 개발자입니다.<br/>
									2011년 12월까지만 해도 저는 전기전자를 전공하는 평범한 대학원생이었습니다.<br/>
									그로부터 1년 후, 저는 잘 알지 못하던 분야에서 꿈을 위해 열심히 일하고 있습니다.<br/>
									여러분~ 노력하면 이루지 못할 것은 없다고 생각합니다!<br/>
									우리 모두 더 행복한 세상을 만들어 나가도록 노력해요~ ^^ 
							</div>
						</div>
						<div class="story_member" style="height:200px;">
							<div class="story_photo"><img src="../image/next.jpg" width="250";  /></div>
							<div class="story_info" style="padding:5px 0 0 25px;">
								<h5>다음 주인공은?</h5>
								<div class="story_info_content" style="padding:10px 0 10px 0;">
									이드마루에서는 함께 일할 분을 찾습니다!<br/>
									경력이 없으셔도 괜찮습니다.<br/>
									열정과 패기 하나면 충분합니다~<br/>
									이드마루와 함께 자신이 원하는 서비스를 개발해보고 싶은 분은 연락주시기 바랍니다. ^^
								</div>
								<div><img id="send_to_idmaru" class="mouseover" src="../image/about_call.png"/></div>
							</div>
						</div>
					</fieldset>
					<fieldset class="about_idmaru round_border" style="margin:10px 0;">
						<legend class="about_idmaru_title">문의하기</legend>
						<div>이드마루에 궁금하신 점이 있으시면 무엇이든 물어보세요. ^^</div>
						<a href="about_question.php"><img src="../image/about_ask.png"/ style="position:absolute; right:15px; top:28px;"></a>
					</fieldset>
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