<?php
	if($category=="all_content"){
		$search_field = "title,content";
	} else if($category=="title"){
		$search_field = "title";
	} else if($category=="content"){
		$search_field = "content";
	}
	$status = 0;
	$status_num = $status;
	$output1 = '';
	$output = '';
	if($category != "thereisnocategory"){
		$output .= '<script>$("select[name=list_search_category]").val("'.$category.'");</script>';
	} else if($category=="thereisnocategory"){
		$output .= '<script>$("select[name=list_search_category]").val("all_content");</script>';
	}
	$sql = "SELECT * FROM club_group_member WHERE count_group = $count_group AND user_num = $user_num";//회원 여부 확인
	$sql_query = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($sql_query);
	if($count==1){//회원일 경우
		$sql5 = "SELECT * FROM club_group WHERE count_group = $count_group";//모임 정보 보기
		$sql_query5 = mysqli_query($conn, $sql5);
		$sql_fetch_array5 = mysqli_fetch_array($sql_query5);
		$sql6 = "SELECT * FROM user WHERE user_num=$sql_fetch_array5[user_num]";//모임장 웹이름 알아내기
		$sql_query6 = mysqli_query($conn, $sql6);
		$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
		$group_name=$sql_fetch_array5["group_name"];
		$output1 .= '
			<div id="club_group_info">
				<div id="club_group_name">'.$group_name.'</div>
				<div id="club_group_desc"><div id="club_group_desc_master" class="relative"><span class="club_group_desc1">모임장</span><span class="club_group_desc2">:</span><span class="club_group_desc3">'.$sql_fetch_array6["user_name"].'</span>';
		if($sql_fetch_array6["user_stop"]=='1'){
			$output1 .= '<span style="margin:0 0 0 20px; color:#F98600;">(모임장이 이드마루에서 탈퇴하였습니다.)</span>';
		} else if($sql_fetch_array6["user_stop"]=='2'){
			$output1 .= '<span style="margin:0 0 0 20px; color:#F98600;">(모임장의 이드마루 이용이 정지되었습니다.)</span>';
		}
		$output1 .= '</div><div id="club_group_desc_ex" class="relative"><span class="club_group_desc1">모임 설명</span><span class="club_group_desc2">:</span><span class="club_group_desc3 word_form">'.convert_to_tag($sql_fetch_array5["description"]).'</span></div></div></div>';
		$output .= '<script>$("#club_group_desc").height($("#club_group_desc_master").height() + $("#club_group_desc_ex > .club_group_desc3").height() ); </script>';
		if($sql_fetch_array5["user_num"]==$user_num){//모임장일 경우
			$output1 .= '
			<div style="position:relative; height:30px;">
				<div id="club_group_modify" class="button_gb">모임정보수정</div>
				<div id="club_group_admin" class="button_gb">회원관리</div>
			</div>
			';
		}
		if($sql_fetch_array5["user_num"] != $user_num){//모임장이 아닐 경우
			$output1 .= '
			<div style="position:relative; height:30px;">
				<div id="club_group_see" class="button_gb">모임정보</div>
			</div>
			<script>
				var status_position = "member";
				$("#club_group_see").click(function(){
					if(user_name=="Guest"){
						alert("로그인 후 이용해주세요");
					}else if(user_name!="Guest"){
						window.open("club_group_see.php?count_group='.$count_group.'", "club_group_see", "width=770,height=650,resizable=yes,scrollbars=yes,location=no");
					}
				});
			</script>
			';
		}
		$output1 .= '
			<div id="club_group_write" class="menu_button" style="margin:0 0 10px 0;"></div>
			<script>
				$("#club_group_write").click(function(){//글쓰기 클릭시
					if(user_name=="Guest"){
						alert("로그인 후 이용해주세요");
					}else if(user_name!="Guest"){
						window.open("club_group_writing.php?count_group='.$count_group.'", "club_group_writing", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no");
					}
				});
				$("#club_group_modify").click(function(){//모임정보수정을 눌렀을 때
					if(user_name=="Guest"){
						alert("로그인 후 이용해주세요");
					}else if(user_name!="Guest"){
						window.open("club_group_modify.php?count_group='.$count_group.'", "club_group_modify", "width=770,height=650,resizable=yes,scrollbars=yes,location=no");
					}
				});
				$("#club_group_admin").click(function(){//회원관리를 눌렀을 때
					if(user_name=="Guest"){
						alert("로그인 후 이용해주세요");
					}else if(user_name!="Guest"){
						window.open("club_group_admin.php?count_group='.$count_group.'", "club_group_admin", "width=770,height=650,resizable=yes,scrollbars=yes,location=no");
					}
				});
			</script>
		';
		echo $output1;//결과물과 list를 함께 출력
		$table_name_main = $table_name."_main";
		$table_name_delta = $table_name."_delta";
		$table_name_reply = $table_name."_reply";
		if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 때
			$sql4 = "SELECT * FROM $table_name WHERE count_group=$count_group";//list_show를 만들기 위해
		} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
			$sphinx->SetFilter("count_group", array($count_group) );
			$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
			$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
		}
		if(($keyword == "thereisnokeyword" && $category == "thereisnocategory") || ($keyword != "thereisnokeyword" && $category=="writer")){//keyword 검색을 하지 않았거나 작성자 검색일 경우
			$sql_query4 = mysqli_query($conn, $sql4);
			$count4 = mysqli_num_rows($sql_query4);//list에 count된 총 갯수
		} else if($keyword != "thereisnokeyword" && $category != "writer"){//작성자 검색이 아니고 keyword 검색을 했을 때
			$count4 = $search["total_found"];
		}
		if($count4 != 0){
			include 'recall_detailB.php';
			if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 때
				if($count_link != 0){
					$sql1 = $sql4." AND count=$count_link";//쓴 글 검색
				} else if($count_link==0){
					$sql1 = $sql4." ORDER BY count DESC LIMIT $start_number, $number";//쓴 글 검색
				}
				$sql_query1 = mysqli_query($conn, $sql1);
				$count1 = mysqli_num_rows($sql_query1);
			} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
				$sphinx->SetFilter("count_group", array($count_group) );
				$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
				if($count_link != 0){
					$sphinx->SetLimits($start_number, 1);
				}else if($count_link==0){
					$sphinx->SetLimits($start_number, $number);//$start_number 번호를 시작으로 $number 갯수만큼 검색
				}
				$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
				$count1 = count($search["matches"]);//검색물 갯수
				foreach($search["matches"] as $key => $value){//검색물 count 정보 추출
					$arr10[] = $key;
				}
			}
		} else {
			$count1=0;
			$html_list = '';
			$total_list_count = 0;
		}
		if($count_link != 0){//세부목록 보기일때
		} else if($count_link==0){//세부목록 보기가 아닐때
			$output .= '<div id="list_box">';
			if($count4 != 0){
				$output .= '
					<div id="list_head">
						<div id="writing_list_A">작성일</div>
						<div id="writing_list_title">제&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;목</div>
						<div id="writing_list_C">조회수</div>
						<div id="writing_list_B">작성자</div>
					</div>
				';
			} else if($count4==0){
				$output .= '<div class="empty_list">작성된 글이 없습니다</div>';
			}
		}
		for($i=0; $i<$count1; $i++){//개별 결과 출력
			$html = '';
			if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 때
				$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
				$sql11 = "SELECT * FROM $table_name WHERE count = $arr10[$i]";
				$sql_query11 = mysqli_query($conn, $sql11);
				$sql_fetch_array1 = mysqli_fetch_array($sql_query11);
			}
			$list_count_link = $start_number + $i +1;//list_count 숫자 설정 (목록에서 링크 설정을 위한 setting)
			$list_page_count_link = (int) ( ($list_count_link-1) / $list_count_on_page) +1;
			$prev_list_page_count_link = (int) ( ($list_count_link-1-1) / $list_count_on_page ) + 1;//전 페이지의 list_page_count
			$next_list_page_count_link = (int) ( ($list_count_link-1+1) / $list_count_on_page ) + 1;//다음 페이지의 list_page_count
			$sql3 = "SELECT * FROM user WHERE user_num = $sql_fetch_array1[user_num]";//작성자 이름 확인
			$sql_query3 = mysqli_query($conn, $sql3);
			$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
			$writer_name = $sql_fetch_array3["user_name"];
			$sql15 = "SELECT * FROM $table_name_reply WHERE count_upperwrite = $sql_fetch_array1[count]";//댓글 검색
			$sql_query15 = mysqli_query($conn, $sql15);
			$count15 = mysqli_num_rows($sql_query15);
			$title = $sql_fetch_array1["title"];
			$content = $sql_fetch_array1["content"];
			if($keyword != "thereisnokeyword"){//키워드 검색했을경우
				$title = search_highlight($keyword, $title);
				$content = search_highlight($keyword, $content);
			}
			if($count_link != 0){//세부목록으로 들어갈 경우
				if($sql_fetch_array1["user_num"] != $user_num){read_doc($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["read_count"]);} // 본인 글이 아닐경우 조회수를 올린다
				$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array1[user_num]";//idcard의 사진을 띄운다
				$sql_query17 = mysqli_query($conn, $sql17);
				$count17 = mysqli_num_rows($sql_query17);
				if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
				else{$user_photo_path = "../image/blank_face.png";}
				$html .= '
				<div id="form_area">
				<div id="info_area">
					<div id="info_area_status">
						<div id="info_area_writer" class="inline">'.$writer_name.'
							<div class="user_info" style="position:absolute; top:16px; left:0px;"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding send_msg pointer">쪽지 보내기</div></div>
						</div>
						<div id="info_area_time">('.$sql_fetch_array1["writetime"].')</div>
					</div>
					<div id="info_area_read_count">조회수: '.$sql_fetch_array1["read_count"].'</div>
				</div>
				<div id="modify_status">
					'.$add_photo_block.'
				</div>
				<div id="main_writing">
					<div id="mywrite_titlearea">
						<article id="mywrite_title" class="inline" style="top:0px;">'.$title.'</article>
						<input type="text" id="mywrite_title_modify" name="mywrite_title" class="inline" value="" maxlength="100" style="width:700px;"/>
					</div>
					<div class="link_block"></div>
					<div id="mywrite_bodyarea">
						<div id="mywrite_body"><!--내글쓰기-->
							<article id="mywrite_content_read">'.$content.'</article>
						</div>
						<div id="mywrite_func">
							<div id="see_reply_'.$sql_fetch_array1["count"].'" class="see_reply_status" onclick="see_reply('.$sql_fetch_array1["count"].')">▼ 댓글 '.$count15.' </div>
					';
				if($sql_fetch_array1["user_num"] == $user_num){//글쓴이 본인일 경우
					$html .= '
								<div id="write_modify_'.$sql_fetch_array1["count"].'" class="write_modify" onclick="write_modify_club_group('.$sql_fetch_array1["count"].')">수정</div>
					';
				}
				if($sql_fetch_array1["user_num"]==$user_num || $sql_fetch_array5["user_num"]==$user_num){//글쓴이 본인이거나 모임장일 경우
					$html .= '<div id="write_delete_'.$sql_fetch_array1["count"].'" class="write_delete" onclick="club_group_writing_delete('.$sql_fetch_array1["count"].')">삭제</div>';
				}
				$html .= '
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
				$writetime = substr($sql_fetch_array1["writetime"], 0, 10);
				$html .= '
					<div id="writing_area_article'.$sql_fetch_array1["count"].'" class="writing_area_article">
						<div class="writing_A">'.$writetime.'</div>
						<a href="'.$url.'count_link='.$sql_fetch_array1["count"].'&list_count='.$list_count_link.$number_url.$keyword_url.$category_url.'"><div class="writing_title">'.$title.' &nbsp;<span style="color:#3C847F; font-weight:normal;">('.$count15.')</span></div></a>
						<div class="writing_C">'.$sql_fetch_array1["read_count"].'</div>
						<div class="writing_B">'.$writer_name.'</div>
					</div>
					<script>
						$("#writing_list_B").hover(function(){//공개여부 영역의 글씨 색깔을 바꿈
							$("#list_status_set").css("display", "block");
						}, function(){
							$("#list_status_set").css("display", "none");
						});
						var height = $("#writing_area_article'.$sql_fetch_array1["count"].' .writing_title").height();
						$("#writing_area_article'.$sql_fetch_array1["count"].'").height(height+10);
						$("#writing_area_article'.$sql_fetch_array1["count"].' .writing_A").height(height);
						$("#writing_area_article'.$sql_fetch_array1["count"].' .writing_B").height(height);
						$("#writing_area_article'.$sql_fetch_array1["count"].' .writing_C").height(height);
					</script>
				';
			}
			$output .= $html;
		}
		if($count_link==0){$output .= '</div>';} // list_box div의 끝
		echo '
			<div id="list_search">
				<div id="list_search_box">
				<div id="list_search_tip" title="검색 Tip"><img src="../image/list_search_tip.png"/></div>
				<select id="list_search_category" name="list_search_category" style="left:1px;">
					<option selected value="all_content">전체</option><option value="title">제목</option><option value="content">글내용</option>
				</select>
				<input id="list_search_word" type="text" name="list_search_word" value="" maxlength="40" tabindex=""/>
				<div id="list_search_word_button" title="검색"></div>
				<div id="list_search_word_cancel" title="검색 취소"></div>
				</div>
			</div>
		';
		echo $html_list . $output . $html_list;//결과물과 list를 함께 출력
		include 'list_button.php';
	}
?>