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
<?php
	include 'declare.php';
	$stranger_num = $_REQUEST["stranger_num"];
	$table_name = $_REQUEST["table_name"];
	$count = $_REQUEST["count"];
	$sql1 = "SELECT * FROM stranger_call WHERE caller_num=$user_num AND table_name='$table_name' AND count=$count";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
?>
	<script>
		$(document).ready(function () {
			$("#mywrite_content").val(reverse_from_tag("<?php echo $sql_fetch_array1["content"];?>"));
			$("#mywrite_content, #textarea_copy").css("min-height", "40px");
			$('#textarea_copy').html(convert_to_tag($("#mywrite_content").val()));
			$("#mywrite_content").height($('#textarea_copy').height()+30);//textarea의 height 조정
			var string = $('textarea[name=mywrite_content]').val();//enter는 글자수에 2씩 더해야한다
			var regExp = /[^\n]/gm;//줄바꿈을 제외한 임의의 문자
			var enter = string.replace(regExp, "");//줄바꿈만 남긴다
			var inputLength = $('textarea[name=mywrite_content]').val().length;
			$("#mywrite_letterleft").html( (inputLength+enter.length) + " / 500");// 글자 수를 구합니다
			$('textarea[name=mywrite_content]').keyup(function () {//글쓰기textarea 설정
				if(event.shiftKey && event.keyCode=="13"){//shift+Enter를 눌렀을때
					$("#mywrite_enter").click();
				}
				$("#textarea_copy").html(convert_to_tag($(this).val()));
				$(this).height($('#textarea_copy').height()+30);//textarea의 height 조정
				var string = $(this).val();//enter는 글자수에 2씩 더해야한다
				var regExp = /[^\n]/gm;//줄바꿈을 제외한 임의의 문자
				var enter = string.replace(regExp, "");//줄바꿈만 남긴다
				var inputLength = $(this).val().length;
				$("#mywrite_letterleft").html( (inputLength+enter.length) + " / 500");// 글자 수를 구합니다
			});
			$('#mywrite_enter').click(function(){//제출 클릭시
				if(user_name=="Guest"){
					alert('로그인 후 이용하실 수 있습니다.');
				} else {//회원일 경우
					var reply = confirm("신고 내용을 전송하시겠습니까?");
					if(reply==true){
						$("#stranger_call").submit();
					}
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<h6 class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 신고하기</div></h6>
	<div id="bodyarea_write">
		<form id="stranger_call" action="stranger_call_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
		<div class="popup_content bold">▼ 신고내용을 작성해주세요</div>
		<div id="mywrite_body"><!--내글쓰기-->
			<textarea id="mywrite_content" class="input_blue" name="mywrite_content" maxlength="500"></textarea>
			<div id="mywrite_func">
				<div id="mywrite_letterleft">0 / 500</div>
				<div id="mywrite_enter"><img src="../image/button_enter.png"/></div>
			</div>
		</div>
		<input type="hidden" name="stranger_num" value="<?php echo $stranger_num;?>"/>
		<input type="hidden" name="table_name" value="<?php echo $table_name;?>"/>
		<input type="hidden" name="count" value="<?php echo $count;?>"/>
		<input type="hidden" name="exist" value="<?php echo $count1;?>"/>
		<input type="submit" value="" style="display:none;"/>
		<div id="textarea_copy"></div>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>