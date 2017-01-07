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
	$table_name = 'club_event';
	$page_name = 'club_event_write';
	include 'declare.php';
?>
	<script>
		var table_name = "<?php echo $table_name;?>";
		var page_name = "<?php echo $page_name;?>";
		var textarea_height = get_textarea_height()-30;
		$(document).ready(function () {
			if(is_mobile_check==1){alert("글쓰는 공간이 안보일 경우 '데스크탑 보기' 로 설정하십시오!");}
			if(user_num==0){$("#mywrite_title").attr("readonly", "readonly"); $("#mywrite_content").attr("disabled", "disabled");}
			ckeditor = CKEDITOR.replace( 'mywrite_content', {
				filebrowserImageUploadUrl: 'image_upload.php?table_name='+table_name+'&page_name='+page_name ,
				height: textarea_height
			});
			var ajaxform_options = {
				target: "#temp_target"
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
						if($("input:radio[name=status]:checked").val()=="party"){
							var reply = confirm("입력하신 글은 행사로 등록됩니다. 글을 입력하시겠습니까?");
						} else if($("input:radio[name=status]:checked").val()=="social"){
							var reply = confirm("입력하신 글은 개인으로 등록됩니다. 글을 입력하시겠습니까?");
						} else if($("input:radio[name=status]:checked").val()=="volunteer"){
							var reply = confirm("입력하신 글은 봉사로 등록됩니다. 글을 입력하시겠습니까?");
						}
						if(reply==true){}
						else if(reply==false){event.preventDefault ? event.preventDefault() : event.returnValue=false;}
					}
				}
			});
			$("#start_time_y").change(function(){
				if($("#start_time_y").val()!="" && $("#start_time_m").val()!=""){
					$("#start_time_d").html(calender_date($("#start_time_y").val(), $("#start_time_m").val()));
				} else {
					$("#start_time_d").html('<option value="">선택</option>');
				}
			});
			$("#start_time_m").change(function(){
				if($("#start_time_y").val()!="" && $("#start_time_m").val()!=""){
					$("#start_time_d").html(calender_date($("#start_time_y").val(), $("#start_time_m").val()));
				} else {
					$("#start_time_d").html('<option value="">선택</option>');
				}
			});
			$("#end_time_y").change(function(){
				if($("#end_time_y").val()!="" && $("#end_time_m").val()!=""){
					$("#end_time_d").html(calender_date($("#end_time_y").val(), $("#end_time_m").val()));
				} else {
					$("#end_time_d").html('<option value="">선택</option>');
				}
			});
			$("#end_time_m").change(function(){
				if($("#end_time_y").val()!="" && $("#end_time_m").val()!=""){
					$("#end_time_d").html(calender_date($("#end_time_y").val(), $("#end_time_m").val()));
				} else {
					$("#end_time_d").html('<option value="">선택</option>');
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 이벤트 등록</div></div>
	<div id="bodyarea_write">
		<form action="club_event_write_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
			<div style="margin:10px 0; padding:3px 10px 3px 10px;">
<?php if($user_num==0){echo '<div class="red">※ 현재 로그인이 되지 않아 글을 작성할 수 없습니다.</div>';} ?>
			<h6 class="inline">이벤트 종류 : </h6>
			<h6 class="inline">&nbsp;행사</h6>
			<input class="inline radio1" type="radio" name="status" value="party" tabindex="" checked />
			<h6 class="inline">&nbsp;개인</h6>
			<input class="inline radio1" type="radio" name="status" value="social" tabindex=""/>
			<h6 class="inline">&nbsp;봉사</h6>
			<input class="inline radio1" type="radio" name="status" value="volunteer" tabindex=""/><br/>
			<h6 class="inline">이벤트 기간 : </h6>
			<h6 class="inline">&nbsp;시작일</h6>
			<select id="start_time_y" class="inline" name="start_time_y">
<?php echo $select_option_year_event_start;?>
			</select>년
			<select id="start_time_m" class="inline" name="start_time_m"><?php echo $select_option_month;?></select>월
			<select id="start_time_d" class="inline" name="start_time_d"><option selected value="">선택</option></select>일<br/>
			<h6 class="inline" style="margin:0 0 0 90px;">&nbsp;종료일</h6>
			<select id="end_time_y" class="inline" name="end_time_y">
<?php echo $select_option_year_event_end;?>
			</select>년
			<select id="end_time_m" class="inline" name="end_time_m"><?php echo $select_option_month; ?></select>월
			<select id="end_time_d" class="inline" name="end_time_d"><option selected value="">선택</option></select>일
			<?php echo $add_photo_block;?>
			</div>
			<div id="write_id" class="title_blue">
				<h6 class="inline" style="position:relative;">&nbsp;이벤트 : </h6>
				<input type="text" id="mywrite_title" class="input_blue" name="mywrite_title" class="inline" value="" maxlength="100" style="width:635px;"/>
			</div>
			<div id="mywrite_body" style="width:725px; padding:0;"><!--내글쓰기-->
				<textarea id="mywrite_content" name="mywrite_content"></textarea>
				<div id="mywrite_func" style="margin:0 0 20px 0;">
					<input id="mywrite_enter" type="image" src="../image/button_enter.png" value="" />
				</div>
			</div>
			<input type="hidden" name="page_name" value="club_event_write"/>
			<input type="hidden" name="write_new" value="new"/>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>