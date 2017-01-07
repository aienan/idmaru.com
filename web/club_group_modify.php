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
	include 'mysql_setting.php';
	$count_group = $_REQUEST["count_group"];
	$sql = "SELECT * FROM club_group WHERE count_group = $count_group AND user_num = $user_num";//모임 정보 보기
	$sql_query = mysqli_query($conn, $sql);
	$sql_fetch_array = mysqli_fetch_array($sql_query);
?>
	<script>
		var count_group = <?php echo $count_group; ?>;
		var group_name = "<?php echo $sql_fetch_array["group_name"]; ?>";
		var status = <?php echo $sql_fetch_array["status"];?>;
		var status_nth = status - 1;
		$(document).ready(function () {
			$("input:radio[name=status]:nth("+status_nth+")").attr("checked", true);
			$('#textarea_copy').html(convert_to_tag($("#mywrite_content").val()));
			$("#mywrite_content").height($('#textarea_copy').height()+30);//textarea의 height 조정
			var string = $("#mywrite_content").val();//enter는 글자수에 2씩 더해야한다
			var regExp = /[^\n]/gm;//줄바꿈을 제외한 임의의 문자
			var enter = string.replace(regExp, '');//줄바꿈만 남긴다
			var inputLength = $("#mywrite_content").val().length;
			$('#mywrite_letterleft').html( (inputLength+enter.length) + ' / 255');// 글자 수를 구합니다
			$("#mywrite_content").keyup(function () {//글쓰기textarea 설정
				$("#textarea_copy").html(convert_to_tag($(this).val()));
				$(this).height($('#textarea_copy').height()+30);//textarea의 height 조정
				var string = $(this).val();//enter는 글자수에 2씩 더해야한다
				var regExp = /[^\n]/gm;//줄바꿈을 제외한 임의의 문자
				var enter = string.replace(regExp, '');//줄바꿈만 남긴다
				var inputLength = $(this).val().length;
				$('#mywrite_letterleft').html( (inputLength+enter.length) + ' / 255');// 글자 수를 구합니다
			});
			$("#keyword_register_button").click(function(){
				var keyword = $("#keyword_input").val();
				var description = $("#mywrite_content").val();
				if(!keyword){
					alert("모임 이름을 입력해주세요");
				} else if(!description){
					alert("모임 설명을 입력해주세요");
				} else if(keyword && description){
					var reply = confirm("모임 정보를 수정하시겠습니까?");
					if(reply==true){
						var status=$("input:radio[name=status]:checked").val();
						$.ajax({
							url:'club_group_modify_submit.php',
							data: {group_name:keyword, description:description, count_group:count_group, status:status},
							success: function(getdata){
								if(getdata == "done"){
									alert("모임 정보가 수정되었습니다");
									window.opener.location.reload();
									window.close();
								}
							}
						});
					}
				}
			});
			$("#club_group_dismiss").click(function(){
				var status_position = "host";
				var reply = confirm("모임을 해체하시겠습니까?");
				if(reply==true){
					var reply1 = confirm("한번 더 확인합니다. 정말로 모임을 해체하시겠습니까?");
					if(reply1 = true){
						$.ajax({
							url:'club_group_quit.php',
							data: {status_position:status_position, count_group:count_group},
							success: function(getdata){
								window.open("club_group.php", "idmaru", "");
								alert("모임이 해체되었습니다");
								window.close();
							}
						});
					}
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div id="bodyarea_write">
		<h6 style="margin:20px 0; padding:5px; background-color:#CFF3E0;"><img src="../image/list_pineB.png"/> 모임 정보 수정</h6>
		<div><h6 class="relative inline">모임명 : &nbsp;</h6><input id="keyword_input" class="input_blue inline" type="text" name="keyword_input" value="<?php echo $sql_fetch_array["group_name"] ?>" tabindex=""/></div>
		<div style="margin:20px 0 10px 0;">
		<h6 class="inline">모임 공개여부 : </h6>
		<h6 class="inline">&nbsp;모두</h6>
		<input class="inline radio1" type="radio" name="status" value="1" tabindex="" checked />
		<h6 class="inline">&nbsp;친구</h6>
		<input class="inline radio1" type="radio" name="status" value="2" tabindex=""/>
		<h6 class="inline">&nbsp;비공개</h6>
		<input class="inline radio1" type="radio" name="status" value="3" tabindex=""/>
		</div>
		<h6 style="padding:0 10px;"> ▼ 모임 설명</h6>
		<div id="mywrite_body"><!--모임 설명-->
			<textarea id="mywrite_content" class="input_blue" name="mywrite_content" maxlength="255"><?php echo $sql_fetch_array["description"]; ?></textarea>
			<div class="relative" style="height:30px;"><div id="mywrite_letterleft">0 / 255</div><div id="keyword_register_button" class="button_gb" style="right:0px; top:0px;">수정하기</div></div>
		</div>
		<div id="textarea_copy"></div>
		<h6 style="margin:100px 0 0 0; padding:5px; background-color:#CFF3E0;"><img src="../image/list_pineB.png" style="position:relative; top:2px;"/> 모임 해체하기</h6><br/>
		<div id="club_group_dismiss" class="button_gb">모임 해체하기</div><br/><br/>
	</div>
	<div id="temp_target"></div>
</body>
</html>