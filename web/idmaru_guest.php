<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-모두에게한마디</title>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link rel="stylesheet" href="../plugin/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script type="text/javascript" src="../plugin/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>
<?php 
	$url = "idmaru_guest.php?";
	$ad_fixbar_cond = "idmaru_guest";
	$ad_pop_cond = "idmaru_guest";
	$ad_side_cond = "idmaru_guest";
	include 'declare.php';
	include 'personal.php';
?>
	<script>
		var url = "<?php echo $url;?>";
		var guest_type = "idmaruGuest";
		var upperwrite=0;
		var idmaru_guest_count = 0;
		$(document).ready(function () {
			greenStyle();
			menuGuest();
			var number = $("#list_number_set").val();
			setCookie("write_modify_count", 0, -1);//수정번호 초기화
			$('#id_area').html(user_name);//글쓰기에 id 설정
			$.ajax({//모두에게한마디 결과물 출력
				url:'idmaru_guest_recall.php',
				data: {upperwrite: upperwrite, number: number, idmaru_guest_count:idmaru_guest_count},
				success: function(getdata){
					$('#idmaru_guest_recall').append(getdata);
					$("#idmaru_guest_loading").css("display", "none");
				}
			});
			$('#mywrite_enter_B').click(function(){//글쓰기 입력시
				if($('textarea[name=mywrite_content]').val().length>=10){//글이 입력됐을경우
					var reply = confirm("글을 입력하시겠습니까?");
					if(reply==true){
						var idmaru_guest_count = 0;
						var upperwrite=0;
						var number = $("#list_number_set").val();
						var mywrite_content = $('textarea[name=mywrite_content]').val();
						$.ajax({
							url:'idmaru_guest_write.php',
							data: {upperwrite: upperwrite, mywrite_content: mywrite_content, idmaru_guest_count:idmaru_guest_count},
							success: function(getdata){
								location.reload();
							}
						});
					}
				} else if($('textarea[name=mywrite_content]').val().length<10){//글이 10자 미만일경우
					alert('글을 10자 이상 입력해주세요.');
				}
			});
			$('textarea[name=mywrite_content]').keyup(function () {//글쓰기textarea 설정
				if(event.shiftKey && event.keyCode=="13"){//shift+Enter를 눌렀을때
					$("#mywrite_enter_B").click();
				}
				$('#textarea_copy_B').width($('#mywrite_text_B').width());
				$('#textarea_copy_B').html(convert_to_tag($(this).val()));
				$(this).height($('#textarea_copy_B').height()+30);//textarea의 height 조정
				if($(this).height() > 380){$(this).css("overflow", "auto");}
				var string = $(this).val();//enter는 글자수에 2씩 더해야한다
				var regExp = /[^\n]/gm;//줄바꿈을 제외한 임의의 문자
				var enter = string.replace(regExp, '');//줄바꿈만 남긴다
				var inputLength = $(this).val().length;
				$('#mywrite_letterleft').html( (inputLength+enter.length) + ' / 1000');// 글자 수를 구합니다
			});
			$('textarea[name=mywrite_modify_content]').keyup(function () {//수정용textarea 설정
				if(event.shiftKey && event.keyCode=="13"){//shift+Enter를 눌렀을때
					$("#mywrite_modify_confirm").click();
				}
				$('#textarea_copy_B').width($('#mywrite_modify_text').width());
				$('#textarea_copy_B').html(convert_to_tag($(this).val()));
				$(this).height($('#textarea_copy_B').height()+30);//textarea의 height 조정
				if($(this).height() > 380){$('#mywrite_modify_text').css('overflow', 'auto')}
				$('#mywrite_modify_text').parents(":eq(3)").height($(this).height()+70);//write_XX의 높이
				var string = $(this).val();//enter는 글자수에 2씩 더해야한다
				var regExp = /[^\n]/gm;//줄바꿈을 제외한 임의의 문자
				var enter = string.replace(regExp, '');//줄바꿈만 남긴다
				var inputLength = $(this).val().length;
				$('#mywrite_modify_letterleft').html( (inputLength+enter.length) + ' / 1000');//글자수를 구합니다
			});
			$('#mywrite_modify_confirm').click(function(){//수정완료
				if($("textarea[name=mywrite_modify_content]").val().length<5){//글이 5자 미만일경우
					alert("글을 5자 이상 입력해주세요.");
				} else if($("textarea[name=mywrite_modify_content]").val().length>=5){//글이 입력됐을경우
					var reply = confirm("글을 수정하시겠습니까?");
					if(reply==true){
						var content = $("#mywrite_modify_text").val();
						var write_modify_count = getCookie('write_modify_count');
						var senddata = { content: content, write_modify_count: write_modify_count };
						$.getJSON( 'idmaru_guest_modify.php', senddata, function (getdata) {
							$.each(getdata, function (key, value) {
								$("#write_"+write_modify_count+" .write_date").html(value);
							});
						});
						$('#mywrite_modify').css('display','none');
						$('#mywrite_modify_letterleft').html('');
						$("#write_body_"+write_modify_count).html(convert_to_tag(content));
						$("#writearea_"+write_modify_count).css('display','block');
						$("#write_"+write_modify_count).height($("#write_"+write_modify_count+"> div[class=write_main_B]").height());//write_XX의 height를 write_main_B(자식) 높이로 설정해준다
						setCookie("write_modify_count", 0, -1);
					}
				}
			});
			$('#mywrite_modify_cancel').click(function(){//수정취소
				$('#mywrite_modify').css('display','none');
				$('#mywrite_modify_letterleft').html('');
				$('#mywrite_modify').prev().css('display', 'block');
				$('#mywrite_modify').parents(":eq(1)").height($('#mywrite_modify').parents(":eq(0)").height());//write_main이 absolute이므로 write_XX의 높이를 설정해준다
				$("#idmaru_guest_write_B").after($("#mywrite_modify"));
				setCookie("write_modify_count", 0, -1);
			});
			$('textarea[name=mywrite_reply_content]').keyup(function () {//댓글용textarea 설정
				$('#textarea_copy_B').html(convert_to_tag($(this).val()));
				$('#textarea_copy_B').width($('#mywrite_reply_text').width());
				$(this).height($('#textarea_copy_B').height()+30);//textarea의 height 조정
				if($(this).height() > 380){$('#mywrite_reply_text').css('overflow', 'auto')}
				var string = $(this).val();//enter는 글자수에 2씩 더해야한다
				var regExp = /[^\n]/gm;//줄바꿈을 제외한 임의의 문자
				var enter = string.replace(regExp, '');//줄바꿈만 남긴다
				var inputLength = $(this).val().length;
				$('#mywrite_reply_letterleft').html( (inputLength+enter.length) + ' / 300');//글자수를 구합니다
			});
			$('#mywrite_reply_enter').click(function(){//댓글 입력시
				var write_modify_count = getCookie('write_modify_count');//수정중인 글이 있는지 확인
				if(write_modify_count){//수정중인 글이 있을경우
					$("#mywrite_modify_text").parent().next().children("#mywrite_modify_cancel").click();//수정취소를 누른다
				}
				if($('textarea[name=mywrite_reply_content]').val().length>=5){//글이 입력됐을경우
					var reply=confirm("댓글을 입력하시겠습니까?");
					if(reply==true){
						var upperwrite_id = $('#mywrite_reply').parent().prev().attr('id');//upperwrite의 id를 구한다
						var upperwrite = upperwrite_id.substring(6, upperwrite_id.length);
						var mywrite_content = $("textarea[name=mywrite_reply_content]").val();
						var senddata = { upperwrite: upperwrite, mywrite_content: mywrite_content };
						$.getJSON( 'idmaru_guest_write.php', senddata, function (getdata) {//글을 입력한다.
						});
						var write_num = '#write_'+upperwrite;//댓글이 씌어지는 부모글번호
						var reply_num = $(write_num).find('.see_reply_status').html().substring(5, $(write_num).find('.see_reply_status').html().length);//댓글갯수 string
						reply_num = parseInt(reply_num);
						var new_reply_num = reply_num+1;//댓글 1올리기
						$(write_num).find('.see_reply_status').html('▼ 댓글 '+new_reply_num);
						$(write_num).find('.write_reply_confirm_cancel').trigger('click');//댓글취소
						$(write_num).find('.see_reply_status').trigger('click');//댓글 입력 후 바로 글이 보이게 하기
						$('textarea[name=mywrite_reply_content]').val('');//댓글입력칸 초기화
						$('#textarea_copy_B').html('');
						$('textarea[name=mywrite_reply_content]').height($('#textarea_copy_B').height()+30);
						$('#mywrite_reply_letterleft').html('0 / 300');
					}
				} else if($('textarea[name=mywrite_content]').val().length<5){//글이 5자 미만일경우
					alert('글을 5자 이상 입력해주세요.');
				}
			});
			var list_number = $("#list_number_set").val();
			$("#list_number_set").blur(function(){
				if(!$("#list_number_set").val()){alert("10 이상의 숫자만 가능합니다"); $("#list_number_set").val(list_number);}
				else{
					var upperwrite=0;
					var number = $("#list_number_set").val();
					if(number == list_number){//변화없을때는 로딩하지 않음
					} else if(isNumber(number)==false){
						alert("숫자만 입력 가능합니다");
						$("#list_number_set").val(list_number);
					} else if(number < 10){
						alert("10 이상의 숫자만 가능합니다");
						$("#list_number_set").val(list_number);
					} else if(number >= 10){
						var idmaru_guest_count = 0;
						$.ajax({
							url:'idmaru_guest_recall.php',
							data: {upperwrite: upperwrite, number: number, idmaru_guest_count:idmaru_guest_count},
							success: function(getdata){
								$("#idmaru_guest_recall").html(getdata);
							}
						});
					}
				}
			});
			enterAndBlur("#list_number_set");
			$("#article_moreB").click(function(){//more 클릭시
				var upperwrite=0;
				var number = $("#list_number_set").val();
				$("#article_moreB").css("display", "none");
				$("#article_moreB_loading").css("display", "block");
				$.ajax({
					url:"idmaru_guest_recall.php",
					data: {upperwrite: upperwrite, number: number, idmaru_guest_count:idmaru_guest_count},
					success: function(getdata){
						$("#idmaru_guest_recall").append(getdata);
						$("#article_moreB_loading").css("display", "none");
					}
				});
			});
		});
		function write_modifyB(count){//글 수정
			var write_modify_count = getCookie("write_modify_count");//현재 다른글을 수정중인지 확인
			if(write_modify_count){//다른글을 수정중인 경우
				$('#mywrite_modify').css('display','none');
				$('#mywrite_modify').prev().css('display', 'block');//수정전의 글을 보이게 한다
				$('#mywrite_modify').parents(":eq(1)").height($('#mywrite_modify').parent().height());//write_main이 absolute이므로 write_XX의 높이를 설정해준다
			}
			var content = reverse_from_tag($("#write_body_"+count).html());
			var height = $("#write_body_"+count).height();
			var width = $("#write_body_"+count).width();
			setCookie("write_modify_count", count, 31536000);
			$("#mywrite_modify_text").val(content);
			$("#mywrite_modify_text").height(height);
			$("#mywrite_modify_text").width(width);
			$("#writearea_"+count).css("display","none");
			$("#writearea_"+count).after($("#mywrite_modify"));
			$("#mywrite_modify").css("display","block");
		}
		function write_deleteB(count){//글 삭제
			var reply = confirm("글을 삭제하시겠습니까?");
			if(reply== true){
				$.ajax({
					url:"idmaru_guest_delete.php",
					data: {count:count},
					success: function(getdata){
						alert("글이 삭제되었습니다.");
						var next_element = $("#write_"+count).next();
						if(next_element.hasClass("replyarea")){
							next_element.remove();
						}
						$("#write_"+count).remove();
					}
				});
			}
		}
		function see_replyB(count){//댓글 클릭
			var upperwrite=count;
			var write_num = "#write_"+upperwrite;//댓글이 씌어지는 부모글번호
			var reply_num = $(write_num).find(".see_reply_status").html().substring(5, $(write_num).find(".see_reply_status").html().length);//댓글갯수 string
			$("#write_"+upperwrite).after('<div class="loading24x24" style="left:350px; display:block;"></div>');
			$.ajax({//댓글 recall
				url:"idmaru_guest_recall.php",
				data: {upperwrite: upperwrite},
				success: function(getdata){//글번호로 가서 결과물 달기
					$("#write_"+upperwrite).next().remove();
					$("#write_"+upperwrite).after(getdata);
					$("#write_"+upperwrite).height($("#write_"+upperwrite).children(".write_main_B").height());//write_num의 height설정
					$("#see_reply_"+upperwrite).css("display", "none");
					$("#see_reply_"+upperwrite).after('<div class="see_reply_status reply_fold" onclick="write_foldB('+upperwrite+')">▲ 댓글 접기</div>');
				}
			});
		}
		function write_foldB(num){//댓글접기 클릭
			var write_num = "#write_"+num;
			var replyarea = $(write_num).next();
			if($(replyarea).has("#mywrite_modify").length){//댓글접기할 때 그 안에 수정중인 글이 있을경우
				$("#mywrite_modify").find("#mywrite_modify_cancel").click();//수정글을 이동해준다
			}
			var mywrite_replyNode = document.getElementById("mywrite_reply");//reply textarea를 이동한다.
			mywrite_replyNode.style.display = "none";
			var idmaru_guest_writeNode = document.getElementById("idmaru_guest_write_B");
			idmaru_guest_writeNode.insertBefore(mywrite_replyNode, idmaru_guest_writeNode.lastChild);
			//댓글을 제거한다.
			var see_reply_num = "see_reply_"+num;
			var write_num = "write_"+num;
			document.getElementById(see_reply_num).style.display="inline";
			document.getElementById(see_reply_num).parentNode.removeChild(document.getElementById(see_reply_num).nextSibling);//댓글접기 제거
			document.getElementById(write_num).parentNode.removeChild(document.getElementById(write_num).nextSibling);//댓글 제거
		}
		function write_replyB(num){//댓글쓰기 클릭
			$(".write_reply_confirm, #write_reply_cancel_"+num).css("display", "block");
			$(".write_reply_confirm_cancel, #write_reply_"+num).css("display", "none");
			var write_numNode = document.getElementById("write_"+num);
			var mywrite_replyNode = document.getElementById("mywrite_reply");
			if(write_numNode.nextSibling.nodeType==3){//댓글이 닫혀있을때
				$(write_numNode).after(mywrite_replyNode);
			} else if(write_numNode.nextSibling.nodeType==1){//댓글이 열려있을때
				$(write_numNode).next().children(":last").after(mywrite_replyNode);
				$(mywrite_replyNode).css('margin', '10px 0 0px 30px');
			}
			mywrite_replyNode.style.display = "block";
			document.getElementById('mywrite_reply_text').style.width=(mywrite_replyNode.offsetWidth-20)+"px";//reply textarea의 넓이를 맞춰준다.
			document.getElementById('textarea_copy_B').style.width=(mywrite_replyNode.offsetWidth-20)+"px";
			var write_reply_numNode = document.getElementById("write_reply_"+num);
			write_reply_numNode.style.display = "none";
			write_reply_numNode.nextSibling.nextSibling.style.display = "block";
		}
		function write_reply_cancelB(num){//댓글취소 클릭
			$("#mywrite_reply_text").val("");//댓글 textarea를 비워준다
			$("#textarea_copy_B").val("");
			$('#mywrite_reply_letterleft').html('0 / 300');
			var mywrite_replyNode = document.getElementById("mywrite_reply");
			mywrite_replyNode.style.display = "none";
			var idmaru_guest_writeNode = document.getElementById("idmaru_guest_write_B");
			idmaru_guest_writeNode.insertBefore(mywrite_replyNode, idmaru_guest_writeNode.lastChild);
			$("#write_reply_"+num).css("display", "block");
			$("#write_reply_cancel_"+num).css("display", "none");
			$("#idmaru_guest_write_B").after($("#mywrite_reply"));
		}
		function rate_upB(count, writer_num){//up 클릭
			if(user_name=='Guest'){
				alert("로그인 후 이용해주세요");
			} else if(writer_num==user_num){
				alert("본인의 글에 투표할 수 없습니다");
			}else{
				var reply = confirm("글을 추천하시겠습니까?");
				if(reply==true){
					$.ajax({//댓글 recall
						url:"idmaru_guest_rate.php",
						data: {count:count, updown:"up"},
						success: function(getdata){//글번호로 가서 결과물 달기
							if(getdata=="exist"){
								var reply2 = confirm("이미 의견을 표시한 글입니다. 의견을 취소하시겠습니까?");
								if(reply2==true){
									$.ajax({
										url:"idmaru_guest_rate_cancel.php",
										data:{count:count},
										success: function(getdata){
											if(getdata=="up"){
												var rate_num = parseInt($("#rate_"+count).html());
												$("#rate_"+count).html(rate_num-1);
											} else if(getdata=="down"){
												var rate_num = parseInt($("#rate_"+count).html());
												$("#rate_"+count).html(rate_num+1);
											}
											alert("의견이 취소되었습니다");
										}
									});
								}
							} else if(getdata=="myself"){
								alert("본인의 글에 투표할 수 없습니다");
							} else if(getdata=="done") {
								var rate_num = parseInt($("#rate_"+count).html());
								$("#rate_"+count).html(rate_num+1);
								alert("글을 추천하셨습니다");
							}
						}
					});
				}
			}
		}
		function rate_downB(count, writer_num){//down 클릭
			if(user_name=='Guest'){
				alert("로그인 후 이용해주세요");
			} else if(writer_num==user_num){
				alert("본인의 글에 투표할 수 없습니다");
			}else{
				var reply = confirm("글을 반대하시겠습니까?");
				if(reply==true){
					$.ajax({//댓글 recall
						url:"idmaru_guest_rate.php",
						data: {count:count, updown:"down"},
						success: function(getdata){//글번호로 가서 결과물 달기
							if(getdata=="exist"){
								var reply2 = confirm("이미 의견을 표시한 글입니다. 의견을 취소하시겠습니까?");
								if(reply2==true){
									$.ajax({
										url:"idmaru_guest_rate_cancel.php",
										data:{count:count},
										success: function(getdata){
											if(getdata=="up"){
												var rate_num = parseInt($("#rate_"+count).html());
												$("#rate_"+count).html(rate_num-1);
											} else if(getdata=="down"){
												var rate_num = parseInt($("#rate_"+count).html());
												$("#rate_"+count).html(rate_num+1);
											}
											alert("의견이 취소되었습니다");
										}
									});
								}
							} else if(getdata=="myself"){
								alert("본인의 글에 투표할 수 없습니다");
							} else if(getdata=="done") {
								var rate_num = parseInt($("#rate_"+count).html());
								$("#rate_"+count).html(rate_num-1);
								alert("글을 반대하셨습니다");
							}
						}
					});
				}
			}
		}
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body>
	<div id="toparea">
<?php include 'toparea.php'; ?>
	</div>
	<div id="bodyarea">
		<div id="mainbar">
			<div id="mainbody">
				<header id="page_title"></header>
				<nav class="menu_square">
					<a href="guest.php"><div id="menu_square_guest" class="menu_square_item">방명록</div></a>
					<a href="idmaru_guest.php"><div id="menu_square_idmaruGuest" class="menu_square_item" style="width:110px;">모두에게한마디</div></a>
				</nav>
				<div class="content_area">
				<div id="idmaru_guest_write_B">
					<div class="write_main_B input_blue round_border" style="position:relative;">
						<div class="write_id_area round_border_top" style="background-color:#DEF0F5; ">
							<div id="id_area" class="write_name"></div>
							<div class="write_date"></div>
						</div>
						<div class="mywrite_body round_border_bottom" style="padding:9px; background-color:#FDFDFD;"><!--내글쓰기-->
							<textarea id="mywrite_text_B" name="mywrite_content" maxlength="1000" class="input_gray"></textarea>
							<div class="mywrite_cont">
								<div id="mywrite_letterleft">0 / 1000</div>
								<div id="mywrite_enter_B"><img src="../image/button_enter.png"/></div>
							</div>
						</div>
						<div id="textarea_copy_B"></div>
					</div>
				</div>
				<div id="mywrite_modify"><!--수정용 textarea-->
					<div id="mywrite_modify_body">
						<textarea id="mywrite_modify_text" name="mywrite_modify_content" maxlength="1000" class="input_blue"></textarea>
					</div>
					<div id="mywrite_modify_bottom" class="write_bottom">
						<div id="mywrite_modify_letterleft"></div>
						<div id="mywrite_modify_confirm">수정완료</div>
						<div id="mywrite_modify_cancel">취소</div>
					</div>
				</div>
				<div id="mywrite_reply" class="mywrite_body"><!--댓글용 textarea-->
					<textarea id="mywrite_reply_text" name="mywrite_reply_content" maxlength="300" class="input_blue"></textarea>
					<div class="mywrite_cont">
						<div id="mywrite_reply_letterleft">0 / 300</div>
						<div id="mywrite_reply_enter"><img src="../image/button_enter.png"/></div>
					</div>
				</div>
<?php include 'ad_textA.php';?>
				<div id="list_number" class="relative round_border" style="height:22px;" title="목록갯수"><input id="list_number_set" type="text" name="list_number_set" value="25" maxlength="2" tabindex=""/></div>
				<div id="idmaru_guest_loading" class="loading48x48" style="left:340px;"></div>
				<div id="idmaru_guest_recall" class="relative"></div><!--글목록-->
				<div id="article_moreB_loading" class="loading48x48" style="left:340px; display:none;"></div>
				<div id="article_moreB">더 보 기</div><!--글더보기-->
				</div>
			</div>
		</div>
<?php include 'sidebar.php'; ?>
	</div>
	<div id="endarea">
<?php include 'pineforest.php'; ?>
	</div>
	<div id="temp_target"></div>
</body>
</html>