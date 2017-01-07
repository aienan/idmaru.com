<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-회원가입</title>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/join.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script>
		$(document).ready(function () {
			$("#find_id_submit").click(function(){
				var find_id_email = $("#find_id_email").val();
				if(isEmail(find_id_email)==false){alert("이메일 주소를 다시 한번 확인해주세요");}
				else {
					$.ajax({
						url: "find_id_submit.php",
						data: {find_id_email:find_id_email},
						success: function(getdata){
							if(getdata != "thereisnoid"){
								alert("회원님의 id는 '"+getdata+"' 입니다.");
							} else if(getdata=="thereisnoid"){
								alert("이메일 주소를 다시 한번 확인해 주세요.");
							}
						}
					});
				}
			});
			$("#find_id_email").keyup(function(){
				if(event.keyCode=="13"){
					$("#find_id_submit").click();
				}
			});
			$("#find_password_submit").click(function(){
				var find_password_id = $("#find_password_id").val();
				var find_password_email = $("#find_password_email").val();
				if(!find_password_id){alert("아이디를 입력해주세요");}
				else if(!find_password_email){alert("이메일 주소를 입력해주세요");}
				else if(isEmail(find_password_email)==false){alert("이메일 주소를 다시 한번 확인해주세요");}
				else {
					var reply = confirm("기존의 비밀번호가 지워지고 이메일로 임시 비밀번호가 전송됩니다. 진행하시겠습니까?");
					if(reply==true){
						$.ajax({
							url: "find_password_submit.php",
							data: {find_password_id:find_password_id, find_password_email:find_password_email},
							success: function(getdata){
								if(getdata != "notcorrectinfo"){
									alert("회원님의 이메일로 임시 비밀번호가 발송되었습니다.");
									window.close();
								} else if(getdata=="notcorrectinfo"){
									alert("입력하신 정보를 다시 한번 확인해 주세요.");
								}
							}
						});
					}
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div id="find_id" class="box1">
		<div class="box1_title"><img src="../image/login_findA.png" style="position:relative; top:3px;"/> 아이디 찾기</div>
		<div style="margin:20px 0 10px 0;">※ 등록하신 이메일 주소를 입력해주세요</div>
		<input id="find_id_email" class="input_blue" type="text" name="find_id_email" value=""/>
		<div id="find_id_submit" class="button_gb">입력</div>
	</div>
	<div id="find_password" class="box1">
		<div class="box1_title"><img src="../image/login_findA.png" style="position:relative; top:3px;"/> 비밀번호 찾기</div>
		<div class="relative" style="margin:20px 5px 10px 3px;">I D <div class="box_colon">:</div> <input id="find_password_id" class="input_blue" type="text" name="find_password_id" value="" maxlength="12"/></div>
		<div class="relative" style="margin:10px 3px;">E-Mail <div class="box_colon">:</div> <input id="find_password_email" class="input_blue" type="text" name="find_password_email" value=""/></div>
		<div style="position:relative;"><div id="find_password_submit" class="button_gb">비밀번호 찾기</div></div>
	</div>
	<div id="temp_target"></div>
</body>
</html>