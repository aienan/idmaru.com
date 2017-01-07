<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-방명록</title>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<link rel="stylesheet" href="../plugin/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script type="text/javascript" src="../plugin/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>
<?php 
	if(isset($_REQUEST["guest_private_type"])){$guest_private_type = $_REQUEST["guest_private_type"];}
	else {$guest_private_type="all";}
	$url = "guest.php?guest_private_type=".$guest_private_type."&";
	$page_name = "guest";
	$table_name = "guest_private";
	$ad_fixbar_cond = "guest";
	$ad_pop_cond = "guest";
	$ad_side_cond = "guest";
	include 'declare.php';
	include 'personal.php';
	include 'list.php';
?>
	<script>
		var guest_private_type = "<?php echo $guest_private_type;?>";
		var url = "<?php echo $url;?>";
		var page_name = "<?php echo $page_name;?>";
		var table_name = "<?php echo $table_name;?>";
		var guest_type = "guestPrivate";
		$(document).ready(function () {
			greenStyle();
			menuGuest();
			$("#guest_private_type_"+guest_private_type).css({"border":"#688009 1px solid", "color":"#688009"});
			setCookie("write_modify_count", 0, -1);//현재 다른글을 수정중인지 확인
			if(user_name=='Guest'){// Guest일 경우
				$('textarea[name=mywrite_content]').val(' 로그인 하셔야 글을 쓸 수 있습니다.');
				$('textarea[name=mywrite_content]').attr('readonly', 'readonly');
			}
			var ajaxform_options = {
				target: "#temp_target",
				success: function(){
					location.reload();
				}
			};
			$('#mywrite_enter').click(function(){//글쓰기 입력시
				if(user_name=="Guest"){
					alert('로그인 후 글을 쓰실 수 있습니다.');
				} else {//회원일 경우
					var name_receive = $('#id_yours_input').val();
					if(!name_receive){//아이디를 쓰지 않았을경우
						alert("받는이의 아이디를 입력해주세요");
					} else if($('textarea[name=mywrite_content]').val().length<3){//글이 3자 미만일경우
						alert('글을 입력해주세요. (3자 이상)');
					} else if(name_receive==user_name){//본인에게 보낼 경우
						alert("본인에게 쪽지를 보낼 수 없습니다");
					} else if($('textarea[name=mywrite_content]').val() && name_receive != user_name){//글이 입력되고 본인이 아닐 경우됐을경우
						var reply = confirm("쪽지를 보내시겠습니까?");
						if(reply==true){$("#mywrite_enter_submit").click();}
					}
				}
			});
			$("form[name=mywrite_new]").ajaxForm(ajaxform_options);//쪽지보내기용 form
			$('#write_friend_list').click(function(){//친구목록 클릭시
				if(user_name=="Guest"){
					alert('로그인 후 친구목록을 보실 수 있습니다.');
				} else {//회원일 경우
					if($("#write_friend_list_content").css("display")=="block"){
						$("#write_friend_list_content").css("display", "none");
					} else {
						$("#write_friend_list_content").css("display", "block");
					}
				}
			});
			$("#message_refuse").click(function(){
				if(user_num==0){alert("로그인 후 이용해주세요");}
				else {window.open("guest_message_refuse.php", "guest_message_refuse", "width=770,height=500,resizable=no,scrollbars=yes,location=no");}
			});
			if(user_num != 0){
				$('textarea[name=mywrite_content]').keyup(function () {//글쓰기textarea 설정
					if(event.shiftKey && event.keyCode=="13"){//shift+Enter를 눌렀을때
						$("#mywrite_enter").click();
					}
					$("#textarea_copy").html(convert_to_tag($(this).val()));
					$(this).height($('#textarea_copy').height()+30);//textarea의 height 조정
				});
				$('textarea[name=mywrite_modify_content]').keyup(function () {//수정용textarea 설정
					if(event.shiftKey && event.keyCode=="13"){//shift+Enter를 눌렀을때
						$("#mywrite_modify_confirm").click();
					}
					$("#textarea_copy").html(convert_to_tag($(this).val()));
					$(this).height($('#textarea_copy').height()+30);//textarea의 height 조정
					if($(this).height() > 2000){$('#mywrite_modify_text').css('overflow', 'auto')}
					$('#mywrite_modify_text').parents(":eq(4)").height($(this).height()+70);//write_XX의 높이
				});
				$('#mywrite_modify_confirm').click(function(){//수정완료
					if($('textarea[name=mywrite_modify_content]').val().length<3){//글이 10자 미만일경우
						alert('글을 입력해주세요. (3자 이상)');
					} else if($('textarea[name=mywrite_modify_content]').val().length>=3){//글이 입력됐을경우
						var reply = confirm("글을 수정하시겠습니까?");
						if(reply==true){
							var content = convert_to_tag($("#mywrite_modify_text").val());
							var write_modify_count = getCookie('write_modify_count');
							var write_modify_date = $(this).parents(":eq(3)").find(".write_date").html();//날짜를 추출한다
							$("input[name=write_modify_date]").val(write_modify_date);
							$("input[name=write_modify_count]").val(write_modify_count);
							$("#write_body_"+write_modify_count).html(content);
							$("#mywrite_modify_submit").click();
						}
					}
				});
				var ajaxform_options_mod = {
					target: "#temp_target",
					success: function(getdata){
						var write_modify_count = getCookie('write_modify_count');
						$("#write_"+write_modify_count+" .write_date").html(getdata);
						$('#mywrite_modify').css('display','none');
						$("#writearea_"+write_modify_count).css('display','block');
						$("#write_"+write_modify_count).height($("#write_"+write_modify_count+"> div[class=write_main]").height());//write_XX의 height를 write_main(자식) 높이로 설정해준다
						setCookie("write_modify_count", 0, -1);
					}
				};
				$("form[name=mywrite_mod]").ajaxForm(ajaxform_options_mod);//수정용 form
				$('#mywrite_modify_cancel').click(function(){//수정취소
					$('#mywrite_modify').css('display','none');
					$('#mywrite_modify_letterleft').html('');
					$('#mywrite_modify').prev().css('display', 'block');
					$('#mywrite_modify').parents(":eq(1)").height($('#mywrite_modify').parents(":eq(0)").height());//write_main이 absolute이므로 write_XX의 높이를 설정해준다
					setCookie("write_modify_count", 0, -1);
				});
				$.ajax({//친구 목록 출력
					url:'guest_private_friend_recall.php',
					data: {},
					success: function(getdata){
						$('#write_friend_list_content').append(getdata);
					}
				});
			}
		});
		function write_modify(count){//글 수정
			var write_modify_count = getCookie("write_modify_count");//현재 다른글을 수정중인지 확인
			if(write_modify_count){//다른글을 수정중인 경우
				$('#mywrite_modify').css('display','none');
				$('#mywrite_modify').prev().css('display', 'block');//수정전의 글을 보이게 한다
				$('#mywrite_modify').parents(":eq(1)").height($('#mywrite_modify').parent().height());//write_main이 absolute이므로 write_XX의 높이를 설정해준다
			}
			var content = $("#write_body_"+count).html();
			content = reverse_from_tag(content);
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
		function sender_dont_see(count){//보낸 메세지를 보지 않도록 표시
			var reply = confirm("글을 삭제하시겠습니까?");
			if(reply==true){
				var delete_type = "sender_dont_see";
				$.ajax({
					url:"guest_private_delete.php",
					data: {count:count, delete_type:delete_type},
					success: function(getdata){
						alert("글이 삭제되었습니다.");
						$("#write_"+count).css("display", "none");
					}
				});
			}
		}
		function receiver_dont_see(count){//받은 메세지를 보지 않도록 표시
			var reply = confirm("글을 삭제하시겠습니까?");
			if(reply==true){
				var delete_type = "receiver_dont_see";
				$.ajax({
					url:"guest_private_delete.php",
					data: {count:count, delete_type:delete_type},
					success: function(getdata){
						alert("글이 삭제되었습니다.");
						$("#write_"+count).css("display", "none");
					}
				});
			}
		}
		function change_list_type(value){
			var current_value = "<?php echo $guest_private_type;?>";
			if(value != current_value){
				location.href = "guest.php?guest_private_type="+value;
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
					<a href="guest.php"><div id="menu_square_guestPrivate" class="menu_square_item">방명록</div></a>
					<a href="idmaru_guest.php"><div id="menu_square_idmaruGuest" class="menu_square_item" style="width:110px;">모두에게한마디</div></a>
				</nav>
				<form name="mywrite_new" action="guest_private_write_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
					<div class="relative input_blue round_border" style="margin:20px 10px; background-color:#FDFDFD;  padding:0;">
						<div class="relative round_border_top" style="padding:0 13px; background-color:#DEF0F5;">
						<div class="write_id_area" style="z-index:6;">
							<div id="id_area" class="write_name">보낸이 : <?php echo $user_name;?></div>
							<div id="id_yours" class="write_to" style="padding:2px 0;">받는이 : <input type="text" id="id_yours_input" name="name_receive" value="" maxlength="12" style="width:165px; border:#98C0E2 1px solid;" /></div>
							<div id="write_friend_list" class="button_gb">친구 목록</div>
							<div id="write_friend_list_content"></div>
						</div>
						</div>
						<div class="relative round_border_bottom" style="padding:7px 13px;">
							<textarea id="mywrite_text" name="mywrite_content" class="input_gray"></textarea>
							<div class="mywrite_cont">
								<div id="mywrite_enter" style="right:2px;"><img src="../image/button_send.png"/></div>
								<input id="mywrite_enter_submit" type="submit" value="입    력" style="display:none;"/>
							</div>
						</div>
					</div>
				</form>
				<div id="textarea_copy"></div>
				<div id="mywrite_modify">
					<form name="mywrite_mod" action="guest_private_modify.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
						<div id="mywrite_modify_body"><!--수정용 textarea-->
							<textarea id="mywrite_modify_text" name="mywrite_modify_content" class="input_blue"></textarea>
						</div>
						<div id="mywrite_modify_bottom" class="write_bottom">
							<div id="mywrite_modify_letterleft"></div>
							<div id="mywrite_modify_confirm">수정완료</div>
							<div id="mywrite_modify_cancel">취소</div>
						</div>
						<input type="hidden" name="write_modify_date" value=""/>
						<input type="hidden" name="write_modify_count" value=""/>
						<input id="mywrite_modify_submit" type="submit" style="display:none;"/>
					</form>
				</div>
				<div class="content_area">
<?php include 'ad_textA.php';?>
					<div id="menu_square2" style="margin:20px 0 0 0;">
						<div id="guest_private_type_all" class="menu_square2_item" onclick="change_list_type('all')" >전체</div>
						<div id="guest_private_type_receive" class="menu_square2_item" onclick="change_list_type('receive')">받은글</div>
						<div id="guest_private_type_send" class="menu_square2_item" onclick="change_list_type('send')">보낸글</div>
					</div>
					<div id="list_search">
						<div id="list_search_box">
						<div id="list_search_tip" title="검색 Tip"><img src="../image/list_search_tip.png"/></div>
						<select id="list_search_category" name="list_search_category">
							<option selected value="writer">아이디</option><option value="content">글내용</option>
						</select>
						<input id="list_search_word" type="text" name="list_search_word" value="" maxlength="40" tabindex=""/>
						<div id="list_search_word_button" title="검색"></div>
						<div id="list_search_word_cancel" title="검색 취소"></div>
						</div>
						<div id="message_refuse" class="button_gb">수신 차단</div>
					</div>
<?php
	if($user_num != 0){include 'guest_private_recall.php';}
	else {echo '<div class="guest_inform"> 회원가입 하시면 idMaru 회원들과 쪽지를 주고받을 수 있습니다.</div>';}
?>
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