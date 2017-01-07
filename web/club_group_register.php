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
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<?php include 'declare.php';?>
	<script>
		$(document).ready(function () {
			var max_num = 10;//등록할 수 있는 최대 모임 갯수
			$("#textarea_copy").css("min-height", "40px");
			$('textarea[name=mywrite_content]').keyup(function () {//글쓰기textarea 설정
				$("#textarea_copy").html(convert_to_tag($(this).val()));
				$(this).height($('#textarea_copy').height()+30);//textarea의 height 조정
				
				var string = $(this).val();//enter는 글자수에 2씩 더해야한다
				var regExp = /[^\n]/gm;//줄바꿈을 제외한 임의의 문자
				var enter = string.replace(regExp, '');//줄바꿈만 남긴다
				var inputLength = $(this).val().length;
				$('#mywrite_letterleft').html( (inputLength+enter.length) + ' / 255');// 글자 수를 구합니다
			});
			$("#group_register_button").click(function(){
				var keyword = $("#keyword_input").val();
				var description = $('textarea[name=mywrite_content]').val();
				if(!keyword){
					alert("모임 이름을 입력해주세요");
				} else if(!description){
					alert("모임 설명을 입력해주세요");
				} else if(keyword && description){
					var reply = confirm("모임을 등록하시겠습니까?");
					if(reply==true){
						var status=$("input:radio[name=status]:checked").val();
						$.ajax({
							url:'club_group_register_submit.php',
							data: {keyword:keyword, description:description, status:status, max_num:max_num},
							success: function(getdata){
								if(getdata == "already"){
									alert("이미 등록된 이름입니다");
								} else if(getdata=="max_num"){
									alert("등록할 수 있는 모임 수는 "+max_num+"개까지 입니다");
								} else if(getdata == "done"){
									window.open("club_group.php", "idmaru", "");
									alert("모임이 생성되었습니다");
									window.close();
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
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 모임 등록</div></div>
	<div id="bodyarea_write">
		<div style="margin:20px 0;"><h6 class="inline">모임명 : &nbsp;</h6><input id="keyword_input" class="input_blue inline" style="width:200px;" type="text" name="keyword_input" value="" tabindex=""/></div>
		<div style="margin:5px 0;">
		<h6 class="inline">모임 공개여부 : </h6>
		<h6 class="inline">&nbsp;모두</h6>
		<input class="inline radio1" type="radio" name="status" value="1" tabindex="" checked />
		<h6 class="inline">&nbsp;친구</h6>
		<input class="inline radio1" type="radio" name="status" value="2" tabindex=""/>
		<h6 class="inline">&nbsp;비공개</h6>
		<input class="inline radio1" type="radio" name="status" value="3" tabindex=""/>
		</div>
		<h6 style="padding:0 10px;"> ▼ 모임 설명</h6>
		<div id="mywrite_body"><!--모임 설명-->
			<textarea id="mywrite_content" class="input_blue" name="mywrite_content" maxlength="255"></textarea>
			<div class="relative" style="height:30px;"><div id="mywrite_letterleft">0 / 255</div><div id="group_register_button" class="button_gb" style="right:0px; top:0px;">등록하기</div></div>
		</div>
		<div id="textarea_copy"></div>
	</div>
	<div id="temp_target"></div>
</body>
</html>