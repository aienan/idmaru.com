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
<?php include 'declare.php';?>
<?php include 'personal.php';?>
<?php //광고 문구 조건 설정
	$ad_fixbar_cond = "myinfo";
	$ad_pop_cond = "myinfo";
	$ad_side_cond = "myinfo";
?>
	<script>
		$(document).ready(function () {
			greenStyle();
			menuMyinfo();
			if(user_name=="Guest"){//Guest일 경우 초기화면으로 이동
				location.href="idmaru.php";
			}
			$(".fancybox").fancybox({width:412, height:207, padding:10, scrolling:'no'});
			$("#user_stop").click(function(){
				var reply = confirm("회원 탈퇴를 하시면 회원 정보는 모두 삭제되고 회원 아이디는 재사용이 불가능하게 됩니다.\n\n회원님이 작성하신 글들은 그대로 남게 되므로 삭제를 원하시면 작성글을 삭제 후 탈퇴해 주시기 바랍니다.\n\n회원을 탈퇴하시겠습니까?");
				if(reply==true){
					var reply2 = confirm("다시 한번 확인합니다. 이드마루 회원에서 탈퇴하시겠습니까?");
					if(reply2==true){
						$.ajax({
							url: "user_stop.php",
							data: {},
							success: function(getdata){
								$("body").append(getdata);
								alert("회원에서 탈퇴하셨습니다. 그동안 이용해 주셔서 감사합니다.");
								location.href="idmaru.php";
							}
						});
					}
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
				<div class="content_area">
				<div style="height:29px; margin:0 0 5px 0;"><a id="self_check_window" class="fancybox fancybox.iframe" href="self_check.php"><div id="myinfo_modify_button" class="menu_button mouseover"><img src="../image/page_title_myinfo_modify.png"/></div></a></div>
				<div style="font-size:10pt; color:#F00;">※ 지인들과 친구를 맺으려면 실명을 입력하시는게 중요합니다!</div>
<?php //개인 정보 가져오기
	include 'mysql_setting.php';
	$sql1 = "SELECT * FROM user WHERE user_num=$user_num";
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
?>
				<div class="myinfo_item">아이디<input id="myinfo_id" class="myinfo_item_input" type="text" name="id" value="<?php echo "$sql_fetch_array1[id]"; ?>" maxlength="12" tabindex="" readonly="readonly" style="width:160px;"/></div>
				<div class="myinfo_item">e-mail<input id="email" class="myinfo_item_input" type="text" name="email" value="<?php echo "$sql_fetch_array1[email]"; ?>" tabindex="4" readonly="readonly" style="width:245px;"/><div id="emailcheck" class="myinfo_item_input_check check" style="left:400px;"></div></div>
				<div class="myinfo_item">성<input id="familyname" class="myinfo_item_input" type="text" name="familyname" value="<?php echo "$sql_fetch_array1[familyname]"; ?>" maxlength="5" tabindex="5" readonly="readonly"/></div>
				<div class="myinfo_item ">이름<input id="firstname" class="myinfo_item_input" type="text" name="firstname" value="<?php echo "$sql_fetch_array1[firstname]"; ?>" maxlength="15" tabindex="6" readonly="readonly"/></div>
				<div class="myinfo_item">성별<input id="sex"  class="myinfo_item_input" type="text" name="add_country" value="<?php echo "$sql_fetch_array1[sex]"; ?>" tabindex="12" readonly="readonly" style="padding:0; border:0; width:70px;"/></div>
				<script>
					var sex = "<?php echo "$sql_fetch_array1[sex]"; ?>";
					if (sex=="M"){
						$("#sex").val("남자");
					} else if(sex=="F"){
						$("#female").val("여자");
					}
				</script>
				<div class="myinfo_item">생일연도<input id="birthday_y"  class="myinfo_item_input" type="text" name="add_country" value="<?php echo "$sql_fetch_array1[birthday_y]"; ?>" tabindex="12" readonly="readonly"/></div>
				<div class="myinfo_item ">월<input id="birthday_m"  class="myinfo_item_input" type="text" name="add_country" value="<?php echo "$sql_fetch_array1[birthday_m]"; ?>" tabindex="12" readonly="readonly"/></div>
				<div class="myinfo_item">일<input id="birthday_d"  class="myinfo_item_input" type="text" name="add_country" value="<?php echo "$sql_fetch_array1[birthday_d]"; ?>" tabindex="12" readonly="readonly"/></div>
				<div class="myinfo_item">국가<input id="add_country"  class="myinfo_item_input" type="text" name="add_country" value="<?php echo "$sql_fetch_array1[add_country]"; ?>" tabindex="12" readonly="readonly" style="width:150px;"/></div>
				<div class="myinfo_item">지역<input id="add_region"  class="myinfo_item_input" type="text" name="add_region" value="<?php echo "$sql_fetch_array1[add_region]"; ?>" tabindex="13" readonly="readonly" style="width:150px;"/></div>
				<div class="myinfo_item">상세주소<input id="add_detail"  class="myinfo_item_input" type="text" name="add_detail" value="<?php echo "$sql_fetch_array1[add_detail]"; ?>" tabindex="14" readonly="readonly" style="width:400px;"/></div>
				<div class="myinfo_item">메일수신<div class="myinfo_item_input" style="padding:0; border:0;"><?php if($sql_fetch_array1["email_refuse"]==0){echo '승인';}else{echo '거절';}?></div></div>
				<!--
				<div class="myinfo_item">휴대폰 번호<input id="phone"  class="myinfo_item_input" type="text" name="phone" value="<?php //echo "$sql_fetch_array1[phone]"; ?>" maxlength="11" tabindex="15" readonly="readonly"/><div id="phonecheck" class="myinfo_item_input_check check"></div></div>
				-->
				<!--별명은 추후에 유료서비스화
				<div class="inline"> 별명(nickname)</div>
				<input id="nickname"  class="" type="text" name="nickname" value="<?php //echo "$sql_fetch_array1[nickname]"; ?>" maxlength="12" tabindex="16"/>
				-->
				<div class="content_title_green" style="margin:100px 0 5px 0;">회원 탈퇴하기<div id="user_stop" class="button_gray">회원 탈퇴</div></div>
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