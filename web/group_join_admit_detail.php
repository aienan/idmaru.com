<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
<?php
	include 'declare.php';
	include 'mysql_setting.php';
	$count_group = $_REQUEST["count_group"];
	$user_num_admit = $_REQUEST["user_num_admit"];
	$sql3 = "SELECT * FROM home_alarm WHERE user_num=$user_num AND count2=$user_num_admit";
	$sql_query3 = mysqli_query($conn, $sql3);
	$count3 = mysqli_num_rows($sql_query3);
	if($count3){//home_alarm 테이블에 정보가 있을경우
		$sql1 = "SELECT * FROM user WHERE user_num = $user_num_admit";//친구 신청인의 정보
		$sql_query1 = mysqli_query($conn, $sql1);
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM idcard_photo WHERE user_num = $user_num_admit";//친구 신청인의 idcard 사진
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$photo_path = $sql_fetch_array2["idcard_photo_path"];
		$image_size = getimagesize($photo_path);//image 넓이와 높이 구하기
		$image_width = $image_size[0];//image 넓이
		$image_height = $image_size[1];//image 높이
		if($image_width > 715){//이미지의 크기가 715px을 넘을경우
			$image_width_shrink = 715;
		} else if($image_width <= 715){
			$image_width_shrink = $image_width;
		}
	}
?>
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
	<script>
		$(document).ready(function () {
			var count_group = <?php echo $count_group; ?>;
			var user_num_admit = <?php echo $user_num_admit;?>;
			$("#group_join_accept").click(function(){
				var reply = confirm("모임 가입을 승인하시겠습니까?");
				if(reply==true){
					var decision = "accept";
					$.ajax({//이벤트 출력
						url:'group_join_admit_decide.php',
						data: {count_group:count_group, user_num_admit:user_num_admit, decision:decision},
						success: function(getdata){
							alert("<?php echo $sql_fetch_array1["user_name"];?>님이 모임에 가입되었습니다");
							window.opener.location.reload();
							window.close();
						}
					});
				}
			});
			$("#group_join_refuse").click(function(){
				var reply = confirm("모임 가입을 거절하시겠습니까?");
				if(reply==true){
					var decision = "refuse";
					$.ajax({//이벤트 출력
						url:'group_join_admit_decide.php',
						data: {count_group:count_group, user_num_admit:user_num_admit, decision:decision},
						success: function(getdata){
							alert("<?php echo $sql_fetch_array1["user_name"];?>님의 모임 가입이 거절되었습니다");
							window.opener.location.reload();
							window.close();
						}
					});
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 모임 가입승인</div></div>
	<div id="bodyarea_write">
		<div class="bold">
			<div class="relative" style="margin:20px 10px; height:25px;"><div id="group_join_accept" class="button_gb">승인하기</div><div id="group_join_refuse" class="button_gb" style="left:85px;">거절하기</div></div>
			<div class="popup_title">신청인 정보</div>
			<div style="padding:10px;">
			<div>&nbsp;웹 이름 : &nbsp;&nbsp;<?php echo $sql_fetch_array1["user_name"]; ?> </div>
<?php
	if($sql_fetch_array1["familyname"] && $sql_fetch_array1["firstname"]){//이름이 있을때
		echo '<div>&nbsp;성&nbsp;&nbsp;&nbsp;&nbsp;명 : &nbsp;&nbsp;'.$sql_fetch_array1["familyname"].' '.$sql_fetch_array1["firstname"].'</div>';
	}
	
	if($sql_fetch_array1["birthday_y"]){//생년이 있을때
		echo '<div> &nbsp;생년월일 : &nbsp;&nbsp;'.$sql_fetch_array1["birthday_y"].'년 ';
	}
	if($sql_fetch_array1["birthday_y"] && $sql_fetch_array1["birthday_m"]){//생월이 있을때
		echo $sql_fetch_array1["birthday_m"].'월 ';
	}
	if($sql_fetch_array1["birthday_y"] && $sql_fetch_array1["birthday_m"] && $sql_fetch_array1["birthday_d"]){//생일이 있을때
		echo $sql_fetch_array1["birthday_d"].'일 ';
	}
	if($sql_fetch_array1["birthday_y"]){
		echo '</div>';
	}
	if(!$sql_fetch_array1["birthday_y"] && $sql_fetch_array1["birthday_m"] && $sql_fetch_array1["birthday_d"]){//생년은 없고 월일만 있을때
		echo '<div> &nbsp;생년월일 : &nbsp;&nbsp;'.$sql_fetch_array1["birthday_m"].'월 '.$sql_fetch_array1["birthday_d"].'일 </div>';
	}
	echo '<div>&nbsp;이&nbsp;메&nbsp;일 : &nbsp;&nbsp;'.$sql_fetch_array1["email"].'</div>';
	if($sql_fetch_array1["add_region"]){//도시정보가 있을때
		echo '<div>&nbsp;사&nbsp;는&nbsp;곳 : &nbsp;&nbsp;'.$sql_fetch_array1["add_region"].'</div>';
	}
	if($sql_fetch_array2["idcard_photo_path"]){//사진이 있을때
		echo '
			<br/><img id="home_friend_photo" src="'.$sql_fetch_array2["idcard_photo_path"].'" width="'.$image_width_shrink.'" style="margin:5px;" />
		';
	} else if(!$sql_fetch_array2["idcard_photo_path"]){//사진이 없을때
		echo '<br/><img src="../image/blank_face.png" style="margin:5px;" />';
	}
?>
			</div>
		</div>
	</div>
	<div id="temp_target"></div>
</body>
</html>