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
<?php
	$table_name = $_REQUEST["table_name"];
	$page_name = $_REQUEST["page_name"];
?>
	<script>
		$(document).ready(function () {
			$('#mywrite_enter').click(function(){//등록 입력시
				if(user_name=="Guest"){
					alert('로그인 후 이용하실 수 있습니다.');
				} else {//회원일 경우
					var uploader = $('#uploader').pluploadQueue();
					if(uploader.files.length==0){//사진이 없을 경우
					} else {
						var reply = confirm("사진을 추가하시겠습니까?");
						if(reply==true){
							window.parent.$("#add_photo_desc").html("<div class=\"inline_block\">파일크기가 조정되는데 시간이 걸리고 있습니다. 사진이 등록될 때 까지 기다려 주십시오</div><div class=\"inline_block loading16x16\"></div>");
							$("form").submit();
						}
					}
				}
			});
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
				var uploader = $('#uploader').pluploadQueue();// Files in queue upload them first
				var ajaxform_options = {
					target: "#temp_target",
					success: function(){
						var content_before = window.parent.ckeditor.getData();
						var content_add;
						var content_after;
						$.ajax({
							url: 'add_photo_content_recall.php',
							data: {table_name:"<?php echo $table_name;?>", page_name:"<?php echo $page_name;?>", photo_number:uploader.files.length},
							success:function(getdata){
								content_add = getdata;
								content_after = content_before + content_add;
								window.parent.ckeditor.setData(content_after);
								window.parent.$("#add_photo_desc").html("");
							}
						});
					}
				};
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
		function mywriteEnter(){$("#mywrite_enter").click();}
	</script>
</head>
<body class="popup_body" style="background-color:#FFF; overflow:hidden;">
	<div id="bodyarea_write">
		<form action="add_photo_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
			<div id="mywrite_body" style="padding:0;"><!--내글쓰기-->
				<div id="uploader">
					<p>현재 사용자님의 브라우저에서는 Flash, Silverlight, Gears BrowserPlus 혹은 HTML5 중 어느것도 사용이 불가능합니다.</p>
				</div>
				<div id="mywrite_func" style="display:none;">
					<div id="mywrite_enter">추가하기</div>
					<input type="submit"/>
				</div>
			</div>
			<div id="textarea_copy"></div>
			<input type="hidden" name="table_name" value="<?php echo $table_name;?>"/>
			<input type="hidden" name="page_name" value="<?php echo $page_name;?>"/>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>