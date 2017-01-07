<?php include 'header.php';?>
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
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<?php
	if($_SESSION["auto_prevent"] != 1){//자동가입방지 페이지를 통해 들어왔는지 확인
		echo '<script>alert("잘못된 경로입니다"); location.href="idmaru.php";</script>';
	}
	$_SESSION["auto_prevent"] = 0; // 다시 들어오지 못하게 수정
	include 'select_menu.php';
	include 'pineforest_policy_content.php';
?>
	<script>
		$(document).ready(function () {
			$("#id").focus();
			$('#id').blur(function(){//아이디체크
				var id = $('#id').val();
				var check = isNocap(id);
				if(check==false){
					$('#id').val('');
					$('#idcheck').html('아이디는 영문소문자 혹은 숫자만 가능합니다.');
				} else if(check==true){
					var is_english = isthereEnglish(id);
					if(is_english==-1){
						$("#id").val('');
						$("#idcheck").html("영문소문자가 하나 이상 포함되어야 합니다");
					} else {
						var id_len = $(this).val().length;
						if ( id_len < 4 ) {
							$('#id').val('');
							$('#idcheck').html('아이디는 4자 이상입니다.');
						} else if(id_len >12){
							$('#id').val('');
							$('#idcheck').html('아이디는 12자 이하입니다.');
						} else {
							if(is_idmaru_id(id) != -1){
								$('#id').val('');
								$('#idcheck').html('맨 앞에 idmaru가 들어갈 수 없습니다.');
							} else if(is_guest_id(id) != -1){
								$('#id').val('');
								$('#idcheck').html('맨 앞에 guest가 들어갈 수 없습니다.');
							} else {
								var senddata = { id : id };
								$.getJSON( 'join_idcheck.php', senddata, function (getdata) {
									$.each(getdata, function (key, value) {
										if ( value == 'exist' ) {
											$('#id').val('');
											$('#idcheck').html('동일한 ID가 존재합니다');
										} else if ( value == 'notyet' ) {
											$('#idcheck').html('사용가능한 ID입니다');
										}
									});
								});
							}
						}
					}
				}
			});
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
				if(check==false){
					$('#email').val('');
					$('#emailcheck').html('이메일 형식에 맞게 작성해주세요.');
				} else if(check==true){
					var senddata = { email : email };
					$.getJSON( 'join_emailcheck.php', senddata, function (getdata) {
						$.each(getdata, function (key, value) {
							if ( value == 'exist' ) {
								$('#email').val('');
								$('#emailcheck').html('동일한 이메일이 존재합니다');
							} else if ( value == 'notyet' ) {
								$('#emailcheck').html('');
							}
						});
					});
				}
			});
			$('#clause_agree2').click(function() {
				$('#clause_agree1').click();
			});
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
			$("#submit").click(function(){
				var id = $("#id").val();
				var password_ = $("#password_").val();
				var password_confirm = $("#password_confirm").val();
				var password_check = ($('#pwconfirmcheck').html() != '비밀번호가 일치하지 않습니다.');
				var email = $("#email").val();
				var clause_agree1 = $("#clause_agree1").is(":checked");
				if(!id){
					alert("아이디를 입력해주세요");
					event.preventDefault ? event.preventDefault() : event.returnValue=false;
				} else if(!password_){
					alert("비밀번호를 입력해주세요");
					event.preventDefault ? event.preventDefault() : event.returnValue=false;
				} else if(!password_confirm){
					alert("비밀번호 확인을 입력해주세요");
					event.preventDefault ? event.preventDefault() : event.returnValue=false;
				} else if(password_check != true){
					alert("비밀번호가 일치하지 않습니다");
					event.preventDefault ? event.preventDefault() : event.returnValue=false;
				} else if(!email){
					alert("이메일 주소를 입력해주세요");
					event.preventDefault ? event.preventDefault() : event.returnValue=false;
				} else if(clause_agree1 != true){
					alert("이드마루 표준약관에 동의해 주세요");
					event.preventDefault ? event.preventDefault() : event.returnValue=false;
				}
			});
		});
	</script>
</head>
<body>
	<form method="POST" action="join_submit.php">
		<div class="relative" style="border-bottom:#CBCBCB 2px solid;height:22px; line-height:1.4; z-index:1;"><div id="join">회 원 가 입</div></div>
		<div class="relative" style="margin:0 0 20px 0; color:#AAA; font-size:8pt;">회원정보는 회원님의 명백한 동의 없이 공개 또는 제3자에게 제공되지 않습니다.</div>
		<div class="title">필수입력정보</div>
		<div id="idbox" class="join_item">아&nbsp;이&nbsp;디<input id="id" class="input_blue join_item_input" type="text" name="id" value="" maxlength="12" tabindex="1"/><div id="idcheck" class="join_item_check">아이디는 영문소문자 혹은 숫자만 가능합니다.</div></div>
		<div id="pwbox" class="join_item">비밀번호<input id="password_" class="input_blue join_item_input" type="password" name="password_" value="" maxlength="20" tabindex="2"/><div id="pwcheck" class="join_item_check"></div></div>
		<div id="pwconfirmbox" class="join_item">비밀번호 확인<input id="password_confirm" class="input_blue join_item_input" type="password" name="password_confirm" value="" maxlength="20" tabindex="3"/><div id="pwconfirmcheck" class="join_item_check"></div></div>
		<div id="emailbox" class="join_item">E-Mail<input id="email" class="input_blue join_item_input" type="text" name="email" value="" tabindex="4"/><div id="emailcheck" class="join_item_check" style="left:415px;"></div></div>
		<br/>
		<div class="title">상세정보<span class="desc">(선택적으로 입력하셔도 됩니다)</span></div>
		<div style="font-size:10pt; color:#F00;">※ 지인들과 친구를 맺으려면 실명을 입력하시는게 중요합니다!</div>
		<div class="join_item">성<input id="familyname" class="input_blue" type="text" name="familyname" value="" maxlength="5" tabindex="5"/></div>
		<div class="join_item">이름<input id="firstname" class="input_blue" type="text" name="firstname" value="" maxlength="15" tabindex="6"/></div>
		<div class="join_item">성별<span id="male_title">남자 <input id="male" type="radio" name="sex" value="M" checked tabindex="7"/>&nbsp;&nbsp;&nbsp; 여자 <input id="female" type="radio" name="sex" value="F" tabindex="8"/></span></div>
		<div class="join_item">생년월일<span class="first_item"><select id="birthday_y" name="birthday_y" tabindex="9"><?php echo $select_option_year;?></select>년&nbsp;&nbsp;
		<select id="birthday_m" name="birthday_m" tabindex="10"><?php echo $select_option_month;?></select>월&nbsp;&nbsp;
		<select id="birthday_d" name="birthday_d" tabindex="11"><option selected value="">선택</option></select>일</span></div>
		<div class="join_item">국가<input id="add_country" class="input_blue" type="text" name="add_country" value="대한민국" tabindex="12"/></div>
		<div class="join_item">지역<input id="add_region" class="input_blue" type="text" name="add_region" value="" tabindex="13"/></div>
		<div class="join_item">상세주소<input id="add_detail" class="input_blue" type="text" name="add_detail" value="" tabindex="14"/></div>
		<br/>
		<div class="title">이드마루 표준약관</div>
		<textarea name="clause" cols="80" rows="15" readonly="readonly"><?php echo $pineforest_policy_content;?></textarea>
		<div class="relative"><input id="clause_agree1" class="inline pointer" type="checkbox" name="clause_agree" value="agree" tabindex="15"/><div id="clause_agree2" class="inline pointer">&nbsp; 위 약관에 동의합니다.</div></div>
		<div class="relative" style="margin:30px 0 0 0;"><input id="submit" class="button_gb" type="submit" value="회원 가입" class="button_gb" tabindex="16"/>
		<input id="reset" class="button_gb" type="reset" value="다시 입력" class="button_gb" tabindex="17"/></div>
	</form>
	<div id="temp_target"></div>
</body>
</html>