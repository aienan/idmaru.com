<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="이드마루, customer center, 고객센터, customer, 고객, member, member center" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-관리자 화면</title>
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
	<script>
		var isidmaruid = is_idmaru_id(user_name);
		if(isidmaruid == -1){//idmaru 관리자 아이디가 아니면,
			location.href="about.php";
		}
		$(document).ready(function () {
			blueStyle();
			$('#db_content_modify').click(function(){//공지확인 클릭시
				// var type="modify";
				// var location_url = 'manager_db_modifyF.php';
				// var reply = confirm(location_url + "를 " + type + "하시겠습니까?");
				// if(reply==true){
					// $.ajax({
						// url: location_url,
						// data: {type:type},
						// success: function(getdata){
							// $("#temp_target").append(getdata);
						// }
					// });
				// }
				alert("비활성 중 입니다");
			});
		});
	</script>
</head>
<body>
	<div id="toparea">
<?php include 'toparea.php'; ?>
	</div>
	<div id="bodyarea">
		<div id="mainbar">
			<div id="mainbody">
				<a href="manager_page.php"><div id="go_upper" class="button_gb" style="top:3px; right:3px;">위로</div></a>
				<div class="popup_title bold font12"><img src="../image/list_pine.png" style="position:relative; top:2px;"/> 회원 로그인 기록</div>
				<div class="content_area" style="white-space: pre-wrap;">
<?php
	$fp = fopen("../files/login.txt", "r");
	while(!feof($fp)) {
		$buffer = fgets($fp, 4096);
		printf("%s", $buffer);
	}
	fclose($fp);
?>
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