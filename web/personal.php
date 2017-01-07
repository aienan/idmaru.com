<?php
	if($user_num!=0){//사진 설정에서 회원 접속시
		$sql = "SELECT * FROM idcard_photo WHERE user_num=$user_num";
		$sql_query = mysqli_query($conn, $sql);
		$count = mysqli_num_rows($sql_query);
		if(!$count){//업로드된 사진이 없을때
			$idcard_photo = '<img src="../image/blank_face_gray.png" alt="no_pic_gray" width="102" height="102"/>';
		} else if($count){//업로드된 사진이 있을때
			$sql_fetch_array = mysqli_fetch_array($sql_query);
			if(!$sql_fetch_array["idcard_photo_path"]){
			} else if($sql_fetch_array["idcard_photo_path"]){
				$idcard_photo = '<img src="'.get_thumbnail_path($sql_fetch_array["idcard_photo_path"]).'" alt="user_pic" width="102" height="102"/>';
			}
		}
	} else if($user_num==0){//사진 설정에서 손님 접속시
		$idcard_photo = '<img src="../image/blank_face_gray.png" alt="guest_gray" width="102" height="102"/>';
	}
	$login_colorA = 'BBBBBB';
	$login_colorB = 'CCCCCC';
	echo "
		<script>
			var user_name = '$user_name';
			$(document).ready(function () {
				var login_fig = '로그인';
				var join_fig = '회원가입';
				var logout_fig = '로그아웃';
				if (user_name != 'Guest') {//회원입장
					$('#idcard_name').html('$user_name');
					$('#idcard_name').click(function(){location.href='myinfo.php';});
					if(isKorean(user_name)){ $('#idcard_name').css('font-size', '12pt');}
					$('#idcard_photo').html('$idcard_photo');
					$('#idcard_login, #idcard_join').css('display', 'none');
					$('#idcard_logout').css('display', 'block');
					$('#idcard_logout').html(logout_fig);
					$('#idcard_logout').click(function() {
						var url = location.href;
						$.ajax({
							url:'logout.php',
							data: {url:url},
							success: function(getdata){
								alert('로그아웃 되었습니다.');
								$('#temp_target').append(getdata);
								$('#idcard_login, #idcard_join').css('display', 'block');
								$('#idcard_logout').css('display', 'none');
							}
						});
					});
				} else if (user_name=='Guest') {//Guest입장
					$('#idcard_photo').html('$idcard_photo');
					if(user_name){ $('#idcard_name').html(user_name);}
					$('#idcard_name').click(function(){alert('로그인 후 이용해주세요');});
					if(is_mobile_check==1){ // mobile일경우
						$('#idcard_login').html(login_fig);
						$('#idcard_login').click(function(){
							window.open('login_window_mobile.php?location='+location.href, 'idcard_login', 'width=440,height=220,resizable=no,scrollbars=no,location=no');
						});
					} else {
						$('#idcard_login').html('<a id=\"login_window\" class=\"fancybox fancybox.iframe\" href=\"login_window.php?location='+location.href+'\">'+login_fig+'</a>');
						$(\".fancybox\").fancybox({width:412, height:192, padding:10, scrolling:'no'});
					}
					$('#idcard_join').html('<a id=\"join_window\" href=\"join_auto_prevent.php\" target=\"_blank\">'+join_fig+'</a>');
				}
				$('#idcard_login').hover(function(){
					$(this).css({'border':'#$login_colorB 1px solid', 'color':'#$login_colorB'});
					$('#login_window').css({'color':'#$login_colorB'});
				}, function(){
					$(this).css({'border':'#$login_colorA 1px solid', 'color':'#$login_colorA'});
					$('#login_window').css({'color':'#$login_colorA'});
				});
				$('#idcard_join').hover(function(){
					$(this).css({'border':'#$login_colorB 1px solid', 'color':'#$login_colorB'});
					$('#join_window').css({'color':'#$login_colorB'});
				}, function(){
					$(this).css({'border':'#$login_colorA 1px solid', 'color':'#$login_colorA'});
					$('#join_window').css({'color':'#$login_colorA'});
				});
				$('#idcard_logout').hover(function(){
					$(this).css({'border':'#$login_colorB 1px solid', 'color':'#$login_colorB'});
				}, function(){
					$(this).css({'border':'#$login_colorA 1px solid', 'color':'#$login_colorA'});
				});
				$('#idcard_photo').click(function(){
					window.open('idcard_photo.php', 'idcard_photo', 'width=800,height=600,resizable=yes,scrollbars=yes,location=no');
				});
				$('#idcard_name').attr('title', '나의 정보');
				$('#idcard_photo').attr('title', '나의 사진');
			});
		</script>
	";
?>
