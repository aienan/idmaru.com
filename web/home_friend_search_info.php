<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
<?php
	include 'declare.php';
	include 'mysql_setting.php';
	$friend_num = $_REQUEST["user_num"];
	$sql1 = "SELECT * FROM user WHERE user_num = $friend_num";//친구의 사용자 정보
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$sql2 = "SELECT * FROM idcard_photo WHERE user_num = $friend_num";//친구의 idcard 사진
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
			$("#register_admit").click(function(){
				if(user_name=="Guest"){
					alert("로그인 후 이용해주세요");
				} else if(user_num==<?php echo $friend_num;?>){
					alert("본인은 친구로 등록할 수 없습니다");
				} else {
					var friend_name = "<?php echo $sql_fetch_array1["user_name"];?>";
					var isidmaruid = is_idmaru_id(friend_name);
					if(isidmaruid != -1){
						alert("이드마루 관리자는 친구 신청에서 제외됩니다.");
					} else {
						var reply = confirm(friend_name+"님께 친구 신청하시겠습니까?");
						if(reply==true){
							var senddata = {friend_name:friend_name};
							$.getJSON( 'home_friend_register.php', senddata, function (getdata) {
								$.each(getdata, function (key, value) {
									if(value=='user_stop'){
										alert('탈퇴한 회원입니다.');
									} else if(value=='myself'){
										alert('본인은 친구로 등록할 수 없습니다.');
									}else if(value=='not_certified'){
										alert('아직 인증되지 않은 회원입니다.');
									}else if (value=='exist'){
										alert('친구로 이미 등록되어 있습니다.');
									}else if(value=='on_request'){
										alert('친구로 신청한 상태입니다.');
									} else if(value=='on_receiving'){
										alert('친구 신청을 받은 상태입니다. 새로운 소식을 확인해보세요.');
										window.opener.location.href = "home.php";
										window.close();
									} else if (value=='submit'){
										alert('친구 신청이 완료되었습니다. 상대방이 승인할 때 친구로 등록됩니다.');
									} else if (value=='cannot'){
										alert('등록된 아이디가 아닙니다.');
									}
								});
							});
						}
					}
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/>  회원 정보</div></div>
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
	$sql3 = "SELECT * FROM friend WHERE user_num=$user_num AND friend_num=$friend_num";//친구로 등록되어 있는지 확인
	$sql_query3 = mysqli_query($conn, $sql3);
	$count3 = mysqli_num_rows($sql_query3);
	if( !$count3 && ($sql_fetch_array1["user_num"] != $user_num) ){//친구로 등록되어 있지 않고 본인이 아닐경우
		echo '
			<div id="register_admit"><div class="button_gb" style="left:10px;">친구 신청</div></div>
		';
	} else if($count3){//이미 친구로 등록됐을경우
		echo '
			<div style="margin:15px 0 0 0; padding:5px 20px; background-color:#E3F8CC;">친구로 등록된 분입니다.</div>
		';
	}
?>
		</div>
	</div>
	<div id="temp_target"></div>
</body>
</html>