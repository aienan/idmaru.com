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
	if($category != "thereisnocategory"){
		$output .= '<script>$("select[name=list_search_category]").val("'.$category.'");</script>';
	} else if($category=="thereisnocategory"){
		$output .= '<script>$("select[name=list_search_category]").val("all_content");</script>';
	}
	include 'reply_recall_common.php';
	if($count_link != 0){//세부목록 보기일때
	} else if($count_link==0){//세부목록 보기가 아닐때
		$output .= '<div id="list_box">';
		if($count4 != 0 || $status != 4){//글이 있거나 전체보기가 아닐경우
			$output .= '
				<div id="list_head">
					<div id="sale_friend_list_A">판&nbsp;매&nbsp;자</div>
					<div id="sale_friend_list_B">물&nbsp;&nbsp;&nbsp;품&nbsp;&nbsp;&nbsp;명</div>
					<div id="sale_friend_list_C">조회수</div>
					<div id="sale_friend_list_D">상태</div>
				</div>
			';
		}
		if($count4 != 0){
		} else if($count4==0){
			if($keyword=="thereisnokeyword"){
				$output .= '<div class="empty_list">댓글을 쓴 물품이 없습니다</div>';
			} else if($keyword!="thereisnokeyword"){
				$output .= '<div class="empty_list">검색된 물품이 없습니다</div>';
			}
		}
		
	}
	if($count4 != 0){//결과물이 있을경우
		for($i=0; $i<$count1; $i++){//개별 결과 출력
			$html = '';
			if($count_link != 0){$sql_fetch_array1 = mysqli_fetch_array($sql_query1);}
			else if($count_link==0){
				$list_order = $i + $start_number;
				$sql11 = "SELECT * FROM $table_name WHERE count = $reply_arr[$list_order]";
				$sql_query11 = mysqli_query($conn, $sql11);
				$sql_fetch_array1 = mysqli_fetch_array($sql_query11);
			}
			if($sql_fetch_array1["status"]==1){
				$status="판매중";
			} else if($sql_fetch_array1["status"]==2){
				$status="판매완료";
			} else if($sql_fetch_array1["status"]==3){
				$status="공유중";
			}
			$list_count_link = $start_number + $i +1;//list_count 숫자 설정 (목록에서 링크 설정을 위한 setting)
			$list_page_count_link = (int) ( ($list_count_link-1) / $list_count_on_page) +1;
			$prev_list_page_count_link = (int) ( ($list_count_link-1-1) / $list_count_on_page ) + 1;//전 페이지의 list_page_count
			$next_list_page_count_link = (int) ( ($list_count_link-1+1) / $list_count_on_page ) + 1;//다음 페이지의 list_page_count
			$sql5 = "SELECT * FROM $table_name_reply WHERE count_upperwrite = $sql_fetch_array1[count]";//댓글 검색
			$sql_query5 = mysqli_query($conn, $sql5);
			$count5 = mysqli_num_rows($sql_query5);
			$sql6 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num]";//작성자 이름 검색
			$sql_query6 = mysqli_query($conn, $sql6);
			$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
			$title = $sql_fetch_array1["title"];
			$content = $sql_fetch_array1["content"];
			if($keyword != "thereisnokeyword"){//키워드 검색했을경우
				$title = search_highlight($keyword, $title);
				$content = search_highlight($keyword, $content);
			}
			$title = '['.selling_type_name($sql_fetch_array1["type"]).'] '.$title;
			if($count_link != 0){//세부목록으로 들어갈 경우
				if($sql_fetch_array1["user_num"] != $user_num){read_doc($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["read_count"]);} // 본인 글이 아닐경우 조회수를 올린다
				$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array6[user_num]";//idcard의 사진을 띄운다
				$sql_query17 = mysqli_query($conn, $sql17);
				$count17 = mysqli_num_rows($sql_query17);
				if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
				else{$user_photo_path = "../image/blank_face.png";}
				$sql16 = "SELECT * FROM market_deal WHERE count=$sql_fetch_array1[count]";
				$sql_query16 = mysqli_query($conn, $sql16);
				$count16 = mysqli_num_rows($sql_query16);
				$link_addr = 'http://www.idmaru.com/web/market.php?count_link='.$sql_fetch_array1["count"];
				$sale_input_date = "";
				if($sql_fetch_array1["sale_year"]!=""){$sale_input_date .= $sql_fetch_array1["sale_year"]."년";}
				if($sql_fetch_array1["sale_month"]!=""){$sale_input_date .= " ".$sql_fetch_array1["sale_month"]."월";}
				if($sql_fetch_array1["sale_date"]!=""){$sale_input_date .= " ".$sql_fetch_array1["sale_date"]."일";}
				$sale_input_how = "";
				if($sql_fetch_array1["sale_direct"]==1){$sale_input_how .= " [ 직거래 ]";}
				if($sql_fetch_array1["sale_parcel"]==1){$sale_input_how .= " [ 택배 ]";}
				if($sql_fetch_array1["sale_safe"]==1){$sale_input_how .= " [ 안전거래 ]";}
				$html .= '
				<div id="form_area">
				<div id="info_area">
					<div id="info_area_writer" class="inline">판매자 : '.$sql_fetch_array6["user_name"].'
					<div class="user_info" style="position:absolute; top:16px; left:0px; display:none;"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding send_msg pointer">쪽지 보내기</div></div>
					</div>
					<div id="writer_report" class="button_small" style="padding:2px;" onclick="writer_report('.$sql_fetch_array6["user_num"].', \''.$sql_fetch_array6["user_name"].'\')">판매자평</div>
					<div id="info_area_status">거래상태 : <span id="write_content_status" class="inline">'.$status.'</span></div>
					<div id="info_area_read_count">조회수: '.$sql_fetch_array1["read_count"].'</div>
				</div>
				<div id="main_writing">
					<div id="mywrite_titlearea">
						<article id="mywrite_title" class="inline" style="top:0px;">'.$title.'  </article>
						'.updown_status($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["user_num"], -1, -1).'
					</div>
					'.link_block($link_addr).'
					<div id="mywrite_bodyarea">
						<article id="mywrite_body"><!--내글쓰기-->
							<div class="market_box1">
							<div id="market_deal" class="button_gb" onclick="market_deal('.$sql_fetch_array1["count"].')">입찰수 '.$count16.'</div><div id="sale_reserve_box" class="button_gb" onclick="sale_reserve_box('.$sql_fetch_array1["count"].', '.$sql_fetch_array1["user_num"].')">장바구니</div><div id="sale_email" class="button_gb" onclick="sale_email('.$sql_fetch_array1["count"].', '.$sql_fetch_array1["user_num"].')">E-Mail 전송</div>
							</div>
							<div class="market_box3">
							<p><strong>구입시기 :</strong> &nbsp; '.$sale_input_date.'</p>
							<p><strong>거래방법 :</strong> &nbsp; '.$sale_input_how.'</p>
							<p><strong>직거래 장소 :</strong> &nbsp; '.$sql_fetch_array1["sale_place"].'</p>
							<p><strong>입찰 시작가 :</strong> &nbsp; <span id="sale_price"></span></p>
							<script>var sale_price = addComma("'.$sql_fetch_array1["sale_price"].'"); if(sale_price){$("#sale_price").html(sale_price+" 원");}</script>
							</div>
							<div id="mywrite_content_read">'.$content.'</div>
						</article>
						<div id="mywrite_func">
							<div id="see_reply_'.$sql_fetch_array1["count"].'" class="see_reply_status" onclick="see_reply('.$sql_fetch_array1["count"].')">▼ 댓글 '.$count5.' </div>
							'.other_link_area($link_addr, $title, $content).'
						</div>
					</div>
				</div>
					</div>
					<div id="textarea_copy"></div>
					<div id="mywrite_reply" class="mywrite_body">
						<textarea id="mywrite_reply_text" name="mywrite_reply_content"></textarea>
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
				$html .= '
					<div id="writing_area_article'.$sql_fetch_array1["count"].'" class="writing_area_article">
						<div class="sale_friend_list_A">'.$sql_fetch_array6["user_name"].'</div>
						<a href="'.$url.'count_link='.$sql_fetch_array1["count"].'&list_count='.$list_count_link.$number_url.$keyword_url.$category_url.$status_url.'&selling_type='.$selling_type.'"><div class="sale_friend_list_B">'.$title.' &nbsp;<span style="color:#3C847F; font-weight:normal;">('.$count5.')</span></div></a>
						<div class="sale_friend_list_C">'.$sql_fetch_array1["read_count"].'</div>
						<div class="sale_friend_list_D">'.$status.'</div>
					</div>
					<script>
						var height = $("#writing_area_article'.$sql_fetch_array1["count"].' .sale_friend_list_B").height();
						$("#writing_area_article'.$sql_fetch_array1["count"].'").height(height+8);
						$("#writing_area_article'.$sql_fetch_array1["count"].' .sale_friend_list_A").height(height);
						$("#writing_area_article'.$sql_fetch_array1["count"].' .sale_friend_list_C").height(height);
						$("#writing_area_article'.$sql_fetch_array1["count"].' .sale_friend_list_D").height(height);
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