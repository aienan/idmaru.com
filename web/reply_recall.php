<?php
	include 'header.php';
	include 'declare_php.php';
	$table_name = $_REQUEST["table_name"];
	$count_upperwrite = $_REQUEST["count_upperwrite"];
	$keyword = $_REQUEST["keyword"];
	$table_name_reply = $table_name."_reply";
	if($table_name=="writing"){
		$table_name_reply_updown = $table_name_reply."_updown";
	}
	if(isset($_REQUEST["start_number"])){
		if($_REQUEST["start_number"]==-1){$start_number = 0;} // 댓글 번호를 지정하지 않으면 start_number가 -1로 날라온다
		else {$start_number = $_REQUEST["start_number"];}
	} else {$start_number = 0;}
	$reply_start_number_box = $start_number + 1;
	$display_number = 50;
	$start_number_next = $start_number + $display_number;
	$sql1 = "SELECT * FROM $table_name_reply WHERE count_upperwrite=$count_upperwrite LIMIT $start_number, $display_number";//댓글 검색
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($_REQUEST["start_number"] != -1 && $count1==0){echo 'x'; exit();} // 댓글 번호를 지정했는데 댓글이 없을경우
	$output = '';
	if($_REQUEST["start_number"]==-1){ // 제일 처음일때
	$output .= '
		<div id="reply_setting" class="relative" style="margin:3px 0 0 0; height:22px;">
			<input id="reply_start_num" class="absolute input_gray center" type="text" name="reply_start_num" value="'.$reply_start_number_box.'" maxlength="4" style="padding:2px; width:28px; right:2px; top:0px;" title="댓글시작번호"/>
		</div>
		<script>
			reply_exist = 1;
			reply_start_number_box = '.$reply_start_number_box.';
			$("#reply_start_num").blur(function(){
				var count_upperwrite = '.$count_upperwrite.';
				var keyword = "'.$keyword.'";
				var reply_start_num = $("#reply_start_num").val();
				var reply_start_numB = reply_start_num - 1;
				if(isNumber(reply_start_num)==false){
					alert("숫자만 입력 가능합니다");
					$("#reply_start_num").val(reply_start_number_box);
				} else if(reply_start_num==reply_start_number_box){
				} else if(reply_start_num < 1){
					alert("1 이상의 숫자만 가능합니다");
					$("#reply_start_num").val(reply_start_number_box);
				} else {
					$.ajax({
						url: "reply_recall.php",
						data: {table_name:table_name, count_upperwrite:count_upperwrite, keyword:keyword, start_number:reply_start_numB},
						success: function(getdata){
							if(getdata=="x"){
								alert(reply_start_num+" 이상의 댓글이 없습니다");
								$("#reply_start_num").val(reply_start_number_box);
							} else {
								$("#mywrite_replyarea").html(getdata);
								reply_start_number_box = reply_start_num;
							}
						}
					});
				}
			});
			enterAndBlur("#reply_start_num");
		</script>
	';
	}
	if($_REQUEST["start_number"]==-1){$output .= '<div id="mywrite_replyarea">';}
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$count_uniq = $sql_fetch_array1["count"];
		$sql2 = "SELECT * FROM user WHERE user_num = $sql_fetch_array1[user_num]";//글쓴이 정보 검색
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		if($table_name=="writing"){
			$sql3 = "SELECT * FROM $table_name_reply_updown WHERE count_upperwrite=$count_upperwrite AND count=$sql_fetch_array1[count] AND updown='up'";//updown이 up인 갯수 세기
			$sql_query3 = mysqli_query($conn, $sql3);
			$count3 = mysqli_num_rows($sql_query3);
			$sql4 = "SELECT * FROM $table_name_reply_updown WHERE count_upperwrite=$count_upperwrite AND count=$sql_fetch_array1[count] AND updown='down'";//updown이 down인 갯수 세기
			$sql_query4 = mysqli_query($conn, $sql4);
			$count4 = mysqli_num_rows($sql_query4);
		}
		$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array1[user_num]";//idcard의 사진을 띄운다
		$sql_query17 = mysqli_query($conn, $sql17);
		$count17 = mysqli_num_rows($sql_query17);
		if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
		else{$user_photo_path = "../image/blank_face.png";}
		if($keyword=="thereisnokeyword"){//검색을 하지 않았을경우
			$content = $sql_fetch_array1["content"];
		} else if($keyword != "thereisnokeyword"){//키워드 검색했을경우
			$content = search_highlight($keyword, $sql_fetch_array1["content"]);
		}
		$content = convert_to_tag($content);
		$html = '
		<div id="reply_count'.$count_uniq.'" class="replyarea_body">
			<div class="replyarea_info">
			<div id="replyarea_info_name_'.$count_uniq.'" class="replyarea_info_name">&nbsp;&nbsp;'.$sql_fetch_array2["user_name"].'&nbsp;&nbsp;
			<div class="user_info" style="top:22px; z-index:6;"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85" onclick="user_pic('.$user_num.', \''.$user_photo_path.'\')"/><div class="select_padding send_msg pointer" onclick="send_message('.$user_num.', '.$sql_fetch_array2["user_num"].')">쪽지 보내기</div></div>
			</div>
			<script>user_info_bind("#replyarea_info_name_'.$count_uniq.'");</script>
		';
		if($table_name=="writing"){//writing 테이블일때
			$html .= '
					<div class="replyarea_info_updown">
						<div class="write_reply_up mouseover" onclick="reply_updown('.$count_uniq.', '.$count_upperwrite.', '.$sql_fetch_array1["count"].', \'up\', '.$count3.')" title="좋아요"><div class="button_like"><img src="../image/button_like.png"/></div><div class="updown_like_num"> '.$count3.'</div></div>
						<div class="write_reply_down mouseover" onclick="reply_updown('.$count_uniq.', '.$count_upperwrite.', '.$sql_fetch_array1["count"].', \'down\', '.$count4.')" title="싫어요"><div class="button_dislike"><img src="../image/button_dislike.png"/></div><div class="updown_dislike_num"> '.$count4.'</div></div>
					</div>
			';
			if($sql_fetch_array1["user_num"] != $user_num){
				$html .= '
					<div class="stranger_call_reply" onclick="stranger_call_reply('.$sql_fetch_array1["user_num"].', \''.$table_name.'\', '.$sql_fetch_array1["count"].', '.$count_upperwrite.')" title="신고"><img src="../image/stranger_call.png"/></div>
				';
			}
		} else {
			if( ($sql_fetch_array1["user_num"]!=$user_num) && ($table_name!="club_group_writing") ){//댓글쓴 사람이 본인이 아니고, 모임글이 아닐 경우
				$html .= '
						<div class="stranger_call_reply" onclick="stranger_call_reply('.$sql_fetch_array1["user_num"].', \''.$table_name.'\', '.$sql_fetch_array1["count"].', '.$count_upperwrite.')" title="신고"><img src="../image/stranger_call.png"/></div>
				';
			}
		}
		$html .= '
					<div class="replyarea_info_writetime">'.$sql_fetch_array1["writetime"].'</div>
				</div>
				<article class="replyarea_content">'.$content.'</article>
		';
		if($sql_fetch_array1["user_num"]==$user_num){//댓글쓴 사람이 본인일 경우
			$html .= '
				<div class="replyarea_func">
					<div class="write_modify" onclick="reply_modify('.$count_uniq.', '.$count_upperwrite.', '.$sql_fetch_array1["count"].')">수정</div>
					<div class="write_delete" onclick="reply_delete('.$count_upperwrite.', '.$sql_fetch_array1["count"].')">삭제</div>
				</div>
			';
		}
		$html .= '</div>'; // replyarea_body 의 div 끝
		if($sql_fetch_array1["user_num"]==$user_num){//댓글쓴 사람이 본인일 경우
			$html .= '<script>myWrite($("#reply_count'.$count_uniq.' .replyarea_info"));</script>';
		} else if($sql_fetch_array1["user_num"]!=$user_num){//댓글쓴 사람이 본인이 아닐 경우
			$html .= '<script>othersWrite($("#reply_count'.$count_uniq.' .replyarea_info"));</script>';
		}
		$output .= $html;
	}
	if($count1==$display_number){
		$output .= '<div id="article_moreB" onclick="reply_more(\'#article_moreB\', '.$count_upperwrite.', '.$start_number_next.')">더 보 기</div>';
	}
	if($_REQUEST["start_number"]==-1){
		$output .= '</div>'; // mywrite_replyarea div의 끝
		$output .= '
			<div id="write_reply_'.$count_upperwrite.'" class="write_reply_confirm" onclick="write_reply('.$count_upperwrite.')"><img src="../image/list_pineB.png" style="position:relative; top:3px;"/> 댓글 쓰기</div>
			<div id="write_reply_cancel_'.$count_upperwrite.'" class="write_reply_confirm_cancel" onclick="write_reply_cancel('.$count_upperwrite.')">▲ 댓글 취소</div>
		';
	}
	echo $output;
?>