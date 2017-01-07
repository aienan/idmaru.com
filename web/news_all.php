<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="News, 뉴스" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-뉴스</title>
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
	$url = "news_all.php?";
	$page_name = "news_all";
	$page_type = "all";
	$table_name = "writing";
	$ad_fixbar_cond = "news";
	$ad_pop_cond = "news";
	$ad_side_cond = "news";
	include 'declare.php';
	include 'personal.php';
	include 'list.php';
?>
	<script>
		var url = "<?php echo $url;?>";
		var page_name = "<?php echo $page_name;?>";
		var table_name = "<?php echo $table_name;?>";
		var table_name_reply = table_name+"_reply";
<?php
	if(isset($_REQUEST["news_type"])){//news_type 변수가 넘어왔을때
		echo '
			var news_type = "'.$_REQUEST["news_type"].'";
		';
		$news_type = $_REQUEST["news_type"];
	} else {//news_type 변수가 안 넘어왔을때
		echo 'var news_type = "all";';//selling_type에 값이 없을때
		$news_type = "all";
	}
	if($news_type=="all"){}
	else {$type = news_type_num($news_type);}
?>
		var order_column = "all";
		var news_type_kor = news_type_status(news_type);
		$(document).ready(function () {
			blueStyle();
			menuNews();
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
				<nav class="select_category">
					<div id="order_all" class="select_category_item" onclick="newsOrderSelect('all')">등록순</div>
					<div id="order_read_count_1" class="select_category_item" onclick="newsOrderSelect('read_count_1')">실시간</div>
					<div id="order_updown_total" class="select_category_item" onclick="newsOrderSelect('updown_total')">추천</div>
					<div id="order_read_count_7" class="select_category_item" onclick="newsOrderSelect('read_count_7')">주간</div>
					<div id="order_read_count_30" class="select_category_item" onclick="newsOrderSelect('read_count_30')">월간</div>
				</nav>
				<div id="category_status"></div>
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
					<div id="writing_write" class="menu_button mouseover"></div>
				</div>
				<div class="content_area">
<?php include 'news_all_recall.php';?>
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