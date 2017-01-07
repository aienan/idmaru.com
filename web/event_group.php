<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="Group, 모임" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-모임</title>
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
	if(isset($_REQUEST["count_start"])){
		$count_start = $_REQUEST["count_start"];
	} else if(!isset($_REQUEST["count_start"])){
		$count_start = 0;
	}
	$url = "event_group.php?";
	$page_name = "event_group";
	$table_name = "club_group";
	$ad_fixbar_cond = "event_group";
	$ad_pop_cond = "event_group";
	$ad_side_cond = "event_group";
	include 'declare.php';
	include 'personal.php';
?>
	<script>
		var url = "<?php echo $url;?>";
		var table_name = "<?php echo $table_name;?>";
		var count_start = <?php echo $count_start;?>;//php에서는 0이 처음 시작 번호다
		var list_start_number = count_start +1;//list_start_number에는 1번째부터 시작하게 한다
		var display_number = 40;
		var group_initial = 1;//처음 시작임을 알리는 변수
<?php
	if(isset($_REQUEST["event_type"])){//event_type 변수가 넘어왔을때
		echo 'var event_type = "'.$_REQUEST["event_type"].'";';
		$event_type = $_REQUEST["event_type"];
	} else {//event_type 변수가 안 넘어왔을때
		echo 'var event_type = "group";';//selling_type에 값이 없을때
		$event_type = "group";
	}
?>
		var page_name = "<?php echo $page_name;?>";
		$(document).ready(function () {
			blueStyle();
			menuEvent();
<?php
	if(isset($_REQUEST["keyword"])){//keyword 검색을 했을 경우
		$keyword = $_REQUEST["keyword"];
		echo '
			var keyword = "'.$keyword.'";
			if(keyword != "thereisnokeyword"){//키워드가 입력되어 있는 경우
				$("#list_search_word_button").prev().val(keyword);
			}
		';
	} else if(!isset($_REQUEST["keyword"])){
		$keyword = "thereisnokeyword";
		echo '
			var keyword = "thereisnokeyword";
		';
	}
	if(isset($_REQUEST["category"])){
		$category = $_REQUEST["category"];
		echo '
			var category = "'.$category.'";
			$("#list_search_word_button").prev().prev().val(category);
		';
	} else if(!isset($_REQUEST["category"])){
		$category = "thereisnocategory";
		echo '
			var category = "thereisnocategory";
		';
	}
?>
			$("#list_start_number_set").val(list_start_number);
			var list_start_number_set_before = $("#list_start_number_set").val();
			$("#list_start_number_set").blur(function(){
				if(!$("#list_start_number_set").val()){alert("1이상의 정수만 가능합니다"); $("#list_start_number_set").val(list_start_number_set_before);}
				else if(isNumber($("#list_start_number_set").val())==false){alert("숫자만 입력 가능합니다"); $("#list_start_number_set").val(list_start_number_set_before);}
				else{
					var count_start_new = parseInt($("#list_start_number_set").val()) - 1;
					if(count_start_new<0){
						alert("1이상의 정수만 가능합니다");
					} else {
						if(count_start_new == count_start){//변화없을때는 로딩하지 않음
						} else{
							location.href = url + "keyword="+keyword+"&category="+category+"&count_start="+count_start_new;
						}
					}
				}
			});
			enterAndBlur("#list_start_number_set");
			var keyword_before = keyword;
			var category_before = category;
			$("#list_search_word_button").click(function(){
				var keyword = $("input[name=list_search_word]").val();
				var category = $("select[name=list_search_category] > option:selected").val();
				if(keyword && (keyword_before!=keyword || category_before!=category)){//새로운 검색내용인 경우
					location.href = url + "keyword="+keyword+"&category="+category+"&count_start="+count_start;
				} else if(!keyword){//키워드가 없을 때
					alert("검색어를 입력해주세요");
				}
			});
			$("input[name=\"list_search_word\"]").keyup(function(){//엔터키를 쳤을때
				if(event.keyCode==13){
					$("#list_search_word_button").click();
				}
			});
			if(keyword_before != "thereisnokeyword"){//검색어가 있을때 커서를 검색창으로 이동
				document.getElementById("list_search_word").select();
			}
			if(keyword != "thereisnokeyword"){//검색어가 있을때 취소 버튼을 보이게 함
				$("#list_search_word_cancel").css("display", "inline");
				$("#list_search_word_cancel").click(function(){
					location.href = url;
				})
			}
			$.ajax({
				url:'event_group_recall.php',
				data: {count_start:count_start, display_number:display_number, group_initial:group_initial, keyword:keyword, category:category},
				success: function(getdata){
					$("#group_article_area").append(getdata);
					$("#loading_more").remove();
				}
			});
			$("#club_group_admit").click(function(){//모임 등록 클릭시
				if(user_name=="Guest"){
					alert("로그인 후 이용해주세요");
				}else if(user_name!="Guest"){
					window.open("club_group_register.php", "club_group_register", "width=770,height=650,resizable=yes,scrollbars=yes,location=no");
				}
			});
			$("#list_search_tip").click(function(){
				window.open("list_search_tip.php?type=group", "list_search_tip", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
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
				<div id="list_search">
					<div id="list_search_box">
					<div id="list_search_tip" title="검색 Tip"><img src="../image/list_search_tip.png"/></div>
					<select id="list_search_category" name="list_search_category" style="left:-13px;">
						<option selected value="all_content">전체</option><option value="founder">만든이</option><option value="group_name">모임명</option><option value="description">모임설명</option>
					</select>
					<input id="list_search_word" type="text" name="list_search_word" value="" maxlength="40" tabindex=""/>
					<div id="list_search_word_button" title="검색"></div>
					<div id="list_search_word_cancel" title="검색 취소"></div>
					</div>
				</div>
				<div id="list_button">
					<div id="club_group_admit" class="menu_button"></div>
					<input id="list_start_number_set" type="text" name="list_start_number_set" value="" maxlength="4" tabindex="" title="목록 시작번호"/>
				</div>
				<div id="loading_more" class="loading48x48" style="left:340px;"></div>
				<div id="group_article_area"></div>
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