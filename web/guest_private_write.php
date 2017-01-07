<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
<?php
	$user_num_receive = $_REQUEST["user_num_receive"];
	include 'declare.php';
	$sql = "SELECT * FROM user WHERE user_num=$user_num_receive";
	$sql_query = mysqli_query($conn, $sql);
	$sql_fetch_array = mysqli_fetch_array($sql_query);
	$id_yours = $sql_fetch_array["user_name"];
?>
	<script>
		$(document).ready(function () {
			$('#id_area').html("보낸이 : " + user_name);//작성자의 id 설정
			$('#id_yours').html("받는이 : <?php echo $id_yours; ?>");//받는사람의 id
			$('textarea[name=mywrite_content]').keyup(function () {//글쓰기textarea 설정
				if(event.shiftKey && event.keyCode=="13"){//shift+Enter를 눌렀을때
					$("#mywrite_enter").click();
				}
				$('#textarea_copy').width($('#mywrite_text').width());
				$("#textarea_copy").html(convert_to_tag($(this).val()));
				$(this).height($('#textarea_copy').height()+30);//textarea의 height 조정
			});
			var ajaxform_options = {
				target: "#temp_target",
				success: function(){
					location.reload();
				}
			};
			$("form[name=mywrite_new]").ajaxForm(ajaxform_options);//쪽지보내기용 form
			$('#mywrite_enter').click(function(){//글쓰기 입력시
				if(user_name=="Guest"){
					alert('로그인 후 글을 쓰실 수 있습니다.');
				} else {//회원일 경우
					var user_num_receive = <?php echo $user_num_receive; ?>;
					if(user_num==user_num_receive){//본인에게 보낼경우
						alert("본인에게 쪽지를 보낼 수 없습니다");
					} else {
						if($('textarea[name=mywrite_content]').val().length>=3){//글이 입력됐을경우
							var reply = confirm("쪽지를 보내시겠습니까?");
							if(reply==true){$("#mywrite_enter_submit").click();}
						} else if($('textarea[name=mywrite_content]').val().length<3){//글이 3자 미만일경우
							alert('글을 3자 이상 입력해주세요.');
						}
					}
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<h6 class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 쪽지 보내기</div></h6>
	<div id="bodyarea_write">
		<form name="mywrite_new" action="guest_private_write_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
			<div class="write_id" style="">
				<div id="id_area" class="write_name"></div>
				<div id="id_yours" class="write_to"></div>
				<div class="write_date"></div>
			</div>
			<div class="mywrite_body2"><!--내글쓰기-->
				<textarea id="mywrite_text" name="mywrite_content" class="input_blue"></textarea>
				<div class="mywrite_cont">
					<div id="mywrite_enter" style="right:2px; top:0px;"><img src="../image/button_send.png"/></div>
				</div>
			</div>
			<input type="hidden" name="user_num_receive" value="<?php echo $user_num_receive;?>">
			<input id="mywrite_enter_submit" type="submit" value="입    력" style="display:none;"/>
		</form>
		<div id="textarea_copy"></div>
	</div>
	<div id="temp_target"></div>
</body>
</html>