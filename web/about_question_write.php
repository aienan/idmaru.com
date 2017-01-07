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
	$table_name = 'about_question';
	$page_name = 'about_question_write';
	include 'declare.php';
?>
	<script>
		var table_name = "<?php echo $table_name;?>";
		var page_name = "<?php echo $page_name;?>";
		function getCurrentCount(editor){
			var currentLength = editor.getData()
				.replace(/<[^>]*>/g, '')
				.replace(/\s+/g, ' ')
				.replace(/^\s*/g, '')
				.replace(/\s*$/g, '')
				.replace(/&\w+;/g ,'X')
				.length;
			return currentLength;
		}
		function checkLength(evt){
			var currentLength = getCurrentCount(evt.editor);
			var maximumLength = 500;
			if(evt.editor.config.maxLength){//maxLength가 설정됐을경우 값을 가져온다
				maximumLength = evt.editor.config.maxLength;
			}
			if(currentLength > maximumLength){
				do{
					evt.editor.execCommand('undo');
					currentLength = getCurrentCount(evt.editor);
				} while(currentLength > maximumLength);
			}
			$("#mywrite_letterleft").html(currentLength + " / 1000");
		}
		var textarea_height = get_textarea_height();
		$(document).ready(function () {
			ckeditor = CKEDITOR.replace( 'mywrite_content', {
				filebrowserImageUploadUrl: 'image_upload.php?table_name='+table_name+'&page_name='+page_name,
				maxLength: 1000,
				height: textarea_height
			});
			ckeditor.on("key", checkLength);
			ckeditor.on("paste", checkLength);
			var ajaxform_options = {
				target: "#temp_target",
				success: function(){
				}
			};
			$('#mywrite_enter').click(function(){//글쓰기 입력시
				if(user_name=="Guest"){
					alert('로그인 후 이용하실 수 있습니다.');
					event.preventDefault ? event.preventDefault() : event.returnValue=false;
				} else {//회원일 경우
					if ($('#mywrite_title').val().length<5){
						alert('제목을 5자 이상 입력해주세요.');
						event.preventDefault ? event.preventDefault() : event.returnValue=false;
					}else if(ckeditor.getData().length<10){//글이 10자 미만일경우
						alert('글이 너무 짧습니다');
						event.preventDefault ? event.preventDefault() : event.returnValue=false;
					} else if(ckeditor.getData().length>=10){//글이 입력됐을경우
						var reply = confirm("글을 입력하시겠습니까?");
						if(reply==true){}
						else if(reply==false){event.preventDefault ? event.preventDefault() : event.returnValue=false;}
					}
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 이드마루에 물어보기</div></div>
	<div id="bodyarea_write">
		<form action="about_question_write_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
			<div style="margin:10px 0; padding:3px 10px;">
			<h6 class="inline">공개여부 : </h6>
			<h6 class="inline">&nbsp;모두</h6>
			<input class="inline radio1" type="radio" name="status" value="all" tabindex="" checked />
			<h6 class="inline">&nbsp;비공개</h6>
			<input class="inline radio1" type="radio" name="status" value="private" tabindex=""/>
			<?php echo $add_photo_block;?>
			</div>
			<div id="write_id" class="title_blue">
				<h6 class="inline" style="position:relative;">&nbsp;제목 : </h6>
				<input type="text" id="mywrite_title" class="input_blue" name="mywrite_title" class="inline" value="" maxlength="100" style="width:650px;"/>
			</div>
			<div id="mywrite_body" style="width:725px; padding:0;"><!--내글쓰기-->
				<textarea id="mywrite_content" name="mywrite_content" maxlength="1000"></textarea>
				<div id="mywrite_func" style="margin:0 0 20px 0;">
					<div id="mywrite_letterleft" style="padding:2px 0 0 0;">0 / 1000</div>
					<input id="mywrite_enter" type="image" src="../image/button_enter.png" value=""/>
				</div>
			</div>
			<input type="hidden" name="page_name" value="about_question_write"/>
			<input type="hidden" name="write_new" value="new"/>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>