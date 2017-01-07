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
	$table_name = 'writing';
	$page_name = 'writing_write';
	include 'declare.php';
?>
	<script>
		var table_name = "<?php echo $table_name;?>";
		var page_name = "<?php echo $page_name;?>";
		var textarea_height = get_textarea_height();
		$(document).ready(function () {
			if(is_mobile_check==1){alert("글쓰는 공간이 안보일 경우 '데스크탑 보기' 로 설정하십시오!");}
			if(user_num==0){$("#mywrite_title").attr("readonly", "readonly"); $("#mywrite_content").attr("disabled", "disabled");}
			ckeditor = CKEDITOR.replace( 'mywrite_content', {
				filebrowserImageUploadUrl: 'image_upload.php?table_name='+table_name+'&page_name='+page_name,
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
					if(!$("select[name=news_type] > option:selected").val()){
						alert("뉴스분류를 설정해주세요");
						event.preventDefault ? event.preventDefault() : event.returnValue=false;
					}else if ($('#mywrite_title').val().length<5){
						alert('제목을 5자 이상 입력해주세요.');
						event.preventDefault ? event.preventDefault() : event.returnValue=false;
					}else if(ckeditor.getData().length<10){//글이 10자 미만일경우
						alert('글이 너무 짧습니다');
						event.preventDefault ? event.preventDefault() : event.returnValue=false;
					} else if(ckeditor.getData().length>=10){//글이 입력됐을경우
						if($("input:radio[name=status]:checked").val()=="all"){
							var reply = confirm("입력하신 글은 전체 공개됩니다. 글을 입력하시겠습니까?");
						} else if($("input:radio[name=status]:checked").val()=="friend"){
							var reply = confirm("입력하신 글은 친구에게만 공개됩니다. 글을 입력하시겠습니까?");
						} else if($("input:radio[name=status]:checked").val()=="private"){
							var reply = confirm("입력하신 글은 비공개됩니다. 글을 입력하시겠습니까?");
						}
						if(reply==true){}
						else if(reply==false){event.preventDefault ? event.preventDefault() : event.returnValue=false;}
					}
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 뉴스 쓰기</div></div>
	<div id="bodyarea_write">
		<form action="writing_write_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
			<div style="margin:10px 0; padding:3px 10px 3px 10px;">
<?php if($user_num==0){echo '<div class="red">※ 현재 로그인이 되지 않아 글을 작성할 수 없습니다.</div>';} ?>
			<h6>뉴스분류 : <select id="news_type" name="news_type"><?php echo $select_category_writing_mod;?></select></h6>
			<h6 class="inline">공개여부 : </h6>
			<h6 class="inline">&nbsp;모두</h6>
			<input class="inline radio1" type="radio" name="status" value="all" tabindex="" checked />
			<h6 class="inline">&nbsp;친구</h6>
			<input class="inline radio1" type="radio" name="status" value="friend" tabindex=""/>
			<h6 class="inline">&nbsp;비공개</h6>
			<input class="inline radio1" type="radio" name="status" value="private" tabindex=""/>
			<?php echo $add_photo_block;?>
			</div>
			<div id="write_id" class="title_blue">
				<h6 class="inline" style="position:relative;">&nbsp;제목 : </h6>
				<input type="text" id="mywrite_title" name="mywrite_title" class="inline input_blue" value="" maxlength="100" style="width:650px;"/>
			</div>
			<div id="mywrite_body" style="width:725px; padding:0;"><!--내글쓰기-->
				<textarea id="mywrite_content" name="mywrite_content"></textarea>
				<div id="mywrite_func" style="margin:0 0 20px 0;">
					<input id="mywrite_enter" type="image" src="../image/button_enter.png" />
				</div>
			</div>
			<input type="hidden" name="page_name" value="writing_write"/>
			<input type="hidden" name="write_new" value="new"/>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>