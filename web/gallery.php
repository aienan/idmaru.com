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
	$url = "gallery.php?";
	$ad_fixbar_cond = "gallery";
	$ad_pop_cond = "gallery";
	$ad_side_cond = "gallery";
	include 'declare.php';
	include 'personal.php';
?>
	<script>
		var type_name = "gallery";//php_tile_list에서 사용
		var display_number = 40;
		var url = "<?php echo $url;?>";
		var url_all = "gallery_all.php?";//검색시에 전체뉴스로 이동
<?php
	if(isset($_REQUEST["gallery_type"])){//gallery_type 변수가 넘어왔을때
		echo 'var gallery_type = "'.$_REQUEST["gallery_type"].'";';
		$gallery_type = $_REQUEST["gallery_type"];
	} else {//gallery_type 변수가 안 넘어왔을때
		echo 'var gallery_type = "all";';//selling_type에 값이 없을때
		$gallery_type = "all";
	}
	if(isset($_REQUEST["order_column"])){//order_column 변수가 넘어왔을때
		echo '
			var order_column = "'.$_REQUEST["order_column"].'";
		';
		$order_column = $_REQUEST["order_column"];
	} else {//order_column 변수가 안 넘어왔을때
		echo 'var order_column = "read_count_1";';
		$order_column = "read_count_1";
	}
?>
		var gallery_type_kor = gallery_type_status(gallery_type);
		$(document).ready(function () {
			<?php include 'list_tile.php'; ?>
			blueStyle();
			menuGallery();
			$.ajax({
				url:'gallery_common_order_recall.php',
				data: {count_start:count_start, display_number:display_number, height_total:height_total, width_total:width_total, gallery_type:gallery_type, order_column:order_column},
				success: function(getdata){
					$("#gallery_article_area").append(getdata);
					$("#loading_more").remove();
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
				<a href="photo_battle.php"><div id="photo_battle" style="position:absolute; right:0px; top:0px; z-index:2;"><img src="../image/button_wc.png"/></div></a>
				<nav class="select_category">
					<div id="order_all" class="select_category_item" onclick="galleryOrderSelect('all')">등록순</div>
					<div id="order_read_count_1" class="select_category_item" onclick="galleryOrderSelect('read_count_1')">실시간</div>
					<div id="order_up_total" class="select_category_item" onclick="galleryOrderSelect('up_total')">추천</div>
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
					<div id="photo_upload" class="menu_button link"></div>
					<input id="list_start_number_set" type="text" name="list_start_number_set" value="" maxlength="4" tabindex="" title="목록 시작번호"/>
				</div>
				<div id="loading_more" class="loading48x48" style="left:340px;"></div>
				<div id="gallery_article_area" class="tile_area"></div>
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