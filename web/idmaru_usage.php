<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="idmaru, 이드마루, SNS, 소셜, portal, 포털, secondhand, market, 중고, 거래, fun, 흥미, photo, 사진, news, 뉴스, event, 이벤트" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루 이용약관</title>
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
	$ad_fixbar_cond = "pineforest_policy";
	$ad_pop_cond = "pineforest_policy";
	$ad_side_cond = "pineforest_policy";
?>
	<script>
		$(document).ready(function () {
			blueStyle();
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
				<div class="title_name" style="margin:15px;"><img src="../image/list_pine.png" style="position:relative; top:2px;"/> 이드마루 이용백서</div>
				<img src="../image/episode1a_idmaru.jpg"/>
				<img src="../image/episode1b_idmaru.jpg"/>
				<img src="../image/episode1c_idmaru.jpg"/><hr/>
				<img src="../image/episode2_idmaru.jpg"/><hr/>
				<img src="../image/episode3a_idmaru.jpg"/>
				<img src="../image/episode3b_idmaru.jpg"/>
				<img src="../image/episode3c_idmaru.jpg"/>
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