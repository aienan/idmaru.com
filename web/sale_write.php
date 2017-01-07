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
	$table_name = 'sale';
	$page_name = 'sale_write';
	include 'declare.php';
?>
	<script>
		var table_name = "<?php echo $table_name;?>";
		var page_name = "<?php echo $page_name;?>";
		var textarea_height = get_textarea_height()-130;
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
					if(!$("select[name=selling_type] > option:selected").val()){
						alert("판매분류를 설정해주세요");
						event.preventDefault ? event.preventDefault() : event.returnValue=false;
					}else if ($('#mywrite_title').val().length<3){
						alert('제품명을 입력해주세요 (3자 이상)');
						event.preventDefault ? event.preventDefault() : event.returnValue=false;
					}else if(ckeditor.getData().length<10){//글이 10자 미만일경우
						alert('글이 너무 짧습니다');
						event.preventDefault ? event.preventDefault() : event.returnValue=false;
					} else if(ckeditor.getData().length>=10){//글이 입력됐을경우
						var reply = confirm("글을 등록하시겠습니까?");
						if(reply==true){}
						else if(reply==false){event.preventDefault ? event.preventDefault() : event.returnValue=false;}
					}
				}
			});
			$("#selling_type_example").click(function(){
				window.open("selling_type_example.php", "selling_type_example", "width=770,height=630,resizable=yes,scrollbars=yes,location=no");
			});
			$("#sale_safe_account").click(function(){
				window.open("sale_safe_account.php", "sale_safe_account", "width=730,height=370,resizable=yes,scrollbars=yes,location=no");
			});
			$("#sale_safe_info").click(function(){
				window.open("sale_safe_info.php", "sale_safe_info", "width=620,height=420,resizable=yes,scrollbars=yes,location=no");
			});
			$("#sale_price").focus(function(){//입찰 시작가에 커서가 찍혔을경우
				var string = $("#sale_price").val();
				if(string==""){
					$("#sale_price").val("");
					$("#sale_price").css("text-align", "right");
				} else {
					$("#sale_price").val(removeComma(string));
					$("#sale_price").css("text-align", "right");
				}
			});
			$("#sale_price").blur(function(){//입찰 시작가에서 커서가 나왔을경우
				var string = $("#sale_price").val();
				if(!string){//글자가 없을때
				} else if(string){
					if(isNumber(string)){//숫자인지 체크
						$("#sale_price").val(addComma(string));
						$("#sale_price").css("text-align", "center");
					} else {//숫자가 아닐때
						$("#sale_price").val("");
						alert("숫자만 입력할 수 있습니다");
					}
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 중고물품 등록</div></div>
	<div id="bodyarea_write">
		<form action="sale_write_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
			<div style="margin:10px 0; padding:3px 7px 3px 7px;">
<?php if($user_num==0){echo '<div class="red">※ 현재 로그인이 되지 않아 글을 작성할 수 없습니다.</div>';} ?>
			<h6>판매분류 : <select id="selling_type" name="selling_type"><?php echo $select_option_selling_type;?></select><div id="selling_type_example" class="button_sw" style="position:relative; display:inline; margin:0 0 0 20px;">물품분류</div></h6>
			<h6 class="inline">거래상태 : </h6>
			<h6 class="inline">&nbsp;판매중</h6>
			<input class="inline radio1" type="radio" name="status" value="selling" tabindex="" checked />
			<h6 class="inline">&nbsp;판매완료</h6>
			<input class="inline radio1" type="radio" name="status" value="done" tabindex=""/>
			<h6 class="inline">&nbsp;공유중</h6>
			<input class="inline radio1" type="radio" name="status" value="share" tabindex=""/>
			<?php echo $add_photo_block;?>
			</div>
			<div id="write_id" class="title_blue">
				<h6 class="inline" style="position:relative;">&nbsp;제품명 : </h6>
				<input type="text" id="mywrite_title" style="width:635px;" name="mywrite_title" class="inline input_blue" value="" maxlength="100"/>
			</div>
			<div id="mywrite_body" style="width:725px; padding:0;"><!--내글쓰기-->
				<div style="padding:5px 0 0 0; background-color:#D8F2ED;">
				<div class="sale_input">구입시기 : <input type="text" name="sale_year" maxlength="4" style="border:1px solid; padding:2px; margin:0 0 0 10px; width:30px;"/>년 <input type="text" name="sale_month" maxlength="2" style="border:1px solid; padding:2px; width:15px;"/>월 <input type="text" name="sale_date" maxlength="2" style="border:1px solid; padding:2px; width:15px;"/>일</div>
				<div class="sale_input">거래방법 : &nbsp;&nbsp;직거래 <input type="checkbox" name="sale_direct" value="1" style="position:relative; top:1px;"/> &nbsp;&nbsp;택배 <input type="checkbox" name="sale_parcel" value="1" style="position:relative; top:1px;"/> &nbsp;&nbsp;안전거래 <input type="checkbox" name="sale_safe" value="1" style="position:relative; top:1px;"/></div>
				<div class="sale_input">직거래 장소 : <input type="text" name="sale_place" style="border:1px solid; padding:2px; margin:0 0 0 10px; width:300px;"/></div>
				<div class="sale_input">입찰 시작가 : <input id="sale_price" type="text" name="sale_price" style="border:1px solid; padding:2px; margin:0 0 0 10px; width:70px;"/> 원</div>
				<div id="sale_safe_account" class="button_gb" style="right:130px; top:33px; font-size:8pt;">안전거래 이용방법</div>
				<div id="sale_safe_info" class="button_gb" style="right:5px; top:33px; font-size:8pt;">안심번호 이용방법</div>
				</div>
				<textarea id="mywrite_content" name="mywrite_content"></textarea>
				<div id="mywrite_func" style="margin:0 0 20px 0;">
					<input id="mywrite_enter" type="image" src="../image/button_enter.png" value=""/>
				</div>
			</div>
			<div id="textarea_copy"></div>
			<input type="hidden" name="page_name" value="sale_write"/>
			<input type="hidden" name="write_new" value="new"/>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>