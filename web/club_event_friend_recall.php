<?php
	if($category=="all_content"){
		$search_field = "title,content";
	} else if($category=="writer"){
		$search_field=="user_name";
	} else if($category=="title"){
		$search_field = "title";
	} else if($category=="content"){
		$search_field = "content";
	}
	$status_num = $status;
	$output = '';
	include 'club_event_friend_recall_process.php';
	if($count_link != 0){//세부목록 보기일때
	} else if($count_link==0){//세부목록 보기가 아닐때
		$output .= '<div id="list_box">';
		if($count4 != 0 || $status != 4){//글이 있거나 전체보기가 아닐경우
			$output .= '
				<div id="list_head">
					<div id="club_list_date">기&nbsp;&nbsp;간</div>
					<div id="columnA2">이&nbsp;&nbsp;&nbsp;&nbsp;벤&nbsp;&nbsp;&nbsp;&nbsp;트</div>
					<div id="columnA3">작 성 자</div>
					<div id="club_list_status">
						<span class="mouseover">▼ 종류</span>
						<div id="list_status_set">
							<div id="list_status_set_4">&nbsp;<input type="radio" name="status" value="4"/> 전체보기</div>
							<div id="list_status_set_1">&nbsp;<input type="radio" name="status" value="1"/> 행사</div>
							<div id="list_status_set_2">&nbsp;<input type="radio" name="status" value="2"/> 개인</div>
							<div id="list_status_set_3">&nbsp;<input type="radio" name="status" value="3"/> 봉사</div>
							<div id="apply_button" class="button_green2">적용</div>
						</div>
					</div>
				</div>
				<script>
					$("#apply_button").click(function(){
						var status=$("input:radio[name=status]:checked").val();
						location.href = "'.$url.'list_count=1'.$number_url.$keyword_url.$category_url.'&status="+status;
					});
					$("#club_list_status").hover(function(){//공개여부 영역의 글씨 색깔을 바꿈
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
			} else if($status==1){//행사 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(1)").attr("checked", true);</script>
				';
			} else if($status==2){//개인 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(2)").attr("checked", true);</script>
				';
			} else if($status==3){//봉사 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(3)").attr("checked", true);</script>
				';
			}
		}
		if($count4 != 0){
			$output .= '<script>$("#list_number, #list_search").css("display", "block");</script>';
		} else if($count4==0){//결과물이 없을때
			if($keyword=="thereisnokeyword"){
				$output .= '<div class="empty_list">등록된 이벤트가 없습니다</div>';
			} else if($keyword!="thereisnokeyword"){//키워드가 있을 경우
				$output .= '<div class="empty_list">검색된 이벤트가 없습니다</div>';
			}
		}
	}
	if($count4 != 0){//결과물이 있을경우
		for($i=0; $i<$count1; $i++){//검색결과 출력
			$html = '';
			if(($keyword == "thereisnokeyword" && $category == "thereisnocategory") || ($keyword != "thereisnokeyword" && $category=="writer")){//keyword 검색을 하지 않았을 때
				$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
				$sql11 = "SELECT * FROM $table_name WHERE count = $arr10[$i]";
				$sql_query11 = mysqli_query($conn, $sql11);
				$sql_fetch_array1 = mysqli_fetch_array($sql_query11);
			}
			if($sql_fetch_array1["status"]=="1"){
				$status="행사";
			} else if($sql_fetch_array1["status"]=="2"){
				$status="개인";
			} else if($sql_fetch_array1["status"]=="3"){
				$status="봉사";
			}
			$list_count_link = $start_number + $i +1;//list_count 숫자 설정 (목록에서 링크 설정을 위한 setting)
			$list_page_count_link = (int) ( ($list_count_link-1) / $list_count_on_page) +1;
			$prev_list_page_count_link = (int) ( ($list_count_link-1-1) / $list_count_on_page ) + 1;//전 페이지의 list_page_count
			$next_list_page_count_link = (int) ( ($list_count_link-1+1) / $list_count_on_page ) + 1;//다음 페이지의 list_page_count
			$sql5 = "SELECT * FROM $table_name_reply WHERE count_upperwrite = $sql_fetch_array1[count]";//댓글 검색
			$sql_query5 = mysqli_query($conn, $sql5);
			$count5 = mysqli_num_rows($sql_query5);
			$sql6 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num]";//작성자를 확인하기 위함
			$sql_query6 = mysqli_query($conn, $sql6);
			$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
			$start_time = '';
			if($sql_fetch_array1["start_time_y"]){//시작 년이 있을때
				$start_time .= $sql_fetch_array1["start_time_y"].'년 ';
				if($sql_fetch_array1["start_time_m"]){//시작 월이 있을때
					$start_time .= $sql_fetch_array1["start_time_m"].'월 ';
					if($sql_fetch_array1["start_time_d"]){//시작 일이 있을때
						$start_time .= $sql_fetch_array1["start_time_d"].'일';
					}
				}
			}
			$end_time = '';
			if($sql_fetch_array1["end_time_y"]){//종료 년이 있을때
				$end_time .= $sql_fetch_array1["end_time_y"].'년 ';
				if($sql_fetch_array1["end_time_m"]){//종료 월이 있을때
					$end_time .= $sql_fetch_array1["end_time_m"].'월 ';
					if($sql_fetch_array1["end_time_d"]){//종료 일이 있을때
						$end_time .= $sql_fetch_array1["end_time_d"].'일';
					}
				}
			}
			$title = $sql_fetch_array1["title"];
			$content = $sql_fetch_array1["content"];
			if($keyword != "thereisnokeyword"){//키워드 검색했을경우
				$title = search_highlight($keyword, $title);
				$content = search_highlight($keyword, $content);
			}
			if($count_link != 0){//세부목록으로 들어갈 경우
				read_doc($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["read_count"]);
				$time_period = '';
				if($start_time){//시작시간이 있을때
					$time_period .= $start_time;
				} else if(!$start_time){
					$time_period .= '시작일';
				}
				$time_period .= ' ~ ';
				if($end_time){//종료시간이 있을때
					$time_period .= $end_time;
				} else if(!$end_time){
					$time_period .= '종료일';
				}
				$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array6[user_num]";//idcard의 사진을 띄운다
				$sql_query17 = mysqli_query($conn, $sql17);
				$count17 = mysqli_num_rows($sql_query17);
				if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
				else{$user_photo_path = "../image/blank_face.png";}
				$link_addr = 'http://www.idmaru.com/web/event_all.php?count_link='.$sql_fetch_array1["count"];
				$html .= '
					<div id="form_area">
					<div id="info_area">
						<div id="info_area_status">이벤트 종류 : <div id="write_content_status" class="inline">'.$status.'</div></div>
						<div id="info_area_time">이벤트 기간 : '.$time_period.'</div>
						<div id="info_area_read_count">조회수: '.$sql_fetch_array1["read_count"].'</div>
						<div id="info_area_writer_event">작성자 : '.$sql_fetch_array6["user_name"].'
							<div class="user_info" style="top:25px; left:0px;"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding send_msg pointer">쪽지 보내기</div></div>
						</div>
					</div>
					<div id="main_writing">
					<div id="mywrite_titlearea">
						<article id="mywrite_title" class="inline" style="top:0px;">'.$title.'</article>
						'.updown_status($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["user_num"], $sql_fetch_array1["up_total"], -1).'
					</div>
					'.link_block($link_addr).'
					<div id="mywrite_bodyarea">
						<div id="mywrite_body"><!--내글쓰기-->
							<article id="mywrite_content_read">'.$content.'</article>
						</div>
						<div id="mywrite_func">
							<div id="see_reply_'.$sql_fetch_array1["count"].'" class="see_reply_status" onclick="see_reply('.$sql_fetch_array1["count"].')">▼ 댓글 '.$count5.' </div>
							'.other_link_area($link_addr, $title, $content).'
						</div>
					</div>
					</div>
					</div>
					<div id="textarea_copy"></div>
					<div id="mywrite_reply" class="mywrite_body">
						<textarea id="mywrite_reply_text" name="mywrite_reply_content" maxlength="1000"></textarea>
						<div class="mywrite_cont">
							<div id="mywrite_reply_enter" class="mouseover" onclick="write_reply_submit('.$sql_fetch_array1["count"].')"><img src="../image/button_enter.png"/></div>
						</div>
					</div>
					<script>
						info_area_functions('.$sql_fetch_array1["user_num"].');
						mywrite_link_click();
						content_img_click('.$sql_fetch_array1["count"].');
						reply_keyup();
					</script>
				';
			} else if($count_link==0){//세부 목록이 아닐 경우
				$up_total = $sql_fetch_array1["up_total"];
				if($up_total==0){
					$updown_total_string = '<span style="color:#909395; font-weight:normal;">(+'.$up_total.')</span>';
				} else if( $up_total > 0){
					$updown_total_string = '<span style="color:#FF0000; font-weight:normal;">(+'.$up_total.')</span>';
				}
				$html .= '
					<div id="club_area_article'.$sql_fetch_array1["count"].'" class="relative">
						<div class="club_date_event">
				';
				if($start_time){//시작시간이 있을때
					$html .= $start_time;
				} else if(!$start_time){
					$html .= '시작일';
				}
				$html .= '<br/>~ ';
				if($end_time){//종료시간이 있을때
					$html .= $end_time;
				} else if(!$end_time){
					$html .= '종료일';
				}
				$html .= '</div>
						<a href="'.$url.'count_link='.$sql_fetch_array1["count"].'&list_count='.$list_count_link.$number_url.$keyword_url.$category_url.$status_url.'"><div class="columnA2">'.$title.' &nbsp;<span style="color:#3C847F; font-weight:normal;">('.$count5.')</span>&nbsp;'.$updown_total_string.'</div></a>
						<div class="columnA3">'.$sql_fetch_array6["user_name"].'</div>
						<div class="club_status_event">'.$status.'</div>
					</div>
					<script>
						var height1 = $("#club_area_article'.$sql_fetch_array1["count"].' .club_title_event").height();
						var height2 = $("#club_area_article'.$sql_fetch_array1["count"].' .club_date_event").height();
						if(height1 >= height2){var height = height1;}
						else if(height1 < height2){var height = height2;}
						$("#club_area_article'.$sql_fetch_array1["count"].'").height(height+8);
						$("#club_area_article'.$sql_fetch_array1["count"].' .club_date_event").height(height);
						$("#club_area_article'.$sql_fetch_array1["count"].' .club_title_event").height(height);
						$("#club_area_article'.$sql_fetch_array1["count"].' .columnA3").height(height);
						$("#club_area_article'.$sql_fetch_array1["count"].' .club_status_event").height(height);
					</script>
				';
			}
			$output .= $html;
		}
	}
	if($count_link==0){$output .= '</div>';} // list_box div의 끝
	echo $html_list . $output . $html_list;//결과물과 list를 함께 출력
	include 'list_button.php';
?>