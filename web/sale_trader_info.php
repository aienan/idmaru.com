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
	$user_num_other = $_REQUEST["user_num_other"];
	$sql = "SELECT * FROM sale_trader WHERE (seller_num = $user_num AND buyer_num = $user_num_other) OR (seller_num = $user_num_other AND buyer_num = $user_num)";//거래자인지 확인하기
	$sql_query = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($sql_query);
	if($count){//거래자가 맞을때
		$sql1 = "SELECT * FROM user WHERE user_num = $user_num_other";//친구의 사용자 정보
		$sql_query1 = mysqli_query($conn, $sql1);
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM idcard_photo WHERE user_num = $user_num_other";//친구의 idcard 사진
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
	<script>
		$(document).ready(function () {
			$("#friend_delete").click(function(){
				var user_name_other = "<?php echo $sql_fetch_array1["user_name"];?>";
				var reply = confirm(user_name_other+"님을 거래자 목록에서 삭제하시겠습니까?");
				if(reply==true){
					$.ajax({//이벤트 출력
					url:'sale_trader_list_delete.php',
					data: {user_num_other:<?php echo $user_num_other;?>},
					success: function(getdata){
						alert(user_name_other+"님이 거래자 목록에서 삭제되었습니다");
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
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 거래자 정보</div></div>
	<div id="bodyarea_write">
		<div class="popup_content bold">
			<div class="info_item"><div class="info_item_title">웹 이름</div><div class="info_item_colon">:</div><div class="info_item_content"><?php echo $sql_fetch_array1["user_name"]; ?></div></div>
<?php
	echo '<div class="info_item"><div class="info_item_title">성명</div><div class="info_item_colon">:</div><div class="info_item_content">'.$sql_fetch_array1["familyname"].' '.$sql_fetch_array1["firstname"].'</div></div>';
	echo '<div class="info_item"><div class="info_item_title">생년월일</div><div class="info_item_colon">:</div><div class="info_item_content">'; if($sql_fetch_array1["birthday_y"]){echo $sql_fetch_array1["birthday_y"].'년 ';} if($sql_fetch_array1["birthday_m"]){echo $sql_fetch_array1["birthday_m"].'월 ';} if($sql_fetch_array1["birthday_d"]){echo $sql_fetch_array1["birthday_d"].'일';} echo '</div></div>';
	echo '<div class="info_item"><div class="info_item_title">이메일</div><div class="info_item_colon">:</div><div class="info_item_content">'.$sql_fetch_array1["email"].'</div></div>';
	echo '<div class="info_item"><div class="info_item_title">사는곳</div><div class="info_item_colon">:</div><div class="info_item_content">'.$sql_fetch_array1["add_region"].'</div></div>';
	if($sql_fetch_array2["idcard_photo_path"]){//사진이 있을때
		$user_photo_path = $sql_fetch_array2["idcard_photo_path"];
	} else if(!$sql_fetch_array2["idcard_photo_path"]){//사진이 없을때
		$user_photo_path = '../image/blank_face.png';
	}
	echo '<img id="home_friend_photo" src="'.$user_photo_path.'" width="'.$image_width_shrink.'" style="margin:20px;" />';
?>
			<div id="friend_delete" class="button_gb" style="margin:0px 20px">거래자 삭제</div>
		</div>
	</div>
	<div id="temp_target"></div>
</body>
</html>