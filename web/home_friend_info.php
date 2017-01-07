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
	<link rel="stylesheet" href="../plugin/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script type="text/javascript" src="../plugin/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>
<?php
	include 'declare.php';
	$friend_num = $_REQUEST["friend_num"];
	$sql = "SELECT * FROM friend WHERE (user_num=$user_num AND friend_num=$friend_num) OR (user_num=$friend_num AND friend_num=$user_num)";//친구인지 확인하기
	$sql_query = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($sql_query);
	if($count){//친구가 맞을때
		$sql1 = "SELECT * FROM user WHERE user_num = $friend_num";//친구의 사용자 정보
		$sql_query1 = mysqli_query($conn, $sql1);
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM idcard_photo WHERE user_num = $friend_num";//친구의 idcard 사진
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$photo_path = $sql_fetch_array2["idcard_photo_path"];
		if($photo_path){
			$image_size = getimagesize($photo_path);//image 넓이와 높이 구하기
			$image_width = $image_size[0];//image 넓이
			$image_height = $image_size[1];//image 높이
			if($image_width > 715){//이미지의 크기가 715px을 넘을경우
				$image_width_shrink = 715;
			} else if($image_width <= 715){
				$image_width_shrink = $image_width;
			}
		}
	}
?>
	<script>
		$(document).ready(function () {
			$("#friend_delete").click(function(){
				var reply = confirm("친구를 삭제하시겠습니까?");
				if(reply==true){
					$.ajax({//이벤트 출력
					url:'home_friend_delete.php',
					data: {friend_num:<?php echo $friend_num;?>},
					success: function(getdata){
						window.open("home_friend.php", "idmaru", "");
						alert("친구가 삭제되었습니다");
						window.close();
					}
				});
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 친구 정보</div></div>
	<div id="bodyarea_write">
		<div class="popup_content bold">
			<div class="info_item"><div class="info_item_title">웹 이름</div><div class="info_item_colon">:</div><div class="info_item_content"><?php echo $sql_fetch_array1["user_name"]; ?></div></div>
<?php
	echo '<div class="info_item"><div class="info_item_title">성명</div><div class="info_item_colon">:</div><div class="info_item_content">'.$sql_fetch_array1["familyname"].' '.$sql_fetch_array1["firstname"].'</div></div>';
	echo '<div class="info_item"><div class="info_item_title">생년월일</div><div class="info_item_colon">:</div><div class="info_item_content">'; if($sql_fetch_array1["birthday_y"]){echo $sql_fetch_array1["birthday_y"].'년 ';} if($sql_fetch_array1["birthday_m"]){echo $sql_fetch_array1["birthday_m"].'월 ';} if($sql_fetch_array1["birthday_d"]){echo $sql_fetch_array1["birthday_d"].'일';} echo '</div></div>';
	echo '<div class="info_item"><div class="info_item_title">이메일</div><div class="info_item_colon">:</div><div class="info_item_content">'.$sql_fetch_array1["email"].'</div></div>';
	echo '<div class="info_item"><div class="info_item_title">사는곳</div><div class="info_item_colon">:</div><div class="info_item_content">'.$sql_fetch_array1["add_region"].'</div></div>';
	// echo '<div class="info_item"><div class="info_item_title">휴대폰 번호</div><div class="info_item_colon">:</div><div class="info_item_content">'.$sql_fetch_array1["phone"].'</div></div>';
	if($sql_fetch_array2["idcard_photo_path"]){//사진이 있을때
		echo '
			<br/><img id="home_friend_photo" src="'.$sql_fetch_array2["idcard_photo_path"].'" width="'.$image_width_shrink.'" style="margin:5px;" />
		';
	} else if(!$sql_fetch_array2["idcard_photo_path"]){//사진이 없을때
		echo '<br/><img src="../image/blank_face.png" style="margin:5px;" />';
	}
	if($sql_fetch_array1["user_stop"]=='1'){
		echo '<br/><br/><div style="font-size:14pt; color:#F98600;">탈퇴한 회원입니다.</div>';
	}
?>
			<div id="friend_delete" class="button_gb absolute" style="margin:20px 10px;">친구 삭제</div>
		</div>
	</div>
	<div id="temp_target"></div>
</body>
</html>