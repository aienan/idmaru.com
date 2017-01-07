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
	$type = 'select';
?>
	<script>
		$(document).ready(function () {
			$("#mywrite_content, #textarea_copy").css("min-height", "40px");
			$('textarea[name=mywrite_content]').keyup(function () {//글쓰기textarea 설정
				if(event.shiftKey && event.keyCode=="13"){//shift+Enter를 눌렀을때
					$("#mywrite_enter").click();
				}
				$("#textarea_copy").html(convert_to_tag($(this).val()));
				$(this).height($('#textarea_copy').height()+30);//textarea의 height 조정
				var string = $(this).val();//enter는 글자수에 2씩 더해야한다
				var regExp = /[^\n]/gm;//줄바꿈을 제외한 임의의 문자
				var enter = string.replace(regExp, '');//줄바꿈만 남긴다
				var inputLength = $(this).val().length;
				$('#mywrite_letterleft').html( (inputLength+enter.length) + ' / 1000');// 글자 수를 구합니다
				if(event.keyCode==13 && event.ctrlKey){ // ctrl + enter를 쳤을때
					$("#mywrite_enter").click();
				}
			});
			var ajaxform_options = {
				target: "#temp_target"
			};
			$('#mywrite_enter').click(function(){//등록 입력시
				if(user_name=="Guest"){
					alert('로그인 후 이용하실 수 있습니다.');
				} else {//회원일 경우
					var photo_battle_category = $("select[name=photo_battle_category]").val();
					var photo_battle = $("input[type=file]").val();
					if(!photo_battle_category){
						alert("경기종목을 선택해주세요");
					} else if(!$("#gallery_type").val()){
						alert("사진분류를 선택해주세요");
					} else if(!photo_battle){
						alert('사진을 선택해주세요.');
					} else if($('textarea[name=mywrite_content]').val().length<5){//글이 5자 미만일경우
						alert('사진설명을 5자 이상 입력해주세요.');
					} else {
						var reply = confirm("이상형 월드컵에 사진을 등록하시겠습니까?");
						if(reply==true){
							$("#mywrite_enter").css("display", "none");
							$("#mywrite_func").append("<div style=\"position:absolute; right:50px; top:10px; font-size:8pt;\">파일크기가 조정되는데 시간이 걸리고 있습니다. 완료창이 뜰 때 까지 기다려 주십시오</div><div class=\"loading24x24\" style=\"position:absolute; left:665px; top:3px;\"></div>");
							$("form").submit();
						}
					}
				}
			});
		});
	</script>
	<script>
		$(document).ready(function () {
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 이상형 월드컵 등록하기</div></div>
	<div id="bodyarea_write">
		<form action="photo_battle_upload_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
			<div id="mywrite_body"><!--내글쓰기-->
				<div class="bold" style="margin:10px 0 10px 0;">
					<div>경기종목 : <select id="photo_battle_category" name="photo_battle_category"><?php include 'photo_battle_category_recall.php';?></select></div>
				</div>
<?php echo $select_gallery_type_write;?>
				<input type="file" class="input_file input_blue round_border" name="photo_battle" accept="image/*" style="margin:30px 0 0 0;"/>
				<p class="font9">(파일 크기가 1024KB를 넘으면 자동으로 조정됩니다.)</p>
				<div id="photo_show"></div>
				<h6 style="margin:10px 0 0 0;">사진 설명</h6>
				<textarea id="mywrite_content" class="input_blue" name="mywrite_content" maxlength="1000"></textarea>
				<div id="mywrite_func">
					<div id="mywrite_letterleft">0 / 1000</div>
					<div id="mywrite_enter"><img src="../image/button_enter.png"/></div>
					<input type="submit" style="display:none;"/>
				</div>
			</div>
			<div id="textarea_copy"></div>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>