<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-모임</title>
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
	$count_group = $_REQUEST["count_group"];
	$url = 'club_group_one.php?count_group='.$count_group.'&'; // club_group_one_recall에서 사용
	$page_name = "club_group_one";
	$table_name = "club_group_writing";
	$ad_fixbar_cond = "club_group_one";
	$ad_pop_cond = "club_group_one";
	$ad_side_cond = "club_group_one";
	include 'declare.php';
	$sql7 = "SELECT * FROM club_group_writing WHERE count_group = $count_group";//모임에 글이 있는지 확인
	$sql_query7 = mysqli_query($conn, $sql7);
	$count7 = mysqli_num_rows($sql_query7);
	$sql8 = "SELECT * FROM club_group_member WHERE count_group=$count_group AND user_num=$user_num";//모임의 회원인지 확인
	$sql_query8 = mysqli_query($conn, $sql8);
	$count8 = mysqli_num_rows($sql_query8);
	include 'personal.php';
	include 'list.php';
?>
	<script>
		var url = "<?php echo $url;?>";
		var page_name = "<?php echo $page_name;?>";
		var table_name = "<?php echo $table_name;?>";
		var table_name_reply = table_name+"_reply";
		var count_group = <?php echo $count_group; ?>;
		var club_type = "myGroup";
<?php
	if(!$count_group || $user_num==0 || $count8==0){
		echo 'location.href="club_group.php";';
		$count_group = 0;
	}
?>
		$(document).ready(function () {
			greenStyle();
			menuClub();
		});
		function write_modify_club_group(count){//개인 글 수정
			var title = $("#mywrite_title").html();
			write_modify_setting(count, title);
			$("form").append("<input type=\"hidden\" name=\"count_group\" value=\""+count_group+"\"/>");
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
				<header id="page_title"></header>
				<nav class="menu_square">
					<a href="club_event.php"><div id="menu_square_myEvent" class="menu_square_item">나의이벤트</div></a>
					<a href="club_event_friend.php"><div id="menu_square_friendEvent" class="menu_square_item">친구이벤트</div></a>
					<a href="club_event_reply.php"><div id="menu_square_replyEvent" class="menu_square_item">나의댓글</div></a>
					<div class="menu_square_bar">|</div>
					<a href="club_group.php"><div id="menu_square_myGroup" class="menu_square_item">나의모임</div></a>
				</nav>
				<div class="page_title_expr"></div>
				<div class="content_area">
					<div id="writing_area">
<?php
	if($user_num != 0){include 'club_group_one_recall.php';}
	else {echo '<div class="guest_inform"> 회원가입 하시면 idMaru 뉴스에 올라가는 글을 쓰실 수 있습니다.</div>';}
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