<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-로그인</title>
	<link type="text/css" rel="stylesheet" href="../css/login.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>var user_name="<?php echo $user_name;?>";</script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script>
		$(document).ready(function () {
			if(getCookie("auto_login")=="agree"){//자동로그인할 경우
				$.ajax({
					url:'login.php',
					data: {auto_login_set:getCookie("auto_login"), save_id_set:getCookie("save_id"), secd:getCookie("secd"), secs:getCookie("secs")},
					success: function(getdata){
						if(getdata=="success"){parent.location.reload(); parent.$.fancybox.close();}
						else{setCookie("secd", "", -1, "/", ""); setCookie("secs", "", -1, "/", ""); setCookie("auto_login", "", -1, "/", ""); setCookie("save_id", "", -1, "/", ""); parent.location.reload(); parent.$.fancybox.close();}
					}
				});
			}else if(getCookie("save_id")=="agree"){$("#id").val(getCookie("secd")); $("#save_id").attr("checked", true);}
			document.getElementById("id").focus();//로그인박스에 focus설정
			$("#enter").click(function(){
				var id = $("#id").val();
				var password_ = $("#password_").val();
				if(!id){
					alert("아이디를 입력해주세요");
				} else if(!password_){
					alert("비밀번호를 입력해주세요");
				} else {
					if($("#save_id").is(":checked")==true){var save_id_set = "agree";}
					else{var save_id_set="";}
					if($("#auto_login").is(":checked")==true){var auto_login_set = "agree";}
					else{var auto_login_set="";}
					$.ajax({
						url:'login.php',
						data: {id:id, password_:password_, save_id_set:save_id_set, auto_login_set:auto_login_set},
						success: function(getdata){
							if(getdata=="no_id"){
								alert("존재하지 않는 아이디입니다");
							} else if(getdata=="user_stop"){
								alert("회원에서 탈퇴하셨습니다. 문의사항은 idmaru@idmaru.co.kr로 보내주시기 바랍니다.");
							} else if(getdata=="user_banned"){
								alert("이용 정지된 회원이십니다. 문의사항은 idmaru@idmaru.co.kr로 보내주시기 바랍니다.");
							} else if(getdata=="email_certify"){
								window.open("email_certify_yet.php?id="+id, "email_certify_yet", "width=600,height=300,resizable=yes,scrollbars=yes,location=no");
							} else if(getdata=="no_password"){
								alert("비밀번호가 맞지 않습니다");
							} else if(getdata=="success"){
								window.opener.location.reload();
								window.close();
							}
						}
					});
				}
			});
			$('#id, #password_box').keyup(function () {
				if(event.keyCode=="13"){//Enter를 눌렀을때
					$("#enter").click();
				}
			});
			$("#find_id_password").click(function(){
				window.open("find_id_password.php", "find_id_password", "width=770,height=300,resizable=yes,scrollbars=yes,location=no");
			});
		});
	</script>
</head>
<body>
	<div id="loginbox" style="margin:100px auto;">
		<div id="idbox"><input id="id" type="text" name="id" value="" maxlength="12" tabindex="1"/></div>
		<div id="password_box"><input id="password_" type="password" name="password_" value="" maxlength="20" tabindex="2"/></div>
		<div id="enter" tabindex="3"></div>
		<div style="position:absolute; left:150px; top:103px; font-size:9pt; color:#234F32;">
			<span>아이디저장 <input id="save_id" type="checkbox" name="save_id_set" value="agree" tabindex="" style="position:relative; top:1px;"/></span>&nbsp;
			<span>자동로그인 <input id="auto_login" type="checkbox" name="auto_login_set" value="agree" tabindex="" style="position:relative; top:1px;"/></span>
		</div>
		<div id="find_id_password">아이디 & 비밀번호 찾기</div>
	</div>
	<div id="temp_target"></div>
</body>
</html>