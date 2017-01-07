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
	$table_name = 'club_group_writing';
	$page_name = 'club_group_writing';
	include 'declare.php';
?>
	<script>
		var table_name = "<?php echo $table_name;?>";
		var page_name = "<?php echo $page_name;?>";
		var textarea_height = get_textarea_height();
		$(document).ready(function () {
			if(is_mobile_check==1){alert("글쓰는 공간이 안보일 경우 '데스크탑 보기' 로 설정하십시오!");}
			ckeditor = CKEDITOR.replace( 'mywrite_content', {
				filebrowserImageUploadUrl: 'image_upload.php?table_name='+table_name+'&page_name='+page_name ,
				height: textarea_height
			});
			var ajaxform_options = {
				target: '#temp_target'
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
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 모임 글쓰기</div></div>
	<div id="bodyarea_write">
		<form action="club_group_writing_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
			<div style="margin:10px 0; padding:3px 10px 3px 10px;">
			<?php echo $add_photo_block;?>
			</div>
			<div id="write_id" class="title_blue" style="margin:10px 0 0 0;">
				<h6 class="inline" style="position:relative;">&nbsp;제목 : </h6>
				<input type="text" id="mywrite_title" name="mywrite_title" class="inline input_blue" value="" maxlength="100" style="width:650px;"/>
			</div>
			<div id="mywrite_body" style="width:725px; padding:0;"><!--내글쓰기-->
				<textarea id="mywrite_content" name="mywrite_content"></textarea>
				<div id="mywrite_func" style="height:33px;">
					<input id="mywrite_enter" type="image" src="../image/button_enter.png" value=""/>
				</div>
			</div>
			<div id="textarea_copy"></div>
			<input type="hidden" name="page_name" value="club_group_writing"/>
			<input type="hidden" name="count_group" value="<?php echo $_REQUEST["count_group"];?>"/>
			<input type="hidden" name="write_new" value="new"/>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>