<?php
	if($category=="all_content"){
		$search_field = "title,content";
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
	include 'sale_recall_detail.php';
	if($count_link != 0){//세부목록 보기일때
	} else if($count_link==0){//세부목록 보기가 아닐때
		$output .= '<div id="list_box">';
		if($count4 != 0 || $status != 4){//글이 있거나 전체보기가 아닐경우
			$output .= '
				<div id="list_head">
					<div id="sale_list_A">조회수</div>
					<div id="sale_list_title">제&nbsp;&nbsp;&nbsp;&nbsp;품&nbsp;&nbsp;&nbsp;&nbsp;명</div>
					<div id="sale_list_bet">입찰수</div>
					<div id="sale_list_status">
						<span class="mouseover">▼ 상태</span>
						<div id="list_status_set">
							<div id="list_status_set_4">&nbsp;<input type="radio" name="status" value="4"/> 전체보기</div>
							<div id="list_status_set_1">&nbsp;<input type="radio" name="status" value="1"/> 판매중</div>
							<div id="list_status_set_2">&nbsp;<input type="radio" name="status" value="2"/> 판매완료</div>
							<div id="list_status_set_3">&nbsp;<input type="radio" name="status" value="3"/> 공유중</div>
							<div id="apply_button" class="button_green2">적용</div>
						</div>
					</div>
				</div>
				<script>
					$("#apply_button").click(function(){
						var status=$("input:radio[name=status]:checked").val();
						location.href = "'.$url.'list_count=1'.$number_url.$keyword_url.$category_url.'&status="+status+"&selling_type='.$selling_type.'";
					});
					$("#sale_list_status").hover(function(){
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
			} else if($status==1){//판매중 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(1)").attr("checked", true);</script>
				';
			} else if($status==2){//판매완료 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(2)").attr("checked", true);</script>
				';
			} else if($status==3){//공유중 보기일 경우
				$output .= '
					<script>$("input:radio[name=status]:nth(3)").attr("checked", true);</script>
				';
			}
		}
		if($count4 != 0){//검색물이 있을 때
		} else if($count4==0){
			if($keyword=="thereisnokeyword"){
				$output .= '<div class="empty_list">등록된 물건이 없습니다</div>';
			} else if($keyword!="thereisnokeyword"){
				$output .= '<div class="empty_list">검색된 물건이 없습니다</div>';
			}
		}
	}
	for($i=0; $i<$count1; $i++){//검색결과 출력
		$html = '';
		if(($keyword == "thereisnokeyword" && $category == "thereisnocategory") || ($keyword != "thereisnokeyword" && $category=="writer")){//keyword 검색을 하지 않았을 때
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		} else if(($keyword != "thereisnokeyword") || ($selling_type != "all")){//keyword 검색을 하거나 selling_type을 설정했을때
			$sql11 = "SELECT * FROM $table_name WHERE count = $arr10[$i]";
			$sql_query11 = mysqli_query($conn, $sql11);
			$sql_fetch_array1 = mysqli_fetch_array($sql_query11);
		}
 		if($sql_fetch_array1["status"]=="1"){
			$status="판매중";
		} else if($sql_fetch_array1["status"]=="2"){
			$status="판매완료";
		} else if($sql_fetch_array1["status"]=="3"){
			$status="공유중";
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
		$title = '['.selling_type_name($sql_fetch_array1["type"]).'] '.$title;
		$sql6 = "SELECT * FROM market_deal WHERE count=$sql_fetch_array1[count]";
		$sql_query6 = mysqli_query($conn, $sql6);
		$count6 = mysqli_num_rows($sql_query6);
		$link_addr = 'http://www.idmaru.com/web/market.php?count_link='.$sql_fetch_array1["count"];
		$sale_input_date = "";
		if($sql_fetch_array1["sale_year"]!=""){$sale_input_date .= $sql_fetch_array1["sale_year"]."년";}
		if($sql_fetch_array1["sale_month"]!=""){$sale_input_date .= " ".$sql_fetch_array1["sale_month"]."월";}
		if($sql_fetch_array1["sale_date"]!=""){$sale_input_date .= " ".$sql_fetch_array1["sale_date"]."일";}
		$sale_input_how = "";
		if($sql_fetch_array1["sale_direct"]==1){$sale_input_how .= " [ 직거래 ]";}
		if($sql_fetch_array1["sale_parcel"]==1){$sale_input_how .= " [ 택배 ]";}
		if($sql_fetch_array1["sale_safe"]==1){$sale_input_how .= " [ 안전거래 ]";}
		if($count_link != 0){//세부목록으로 들어갈 경우
			$html .= '
			<div id="form_area">
			<div id="info_area">
				<div id="info_area_status">거래상태 : <span id="write_content_status">'.$status.'</span></div>
				<div id="info_area_read_count">조회수: '.$sql_fetch_array1["read_count"].'</div>
			</div>
			<div id="modify_status">
				<h6 id="selling_type_mod_box" class="inline">판매분류 : <select id="selling_type_mod" name="selling_type_mod">'.$select_option_selling_type.'</select></h6>
				<div id="selling_type_example_mod" class="button_sw" style="position:relative; display:inline; margin:0 0 0 20px;">물품 Tip</div>
				<script>
					$("#selling_type_example_mod").click(function(){
						window.open("selling_type_example.php", "selling_type_example", "width=770,height=630,resizable=yes,scrollbars=yes,location=no");
					});
				</script>
				<div><h6 class="inline">거래상태 : &nbsp;판매중&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="selling" tabindex=""/><h6 class="inline basicmargin">&nbsp;&nbsp;판매완료&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="done" tabindex=""/><h6 class="inline basicmargin">&nbsp;&nbsp;공유중&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="share" tabindex=""/></div>
				'.$add_photo_block.'
			</div>
			<div id="main_writing">
				<div id="mywrite_titlearea">
					<article id="mywrite_title" class="inline" style="top:0px;">'.$title.'</article>
					<input type="text" id="mywrite_title_modify" name="mywrite_title" class="inline" value="" maxlength="100" style="width:700px;"/>
				</div>
				'.link_block($link_addr).'
				<div id="mywrite_bodyarea">
					<article id="mywrite_body"><!--내글쓰기-->
						<div class="market_box1">
						<span id="market_deal" class="button_gb" onclick="market_deal('.$sql_fetch_array1["count"].')">입찰수 '.$count6.'</span>
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
				';
			$html .= '
						<div id="write_modify_'.$sql_fetch_array1["count"].'" class="write_modify" onclick="write_modify_market('.$sql_fetch_array1["count"].', '.$sql_fetch_array1["type"].')">수정</div>
						<div id="write_delete_'.$sql_fetch_array1["count"].'" class="write_delete" onclick="write_delete(\''.$table_name.'\', '.$sql_fetch_array1["count"].')">삭제</div>
						'.other_link_area($link_addr, $title, $content).'
					</div>
				</div>
			</div>
				</div>
				<div id="textarea_copy"></div>
				<div id="mywrite_modify">
					<div class="market_box2">
					<div class="sale_input">구입시기 : <input type="text" name="sale_year_mod" maxlength="4" style="border:1px solid; padding:2px; margin:0 0 0 10px; width:30px;"/>년 <input type="text" name="sale_month_mod" maxlength="2" style="border:1px solid; padding:2px; width:15px;"/>월 <input type="text" name="sale_date_mod" maxlength="2" style="border:1px solid; padding:2px; width:15px;"/>일</div>
					<div class="sale_input">거래방법 : &nbsp;&nbsp;직거래 <input type="checkbox" name="sale_direct_mod" value="1" style="position:relative; top:1px;"/> &nbsp;&nbsp;택배 <input type="checkbox" name="sale_parcel_mod" value="1" style="position:relative; top:1px;"/> &nbsp;&nbsp;안전거래 <input type="checkbox" name="sale_safe_mod" value="1" style="position:relative; top:1px;"/></div>
					<div class="sale_input">직거래 장소 : <input type="text" name="sale_place_mod" style="border:1px solid; padding:2px; margin:0 0 0 10px; width:300px;"/></div>
					<div class="sale_input">입찰 시작가 : <input id="sale_price_mod" type="text" name="sale_price_mod" style="border:1px solid; padding:2px; margin:0 0 0 10px; width:70px;"/> 원</div>
					<div id="sale_safe_account" class="button_gb" style="right:130px; top:33px; font-size:8pt;">안전거래 이용방법</div>
					<div id="sale_safe_info" class="button_gb" style="right:5px; top:33px; font-size:8pt;">안심번호 이용방법</div>
					</div>
					<script>
						$("#sale_safe_account").click(function(){
							window.open("sale_safe_account.php", "sale_safe_account", "width=730,height=370,resizable=yes,scrollbars=yes,location=no");
						});
						$("#sale_safe_info").click(function(){
							window.open("sale_safe_info.php", "sale_safe_info", "width=620,height=420,resizable=yes,scrollbars=yes,location=no");
						});
					</script>
					<div id="mywrite_modify_body"  style="width:725px; padding:0;"><!--수정용 textarea-->
						<textarea id="mywrite_modify_text" name="mywrite_modify_content"></textarea>
					</div>
					<div id="mywrite_modify_bottom" class="write_bottom">
						<div id="mywrite_modify_confirm" onclick="mywrite_modify_confirm()">수정완료</div>
						<div id="mywrite_modify_cancel" onclick="mywrite_modify_cancel()">취소</div>
					</div>
				</div>
				<script>
					$("input[name=sale_year_mod]").val("'.$sql_fetch_array1["sale_year"].'");
					$("input[name=sale_month_mod]").val("'.$sql_fetch_array1["sale_month"].'");
					$("input[name=sale_date_mod]").val("'.$sql_fetch_array1["sale_date"].'");
					var sale_direct_mod = '.$sql_fetch_array1["sale_direct"].';
					if(sale_direct_mod==1){$("input[name=sale_direct_mod]").attr("checked", true);}
					var sale_parcel_mod = '.$sql_fetch_array1["sale_parcel"].';
					if(sale_parcel_mod==1){$("input[name=sale_parcel_mod]").attr("checked", true);}
					var sale_safe_mod = '.$sql_fetch_array1["sale_safe"].';
					if(sale_safe_mod==1){$("input[name=sale_safe_mod]").attr("checked", true);}
					$("input[name=sale_place_mod]").val("'.$sql_fetch_array1["sale_place"].'");
					$("input[name=sale_price_mod]").val(addComma("'.$sql_fetch_array1["sale_price"].'"));
					$("#sale_price_mod").focus(function(){//입찰 시작가에 커서가 찍혔을경우
						var string = $("#sale_price_mod").val();
						if(string==""){
							$("#sale_price_mod").val("");
							$("#sale_price_mod").css("text-align", "right");
						} else {
							$("#sale_price_mod").val(removeComma(string));
							$("#sale_price_mod").css("text-align", "right");
						}
					});
					$("#sale_price_mod").blur(function(){//입찰 시작가에서 커서가 나왔을경우
						var string = $("#sale_price_mod").val();
						if(!string){//글자가 없을때
						} else if(string){
							if(isNumber(string)){//숫자인지 체크
								$("#sale_price_mod").val(addComma(string));
								$("#sale_price_mod").css("text-align", "center");
							} else {//숫자가 아닐때
								$("#sale_price_mod").val("");
								alert("숫자만 입력할 수 있습니다");
							}
						}
					});
				</script>
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
			$html .= '
				<div id="sale_area_article'.$sql_fetch_array1["count"].'" class="sale_area_article">
					<div class="sale_A">'.$sql_fetch_array1["read_count"].'</div>
					<a href="'.$url.'count_link='.$sql_fetch_array1["count"].'&list_count='.$list_count_link.$number_url.$keyword_url.$category_url.$status_url.'&selling_type='.$selling_type.'"><div class="sale_title">'.$title.' &nbsp;<span style="color:#3C847F; font-weight:normal;">('.$count5.')</span></div></a>
					<div class="sale_bet">'.$count6.'</div>
					<div class="sale_status">'.$status.'</div>
				</div>
				<script>
					var height = $("#sale_area_article'.$sql_fetch_array1["count"].' .sale_title").height();
					$("#sale_area_article'.$sql_fetch_array1["count"].'").height(height+8);
					$("#sale_area_article'.$sql_fetch_array1["count"].' .sale_A").height(height);
					$("#sale_area_article'.$sql_fetch_array1["count"].' .sale_title").height(height);
					$("#sale_area_article'.$sql_fetch_array1["count"].' .sale_bet").height(height);
					$("#sale_area_article'.$sql_fetch_array1["count"].' .sale_status").height(height);
				</script>
			';
		}
		$output .= $html;
	}
	if($count_link==0){$output .= '</div>';} // list_box div의 끝
	echo $html_list . $output . $html_list;//결과물과 list를 함께 출력
	include 'list_button.php';
?>