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
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<?php include 'declare.php';?>
	<script>
		$(document).ready(function () {
			$("#profile_submit").click(function(){
				if(user_num==0){alert("로그인 후 이용해주세요");}
				else {
				var idcard_photo = $("input[type=file]").val();
				if(!idcard_photo){
					alert("사진을 선택해주세요");
				} else if(idcard_photo){
					var reply = confirm("사진을 등록하시겠습니까?");
					if(reply==true){
						$("input[type=submit]").click();
					}
				}
				}
			});
			$("#profile_delete").click(function(){
				if(user_num==0){alert("로그인 후 이용해주세요");}
				else {
				var idcard_photo_now = $("#idcard_photo_now img").attr("src");
				if(!idcard_photo_now){
					alert("등록된 사진이 없습니다");
				} else if(idcard_photo_now){
					var reply = confirm("사진을 삭제하시겠습니까?");
					if(reply==true){
						$.ajax({
							url:'idcard_photo_delete.php',
							data: {},
							success: function(getdata){
								alert("사진이 삭제되었습니다");
								location.reload();
							}
						});
					}
				}
				}
			});
			if(navigator.appName.toLowerCase().match('microsoft internet explorer')){
				$("input[name=idcard_photo]").css("background-color", "#FFFFFF");
			}
		});
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 프로필 사진 등록하기</div></div>
	<div id="bodyarea_write">
	<div class="popup_content bold" style="margin:15px 0 0 0;">
	<form action="idcard_photo_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
		<input type="file" class="input_blue" name="idcard_photo" accept="image/*"/>
		<div style="margin:5px 0 15px 0; font-size:9pt;">※ 10MB가 넘는 파일은 업로드되지 않습니다.</div>
		<input type="submit" value="" style="display:none;">
		<div class="relative">
		<div id="profile_submit" class="button_gb" style="display:inline-block;">등록하기</div>
		<div id="profile_delete" class="button_gb" style="left:90px; top:0px; display:inline-block;">삭제하기</div>
		</div>
		<br/><br/><div class="input_blue"></div><br/>
		<div id="idcard_photo_now" style="font-weight:bold;">
<?php
	include 'mysql_setting.php';
	$sql = "SELECT * FROM idcard_photo WHERE user_num=$user_num";
	$sql_query = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($sql_query);
	if(!$count){
		echo "&nbsp;&nbsp;&nbsp;등록된 사진이 없습니다.";
	} else if($count){
		$sql_fetch_array = mysqli_fetch_array($sql_query);
		if(!$sql_fetch_array[idcard_photo_path]){
			echo "&nbsp;&nbsp;&nbsp;등록된 사진이 없습니다.";
		} else if($sql_fetch_array[idcard_photo_path]){
			echo "<img src=\"$sql_fetch_array[idcard_photo_path]\"/>";
		}
	}
	
?>
		</div>
		</div>
	</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>