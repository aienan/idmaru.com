<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="Event, 이벤트" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-이벤트</title>
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
	$url = "event_all.php?";
	$page_name = "event_all";
	$page_type = "all";//전체보기일 경우
	$table_name = "club_event";
	$ad_fixbar_cond = "event";
	$ad_pop_cond = "event";
	$ad_side_cond = "event";
	include 'declare.php';
	include 'personal.php';
	include 'list.php';
?>
	<script>
		var url = "<?php echo $url;?>";
		var table_name = "<?php echo $table_name;?>";
		var table_name_reply = table_name+"_reply";
<?php
	if(isset($_REQUEST["event_type"])){//event_type 변수가 넘어왔을때
		echo '
			var event_type = "'.$_REQUEST["event_type"].'";
		';
		$event_type = $_REQUEST["event_type"];
	} else {//event_type 변수가 안 넘어왔을때
		echo 'var event_type = "list";';//selling_type에 값이 없을때
		$event_type = "list";
	}
?>
		var event_type_kor = event_type_status(event_type);
		var page_name = "<?php echo $page_name;?>";
		$(document).ready(function () {
			blueStyle();
			menuEvent();
			date_set_change();
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
					<a href="event.php"><div id="menu_square_tile" class="menu_square_item">타일형</div></a>
					<a href="event_all.php"><div id="menu_square_list" class="menu_square_item">목록형</div></a>
				</nav>
				<div id="list_search">
					<div id="list_search_box">
					<div id="list_search_tip" title="검색 Tip"><img src="../image/list_search_tip.png"/></div>
					<select id="list_search_category" name="list_search_category">
						<option selected value="all_content">전체</option><option value="writer"> 작성자 </option><option value="title"> 제목 </option><option value="content"> 글내용 </option>
					</select>
					<input id="list_search_word" type="text" name="list_search_word" value="" maxlength="40" tabindex=""/>
					<div id="list_search_word_button" title="검색"></div>
					<div id="list_search_word_cancel" title="검색 취소"></div>
					</div>
				</div>
				<div id="list_button">
					<div id="club_event_admit" class="menu_button" onclick="club_event_admit()"></div>
				</div>
				<div class="content_area">
<?php include 'event_all_recall.php';?>
<?php include 'ad_textA.php';?>
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