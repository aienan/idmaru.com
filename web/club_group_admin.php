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
	include 'declare.php';
	$count_group = $_REQUEST["count_group"];
	$sql2 = "SELECT COUNT(*) AS count_all FROM club_group WHERE count_group=$count_group AND user_num=$user_num";
	$sql_query2 = mysqli_query($conn, $sql2);
	$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
	if($sql_fetch_array2["count_all"]==0){echo '<script>alert("잘못된 접근 경로입니다!");</script>'; exit();}
?>
	<script>
		$(document).ready(function () {
			var count_group = <?php echo $count_group; ?>;
			$.ajax({//개인방명록 출력
				url:'group_member_register_status.php',
				data: {count_group:count_group},
				success: function(getdata){
					$('#register_status_content').append(getdata);
				}
			});
			$("#keyword_register_button").click(function(){
				var keyword = $("#keyword_inputA").val();
				if(!keyword){
					alert("초대할 회원을 입력해주세요");
				} else if(keyword){
					var reply = confirm("입력한 회원님을 초대하시겠습니까?");
					if(reply==true){
						$.ajax({
							url:'club_group_invite_submit.php',
							data: {keyword:keyword, count_group:count_group},
							success: function(getdata){
								if(getdata == "none"){
									alert("존재하지 않는 회원입니다");
								} else if(getdata == "already"){
									alert("이미 등록된 회원입니다");
								} else if(getdata == "invited"){
									alert("현재 초대되어 있는 상태입니다");
								} else if(getdata == "done"){
									alert(keyword + " 회원님께 초대 메시지를 전송하였습니다");
								}
							}
						});
					}
				}
			});
			$("input[name='search']").keyup(function(){//엔터키를 쳤을때
				if(event.keyCode==13){
					$("#keyword_register_button").click();
				}
			});
			$("#register_status").click(function(){
				if($("#register_status_content").css("display")=="block"){
					$("#register_status_content").css("display", "none");
				} else {
					$("#register_status_content").css("display", "block");
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div id="bodyarea_write">
		<h6 class="popup_title" style="margin:20px 0 10px 0;"><img src="../image/list_pineB.png" style="position:relative; top:2px;"/> 회원 초대하기</h6>
		<div style="margin:0 10px;">
		<div class="relative"><h6 class="inline">초대할 회원님의 별명 혹은 아이디를 입력해주세요</h6>><div id="register_status" class="button_sw inline" style="margin:0 0 0 10px;">초대현황</div><div id="register_status_content"></div></div>
		<div style="margin:5px 0 0 0;"><input id="keyword_inputA" class="input_blue inline" type="text" name="search" value="" tabindex="" style="margin:0 10px 0 0; padding:4px;"/>
		<div id="keyword_register_button" class="button_gb inline">초대하기</div></div>
		</div>
		<h6 class="popup_title" style="margin:70px 0 0 0;"><img src="../image/list_pineB.png" style="position:relative; top:2px;"/> 회원 목록</h6><br/>
<?php
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
					<div class="zindex1 padding5">'.$member_name.user_info_groupA($user_num, $sql_fetch_array4["user_num"], $sql_fetch_array1["user_name"], $user_photo_path, $count_group).'</div>
				</div>
			';
			if(($num==($divide_num-1)) || ($num==$count4 - 1)){$output1 .= '</div>';}
		}
		$output1 .= '</div>';
		echo $output1;
		echo '
			<script>
				$(".zindex1").hover(function(){
					$(this).children(".user_info").css({"display":"block"});
				}, function(){
					$(this).children(".user_info").css({"display":"none"});
				});
			</script>
		';
	}
?>
	</div>
	<div id="temp_target"></div>
</body>
</html>