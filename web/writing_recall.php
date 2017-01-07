<?php
	if($category=="all_content"){
		$search_field = "title,content";
	} else if($category=="title"){
		$search_field = "title";
	} else if($category=="content"){
		$search_field = "content";
	}
	$status_num = $status;
	if($news_type=="all"){}
	else {$type = news_type_num($news_type);}
	$output = '';
	if($category != "thereisnocategory"){
		$output .= '<script>$("select[name=list_search_category]").val("'.$category.'");</script>';
	} else if($category=="thereisnocategory"){
		$output .= '<script>$("select[name=list_search_category]").val("all_content");</script>';
	}
	include 'writing_recall_detail.php';
	if($count_link != 0){//세부목록 보기일때
	} else if($count_link==0){//세부목록 보기가 아닐때
		$output .= '<div id="list_box">';
		if($count4 != 0 || $status != 4){//글이 있거나 전체보기가 아닐경우
			$output .= '
				<div id="list_head">
					<div id="writing_list_A">작성일</div>
					<div id="writing_list_title_mine">제&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;목</div>
					<div id="writing_list_C_mine">조회수</div>
					<div id="writing_list_B_mine">
						<span class="mouseover">▼ 공개</span>
						<div id="list_status_set">
							<div id="list_status_set_4" class="list_status_item">&nbsp;<input type="radio" name="status" value="4"/> 전체보기</div>
							<div id="list_status_set_1" class="list_status_item">&nbsp;<input type="radio" name="status" value="1"/> 모두</div>
							<div id="list_status_set_2" class="list_status_item">&nbsp;<input type="radio" name="status" value="2"/> 친구</div>
							<div id="list_status_set_3" class="list_status_item">&nbsp;<input type="radio" name="status" value="3"/> 비공개</div>
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
			} else if($status==1){//모두 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(1)").attr("checked", true);</script>
				';
			} else if($status==2){//친구 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(2)").attr("checked", true);</script>
				';
			} else if($status==3){//비공개 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(3)").attr("checked", true);</script>
				';
			}
		}
		if($count4 != 0){//글이 있을때
		} else if($count4==0){//글이 없을때
			if($keyword=="thereisnokeyword"){
				$output .= '
					<div class="empty_list">작성된 글이 없습니다</div>
				';
			} else if($keyword!="thereisnokeyword"){
				$output .= '<div class="empty_list">검색된 글이 없습니다</div>';
			}
		}
	}
	if($count4 != 0){//결과물이 있을경우
		for($i=0; $i<$count1; $i++){//개별 결과 출력
			$html = '';
			if(($keyword == "thereisnokeyword" && $category == "thereisnocategory") || ($keyword != "thereisnokeyword" && $category=="writer")){//keyword 검색을 하지 않았을 때
				$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
				$sql11 = "SELECT * FROM $table_name WHERE count = $arr10[$i]";
				$sql_query11 = mysqli_query($conn, $sql11);
				$sql_fetch_array1 = mysqli_fetch_array($sql_query11);
			}
			if($sql_fetch_array1["status"]==1){
				$status="모두";
			} else if($sql_fetch_array1["status"]==2){
				$status="친구";
			} else if($sql_fetch_array1["status"]==3){
				$status="비공개";
			}
			$list_count_link = $start_number + $i +1;//list_count 숫자 설정 (목록에서 링크 설정을 위한 setting)
			$list_page_count_link = (int) ( ($list_count_link-1) / $list_count_on_page) +1;
			$prev_list_page_count_link = (int) ( ($list_count_link-1-1) / $list_count_on_page ) + 1;//전 페이지의 list_page_count
			$next_list_page_count_link = (int) ( ($list_count_link-1+1) / $list_count_on_page ) + 1;//다음 페이지의 list_page_count
			$sql5 = "SELECT * FROM $table_name_reply WHERE count_upperwrite = $sql_fetch_array1[count]";//댓글 검색
			$sql_query5 = mysqli_query($conn, $sql5);
			$count5 = mysqli_num_rows($sql_query5);
			$title = $sql_fetch_array1["title"];
			$content = $sql_fetch_array1["content"];
			if($keyword != "thereisnokeyword"){//키워드 검색했을경우
				$title = search_highlight($keyword, $title);
				$content = search_highlight($keyword, $content);
			}
			if($count_link != 0){//세부목록으로 들어갈 경우
				$sql7 = "SELECT * FROM writing_updown WHERE count=$sql_fetch_array1[count] AND updown='up'";//글에 좋아요 표시한 갯수를 센다
				$sql_query7 = mysqli_query($conn, $sql7);
				$count7 = mysqli_num_rows($sql_query7);
				$sql8 = "SELECT * FROM writing_updown WHERE count=$sql_fetch_array1[count] AND updown='down'";//글에 싫어요 표시한 갯수를 센다
				$sql_query8 = mysqli_query($conn, $sql8);
				$count8 = mysqli_num_rows($sql_query8);
				$info_area_type = news_type_info_area($sql_fetch_array1["type"]);
				$link_addr = 'http://www.idmaru.com/web/news_all.php?count_link='.$sql_fetch_array1["count"];
				$html .= '
				<div id="form_area">
				<div id="info_area">
					<div id="write_content_status" class="inline">'.$status.'</div>
					<div class="inline" style="margin:0 5px;">/</div>
					<div id="info_area_type" class="inline">['.$info_area_type.']</div>
					<div id="info_area_time">('.$sql_fetch_array1["writetime"].')</div>
					<div id="info_area_read_count">조회수: '.$sql_fetch_array1["read_count"].'</div>
				</div>
				<div id="modify_status">
					<h6>뉴스분류 : <select id="news_type_mod" name="news_type_mod">'.$select_category_writing_mod.'</select></h6>
					<h6 class="inline">공개여부 : &nbsp;모두&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="all" tabindex=""/><h6 class="inline basicmargin">&nbsp;&nbsp;친구&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="friend" tabindex=""/><h6 class="inline basicmargin">&nbsp;&nbsp;비공개&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="private" tabindex=""/>
					'.$add_photo_block.'
				</div>
				<div id="main_writing">
					<div id="mywrite_titlearea">
						<article id="mywrite_title" class="inline" style="top:0px;">'.$title.'  </article>
						'.updown_status($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["user_num"], $count7, $count8).'
						<input type="text" id="mywrite_title_modify" name="mywrite_title" class="inline" value="" maxlength="100" style="width:700px;"/>
					</div>
					'.link_block($link_addr).'
					<div id="mywrite_bodyarea">
						<div id="mywrite_body"><!--내글쓰기-->
							<article id="mywrite_content_read">'.$content.'</article>
						</div>
						<div id="mywrite_func">
							<div id="see_reply_'.$sql_fetch_array1["count"].'" class="see_reply_status" onclick="see_reply('.$sql_fetch_array1["count"].')">▼ 댓글 '.$count5.' </div>
				';
			$html .= '
							<div id="write_modify_'.$sql_fetch_array1["count"].'" class="write_modify" onclick="write_modify_writing('.$sql_fetch_array1["count"].', '.$sql_fetch_array1["type"].')">수정</div>
							<div id="write_delete_'.$sql_fetch_array1["count"].'" class="write_delete" onclick="write_delete(\''.$table_name.'\', '.$sql_fetch_array1["count"].')">삭제</div>
							'.other_link_area($link_addr, $title, $content).'
						</div>
					</div>
				</div>
					</div>
					<div id="textarea_copy"></div>
					<div id="mywrite_modify">
						<div id="mywrite_modify_body" style="width:725px; padding:0;"><!--수정용 textarea-->
							<textarea id="mywrite_modify_text" name="mywrite_modify_content"></textarea>
						</div>
						<div id="mywrite_modify_bottom" class="write_bottom">
							<div id="mywrite_modify_confirm" onclick="mywrite_modify_confirm()">수정완료</div>
							<div id="mywrite_modify_cancel" onclick="mywrite_modify_cancel()">취소</div>
						</div>
					</div>
					<div id="mywrite_reply" class="mywrite_body">
						<textarea id="mywrite_reply_text" name="mywrite_reply_content"></textarea>
						<div class="mywrite_cont">
							<div id="mywrite_reply_letterleft"></div>
							<div id="mywrite_reply_enter" class="mouseover" onclick="write_reply_submit_index('.$sql_fetch_array1["count"].', '.$sql_fetch_array1["status"].')"><img src="../image/button_enter.png"/></div>
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
				$updown_total = $sql_fetch_array1["updown_total"];
				if($updown_total==0){
					$updown_total_string = '<span style="color:#909395; font-weight:normal;">(+'.$updown_total.')</span>';
				} else if( $updown_total > 0){
					$updown_total_string = '<span style="color:#FF0000; font-weight:normal;">(+'.$updown_total.')</span>';
				} else if($updown_total < 0){
					$updown_total_string = '<span style="color:#0000FF; font-weight:normal;">('.$updown_total.')</span>';
				}
				$writetime = substr($sql_fetch_array1["writetime"], 0, 10);
				$html .= '
					<div id="writing_area_article'.$sql_fetch_array1["count"].'" class="writing_area_article">
						<div class="writing_A">'.$writetime.'</div>
						<a href="'.$url.'count_link='.$sql_fetch_array1["count"].'&list_count='.$list_count_link.$number_url.$keyword_url.$category_url.$status_url.'&news_type='.$news_type.'"><div class="writing_title_mine">'.$title.' &nbsp;<span style="color:#3C847F; font-weight:normal;">('.$count5.')</span>&nbsp;'.$updown_total_string.'</div></a>
						<div class="writing_C_mine">'.$sql_fetch_array1["read_count"].'</div>
						<div class="writing_B_mine">'.$status.'</div>
					</div>
					<script>
						var height = $("#writing_area_article'.$sql_fetch_array1["count"].' .writing_title_mine").height();
						$("#writing_area_article'.$sql_fetch_array1["count"].'").height(height+10);
						$("#writing_area_article'.$sql_fetch_array1["count"].' .writing_A").height(height);
						$("#writing_area_article'.$sql_fetch_array1["count"].' .writing_C_mine").height(height);
						$("#writing_area_article'.$sql_fetch_array1["count"].' .writing_B_mine").height(height);
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