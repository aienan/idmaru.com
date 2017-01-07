<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-친구관리</title>
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
<?php include 'declare.php';?>
<?php include 'personal.php';?>
<?php //광고 문구 조건 설정
	$ad_fixbar_cond = "home_friend";
	$ad_pop_cond = "home_friend";
	$ad_side_cond = "home_friend";
?>
	<script>
		var home_type = 'friend';
		$(document).ready(function () {
			greenStyle();
			menuHome();
			$("#friend_search_name").css({"border":"#688009 1px solid", "color":"#688009"});
			var user_name = "<?php echo $user_name; ?>";
			$.ajax({//개인방명록 출력
				url:'home_friend_waiting_recall.php',
				data: {},
				success: function(getdata){
					$('#friend_waiting_list_content').append(getdata);
				}
			});
			$('#friend_waiting_list').click(function(){//친구목록 클릭시
				if(user_name=="Guest"){
					alert('로그인 후 이용해주세요');
				} else {//회원일 경우
					if($("#friend_waiting_list_content").css("display")=="block"){
						$("#friend_waiting_list_content").css("display", "none");
					} else {
						$("#friend_waiting_list_content").css("display", "block");
					}
				}
			});
			$('#register_admit').click(function(){//친구신청하기
				if(user_name=='Guest'){
					alert('로그인 후 이용해주세요');
				} else {
					var friend_name = $('input:text[name=friend_name]').val();
					if(!friend_name){//아무것도 입력하지 않았을때
						alert('웹이름 혹은 id를 입력해주세요.');
					} else if(friend_name){//이름을 입력했을 때
						var isidmaruid = is_idmaru_id(friend_name);
						if(isidmaruid != -1){
							alert("이드마루 관리자는 친구 신청에서 제외됩니다.");
						} else {
							var reply = confirm("친구 신청하시겠습니까?");
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
											location.href = "home.php";
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
				}
			});
			$("input[name=friend_name]").keyup(function () {//수정용textarea 설정
				if(event.keyCode=="13"){//Enter를 눌렀을때
					$("#register_admit").click();
				}
			});
			if(user_name!='Guest'){//친구목록
				$.ajax({
					url:'home_friend_list.php',
					success: function(getdata){
						$('#friend_list').html(getdata);
						$("#friend_list_loading").css("display", "none");
					}
				});
			}
			$('#friend_search_button').click(function(){//친구검색
				var radioval = "email";
				var friend_search_input = $('input:text[name=search]').val();
				$("#friend_search_check").html("");
				var check=isEmail(friend_search_input);
				if(check==false){
					$('input:text[name=search]').val('');
					$('#friend_search_check').html('E-Mail 형식에 맞게 입력해주세요.');
				} else if(check==true){
					$("#friend_search_check_loading").css("display", "block");
					$.ajax({
						url:'home_friend_search_result.php',
						data: {type: radioval, input: friend_search_input},
						success: function(getdata){
							if (getdata!='none'){
								$('#friend_search_list').css("display", "block");
								$('#friend_search_list').html(getdata);
							} else if (getdata=='none'){
								$('#friend_search_list').css("display", "none");
								$("#friend_search_check").css("display", "block");
								$('#friend_search_check').html('이드마루에 등록된 주소가 아닙니다.');
							}
							$("#friend_search_check_loading").css("display", "none");
						}
					});
				}
			});
			$("#search_name_birth").click(function(){
				var radioval = "name";
				var familyname1 = $("#familyname1").val();
				var firstname1 = $("#firstname1").val();
				var birthday_y = $("select[name=birthday_y] > option:selected").val();
				var birthday_m = $("select[name=birthday_m] > option:selected").val();
				var birthday_d = $("select[name=birthday_d] > option:selected").val();
				if(!familyname1){
					alert("검색하고자 하는 회원님의 성을 입력해주세요");
				} else if(!firstname1){
					alert("검색하고자 하는 회원님의 이름을 입력해주세요");
				} else {
					$("#friend_search_check_loading").css("display", "block");
					$.ajax({
						url:'home_friend_search_result.php',
						data: {type: radioval, familyname:familyname1, firstname:firstname1, birthday_y:birthday_y, birthday_m:birthday_m, birthday_d:birthday_d},
						success: function(getdata){
							if (getdata!='none'){
								$("#friend_search_check").css("display", "none");
								$('#friend_search_list').css("display", "block");
								$('#friend_search_list').html(getdata);
							} else if (getdata=='none'){
								$('#friend_search_list').css("display", "none");
								$('#friend_search_check').css("display", "block");
								$('#friend_search_check').html('이드마루에 등록된 정보가 없습니다.');
							}
							$("#friend_search_check_loading").css("display", "none");
						}
					});
				}
			});
			$('#search_text').keyup(function () {
				if(event.keyCode=="13"){//Enter를 눌렀을때
					$("#friend_search_button").click();
				}
			});
			var friend_search = 1;//mouse가 올라갔을때 그림파일 설정을 위한 변수
			$("#friend_search_name").click(function(){
				friend_search = 1;
				$("#search_email_box, #friend_search_list").css("display", "none");
				$("#search_name_box").css("display", "block");
				$("#friend_search_check").html("");
				$("#familyname1, #firstname1").val("");
				$("#birthday_y, #birthday_m, #birthday_d").val("");
				$("#friend_search_name").css({'border':'#688009 1px solid', 'color':'#688009'});
				$("#friend_search_email").css({'border':'#CCCCCC 1px solid', 'color':'#CCCCCC'});
			});
			$("#friend_search_email").click(function(){
				friend_search = 2;
				$("#search_name_box, #friend_search_list").css("display", "none");
				$("#search_email_box").css("display", "block");
				$("#friend_search_check").html("");
				$("#search_text").val("");
				$("#friend_search_name").css({'border':'#CCCCCC 1px solid', 'color':'#CCCCCC'});
				$("#friend_search_email").css({'border':'#688009 1px solid', 'color':'#688009'});
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
		});
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body>
	<div id="toparea">
<?php include 'toparea.php'; ?>
	</div>
	<div id="bodyarea">
		<div id="mainbar">
			<div id="mainbody">
				<header id="page_title"></header>
				<nav class="menu_square">
					<a href="home.php"><div id="menu_square_home" class="menu_square_item">새소식</div></a>
					<a href="home_friend.php"><div id="menu_square_friend" class="menu_square_item">친구관리</div></a>
				</nav>
				<div class="content_area">
				<div class="content_title_green" style="margin:0 0 20px 0;">회원 검색</div>
				<div class="menu_square2" style="left:10px; margin:0 0 5px 0;">
					<div id="friend_search_name" class="menu_square2_item">이름&생년월일</div>
					<div id="friend_search_email" class="menu_square2_item">E-Mail</div>
				</div>
				<div style="padding:5px 15px 10px 15px;">
				<div id="search_name_box">
					<div class="item item_desc"><span class="red">※ 성과 이름은 필수 입력 사항입니다.</span> 생년월일은 선택사항입니다.</div>
					<div class="item">성<input id="familyname1" class="input_gray" type="text" name="familyname1" value="" maxlength="5" tabindex="5"/></div>
					<div class="item">이름<input id="firstname1" class="input_gray" type="text" name="firstname1" value="" maxlength="15" tabindex="6"/></div>
					<div class="item">생년월일<span class="first_item"><select id="birthday_y" name="birthday_y" tabindex="9"><?php echo $select_option_year;?></select>년&nbsp;&nbsp;
					<select id="birthday_m" name="birthday_m" tabindex="10"><?php echo $select_option_month;?></select>월&nbsp;&nbsp;
					<select id="birthday_d" name="birthday_d" tabindex="11"><option selected value="">선택</option></select>일</span></div>
					<div id="search_name_birth" class="mouseover"><img src="../image/home_friend_search.png"/></div>
				</div>
				<div id="search_email_box">
					<div id="email_desc">(ex) idmaru@idmaru.co.kr</div>
					<input id="search_text" class="input_gray" type="text" name="search" value="" tabindex="" style="padding:5px; width:245px; font-size:11pt;"/>
					<div id="friend_search_button" class="mouseover"><img src="../image/home_friend_search.png"/></div>
				</div>
				<div id="friend_search_check_loading" class="loading16x16" style="display:none; left:100px; top:-1px;"></div>
				<div id="friend_search_check" class="check"></div>
				<div id="friend_search_list"></div>
				</div>
<?php include 'ad_textA.php';?>
				<div class="content_title_green" style="margin:40px 0 0 0; z-index:2;">친구 신청<div id="friend_waiting_list" class="button_gb">신청 현황</div><div id="friend_waiting_list_content"><div style="padding:0 5px; margin:0 0 5px 0; background-color:#DEF0F5;">신청 대기자</div></div></div>
				<div class="content_area">
				<div style="margin:0px 0 5px 0; font-size:10pt; font-weight:bold;">※ 아이디(id) 혹은 웹이름을 입력해주세요.</div>
				<div class="relative">
				<input class="input_gray" type="text" name="friend_name" value="" maxlength="15" tabindex="" style="width:240px; padding:4px 5px;"/>
				<div id="register_admit" class="button_gb" style="display:inline-block; margin:0 0 0 15px; width:90px;">친구 신청</div>
				</div>
				</div>
				<div class="content_title_green" style="margin:40px 0 0 0;">친구 목록</div>
					<div class="content_area">
<?php
if($user_num != 0){
	echo '
			<div id="friend_list" style="line-height:1.6;">
				<div id="friend_list_loading" class="loading24x24" style="left:350px;"></div>
			</div>
	';
} else {
	echo '
			<div class="guest_inform"> 회원가입 하시면 친구를 등록하실 수 있습니다.</div>
	';
}
?>
					</div>
				</div>
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