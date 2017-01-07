<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="이드마루, customer center, 고객센터, customer, 고객, member, member center" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-관리자-회원목록</title>
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
				<div class="popup_title bold font12"><img src="../image/list_pine.png" style="position:relative; top:2px; cursor:default;"/> &nbsp;관리자 화면 - 회원 목록</div><br/>
<?php
	include 'mysql_setting.php';
	$sql1 = "SELECT * FROM user";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$user_detail = '';
		if($sql_fetch_array1["user_stop"]=='0'){}
		else if($sql_fetch_array1["user_stop"]=='1'){$user_detail .= '(회원탈퇴)';}
		else if($sql_fetch_array1["user_stop"]=='2'){$user_detail .= '(강제정지)';}
		if($sql_fetch_array1["email_certify"]=='0'){$user_detail .= '(비인증)';}
		echo '
			<div>
				<span class="member_detail" style="font-weight:bold;">'.$user_detail.'</span>
				<span class="member_detail">'.$sql_fetch_array1["user_name"].'</span>&nbsp;■
				<span class="member_detail">'.$sql_fetch_array1["familyname"]." ".$sql_fetch_array1["firstname"].'</span>&nbsp;■
				<span class="member_detail">'.$sql_fetch_array1["sex"].'</span>&nbsp;■
				<span class="member_detail">'.$sql_fetch_array1["birthday_y"].'년 '.$sql_fetch_array1["birthday_m"].'월 '.$sql_fetch_array1["birthday_d"].'일</span>&nbsp;■
				<span class="member_detail">'.$sql_fetch_array1["add_country"].' '.$sql_fetch_array1["add_region"].' '.$sql_fetch_array1["add_detail"].'</span>
			</div>
		';
	}
?>
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