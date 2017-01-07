<?php
	include 'header.php';
	include 'mysql_setting.php';
	$output = '';
	$sql1 = "SELECT * FROM home_alarm WHERE user_num=$user_num ORDER BY writetime ASC";//home_alarm에서 새로운 소식을 불러온다
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	for($i=0; $i<$count1; $i++){//home_alarm의 결과 출력
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		if($sql_fetch_array1["count2"]){$count2 = $sql_fetch_array1["count2"];}
		else {$count2 = 0;}
		if( ($sql_fetch_array1["table_name"]=="club_group_invite_accept") || ($sql_fetch_array1["table_name"]=="club_group_invite_refuse") || ($sql_fetch_array1["table_name"]=="club_group_member_deleted") || ($sql_fetch_array1["table_name"]=="club_group_member_quit") || ($sql_fetch_array1["table_name"]=="club_group_dismissed") || ($sql_fetch_array1["table_name"]=="friend_submit_accept") || ($sql_fetch_array1["table_name"]=="friend_submit_refuse") || ($sql_fetch_array1["table_name"]=="friend_delete") || ($sql_fetch_array1["table_name"]=="club_group_admit_refuse") || ($sql_fetch_array1["table_name"]=="club_group_admit_accept") || ($sql_fetch_array1["table_name"]=="sale_trader_refuse") || ($sql_fetch_array1["table_name"]=="market_deal_new") || ($sql_fetch_array1["table_name"]=="market_deal_modify") || ($sql_fetch_array1["table_name"]=="reply_submit_idmaru_guest") || ($sql_fetch_array1["table_name"]=="reply_submit_writing") || ($sql_fetch_array1["table_name"]=="reply_submit_photo") || ($sql_fetch_array1["table_name"]=="reply_submit_sale") || ($sql_fetch_array1["table_name"]=="reply_submit_club_event") || ($sql_fetch_array1["table_name"]=="reply_submit_club_group_writing") || ($sql_fetch_array1["table_name"]=="reply_submit_about_question") || ($sql_fetch_array1["table_name"]=="sale_reserve_box_delete") || ($sql_fetch_array1["table_name"]=="about_question_write") ){//확인만 누르면 지워지는 메세지
			$html = '
				<div id="home_alarm_one'.$i.'" class="home_alarm_one">
					'.$sql_fetch_array1["description"].' <span class="writetime">('.$sql_fetch_array1["writetime"].')</span>
					<div class="home_alarm_one_delete button_gb">확인</div>
				</div>
				<script>
					$(".home_alarm_one").hover(function(){
						$(this).css({"background-color":"#EEF6D4"});
					}, function(){
						$(this).css({"background-color":"#FFF"});
					});
					$("#home_alarm_one'.$i.' .home_alarm_one_delete").click(function(){//확인을 클릭할 경우
						var table_name = "'.$sql_fetch_array1["table_name"].'";
						var count2 = '.$count2.';
						$.ajax({
							url:"home_alarm_delete.php",
							data: {table_name:table_name, count:'.$sql_fetch_array1["count"].', count2:count2, writetime:"'.$sql_fetch_array1["writetime"].'"},
							success: function(getdata){
								$("#home_alarm_one'.$i.'").css("display", "none");
								if(getdata=="none"){//소식이 하나도 없을경우
									location.reload();
								}
							}
						});
					});
				</script>
			';
		} else if($sql_fetch_array1["table_name"]=="manager_news"){
			$html = '
				<div id="home_alarm_one'.$i.'" class="home_alarm_one link"> [공지] '.$sql_fetch_array1["description"].' <span class="writetime">('.$sql_fetch_array1["writetime"].')</span></div>
				<script>
					$("#home_alarm_one'.$i.'").click(function(){
						window.open("manager_news_see.php?count='.$sql_fetch_array1["count2"].'", "manager_news_see", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
					});
				</script>
			';
		} else if($sql_fetch_array1["table_name"]=="sale_trader_delete" ){
			$html = '
				<div id="home_alarm_one'.$i.'" class="home_alarm_one link"> [알림] '.$sql_fetch_array1["description"].' <span class="writetime">('.$sql_fetch_array1["writetime"].')</span></div>
				<script>
					$("#home_alarm_one'.$i.'").click(function(){
						window.open("sale_trader_list.php", "sale_trader_list", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
					});
				</script>
			';
		} else if($sql_fetch_array1["table_name"]=="sale_trader_accept"){
			$html = '
				<div id="home_alarm_one'.$i.'" class="home_alarm_one link"> [알림] '.$sql_fetch_array1["description"].' <span class="writetime">('.$sql_fetch_array1["writetime"].')</span></div>
				<script>
					$("#home_alarm_one'.$i.'").click(function(){
						window.open("sale_trader_list.php", "sale_trader_list", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
					});
				</script>
			';
		} else if($sql_fetch_array1["table_name"]=="club_group_invite"){//모임에 초대되었을 경우
			$html = '
				<div id="home_alarm_one'.$i.'" class="home_alarm_one link"> [알림] '.$sql_fetch_array1["description"].' <span class="writetime">('.$sql_fetch_array1["writetime"].')</span></div>
				<script>
					$("#home_alarm_one'.$i.'").click(function(){
						window.open("club_group_invite_detail.php?count_group='.$sql_fetch_array1["count"].'", "home_alarm_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
					});
				</script>
			';
		} else if($sql_fetch_array1["table_name"]=="friend_submit"){//친구신청 받았을 경우
			$html = '
				<div id="home_alarm_one'.$i.'" class="home_alarm_one link"> [알림] '.$sql_fetch_array1["description"].' <span class="writetime">('.$sql_fetch_array1["writetime"].')</span></div>
				<script>
					$("#home_alarm_one'.$i.'").bind({
						mouseenter: function () {
							$("#home_alarm_one'.$i.' .friend_submit_detail").css("display", "block");
						},
						mouseleave: function () {
							$("#home_alarm_one'.$i.' .friend_submit_detail").css("display", "none");
						}
					});
					$("#home_alarm_one'.$i.'").click(function(){//알림을 클릭할 경우
						window.open("friend_submit_detail.php?friend_num='.$sql_fetch_array1["count"].'", "friend_submit_detail", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
					});
				</script>
			';
		} else if($sql_fetch_array1["table_name"]=="club_group_admit"){//모임 가입신청이 왔을때
			$html = '
				<div id="home_alarm_one'.$i.'" class="home_alarm_one link"> [알림] '.$sql_fetch_array1["description"].' <span class="writetime">('.$sql_fetch_array1["writetime"].')</span></div>
				<script>
					$("#home_alarm_one'.$i.'").click(function(){
						window.open("group_join_admit_detail.php?count_group='.$sql_fetch_array1["count"].'&user_num_admit='.$sql_fetch_array1["count2"].'", "home_alarm_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
					});
				</script>
			';
		} else if($sql_fetch_array1["table_name"]=="sale_trader_admit"){//거래 신청이 왔을때
			$html = '
				<div id="home_alarm_one'.$i.'" class="home_alarm_one link"> [알림] '.$sql_fetch_array1["description"].' <span class="writetime">('.$sql_fetch_array1["writetime"].')</span></div>
				<script>
					$("#home_alarm_one'.$i.'").click(function(){
						window.open("sale_trader_admit_detail.php?count='.$sql_fetch_array1["count"].'&count2='.$sql_fetch_array1["count2"].'", "home_alarm_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
					});
				</script>
			';
		} else {
			$html = '';
		}
		$output .= $html;
	}
	if($count1==0){
		$output .= '<div class="home_alarm_one"> &nbsp;새로운 소식이 없습니다.</div><script>var home_alarm_none=1;</script>';
	} else if($count1 != 0){
		$output .= '<script>var home_alarm_none=0;</script>';
	}
	echo $output;
	
?>