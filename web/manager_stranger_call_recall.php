<?php
	if(isset($_REQUEST["start_count"])){
		$start_count = $_REQUEST["start_count"];
		$start_count_url = 'start_count='.$start_count;
	} else {
		$start_count = 0;
		$start_count_url = '';
	}
	$status_num = $status;
	$output = '';
	if($status=="4"){
		$sql4 = "SELECT * FROM $table_name";
	} else if($status!="4"){
		$sql4 = "SELECT * FROM $table_name WHERE status='$status'";
	}
	$sql_query4 = mysqli_query($conn, $sql4);
	$count4 = mysqli_num_rows($sql_query4);//list에 count된 총 갯수
	if($count4 != 0){
		include 'list_recall.php';
		if($start_count != 0){
			$sql1 = $sql4." ORDER BY writetime DESC LIMIT $start_number, 1";//쓴 글 검색
		} else if($start_count==0){
			$sql1 = $sql4." ORDER BY writetime DESC LIMIT $start_number, $number";//쓴 글 검색
		}
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
	}
	if($start_count != 0){//세부목록 보기일때
	} else if($start_count==0){//세부목록 보기가 아닐때
		$output .= '<div id="list_box">';
		if($count4 != 0 || $status != 4){//글이 있거나 전체보기가 아닐경우
			$output .= '
				<div id="list_head">
					<div id="writing_list_A">작성일</div>
					<div id="writing_list_title_mine">신고 정보</div>
					<div id="writing_list_C_mine">종류</div>
					<div id="writing_list_B_mine">
						<span class="mouseover">▼ 상태</span>
						<div id="list_status_set">
							<div id="list_status_set_4">&nbsp;<input type="radio" name="status" value="4"/> 전체보기</div>
							<div id="list_status_set_1">&nbsp;<input type="radio" name="status" value="1"/> 접수중</div>
							<div id="list_status_set_2">&nbsp;<input type="radio" name="status" value="2"/> 문제없음</div>
							<div id="list_status_set_3">&nbsp;<input type="radio" name="status" value="3"/> 삭제처리</div>
							<div id="apply_button" class="button_green2">적용</div>
						</div>
					</div>
				</div>
				<script>
					$("#apply_button").click(function(){
						var status=$("input:radio[name=status]:checked").val();
						location.href = "'.$url.'list_count=1'.$number_url.$keyword_url.$category_url.'&status="+status;
					});
					$("#writing_list_B_mine").hover(function(){//공개여부 영역의 글씨 색깔을 바꿈
						$("#list_status_set").css("display", "block");
					}, function(){
						$("#list_status_set").css("display", "none");
					});
				</script>
			';
			if($status==4){//전체 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(0)").attr("checked", true);</script>
				';
			} else if($status==1){//접수중 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(1)").attr("checked", true);</script>
				';
			} else if($status==2){//문제없음 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(2)").attr("checked", true);</script>
				';
			} else if($status==3){//삭제처리 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(3)").attr("checked", true);</script>
				';
			}
		}
		if($count4 != 0){//글이 있을때
		} else if($count4==0){//글이 없을때
			if($keyword=="thereisnokeyword"){
				$output .= '
					<div id="empty_list">작성된 글이 없습니다</div>
				';
			} else if($keyword!="thereisnokeyword"){
				$output .= '
					<div id="empty_list">검색된 글이 없습니다</div>
				';
			}
		}
	}
	if($count4 != 0){//결과물이 있을경우
		for($i=0; $i<$count1; $i++){//개별 결과 출력
			$html = '';
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			if($sql_fetch_array1["status"]==1){
				$status="접수중";
			} else if($sql_fetch_array1["status"]==2){
				$status="문제없음";
			} else if($sql_fetch_array1["status"]==3){
				$status="삭제처리";
			}
			if($sql_fetch_array1["count_upperwrite"]==0){
				$reply_or_not = "본문";
			} else if($sql_fetch_array1["count_upperwrite"] != 0){
				$reply_or_not = "댓글";
				
			}
			$list_count_link = $start_number + $i +1;//list_count 숫자 설정 (목록에서 링크 설정을 위한 setting)
			$list_page_count_link = (int) ( ($list_count_link-1) / $list_count_on_page)+1;
			$prev_list_page_count_link = (int) ( ($list_count_link-1-1) / $list_count_on_page )+1;//전 페이지의 list_page_count
			$next_list_page_count_link = (int) ( ($list_count_link-1+1) / $list_count_on_page )+1;//다음 페이지의 list_page_count
			$content = $sql_fetch_array1["content"];
			$content = convert_to_tag($content);
			$sql5 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[caller_num]";//신고자
			$sql_query5 = mysqli_query($conn, $sql5);
			$sql_fetch_array5 = mysqli_fetch_array($sql_query5);
			$sql6 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[stranger_num]";//신고 받은 사람
			$sql_query6 = mysqli_query($conn, $sql6);
			$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
			$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array1[caller_num]";//idcard의 사진을 띄운다
			$sql_query17 = mysqli_query($conn, $sql17);
			$count17 = mysqli_num_rows($sql_query17);
			if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $caller_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
			else{$caller_photo_path = "../image/blank_face.jpg";}
			$sql18 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array1[stranger_num]";//idcard의 사진을 띄운다
			$sql_query18 = mysqli_query($conn, $sql18);
			$count18 = mysqli_num_rows($sql_query18);
			if($count18){$sql_fetch_array18 = mysqli_fetch_array($sql_query18); $stranger_photo_path = $sql_fetch_array18["idcard_photo_path"];}
			else{$stranger_photo_path = "../image/blank_face.jpg";}
			if($start_count != 0){//세부목록으로 들어갈 경우
				if($sql_fetch_array1["count_upperwrite"]==0){//본문일 때
					$content_reply = "";
				} else if($sql_fetch_array1["count_upperwrite"] != 0){//댓글일 때
					$sql19 = "SELECT * FROM ".$sql_fetch_array1["table_name"]."_reply WHERE count=$sql_fetch_array1[count] AND count_upperwrite=$sql_fetch_array1[count_upperwrite]";
					$sql_query19 = mysqli_query($conn, $sql19);
					$count19 = mysqli_num_rows($sql_query19);
					if($count19){$sql_fetch_array19 = mysqli_fetch_array($sql_query19); $content_reply = "<hr/><div style='font-size:10pt; font-weight:bold;'>댓글 내용</div><div>".convert_to_tag($sql_fetch_array19["content"])."</div>";}
					else {$content_reply = "<hr/><div style='font-size:10pt; font-weight:bold;'>댓글 내용</div><div style='color:red;'>댓글이 존재하지 않습니다</div>";}
				}
				$html .= '
					<div id="form_area">
					<div id="info_area">
						<div id="info_area_status">처리상황 : 
							<div id="write_content_status" class="inline">'.$status.'</div>
							<div id="info_area_time">('.$sql_fetch_array1["writetime"].')</div>
						</div>
					</div>
					<div id="main_writing">
					<div id="mywrite_titlearea">
						<span style="font-weight:bold;" class="inline">신고 정보 : </span>
						<article id="mywrite_title" class="inline bold" style="top:0px;">'.$sql_fetch_array1["table_name"].' ('.$reply_or_not.') - '.$sql_fetch_array1["count"].' (피고: <span id="defendant"><span class="pointer">'.$sql_fetch_array6["user_name"].'</span><div class="user_info" style="top:13px;"><img class="user_photo pointer" src="'.$stranger_photo_path.'" width="85"/><div class="user_info_detail"><div class="select_padding pointer" onclick="user_info_see('.$sql_fetch_array6["user_num"].')">사용자 정보</div></div><div class="select_padding send_msg pointer" onclick="send_message('.$user_num.', '.$sql_fetch_array6["user_num"].')">쪽지 보내기</div></div></span>, 신고자: <span id="plaintiff"><span class="pointer">'.$sql_fetch_array5["user_name"].'</span><div class="user_info" style="top:13px;"><img class="user_photo pointer" src="'.$caller_photo_path.'" width="85" height="85"/><div class="user_info_detail"><div class="select_padding pointer" onclick="user_info_see('.$sql_fetch_array5["user_num"].')">사용자 정보</div></div><div class="select_padding send_msg pointer" onclick="send_message('.$user_num.', '.$sql_fetch_array5["user_num"].')">쪽지 보내기</div></div></span>)</article>
						<input type="text" id="mywrite_title_modify" name="mywrite_title" class="inline" value="" maxlength="100" style="width:650px;"/>
					</div>
					<div class="link_block"></div>
					<div id="mywrite_bodyarea">
						<div id="mywrite_body"><!--내글쓰기-->
							<article id="mywrite_content_read">'.$content.$content_reply.'</article>
						</div>
						<div id="mywrite_func">
				';
				if($sql_fetch_array1["status"]!=3){
					$html .= '
								<div id="stranger_call_see" class="mouseover">보러가기</div>
								<div id="stranger_call_1" class="mouseover">접수중</div>
								<div id="stranger_call_2" class="mouseover">문제없음</div>
								<div id="stranger_call_3" class="mouseover">삭제처리</div>
					';
				}
				$html .= '
						</div>
					</div>
					</div>
					</div>
					<script>
						$("#mywrite_title .user_photo").click(function(){//사진을 클릭할 경우
							if('.$user_num.'==0){
								alert("로그인 후 이용해주세요");
							} else {
								var photo_path = $(this).attr("src");
								window.open("photo_recall_one.php?photo_path="+photo_path+"&table_name=idcard_photo", "photo_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
							}
						});
						$("#defendant, #plaintiff").bind({
							mouseenter: function () {
								$(this).find(".user_info").css("display", "block");
							},
							mouseleave: function () {
								$(this).find(".user_info").css("display", "none");
							}
						});
				';
				if($sql_fetch_array1["count_upperwrite"]==0){
					$html .= '
						$("#stranger_call_see").click(function(){//보러가기를 눌렀을때
							$.ajax({
								url:"stranger_call_disposal.php",
								data: {type:"see", table_name:"'.$sql_fetch_array1["table_name"].'", count:"'.$sql_fetch_array1["count"].'"},
								success: function(getdata){
									$("body").append(getdata);
								}
							});
						});
					';
				} else if($sql_fetch_array1["count_upperwrite"] != 0){
					$html .= '
						$("#stranger_call_see").click(function(){//보러가기를 눌렀을때
							$.ajax({
								url:"stranger_call_disposal_reply.php",
								data: {type:"see", table_name:"'.$sql_fetch_array1["table_name"].'", count:"'.$sql_fetch_array1["count"].'", count_upperwrite:"'.$sql_fetch_array1["count_upperwrite"].'"},
								success: function(getdata){
									$("body").append(getdata);
								}
							});
						});
					';
				}
				if($sql_fetch_array1["count_upperwrite"]==0){
				$html .= '
						$("#stranger_call_1").click(function(){//접수중을 눌렀을때
							$.ajax({
								url:"stranger_call_disposal.php",
								data: {type:"dispose", caller_num:'.$sql_fetch_array1["caller_num"].', table_name:"'.$sql_fetch_array1["table_name"].'", count:"'.$sql_fetch_array1["count"].'", status:"1"},
								success: function(getdata){
									alert("접수중으로 선택 되었습니다");
									location.reload();
								}
							});
						});
						$("#stranger_call_2").click(function(){//문제없음를 눌렀을때
							$.ajax({
								url:"stranger_call_disposal.php",
								data: {type:"dispose", caller_num:'.$sql_fetch_array1["caller_num"].', table_name:"'.$sql_fetch_array1["table_name"].'", count:"'.$sql_fetch_array1["count"].'", status:"2"},
								success: function(getdata){
									alert("문제없음으로 선택 되었습니다");
									location.reload();
								}
							});
						});
						$("#stranger_call_3").click(function(){//삭제처리을 눌렀을때
							var reply = confirm("해당 게시물이 삭제됩니다. 삭제처리 하시겠습니까?");
							if(reply==true){
								$.ajax({
									url:"delete_write.php",
									data: {table_name:"'.$sql_fetch_array1["table_name"].'", count:"'.$sql_fetch_array1["count"].'"},
									success: function(getdata){
									}
								});
								$.ajax({
									url:"stranger_call_disposal.php",
									data: {type:"dispose", caller_num:'.$sql_fetch_array1["caller_num"].', table_name:"'.$sql_fetch_array1["table_name"].'", count:"'.$sql_fetch_array1["count"].'", status:"3"},
									success: function(getdata){
										alert("해당 게시물이 삭제처리 되었습니다");
										location.reload();
									}
								});
							}
						});
				';
				} else if($sql_fetch_array1["count_upperwrite"] != 0){
				$html .= '
						$("#stranger_call_1").click(function(){//접수중을 눌렀을때
							$.ajax({
								url:"stranger_call_disposal_reply.php",
								data: {type:"dispose", caller_num:'.$sql_fetch_array1["caller_num"].', table_name:"'.$sql_fetch_array1["table_name"].'", count:"'.$sql_fetch_array1["count"].'", count_upperwrite:"'.$sql_fetch_array1["count_upperwrite"].'", status:"1"},
								success: function(getdata){
									alert("접수중으로 선택 되었습니다");
									location.reload();
								}
							});
						});
						$("#stranger_call_2").click(function(){//문제없음을 눌렀을때
							$.ajax({
								url:"stranger_call_disposal_reply.php",
								data: {type:"dispose", caller_num:'.$sql_fetch_array1["caller_num"].', table_name:"'.$sql_fetch_array1["table_name"].'", count:"'.$sql_fetch_array1["count"].'", count_upperwrite:"'.$sql_fetch_array1["count_upperwrite"].'", status:"2"},
								success: function(getdata){
									alert("문제없음으로 선택 되었습니다");
									location.reload();
								}
							});
						});
						$("#stranger_call_3").click(function(){//삭제처리을 눌렀을때
							var reply = confirm("해당 댓글이 삭제됩니다. 삭제처리 하시겠습니까?");
							if(reply==true){
								var table_name_reply = "'.$sql_fetch_array1["table_name"].'"+"_reply";
								var count = '.$sql_fetch_array1["count"].';
								var count_upperwrite = '.$sql_fetch_array1["count_upperwrite"].';
								$.ajax({
									url:"php_reply_delete.php",
									data: {table_name_reply:table_name_reply, count_upperwrite:count_upperwrite, count:count},
									success: function(getdata){
									}
								});
								$.ajax({
									url:"stranger_call_disposal_reply.php",
									data: {type:"dispose", caller_num:'.$sql_fetch_array1["caller_num"].', table_name:"'.$sql_fetch_array1["table_name"].'", count:"'.$sql_fetch_array1["count"].'", count_upperwrite:"'.$sql_fetch_array1["count_upperwrite"].'", status:"3"},
									success: function(getdata){
										alert("해당 댓글이 삭제처리 되었습니다");
										location.reload();
									}
								});
							}
						});
				';
				}
				$html .= '
					</script>
				';
			} else if($start_count==0){//세부 목록이 아닐 경우
				$writetime = substr($sql_fetch_array1["writetime"], 0, 10);
				$html .= '
					<div id="writing_area_article'.$i.'" class="writing_area_article">
						<div class="writing_A">'.$writetime.'</div>
						<a href="'.$url.'start_count='.$list_count_link.'&list_count='.$list_count_link.$number_url.$keyword_url.$category_url.$status_url.'"><div class="writing_title_mine">'.$sql_fetch_array1["table_name"].' - '.$sql_fetch_array1["count"].' (피고: '.$sql_fetch_array6["user_name"].', 신고자: '.$sql_fetch_array5["user_name"].')</div></a>
						<div class="writing_C_mine">'.$reply_or_not.'</div>
						<div class="writing_B_mine">'.$status.'</div>
					</div>
					<script>
						var height = $("#writing_area_article'.$i.' .writing_title_mine").height();
						$("#writing_area_article'.$i.'").height(height+10);
						$("#writing_area_article'.$i.' .writing_A").height(height);
						$("#writing_area_article'.$i.' .writing_C_mine").height(height);
						$("#writing_area_article'.$i.' .writing_B_mine").height(height);
					</script>
				';
			}
			$output .= $html;
		}
	}
	if($start_count==0){$output .= '</div>';} // list_box div의 끝
	echo $html_list . $output . $html_list;//결과물과 list를 함께 출력
	if(is_int($list_count / $number)){//리스트 갯수가 나누어 떨어지면
		$list_go_back_list_count = (int) ($list_count / $number);//리스트 갯수
	} else if(!is_int($list_count / $number)){//리스트 갯수가 나누어 떨어지지 않으면
		$list_go_back_list_count = (int) ($list_count / $number) + 1;//리스트 갯수
	}
	$list_count_prev = $list_count - 1;
	$list_count_next = $list_count + 1;
	$output = '';
	$extra_post = '';
	$list_show = '.list_show:eq(0)'; // .list_show   .list_show:eq(0)
	$output .= '<script>';
	if($start_count != 0){//세부 목록 내용에서
		$output .= 'count_link='.$start_count.';'; // list.php에서 list_number_set을 가리기 위함
		$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_go_back_list_count.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="list_go_back"></div></a>\');'; // 목록 버튼
		if($list_count != 1){//list_count가 처음이 아닐 경우 (이전 버튼)
			$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'start_count='.$list_count_prev.'&list_count='.$list_count_prev.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_prev_list"></div></a>\');';
		}
		if($list_count != $total_list_count){//list_count가 끝이 아닐 경우 (다음 버튼)
			$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'start_count='.$list_count_next.'&list_count='.$list_count_next.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_next_list"></div></a>\');';
		}
	} else if($start_count==0){// 세부 목록이 아닐때
		if($list_count != 1){//list_count가 처음이 아닐 경우 (이전 버튼)
			$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_count_prev.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_prev_list"></div></a>\');';
		}
		if($list_count != $total_list_count){//list_count가 끝이 아닐 경우 (다음 버튼)
			$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_count_next.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_next_list"></div></a>\');';
		}
	}
	$output .= '</script>';
	echo $output;
?>