<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
<?php
	include 'mysql_setting.php';
	$sql1 = "SELECT * FROM sale_keyword WHERE user_num = $user_num";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
?>
	<script>
		$(document).ready(function () {
			$("#keyword_register_button").click(function(){
				var keyword = $("#keyword_input").val();
				if(!keyword){
					$("#sale_register_check").html("키워드를 입력해주세요");
				} else if(keyword){
					$.ajax({
						url:'sale_keyword_register.php',
						data: {keyword:keyword},
						success: function(getdata){
							if(getdata == "already"){
								$("#sale_register_check").html("이미 등록된 키워드입니다");
							} else if(getdata == "max_num"){
								$("#sale_register_check").html("키워드 등록은 5개까지 가능합니다");
							} else if(getdata == "done"){
								alert("키워드가 등록되었습니다");
								location.reload();
							}
						}
					});
				}
			});
			$('#keyword_input').keyup(function () {
				if(event.keyCode=="13"){//Enter를 눌렀을때
					$("#keyword_register_button").click();
				}
			});
		});
		function keyword_item_see(keyword){
			
		}
		function keyword_delete(keyword){
			$.ajax({
				url:'sale_keyword_delete.php',
				data: {keyword:keyword},
				success: function(getdata){
					alert('검색어가 삭제되었습니다.');
					location.reload();
				}
			});
		}
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body class="popup_body">
	<div id="bodyarea_write">
		<br/><h6 class="popup_title"><img src="../image/list_pineB.png" style="position:relative; top:2px;"/> 검색어 등록</h6><br/>
		<input id="keyword_input" class="input_blue inline" type="text" name="search" value="" maxlength="30" tabindex="" style="width:240px;"/>
		<div id="keyword_register_button" class="button_gb inline basicmargin">등록</div>
		<h6 class="popup_title" style="margin:50px 0 0 0;"><img src="../image/list_pineB.png" style="position:relative; top:2px;"/> 검색어 목록</h6><br/>
		<div id="keyword_registered">
<?php
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$keyword_str = $sql_fetch_array1["keyword"];
		$keyword_set = urlencode($keyword_str);
		echo '
			<div>
			<div class="keyword_item">'.$keyword_str.'</div>
			<a href="market.php?keyword='.$keyword_set.'&category=all_content" target="_blank"><div class="button_gb_rel keyword_item_see">전체보기</div></a>
			<a href="sale_friend.php?keyword='.$keyword_set.'&category=all_content" target="_blank"><div class="button_gb_rel keyword_item_see2">친구보기</div></a>
			<div id="keyword_item_delete_$i" class="button_gb_rel keyword_item_delete" onclick="keyword_delete(\''.$keyword_str.'\')">삭제</div>
			</div>
		';
	}
	if($count1==0){
		echo '<div class="basicmargin bold">등록된 검색어가 없습니다</div>';
	}
?>
		</div>
	</div>
	<div id="temp_target"></div>
</body>
</html>