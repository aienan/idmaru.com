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
<?php
	include 'mysql_setting.php';
	$sql1 = "SELECT * FROM guest_message_refuse WHERE user_num = $user_num";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
?>
	<script>
		$(document).ready(function () {
			$("#refuse_submit").click(function(){
				var refuse_user_name = $("#keyword_inputB").val();
				if(!refuse_user_name){
					alert("아이디(웹이름)를 입력해주세요");
				} else if(refuse_user_name){
					var reply = confirm("차단자를 등록하시겠습니까?");
					if(reply==true){
						var type = "insert";
						$.ajax({
							url:'guest_message_refuse_register.php',
							data: {type:type, refuse_user_name:refuse_user_name},
							success: function(getdata){
								if(getdata=="none"){
									alert("아이디(웹이름)을 정확히 입력해주세요");
								} else if(getdata == "already"){
									alert("이미 등록된 아이디(웹이름)입니다");
								} else if(getdata == "done"){
									alert("차단자가 등록되었습니다");
									location.reload();
								}
							}
						});
					}
				}
			});
			$('#keyword_inputB').keyup(function () {
				if(event.keyCode=="13"){//Enter를 눌렀을때
					$("#refuse_submit").click();
				}
			});
		});
		function keyword_delete(refuse_user_name){
			var reply = confirm("차단자를 삭제하시겠습니까?");
			if(reply==true){
				var type = "delete";
				$.ajax({
					url:'guest_message_refuse_register.php',
					data: {type:type, refuse_user_name:refuse_user_name},
					success: function(getdata){
						if(getdata == "already"){
							alert("등록된 차단자가 없습니다");
						} else if(getdata == "done"){
							alert("차단자가 목록에서 삭제 되었습니다");
							location.reload();
						}
					}
				});
			}
		}
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body class="popup_body">
	<div id="bodyarea_write">
		<h6 class="popup_title"><img src="../image/list_pineB.png" style="position:relative; top:2px;"/> 수신차단 등록</h6>
		<div class="bold" style="margin:10px 0 0px 0;">※ 아이디(웹이름)을 입력해주세요.</div>
		<input id="keyword_inputB" class="input_blue inline padding3" style="width:210px;" type="text" name="search" value="" maxlength="30" tabindex=""/>
		<div id="refuse_submit" class="button_gb inline">등록</div>
		<div id="register_check" class="check"></div>
		<h6 class="popup_title" style="margin:30px 0 0 0; "><img src="../image/list_pineB.png" style="position:relative; top:2px;"/> 차단 목록</h6><br/>
		<div id="keyword_registered">
<?php
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[refuse_user_num]";
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		echo '
			<div><div class="keyword_item">'.$sql_fetch_array2["user_name"].'</div><div id="keyword_item_delete_$i" class="button_gb keyword_item_delete" onclick="keyword_delete(\''.$sql_fetch_array2["user_name"].'\')">삭제</div></div>
		';
	}
	if($count1==0){
		echo '
			<div style="font-weight:bold;">등록된 차단자가 없습니다</div>
		';
	}
?>
		</div>
	</div>
	<div id="temp_target"></div>
</body>
</html>