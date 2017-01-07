<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="idmaru, 이드마루, SNS, 소셜, portal, 포털, secondhand, market, 중고, 거래, fun, 흥미, photo, 사진, news, 뉴스, event, 이벤트, 참고" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루</title>
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
	$ad_fixbar_cond = "idmaru";
	$ad_pop_cond = "idmaru";
	$ad_side_cond = "idmaru";
?>
<?php unset($_SESSION["auto_prevent"]);//자동가입방지 확인용 session 변수 제거?>
	<script>
<?php $section_list_number = 5; $section_list_gallery = 5; ?>
		var section_list_number = 5;
		var section_list_gallery = 5;
		var section_count_news = 0;
		var section_end_news = 0;
		var section_count_gallery = 0;
		var section_end_gallery = 0;
		var section_count_market = 0;
		var section_end_market = 0;
		var section_count_event = 0;
		var section_end_event = 0;
		var section_count_group = 0;
		var section_end_group = 0;
		var section_count_guest_all = 0;
		var section_end_guest_all = 0;
		$(document).ready(function () {
			blueStyle();
			idmaruNotice();
			$("#idmaru_news .main_section_prev").click(function(){
				var type="news";
				var section_count = section_count_news;
				if(section_count != 0){
					if(section_count <= section_list_number){section_count = 0;}
					else{section_count -= section_list_number;}
					$.ajax({
						url:'idmaru_section_recall.php',
						data: {type:type, count_start:section_count},
						success: function(getdata){
							$("#idmaru_"+type+" > .main_section_body").html(getdata);
							section_count_news = section_count;
							section_end_news = 0;
						}
					});
				}
			});
			$("#idmaru_news .main_section_next").click(function(){
				var type="news";
				var section_count = section_count_news;
				var section_end = section_end_news;
				if(section_end != 1){
					section_count += section_list_number;
					$.ajax({
						url:'idmaru_section_recall.php',
						data: {type:type, count_start:section_count},
						success: function(getdata){
							if(getdata=="endofSection"){section_end_news = 1;}
							else {
								$("#idmaru_"+type+" > .main_section_body").html(getdata);
								section_count_news = section_count;
							}
						}
					});
				}
			});
			$("#idmaru_gallery_prev").click(function(){
				var type="gallery";
				var section_count = section_count_gallery;
				if(section_count != 0){
					if(section_count <= section_list_gallery){section_count = 0;}
					else{section_count -= section_list_gallery;}
					$.ajax({
						url:'idmaru_section_recall.php',
						data: {type:type, count_start:section_count},
						success: function(getdata){
							$("#idmaru_gallery_body_box").html(getdata);
							section_count_gallery = section_count;
							section_end_gallery = 0;
						}
					});
				}
			});
			$("#idmaru_gallery_next").click(function(){
				var type="gallery";
				var section_count = section_count_gallery;
				var section_end = section_end_gallery;
				if(section_end != 1){
					section_count += section_list_gallery;
					$.ajax({
						url:'idmaru_section_recall.php',
						data: {type:type, count_start:section_count},
						success: function(getdata){
							if(getdata=="endofSection"){section_end_news = 1;}
							else {
								$("#idmaru_gallery_body_box").html(getdata);
								section_count_gallery = section_count;
							}
						}
					});
				}
			});
			$("#idmaru_market .main_section_prev").click(function(){
				var type="market";
				var section_count = section_count_market;
				if(section_count != 0){
					if(section_count <= section_list_number){section_count = 0;}
					else{section_count -= section_list_number;}
					$.ajax({
						url:'idmaru_section_recall.php',
						data: {type:type, count_start:section_count},
						success: function(getdata){
							$("#idmaru_"+type+" > .main_section_body").html(getdata);
							section_count_market = section_count;
							section_end_market = 0;
						}
					});
				}
			});
			$("#idmaru_market .main_section_next").click(function(){
				var type="market";
				var section_count = section_count_market;
				var section_end = section_end_market;
				if(section_end != 1){
					section_count += section_list_number;
					$.ajax({
						url:'idmaru_section_recall.php',
						data: {type:type, count_start:section_count},
						success: function(getdata){
							if(getdata=="endofSection"){section_end_news = 1;}
							else {
								$("#idmaru_"+type+" > .main_section_body").html(getdata);
								section_count_market = section_count;
							}
						}
					});
				}
			});
			$("#idmaru_event .main_section_prev").click(function(){
				var type="event";
				var section_count = section_count_event;
				if(section_count != 0){
					if(section_count <= section_list_number){section_count = 0;}
					else{section_count -= section_list_number;}
					$.ajax({
						url:'idmaru_section_recall.php',
						data: {type:type, count_start:section_count},
						success: function(getdata){
							$("#idmaru_"+type+" > .main_section_body").html(getdata);
							section_count_event = section_count;
							section_end_event = 0;
						}
					});
				}
			});
			$("#idmaru_event .main_section_next").click(function(){
				var type="event";
				var section_count = section_count_event;
				var section_end = section_end_event;
				if(section_end != 1){
					section_count += section_list_number;
					$.ajax({
						url:'idmaru_section_recall.php',
						data: {type:type, count_start:section_count},
						success: function(getdata){
							if(getdata=="endofSection"){section_end_news = 1;}
							else {
								$("#idmaru_"+type+" > .main_section_body").html(getdata);
								section_count_event = section_count;
							}
						}
					});
				}
			});
			$("#idmaru_group .main_section_prev").click(function(){
				var type="group";
				$.ajax({
					url:'idmaru_section_recall.php',
					data: {type:type, count_start:0},
					success: function(getdata){
						$("#idmaru_"+type+" > .main_section_body").html(getdata);
					}
				});
			});
			$("#idmaru_group .main_section_next").click(function(){
				var type="group";
				$.ajax({
					url:'idmaru_section_recall.php',
					data: {type:type, count_start:0},
					success: function(getdata){
						$("#idmaru_"+type+" > .main_section_body").html(getdata);
					}
				});
			});
			$("#idmaru_guest_all .main_section_prev").click(function(){
				var type="guest_all";
				var section_count = section_count_guest_all;
				if(section_count != 0){
					if(section_count <= section_list_number){section_count = 0;}
					else{section_count -= section_list_number;}
					$.ajax({
						url:'idmaru_section_recall.php',
						data: {type:type, count_start:section_count},
						success: function(getdata){
							$("#idmaru_"+type+" > .main_section_body").html(getdata);
							section_count_guest_all = section_count;
							section_end_guest_all = 0;
						}
					});
				}
			});
			$("#idmaru_guest_all .main_section_next").click(function(){
				var type="guest_all";
				var section_count = section_count_guest_all;
				var section_end = section_end_guest_all;
				if(section_end != 1){
					section_count += section_list_number;
					$.ajax({
						url:'idmaru_section_recall.php',
						data: {type:type, count_start:section_count},
						success: function(getdata){
							if(getdata=="endofSection"){section_end_news = 1;}
							else {
								$("#idmaru_"+type+" > .main_section_body").html(getdata);
								section_count_guest_all = section_count;
							}
						}
					});
				}
			});
			$(".main_section_prev").attr("title", "이전");
			$(".main_section_next").attr("title", "다음");
		});
		function club_group_click(count_group){
			window.open("group_recall_one.php?count_group="+count_group, "group_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
		}
		function idmaruNotice(){ // idmaru_notice 부분을 setting한다
			notice_index = 0;
			notice_length = $(".idmaru_notice_content").length;
			notice_list_left = ( 765 - notice_length * 20 + 5 ) / 2;
			$("#idmaru_notice_list").before('<div id="idmaru_notice_list_box"></div>');
			$("#idmaru_notice_list_box").append($("#idmaru_notice_list"));
			for(var i=0; i < notice_length; i++){
				if(i != 0){$("#idmaru_notice_list").append('<img id="idmaru_notice_list'+ i +'" class="idmaru_notice_list" src="../image/idmaru_notice_listB.png"/>');}
				else {$("#idmaru_notice_list").append('<img id="idmaru_notice_list'+ i +'" class="idmaru_notice_list" src="../image/idmaru_notice_listA.png"/>');}
				$("#idmaru_notice_list"+i).hover(function(){
					var temp = $(this).attr("id").substring(18);
					idmaruNoticeChange(temp);
					notice_index = temp;
				}, function(){
				});
			}
			$("#idmaru_notice_list").css({"left":notice_list_left});
			$("#idmaru_notice").hover(function(){
				window.clearInterval(idmaru_notice_content);
			}, function(){
				idmaruNoticeContent();
			});
			idmaruNoticeContent();
		}
		function idmaruNoticeContent(){ // idmaru_notice의 내용을 자동으로 바꿔준다
			idmaru_notice_content = self.setInterval(function(){
				notice_index += 1;
				if(notice_index >= notice_length){notice_index = 0;}
				idmaruNoticeChange(notice_index);
			}, 7000);
		}
		function idmaruNoticeChange(temp){ // idmaru_notice의 내용을 바꾼다
			$(".idmaru_notice_content").css({"display":"none"});
			$(".idmaru_notice_content").eq(temp).css({"display":"block"});
			$(".idmaru_notice_list").attr("src", "../image/idmaru_notice_listB.png");
			$(".idmaru_notice_list").eq(temp).attr("src", "../image/idmaru_notice_listA.png");
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
				<div id="idmaru_notice">
					<div id="idmaru_notice_content">
					<a href="photo_battle.php"><img class="idmaru_notice_content" style="display:block;" src="../image/link_photo_battle.jpg" title="이상형월드컵 입장하기"/></a>
					<!--<a href="http://www.idmaru.com/web/event_all.php?count_link=172"><img class="idmaru_notice_content" style="left:7px;" src="../image/event4_title.jpg" title="이드마루 기획 이벤트 4탄"/></a>-->
					</div>
					<div id="idmaru_notice_list"></div>
				</div>
				<div style="font-size:9pt; color:red;">※ 이드마루는 친구들과 중고거래를 쉽고 편하게 할 수 있는 곳입니다. ^^</div>
				<div class="idmaru_shortcut"><img class="shortcut_icon" src="../image/shortcut_iconA.png" style="top:9px;"/><div class="shortcut_text">자신의 친구가 회원으로 가입됐는지 확인해보세요!</div><a href="home_friend.php"><img src="../image/idmaru_notice1_link.png" class="idmaru_shortcut_button" title="친구검색"/></a></div>
				<div class="idmaru_shortcut"><img class="shortcut_icon" src="../image/shortcut_iconB.png" style="top:8px;"/><div class="shortcut_text">처음 오신 분은 이곳에 글을 남겨보세요. ^^</div><a href="idmaru_guest.php"><img src="../image/idmaru_notice2_link.png" class="idmaru_shortcut_button" title="모두에게한마디"/></a></div>
				<div id="idmaru_gallery">
					<div style="position:relative; height:28px;"><a href="gallery.php" title="갤러리"><img src="../image/shortcut_gallery.png" title="갤러리"/><div class="font_menu" style="position:absolute; left:0px; top:4px; width:143px; height:24px; font-size:10pt; background-color:#2C2E35; color:#BFDDEA" title="갤러리"><div style="position:absolute; left:15px; top:0px;">GALLERY</div></div></a></div>
					<div id="idmaru_gallery_body">
					<div id="idmaru_gallery_prev" title="이전"><img src="../image/idmaru_gallery_prev.jpg"/></div><div id="idmaru_gallery_next" title="다음"><img src="../image/idmaru_gallery_next.jpg"/></div>
						<div id="idmaru_gallery_body_box">
<?php
	$sql1 = "SELECT * FROM photo WHERE status='1' ORDER BY count DESC LIMIT 0, $section_list_gallery";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		echo '<a href="gallery_all.php?count_link='.$sql_fetch_array1["count"].'"><div class="main_section_body_img"><div class="relative">'.img_adjust(get_thumbnail_path($sql_fetch_array1["photo_path"]), 114, 114).'</div></div></a>';
	}
	if($count1 != $section_list_gallery){echo '<script>section_end_gallery = 1;</script>';}
?>
						</div>
					</div>
				</div>
				<a href="search_list.php"><div class="absolute" style="left:0px; bottom:0px; width:1px; height:1px;"></div></a>
				<div id="main_section_area">
				<div id="idmaru_news" class="main_section">
					<div class="main_section_title"><a href="news.php" title="뉴스"><img src="../image/idmaru_news_title.png"/></a><div class="main_section_prev"><img src="../image/main_section_prev.png"/></div><div class="main_section_next"><img src="../image/main_section_next.png"/></div></div>
					<div class="main_section_body">
<?php
	$sql1 = "SELECT * FROM writing WHERE status='1' ORDER BY count DESC LIMIT 0, $section_list_number";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		echo '<a href="news_all.php?count_link='.$sql_fetch_array1["count"].'"><div class="main_section_content"> · '.$sql_fetch_array1["title"].'</div></a>';
	}
	if($count1 != $section_list_number){echo '<script>section_end_news = 1;</script>';}
?>
					</div>
				</div>
				<div id="idmaru_market" class="main_section">
					<div class="main_section_title"><a href="market.php" title="장터"><img src="../image/idmaru_market_title.png"/></a><div class="main_section_prev"><img src="../image/main_section_prev.png"/></div><div class="main_section_next"><img src="../image/main_section_next.png"/></div></div>
					<div class="main_section_body">
<?php
	$sql1 = "SELECT * FROM sale WHERE status='1' ORDER BY count DESC LIMIT 0, $section_list_number";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		echo '<a href="market.php?count_link='.$sql_fetch_array1["count"].'"><div class="main_section_content"> · '.$sql_fetch_array1["title"].'</div></a>';
	}
	if($count1 != $section_list_number){echo '<script>section_end_market = 1;</script>';}
?>
					</div>
				</div>
				<div id="idmaru_event" class="main_section">
					<div class="main_section_title"><a href="event.php" title="이벤트"><img src="../image/idmaru_event_title.png"/></a><div class="main_section_prev"><img src="../image/main_section_prev.png"/></div><div class="main_section_next"><img src="../image/main_section_next.png"/></div></div>
					<div class="main_section_body">
<?php
	$sql1 = "SELECT * FROM club_event ORDER BY count DESC LIMIT 0, $section_list_number";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		echo '<a href="event_all.php?count_link='.$sql_fetch_array1["count"].'"><div class="main_section_content"> · '.$sql_fetch_array1["title"].'</div></a>';
	}
	if($count1 != $section_list_number){echo '<script>section_end_event = 1;</script>';}
?>
					</div>
				</div>
				<div id="idmaru_group" class="main_section">
					<div class="main_section_title"><a href="event_group.php" title="모임"><img src="../image/idmaru_group_title.png"/></a><div class="main_section_prev"><img src="../image/main_section_prev.png"/></div><div class="main_section_next"><img src="../image/main_section_next.png"/></div></div>
					<div class="main_section_body">
<?php
	$sql1 = "SELECT count_group FROM club_group WHERE status='1'";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$rand_num_arr = array();
	for($i=0; $i < $section_list_number && $i < $count1 ; $i++){
		do{
			$exist = 0;
			$rand_num = rand(0, $count1-1);
			for($j=0; $j < count($rand_num_arr); $j++){
				if($rand_num_arr[$j]==$rand_num){$exist = 1; break;}
			}
		} while($exist==1);
		if($exist==0){
			$rand_num_arr[] = $rand_num;
			mysqli_data_seek($sql_query1, $rand_num);
			$row = mysqli_fetch_row($sql_query1);
			$sql2 = "SELECT * FROM club_group WHERE count_group=$row[0]";
			$sql_query2 = mysqli_query($conn, $sql2);
			$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
			echo '<div class="main_section_content mouseover" onclick="club_group_click('.$sql_fetch_array2["count_group"].')"> · '.$sql_fetch_array2["group_name"].'</div>';
		}
	}
	// if($count1 != $section_list_number){echo '<script>section_end_group = 1;</script>';}
?>
					</div>
				</div>
				<div id="idmaru_guest_all" class="main_section">
					<div class="main_section_title"><a href="idmaru_guest.php" title="모두에게한마디"><img src="../image/idmaru_guest_all_title.png"/></a><div class="main_section_prev"><img src="../image/main_section_prev.png"/></div><div class="main_section_next"><img src="../image/main_section_next.png"/></div></div>
					<div class="main_section_body">
<?php
	$sql1 = "SELECT * FROM idmaru_guest WHERE upperwrite=0 ORDER BY count DESC LIMIT 0, $section_list_number";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		echo '<a href="idmaru_guest.php"><div class="main_section_content"> · '.$sql_fetch_array1["content"].'</div></a>';
	}
	if($count1 != $section_list_number){echo '<script>section_end_guest_all = 1;</script>';}
?>
					</div>
				</div>
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