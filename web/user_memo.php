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
	$sql1 = "SELECT * FROM user_memo WHERE user_num=$user_num";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
?>
	<script>
		$(document).ready(function () {
			$("#mywrite_content, #textarea_copy").css("min-height", "40px");
			$('#textarea_copy').html(convert_to_tag($("#mywrite_content").val()));
			$("#mywrite_content").height($('#textarea_copy').height()+30);//textarea의 height 조정
			$('textarea[name=mywrite_content]').keyup(function () {//글쓰기textarea 설정
				if(event.shiftKey && event.keyCode=="13"){//shift+Enter를 눌렀을때
					$("#mywrite_enter").click();
				}
				$("#textarea_copy").html(convert_to_tag($(this).val()));
				$(this).height($('#textarea_copy').height()+30);//textarea의 height 조정
			});
			var ajaxform_options = {
				target: "#temp_target",
				success: function(){
					alert("메모가 저장되었습니다");
				}
			};
			$('#mywrite_enter').click(function(){//저장 클릭시
				if(user_num==0){alert("로그인 후 이용해주세요");}
				else {$("form").ajaxSubmit(ajaxform_options);}
			});
		});
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 메모장</div></div>
	<div id="bodyarea_write">
		<form name="user_memo" action="user_memo_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
		<div id="mywrite_body" style="margin:10px 0 0 0; padding:0; width:725px;"><!--내글쓰기-->
			<textarea id="mywrite_content" name="mywrite_content" class="input_blue" style="padding:9px;"><?php echo $sql_fetch_array1["content"];?></textarea>
			<div id="mywrite_func">
				<div id="mywrite_enter" class="button_gb">저 장</div>
			</div>
		</div>
		<input type="hidden" name="exist" value="<?php echo $count1;?>"/>
		<input type="submit" value="" style="display:none;"/>
		<div id="textarea_copy"></div>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>