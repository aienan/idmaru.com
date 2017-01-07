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
	$count = $_REQUEST["count"];
	$type = 'select';
	$sql = "SELECT * FROM photo WHERE count=$count AND user_num=$user_num";
	$sql_query = mysqli_query($conn, $sql);
	$sql_fetch_array = mysqli_fetch_array($sql_query);
	$img_tag = img_adjust2($sql_fetch_array["photo_path"], 705, 705);
	$battle_exist = 0; // photo_battle 등록여부
	$sql2 = "SELECT * FROM photo_battle_type WHERE count=$count";
	$sql_query2 = mysqli_query($conn, $sql2);
	$count2 = mysqli_num_rows($sql_query2);
	if($count2){
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$battle_exist = 1;
	}
?>
	<script>
		$(document).ready(function () {
			var type = <?php echo $sql_fetch_array["type"];?>;
			var status = "<?php echo $sql_fetch_array["status"]; ?>";
			var battle_exist = <?php echo $battle_exist;?>;
			var photo_type = "<?php echo $sql_fetch_array2["photo_type"];?>";
			if(battle_exist==1){ // 이상형월드컵에 등록된 경우
				$("input:radio[name=battle_submit]:nth(0)").attr("checked", true);
				$("#photo_battle_category").val(photo_type);
				$("#battle_category").css({"display":"inline"});
			} else {
				$("input:radio[name=battle_submit]:nth(1)").attr("checked", true);
				$("#battle_category").css({"display":"none"});
			}
			$("#gallery_type").val(type);
			if(status=="1"){
				$('input:radio[name=status]:nth(0)').attr("checked", true);
			} else if(status=="2"){
				$('input:radio[name=status]:nth(1)').attr("checked", true);
			} else if(status=="3"){
				$('input:radio[name=status]:nth(2)').attr("checked", true);
			}
			$("#textarea_copy").html(convert_to_tag($("#mywrite_content").val()));
			$("#mywrite_content").height($('#textarea_copy').height()+30);//textarea의 height 조정
			$("#mywrite_content").keyup(function () {//글쓰기textarea 설정
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
				target: "#temp_target",
				success: function(){
					window.opener.location.reload();
					window.close();
				}
			};
			$('#mywrite_enter').click(function(){//등록 입력시
				if(user_name=="Guest"){
					alert('로그인 후 이용하실 수 있습니다.');
					event.preventDefault ? event.preventDefault() : event.returnValue=false;
				} else {//회원일 경우
					if(!$("#gallery_type").val()){
						alert("사진분류를 선택해주세요");
						event.preventDefault ? event.preventDefault() : event.returnValue=false;
					} else if($('textarea[name=mywrite_content]').val().length<5){//글이 10자 미만일경우
						alert('글을 5자 이상 입력해주세요.');
						event.preventDefault ? event.preventDefault() : event.returnValue=false;
					} else if($('textarea[name=mywrite_content]').val().length>=5){//글이 입력됐을경우
						var battle_submit = $("input:radio[name=battle_submit]:checked").val();
						var photo_battle_category = $("#photo_battle_category").val();
						if(battle_submit=="y" && !photo_battle_category){
							alert("이상형월드컵 경기종목을 선택해주세요");
							event.preventDefault ? event.preventDefault() : event.returnValue=false;
						} else {
							var reply;
							if(battle_exist==0 && battle_submit=="n"){reply = confirm("사진을 수정하시겠습니까?");} // 이상형월드컵에 미등록 상태이고 미등록 할 때
							else if(battle_exist==0 && battle_submit=="y"){reply = confirm("사진이 이상형월드컵에 등록됩니다. 사진을 수정하시겠습니까?");} // 이상형월드컵에 미등록 상태이고 등록 할 때
							else if(battle_exist==1 && battle_submit=="n"){reply = confirm("이상형월드컵 목록에서 사진이 제거됩니다. 사진을 수정하시겠습니까?");} // 이상형월드컵에 등록 상태이고 미등록 할 때
							else if(battle_exist==1 && battle_submit=="y"){ // 이상형월드컵에 등록 상태이고 등록 할 때
								if(photo_type==photo_battle_category){reply = confirm("사진을 수정하시겠습니까?");} // 이상형월드컵 사진에 변동이 없을때
								else if(photo_type != photo_battle_category){reply = confirm("이상형월드컵 사진의 경기종목이 바뀝니다. 사진을 수정하시겠습니까?");}
							}
							if(reply==true){$("form").ajaxSubmit(ajaxform_options); return false;}
							else if(reply==false){event.preventDefault ? event.preventDefault() : event.returnValue=false;}
						}
					}
				}
			});
			$("#mywrite_cancel").click(function(){
				window.close();
			});
			$("input:radio[name=battle_submit]").click(function(){
				var battle_category_select = $("input:radio[name=battle_submit]:checked").val();
				if(battle_category_select=='y'){$("#battle_category").css({"display":"inline"});}
				else if(battle_category_select=='n'){$("#battle_category").css({"display":"none"});}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 사진 수정하기</div></div>
	<div id="bodyarea_write">
		<form action="photo_modify_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
			<div id="mywrite_body" style="padding:10px;"><!--내글쓰기-->
				<div class="bold">
					<span>이상형월드컵 : </span>
					<span style="margin:0 0 0 5px;"> 등록 <input class="radio1" type="radio" name="battle_submit" value="y" tabindex=""/></span>
					<span style="margin:0 0 0 10px;"> 미등록 <input class="radio1" type="radio" name="battle_submit" value="n" tabindex=""/></span>
					<span id="battle_category" style="margin:0 0 0 10px;">경기종목 : <select id="photo_battle_category" name="photo_battle_category"><?php include 'photo_battle_category_recall.php';?></select></span>
				</div>
				<div class="input_gray" style="margin:0 0 5px 0;"></div>
<?php echo $select_gallery_type_write;?>
				<h6 class="inline">공개여부 : </h6>
				<h6 class="inline">&nbsp;모두</h6>
				<input class="inline radio1" type="radio" name="status" value="all" tabindex=""/>
				<h6 class="inline">&nbsp;친구</h6>
				<input class="inline radio1" type="radio" name="status" value="friend" tabindex=""/>
				<h6 class="inline">&nbsp;비공개</h6>
				<input class="inline radio1" type="radio" name="status" value="private" tabindex=""/><br/>
				<div id="photo_show"><?php echo $img_tag; ?></div>
				<h6>사진 설명</h6>
				<textarea id="mywrite_content" class="input_blue" name="mywrite_content" maxlength="1000" style="width:705px;"><?php echo $sql_fetch_array["content"]; ?></textarea>
				<div id="mywrite_func" style="height:30px;">
					<div id="mywrite_letterleft">0 / 1000</div>
					<input id="mywrite_enter" type="image" src="../image/button_enter.png" style="right:60px;" />
					<input id="mywrite_cancel" type="image" name="cancel" src="../image/button_cancel.png" style="position:absolute; right:0px; top:0px;" />
				</div>
			</div>
			<div id="textarea_copy"></div>
			<input type="hidden" name="count" value="<?php echo $sql_fetch_array["count"]; ?>"/>
			<input type="hidden" name="battle_exist" value="<?php echo $battle_exist; ?>"/>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>