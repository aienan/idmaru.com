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
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
<?php
	include 'declare.php';
	$type = 'select_list';
?>
	<script>
		$(document).ready(function () {
			var ajaxform_options = {
				target: "#temp_target"
			};
			$('#photo_battle_category_enroll').click(function(){//등록 입력시
				if(user_name=="Guest"){
					alert('로그인 후 이용하실 수 있습니다.');
				} else {//회원일 경우
					var photo_battle_category_word = $("#photo_battle_category_word").val();
					if(!photo_battle_category_word){
						alert("종목명을 입력해주세요");
					} else {
						var reply = confirm("종목으로 등록되면 지울 수 없습니다.\n이상형월드컵의 종목을 등록하시겠습니까?");
						if(reply==true){
							$.ajax({//이상형월드컵의 카테고리를 보여준다
								url:'photo_battle_category_enroll_submit.php',
								data: {photo_battle_category_word:photo_battle_category_word},
								success: function(getdata){
									if(getdata=="success"){
										alert("종목이 등록되었습니다");
										location.reload();
									} else if(getdata=="already"){
										alert("이미 등록된 종목입니다");
									}
								}
							});
						}
					}
				}
			});
		});
		function stopEnter(evt) {
			var evt = (evt) ? evt : ((event) ? event : null); 
			var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
			if (evt.keyCode==13){return false;}
		}
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 이상형월드컵 종목 등록</div></div>
	<div id="bodyarea_write">
		<div id="mywrite_body"><!--내글쓰기-->
			<div class="bold" style="margin:20px 0 0 0;">종목명 : <input id="photo_battle_category_word" class="input_blue" type="text" name="photo_battle_category_word" value="" maxlength="20" style="padding:5px 8px; width:150px;" /><span id="photo_battle_category_enroll" class="button_gb" style="margin:2px 0 0 10px;">새로등록</span></div>
			<div class="bold input_blue round_border" style="margin:20px 0 0 0; padding:7px 20px;">
			<div class="relative font11 bold photo_battle_divide1" style="margin:5px 0 20px 0; height:22px; border-bottom:#98C0E2 2px solid; line-height:1.4;"><div class="absolute" style="padding:0 15px 0 5px; left:0px; bottom:-2px; color:#377EB6; border-bottom:#377EB6 2px solid;"><span style="padding:0 40px 0 30px;">이상형월드컵 종목</span></div></div>
			<div style="padding:0 10px;">
<?php include 'photo_battle_category_recall.php';?>
			</div>
			</div>
		</div>
		<div id="textarea_copy"></div>
	</div>
	<div id="temp_target"></div>
</body>
</html>