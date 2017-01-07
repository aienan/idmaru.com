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
	<style type="text/css">@import url(../plugin/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css);</style>
	<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
	<script type="text/javascript" src="../plugin/plupload/js/plupload.full.js"></script>
	<script type="text/javascript" src="../plugin/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<?php include 'declare.php';?>
	<script>
		$(document).ready(function () {
			if(user_num==0){$("#mywrite_title").attr("readonly", "readonly"); $("#mywrite_content").attr("disabled", "disabled");}
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
			});
			var ajaxform_options = {
				target: "#temp_target"
			};
			$('#mywrite_enter').click(function(){//등록 입력시
				if(user_name=="Guest"){
					alert('로그인 후 이용하실 수 있습니다.');
					// event.preventDefault ? event.preventDefault() : event.returnValue=false;
				} else {//회원일 경우
					var uploader = $('#uploader').pluploadQueue();
					if(!$("#gallery_type").val()){
						alert("사진분류를 선택해주세요");
					} else if(uploader.files.length==0){//사진이 없을 경우
						alert('사진을 선택해주세요.');
						// event.preventDefault ? event.preventDefault() : event.returnValue=false;
					} else if($('textarea[name=mywrite_content]').val().length<5){//글이 5자 미만일경우
						alert('사진설명을 5자 이상 입력해주세요.');
						// event.preventDefault ? event.preventDefault() : event.returnValue=false;
					} else if($('textarea[name=mywrite_content]').val().length>=5){//글이 입력됐을경우
						if($("input:radio[name=status]:checked").val()=="all"){
							var reply = confirm("사진이 전체 공개됩니다. 사진을 등록하시겠습니까?");
						} else if($("input:radio[name=status]:checked").val()=="friend"){
							var reply = confirm("사진이 친구에게만 공개됩니다. 사진을 등록하시겠습니까?");
						} else if($("input:radio[name=status]:checked").val()=="private"){
							var reply = confirm("사진이 비공개됩니다. 사진을 등록하시겠습니까?");
						}
						if(reply==true){
							$("#mywrite_enter").css("display", "none");
							$("#mywrite_func").append("<div style=\"position:absolute; right:50px; top:10px; font-size:8pt;\">파일크기가 조정되는데 시간이 걸리고 있습니다. 완료창이 뜰 때 까지 기다려 주십시오</div><div class=\"loading24x24\" style=\"position:absolute; left:665px; top:3px;\"></div>");
							$("form").submit();
						}
						// else if(reply==false){event.preventDefault ? event.preventDefault() : event.returnValue=false;}
					}
				}
			});
		});
	</script>
	<script>
		$(document).ready(function () {
			$("#uploader").pluploadQueue({
				runtimes : 'gears,flash,silverlight,browserplus,html5',
				url : '../plugin/plupload/upload.php',
				max_file_size : '10mb',
				// chunk_size : '1mb',
				unique_names : true,
				// resize : {width : 320, height : 240, quality : 90},
				filters : [
					{title : "Image files", extensions : "jpg,gif,png"},
					// {title : "Zip files", extensions : "zip"}
				],
				dragdrop : true,
				multiple_queues : true,
				flash_swf_url : '../plugin/plupload/js/plupload.flash.swf',// Flash settings
				silverlight_xap_url : '../plugin/plupload/js/plupload.silverlight.xap'// Silverlight settings
			});
			$('form').submit(function(e) {// Client side form validation
				var ajaxform_options = {target: "#temp_target"};
				var uploader = $('#uploader').pluploadQueue();// Files in queue upload them first
				if (uploader.files.length > 0) {// When all files are uploaded submit form
					uploader.bind('UploadComplete', function() {
						$("form").ajaxSubmit(ajaxform_options); return false;
					});
					uploader.start();
				} else {
					alert('파일을 하나 이상 선택하십시오');
				}
				return false;
			});
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 사진 등록하기</div></div>
	<div id="bodyarea_write">
		<form action="photo_upload_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
			<div id="mywrite_body" style="margin:10px 0 0 0;"><!--내글쓰기-->
<?php if($user_num==0){echo '<div class="red">※ 현재 로그인이 되지 않아 글을 작성할 수 없습니다.</div>';} ?>
<?php echo $select_gallery_type_write;?>
				<h6 class="inline">공개여부 : </h6>
				<h6 class="inline">&nbsp;모두</h6>
				<input class="inline radio1" type="radio" name="status" value="all" tabindex="" checked />
				<h6 class="inline">&nbsp;친구</h6>
				<input class="inline radio1" type="radio" name="status" value="friend" tabindex=""/>
				<h6 class="inline">&nbsp;비공개</h6>
				<input class="inline radio1" type="radio" name="status" value="private" tabindex=""/>
				<div id="uploader">
					<p>현재 사용자님의 브라우저에서는 Flash, Silverlight, Gears BrowserPlus 혹은 HTML5 중 어느것도 사용이 불가능합니다.</p>
				</div>
				<p style="font-size:9pt; font-weight:bold;">(파일 크기가 1024KB를 넘으면 자동으로 조정됩니다.)</p>
				<div id="photo_show"></div>
				<h6 style="margin:10px 0 0 0;">사진 설명</h6>
				<textarea id="mywrite_content" class="input_blue" name="mywrite_content" maxlength="1000"></textarea>
				<div id="mywrite_func">
					<div id="mywrite_letterleft">0 / 1000</div>
					<div id="mywrite_enter" style="height:25px;"><img src="../image/button_enter.png"/></div>
					<input type="submit" style="display:none;"/>
				</div>
			</div>
			<div id="textarea_copy"></div>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>