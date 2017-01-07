<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-나의정보</title>
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
	include 'personal.php';
	$myinfo_modify = $_SESSION['myinfo_modify'];
	if($myinfo_modify!="yes"){
		echo "<script>location.href='myinfo.php';</script>";
	}
	$sql1 = "SELECT * FROM user WHERE user_num=$user_num";//개인 정보 가져오기
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
?>
	<script>
		$(document).ready(function () {
			greenStyle();
			menuMyinfo();
			if(user_name=="Guest"){//Guest일 경우 초기화면으로 이동
				location.href="idmaru.php";
			}
			$('#password_').blur(function(){//비밀번호체크
				var pw_len = $(this).val().length;
				if ( pw_len < 4 ) {
					$('#pwcheck').html('비밀번호는 4자 이상이어야 합니다.');
				} else if(pw_len>20){
					$('#password_').val('');
					$('#pwcheck').html('비밀번호는 20자 이하로 해주세요.');
				} else {
					$('#pwcheck').html('');
				}
			});
			$('#password_confirm').blur(function(){//비밀번호확인체크
				var pw = $('#password_').val();
				var pw_c = $('#password_confirm').val();
				if ( pw != pw_c ) {
					$('#pwconfirmcheck').html('비밀번호가 일치하지 않습니다.');
				} else if (pw == pw_c){
					$('#pwconfirmcheck').html('비밀번호가 동일합니다.');
				}
			});
			$('#email').blur(function(){//이메일체크
				var email = $('#email').val();
				var check = isEmail(email);
				if(check==true){
					$("#emailcheck").html("");
				} else if(check==false){
					$("#email").val("");
					$("#emailcheck").html("이메일 형식에 맞게 작성해주세요.");
				}
			});
			$('#return').click(function(){
				location.href="myinfo.php";
			});
			if($("#birthday_y").val()!="" && $("#birthday_m").val()!=""){
				$("#birthday_d").html(calender_date($("#birthday_y").val(), $("#birthday_m").val()));
			}
			$("#birthday_y").change(function(){
				if($("#birthday_y").val()!="" && $("#birthday_m").val()!=""){
					$("#birthday_d").html(calender_date($("#birthday_y").val(), $("#birthday_m").val()));
				} else {
					$("#birthday_d").html('<option value="">선택</option>');
				}
			});
			$("#birthday_m").change(function(){
				if($("#birthday_y").val()!="" && $("#birthday_m").val()!=""){
					$("#birthday_d").html(calender_date($("#birthday_y").val(), $("#birthday_m").val()));
				} else {
					$("#birthday_d").html('<option value="">선택</option>');
				}
			});
		});
		function submit_click(){//수정확인
			var password_ = $("#password_").val();
			var password_confirm = $("#password_confirm").val();
			var email_before = $('#email_before').val();
			var email = $('#email').val();
			if(!password_){
				alert("비밀번호를 입력해주세요");
				$("#password_").focus();
			} else if(!password_confirm){
				alert("비밀번호 확인을 입력해주세요");
				$("#password_confirm").focus();
			} else if(!email){
				alert("이메일 주소를 입력해주세요");
				$("#email").focus();
			} else if(email==email_before){
				var reply = confirm("회원정보를 수정하시겠습니까?");
			} else if(email != email_before){
				var reply = confirm("이메일 정보를 수정할 경우 새로 이메일 인증을 받으셔야 합니다.\n\n이메일 정보를 포함한 회원정보를 수정하시겠습니까?");
			}
			if(reply== true){
				$("#submit").click();
			}
		}
	</script>
</head>
<body>
	<div id="toparea">
<?php include 'toparea.php'; ?>
	</div>
	<div id="bodyarea">
		<div id="mainbar">
			<div id="mainbody">
				<form method="POST" action="myinfo_modify_check.php">
					<header id="page_title"></header>
					<div class="content_area">
					<div style="font-size:10pt; color:#F00;">※ 지인들과 친구를 맺으려면 실명을 입력하시는게 중요합니다!</div>
					<div class="myinfo_item">아이디<input id="myinfo_id" class="myinfo_item_input" type="text" name="id" value="<?php echo "$sql_fetch_array1[id]"; ?>" maxlength="12" tabindex="" readonly="readonly" style="width:160px;"/></div>
					<div class="myinfo_item">비밀번호<input id="password_" class="myinfo_item_input" type="password" name="password_" value="" maxlength="20" tabindex="2" style="width:160px;"/><div id="pwcheck" class="myinfo_item_input_check check"></div></div>
					<div class="myinfo_item">비밀번호확인<input id="password_confirm" class=" myinfo_item_input" type="password" name="password_confirm" value="" maxlength="20" tabindex="3" style="width:160px;"/><div id="pwconfirmcheck" class="myinfo_item_input_check check"></div></div>
					<div class="myinfo_item">e-mail<input id="email" class="myinfo_item_input" type="text" name="email" value="<?php echo "$sql_fetch_array1[email]"; ?>" tabindex="4" style="width:160px;"/><div id="emailcheck" class="myinfo_item_input_check check" style="width:245px;"></div></div>
					<input id="email_before" type="hidden" name="email_before" value="<?php echo "$sql_fetch_array1[email]";?>"/>
					<div class="myinfo_item">성<input id="familyname" class="myinfo_item_input" type="text" name="familyname" value="<?php echo "$sql_fetch_array1[familyname]"; ?>" maxlength="5" tabindex="5"/></div>
					<div class="myinfo_item ">이름<input id="firstname" class="myinfo_item_input" type="text" name="firstname" value="<?php echo "$sql_fetch_array1[firstname]"; ?>" maxlength="15" tabindex="6"/></div>
					<div class="myinfo_item">성별<div class="myinfo_item_input" style="padding:0; border:0;"><span style="">남자 </span><input id="male" style="" type="radio" name="sex" value="M" tabindex="7"/>&nbsp;&nbsp;&nbsp;<span style="">여자 </span><input id="female" style="" type="radio" name="sex" value="F" tabindex="8"/></div></div>
					<script>
						var sex = "<?php echo "$sql_fetch_array1[sex]"; ?>";
						if (sex=="M"){
							$("#male").attr("checked", "checked");
						} else if(sex=="F"){
							$("#female").attr("checked", "checked");
						}
					</script>
					<div class="myinfo_item">생일 연도<select id="birthday_y"  class="myinfo_item_select" name="birthday_y" tabindex="9"><?php echo $select_option_year; ?></select></div>
					<script>$("#birthday_y").val(<?php echo "$sql_fetch_array1[birthday_y]"; ?>);</script>
					<div class="myinfo_item ">월<select id="birthday_m"  class="myinfo_item_select" name="birthday_m" tabindex="10"><?php echo $select_option_month; ?></select></div>
					<script>$("#birthday_m option:eq(<?php echo "$sql_fetch_array1[birthday_m]"; ?>)").attr("selected", "selected");</script>
					<div class="myinfo_item">일<select id="birthday_d"  class="myinfo_item_select" name="birthday_d" tabindex="11"><option value="">선택</option></select></div>
					<script>$("#birthday_d option:eq(<?php echo "$sql_fetch_array1[birthday_d]"; ?>)").attr("selected", "selected");</script>
					<div class="myinfo_item">국가<input id="add_country"  class="myinfo_item_input" type="text" name="add_country" value="<?php echo "$sql_fetch_array1[add_country]"; ?>" tabindex="12" style="width:150px;"/></div>
					<div class="myinfo_item">지역<input id="add_region"  class="myinfo_item_input" type="text" name="add_region" value="<?php echo "$sql_fetch_array1[add_region]"; ?>" tabindex="13" style="width:150px;"/></div>
					<div class="myinfo_item">상세주소<input id="add_detail"  class="myinfo_item_input" type="text" name="add_detail" value="<?php echo "$sql_fetch_array1[add_detail]"; ?>" tabindex="14" style="width:400px;"/></div>
					<div class="myinfo_item">메일수신<div class="myinfo_item_input" style="padding:0; border:0;">승인 <input id="email_refuse_0" style="" type="radio" name="email_refuse" value="0" tabindex="15"/>&nbsp;&nbsp;&nbsp; 거절 <input id="email_refuse_1" style="" type="radio" name="email_refuse" value="1" tabindex="16"/></div></div>
					<script>
						var email_refuse = <?php echo $sql_fetch_array1["email_refuse"]; ?>;
						if (email_refuse==0){
							$("#email_refuse_0").attr("checked", "checked");
						} else if(email_refuse==1){
							$("#email_refuse_1").attr("checked", "checked");
						}
					</script>
					<!--
					<div class="myinfo_item">휴대폰 번호<input id="phone"  class="myinfo_item_input" type="text" name="phone" value="<?php echo "$sql_fetch_array1[phone]"; ?>" maxlength="11" tabindex="15"/><div id="phonecheck" class="myinfo_item_input_check check"></div></div>
					-->
					<!--별명은 추후에 유료서비스화
					<div class="inline"> 별명(nickname)</div>
					<input id="nickname"  class="" type="text" name="nickname" value="<?php //echo "$sql_fetch_array1[nickname]"; ?>" maxlength="12" tabindex="16"/>
					-->
					<br/><div id="submit_button" class="button_gb" tabindex="17" onclick="submit_click()">수정완료</div>
					<div id="return" class="button_gb" style="margin:0 0 0 10px;" tabindex="17">돌아가기</div>
					<input id="submit" type="submit" value="수정완료" class="button_gb none"/>
					</div>
				</form>
			</div>
		</div>
<?php include 'sidebar.php'; ?>
	</div>
	<div id="endarea">
<?php include 'pineforest.php'; ?>
	</div>
	<div id="temp_target"></div>
</body>
</html>
<?php
	
	$_SESSION["myinfo_modify"]='no';//수정화면 접근 불가능으로 설정
?>