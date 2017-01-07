<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-친구의이벤트</title>
	<link rel="stylesheet" href="../plugin/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script type="text/javascript" src="../plugin/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>
<?php
	$url = "club_event_friend.php?";
	$page_name = "club_event_friend";
	$table_name = "club_event";
	$ad_fixbar_cond = "club_event_friend";
	$ad_pop_cond = "club_event_friend";
	$ad_side_cond = "club_event_friend";
	include 'declare.php';
	include 'personal.php';
	include 'list.php';
?>
	<script>
		var url = "<?php echo $url;?>";
		var page_name = "<?php echo $page_name;?>";
		var table_name = "<?php echo $table_name;?>";
		var table_name_reply = table_name+"_reply";
		var club_type = "friendEvent";
		$(document).ready(function () {
			greenStyle();
			menuClub();
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
					<a href="club_event.php"><div id="menu_square_myEvent" class="menu_square_item">나의이벤트</div></a>
					<a href="club_event_friend.php"><div id="menu_square_friendEvent" class="menu_square_item">친구이벤트</div></a>
					<a href="club_event_reply.php"><div id="menu_square_replyEvent" class="menu_square_item">나의댓글</div></a>
					<div class="menu_square_bar">|</div>
					<a href="club_group.php"><div id="menu_square_myGroup" class="menu_square_item">나의모임</div></a>
				</nav>
				<div class="page_title_expr">※ 친구들이 등록한 이벤트를 볼 수 있습니다.</div>
				<div id="list_search">
					<div id="list_search_box">
					<div id="list_search_tip" title="검색 Tip"><img src="../image/list_search_tip.png"/></div>
					<select id="list_search_category" name="list_search_category" style="left:1px;">
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
					<div id="writing_area">
<?php
	if($user_num != 0){include 'club_event_friend_recall.php';}
	else {echo '<div class="guest_inform"> 회원가입 하시면 친구가 등록한 이벤트를 볼 수 있습니다.</div>';}
?>
					</div>
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