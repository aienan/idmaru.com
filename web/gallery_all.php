<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="Gallery, 갤러리, 사진" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-갤러리</title>
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
	$url = "gallery_all.php?";
	$page_name = "gallery_all";
	$page_type = "all";//전체보기일 경우
	$table_name = "photo";
	$ad_fixbar_cond = "gallery";
	$ad_pop_cond = "gallery";
	$ad_side_cond = "gallery";
	include 'declare.php';
	include 'personal.php';
	include 'list.php';
?>
	<script>
		var url = "<?php echo $url;?>";
		var table_name = "<?php echo $table_name;?>";
		var table_name_reply = table_name+"_reply";
<?php
	if(isset($_REQUEST["gallery_type"])){//gallery_type 변수가 넘어왔을때
		echo 'var gallery_type = "'.$_REQUEST["gallery_type"].'";';
		$gallery_type = $_REQUEST["gallery_type"];
	} else {//gallery_type 변수가 안 넘어왔을때
		echo 'var gallery_type = "all";';//selling_type에 값이 없을때
		$gallery_type = "all";
	}
	if($gallery_type=="all"){}
	else {$type = gallery_type_num($gallery_type);}
?>
		var order_column = "all";
		var gallery_type_kor = gallery_type_status(gallery_type);
		$(document).ready(function () {
			blueStyle();
			menuGallery();
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
				<a href="photo_battle.php"><div id="photo_battle" style="position:absolute; right:0px; top:0px; z-index:2;"><img src="../image/button_wc.png"/></div></a>
				<nav class="select_category">
					<div id="order_all" class="select_category_item" onclick="galleryOrderSelect('all')">등록순</div>
					<div id="order_read_count_1" class="select_category_item" onclick="galleryOrderSelect('read_count_1')">실시간</div>
					<div id="order_updown_total" class="select_category_item" onclick="galleryOrderSelect('up_total')">추천</div>
					<div id="order_read_count_7" class="select_category_item" onclick="galleryOrderSelect('read_count_7')">주간</div>
					<div id="order_read_count_30" class="select_category_item" onclick="galleryOrderSelect('read_count_30')">월간</div>
				</nav>
				<div id="category_status"></div>
				<div id="list_search">
					<div id="list_search_box">
					<div id="list_search_tip" title="검색 Tip"><img src="../image/list_search_tip.png"/></div>
					<select id="list_search_category" name="list_search_category">
						<option selected value="content"> 글내용 </option><option value="writer"> 작성자 </option>
					</select>
					<input id="list_search_word" type="text" name="list_search_word" value="" maxlength="40" tabindex=""/>
					<div id="list_search_word_button" title="검색"></div>
					<div id="list_search_word_cancel" title="검색 취소"></div>
					</div>
				</div>
				<div id="list_button">
					<div id="photo_upload" class="menu_button"></div>
				</div>
				<div class="content_area">
<?php include 'gallery_all_recall.php'; ?>
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