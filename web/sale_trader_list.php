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
	<script type="text/javascript" src="../js/idmaru.js"></script>
<?php include 'declare_php.php';?>
	<script>
		$(document).ready(function () {
		});
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 거래자 목록</div></div>
	<div id="bodyarea_write">
<?php
	$sql1 = "SELECT * FROM sale_trader WHERE seller_num=$user_num OR buyer_num=$user_num";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$output1 = '';
	$row_height = 34;
	$divide_num = 5;
	if($count1){//등록된 거래자가 있을때
		$output1 .= '<div id="sale_trader_info">';
		for($i=0; $i<$count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			if($sql_fetch_array1["seller_num"]==$user_num){
				$user_num_other = $sql_fetch_array1["buyer_num"];
			} else if($sql_fetch_array1["buyer_num"]==$user_num){
				$user_num_other = $sql_fetch_array1["seller_num"];
			}
			$sql2 = "SELECT * FROM user WHERE user_num = $user_num_other";//회원정보 검색
			$sql_query2 = mysqli_query($conn, $sql2);
			$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
			$trader_name = $sql_fetch_array2["user_name"];
			$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array2[user_num]";//idcard의 사진을 띄운다
			$sql_query17 = mysqli_query($conn, $sql17);
			$count17 = mysqli_num_rows($sql_query17);
			if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
			else{$user_photo_path = "../image/blank_face.png";}
			$num = $i % $divide_num;
			if($num==0){$output1 .= '<div class="relative" style="height:'.$row_height.'px;">';}
			$output1 .= '
				<div id="sale_trader'.$sql_fetch_array2["user_num"].'" class="list_pos'.$num.'">
					<div class="zindex1 padding5">'.$trader_name.user_info_trader($user_num, $sql_fetch_array2["user_num"], $sql_fetch_array2["user_name"], $user_photo_path).'</div>
				</div>
			';
			if(($num==($divide_num-1)) || ($num==$count1 - 1)){$output1 .= '</div>';}
		}
		$output1 .= '
			</div>
			<script>
				$(".zindex1").hover(function(){
					$(this).children(".user_info").css({"display":"block"});
				}, function(){
					$(this).children(".user_info").css({"display":"none"});
				});
			</script>
		';
	} else if(!$count1){//등록된 거래자가 없을때
		$output1 .= '<div class="bold" style="margin:10px;">등록된 거래자가 없습니다.</div>';
	}
	echo $output1;
?>
	<div id="temp_target"></div>
</body>
</html>