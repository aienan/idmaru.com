<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-사진</title>
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
	$url = "photo.php?";
	$page_name = "photo";
	$table_name = "photo";
	$ad_fixbar_cond = "photo";
	$ad_pop_cond = "photo";
	$ad_side_cond = "photo";
	include 'declare.php';
	include 'personal.php';
	include 'list.php';
?>
	<script>
		var url = "<?php echo $url;?>";
		var page_name = "<?php echo $page_name;?>";
		var table_name = "<?php echo $table_name;?>";
		var table_name_reply = table_name+"_reply";
		var photo_type = "mine";
<?php
	if(isset($_REQUEST["gallery_type"])){//gallery_type 변수가 넘어왔을때
		echo '
			var gallery_type = "'.$_REQUEST["gallery_type"].'";
		';
		$gallery_type = $_REQUEST["gallery_type"];
	} else {//gallery_type 변수가 안 넘어왔을때
		echo 'var gallery_type = "all";';//selling_type에 값이 없을때
		$gallery_type = "all";
	}
?>
		$(document).ready(function () {
			greenStyle();
			menuPhoto();
			$("#photo_watch").change(function(){
				var status = $("#photo_watch").val();
				location.href = url + "gallery_type="+gallery_type + "&status="+status;
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
					<a href="photo.php"><div id="menu_square_mine" class="menu_square_item">나의사진</div></a>
					<a href="photo_friend.php"><div id="menu_square_friend" class="menu_square_item">친구사진</div></a>
					<a href="photo_reply.php"><div id="menu_square_reply" class="menu_square_item">나의댓글</div></a>
				</nav>
				<div class="page_title_expr">※ 회원님이 등록하신 사진을 볼 수 있습니다.</div>
<?php echo $select_category_gallery;?>
				<div id="list_search">
					<div id="list_search_box">
					<div id="list_search_tip" title="검색 Tip"><img src="../image/list_search_tip.png"/></div>
					<select id="list_search_category" name="list_search_category">
						<option selected value="content">글내용</option>
					</select>
					<input id="list_search_word" type="text" name="list_search_word" value="" maxlength="40" tabindex=""/>
					<div id="list_search_word_button" title="검색"></div>
					<div id="list_search_word_cancel" title="검색 취소"></div>
					</div>
				</div>
				<div id="list_button">
					<div id="photo_upload" class="menu_button link"></div>
					<select id="photo_watch" name="photo_watch">
						<option  value="4"> 전체 </option><option value="1"> 모두 </option><option value="2"> 친구 </option><option value="3"> 비공개 </option>
					</select>
				</div>
				<div class="content_area">
<?php
	if($user_num != 0){include 'photo_recall.php';}
	else {echo '<div class="guest_inform"> 회원가입 하시면 idMaru 갤러리에 사진을 등록할 수 있습니다.</div>';}
?>
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