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
<?php
	include 'declare_php.php';
	$count_group = $_REQUEST["count_group"];
?>
	<script>
		$(document).ready(function () {
		});
	</script>
</head>
<body class="popup_body">
	<div id="bodyarea_write">
		<br/><h6 class="popup_title"><img src="../image/list_pineB.png" style="position:relative; top:2px;"/> 회원 정보</h6><br/>
<?php
	$output1 = '';
	$sql = "SELECT * FROM club_group_member WHERE count_group = $count_group AND user_num = $user_num";//회원 여부 확인
	$sql_query = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($sql_query);
	$row_height = 34;
	$divide_num = 5;
	if($count==1){//회원일 경우
		$sql4 = "SELECT * FROM club_group_member WHERE count_group = $count_group";//모임의 회원 user_num 검색
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);
		$sql5 = "SELECT * FROM club_group WHERE count_group = $count_group";//모임 정보 보기
		$sql_query5 = mysqli_query($conn, $sql5);
		$sql_fetch_array5 = mysqli_fetch_array($sql_query5);
		$group_name = $sql_fetch_array5["group_name"];
		$output1 .= '
			<div id="club_group_info">
				<div id="club_group_name">'.$group_name.' ('.$count4.'명)</div>
		';
		for($i=0; $i<$count4; $i++){//회원 목록 출력
			$sql_fetch_array4 = mysqli_fetch_array($sql_query4);
			$sql1 = "SELECT * FROM user WHERE user_num = $sql_fetch_array4[user_num]";//회원정보 검색
			$sql_query1 = mysqli_query($conn, $sql1);
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$member_name = $sql_fetch_array1["user_name"];
			$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array4[user_num]";//idcard의 사진을 띄운다
			$sql_query17 = mysqli_query($conn, $sql17);
			$count17 = mysqli_num_rows($sql_query17);
			if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
			else{$user_photo_path = "../image/blank_face.png";}
			$num = $i % $divide_num;
			if($num==0){$output1 .= '<div class="relative" style="height:'.$row_height.'px;">';}
			$output1 .= '
				<div id="club_group_member'.$sql_fetch_array4["user_num"].'" class="list_pos'.$num.'">
					<div class="zindex1 padding5">'.$member_name.user_info($user_num, $sql_fetch_array4["user_num"], $sql_fetch_array1["user_name"], $user_photo_path).'</div>
				</div>
			';
			if(($num==($divide_num-1)) || ($i==($count4 - 1))){$output1 .= '</div>';}
		}
		$output1 .= '</div>'; // club_group_info div의 끝
		echo $output1;
		echo '
			<script>
				$(".zindex1").hover(function(){
					$(this).children(".user_info").css({"display":"block"});
				}, function(){
					$(this).children(".user_info").css({"display":"none"});
				});
			</script>
			<h6 class="popup_title" style="margin:100px 0 0 0;"><img src="../image/list_pineB.png" style="position:relative; top:2px;"/> 모임 탈퇴하기</h6>
			<div id="club_group_quit" class="button_gb" style="position:relative; display:inline-block; margin:10px;">탈퇴하기</div>
			<script>
				var status_position = "member";
				$("#club_group_quit").click(function(){
					var reply = confirm("\" '.$group_name.' \" 에서 탈퇴하시겠습니까?");
					if(reply==true){
						var reply1 = confirm("한번 더 확인합니다. 정말 모임( '.$group_name.' )에서 탈퇴하시겠습니까?");
						if(reply1==true){
							$.ajax({//이벤트 출력
								url:"club_group_quit.php",
								data: {status_position:status_position, count_group:'.$count_group.'},
								success: function(getdata){
									window.open("club_group.php", "idmaru", "");
									alert("\" '.$group_name.' \" 에서 탈퇴하였습니다");
									window.close();
								}
							});
						}
					}
				});
			</script>
		';
	}
?>
	</div>
	<div id="temp_target"></div>
</body>
</html>