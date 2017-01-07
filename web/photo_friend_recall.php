<?php
if($category=="content"){
	$search_field = "content";
}
$status_num = $status;
if($gallery_type=="all"){}
else {$type = gallery_type_num($gallery_type);}
$standard_width = 235;
$standard_width_one = 645;
$output = '';
if($category != "thereisnocategory"){
	$output .= '<script>$("select[name=list_search_category]").val("'.$category.'");</script>';
} else if($category=="thereisnocategory"){
	$output .= '<script>$("select[name=list_search_category]").val("content");</script>';
}
include 'photo_friend_recall_detail.php';
if($count_link != 0){//세부목록 보기일때
	if($count4==0){//세부목록인데 사진이 없을때
		echo '<script>location.href = "'.$url.'";</script>';
	}
} else if($count_link==0){//세부목록이 아닐때
	$output .= '<div id="photo_area_total">';
	if($count4 != 0){//결과물이 있을때
		$output .= '
			<div id="photo_area_1"></div><div id="photo_area_2"></div><div id="photo_area_3"></div>
		';
	} else if($count4==0){//결과물이 없을때
		if($not_friend==0){//작성자 검색시 친구가 맞을경우
			if($keyword=="thereisnokeyword"){
				$output .= '<div class="empty_list">등록된 사진이 없습니다</div>';
			} else if($keyword!="thereisnokeyword"){
				$output .= '<div class="empty_list">검색된 사진이 없습니다</div>';
			}
		} else if($not_friend==1){//작성자 검색시 친구가 아닐경우
			$output .= '<div class="empty_list">검색하신 분은 친구로 등록되지 않았습니다</div>';
		}
	}
}
if($count4 != 0){//결과물이 있을경우
	for($i=0; $i<$count1; $i++){//photo 출력
		$html = '';
		if(($keyword == "thereisnokeyword" && $category == "thereisnocategory") || ($keyword != "thereisnokeyword" && $category=="writer")){//keyword 검색을 하지 않았을 때
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
			$sql11 = "SELECT * FROM $table_name WHERE count = $arr10[$i]";
			$sql_query11 = mysqli_query($conn, $sql11);
			$sql_fetch_array1 = mysqli_fetch_array($sql_query11);
		}
		$photo_path = $sql_fetch_array1["photo_path"];
		if(file_exists($photo_path)==false){$photo_path="../image/error.jpg";}
		else if($count_link==0){$photo_path = get_thumbnail_path($photo_path);}
		$image_size = getimagesize($photo_path);//image 넓이와 높이 구하기
		$image_width = $image_size[0];//image 넓이
		$image_height = $image_size[1];//image 높이
		if($image_width > $standard_width){//list형 보기에서 image가 커서 보정이 될 경우
			$image_width_adjusted = $standard_width;
			$image_height_adjusted = $image_height * $image_width_adjusted / $image_width;
		} else {//list형 보기에서 image가 작아서 보정이 안될 경우
			$image_width_adjusted = $image_width;
			$image_height_adjusted = $image_height;
		}
		if($image_width > $standard_width_one){//하나 보기에서 image가 커서 보정이 될 경우
			$image_height_shrink = $image_height / ($image_width / $standard_width_one);
		} else if($image_width <= $standard_width_one){//하나 보기에서 image가 작아서 보정이 안될 경우
			$image_height_shrink = $image_height;
		}
		$go_arrow_top = height_middle($image_height_shrink, 36);//화살표의 top 수치
		if($sql_fetch_array1["status"] == "1"){//모두에게 공개될 경우
			$status = "모두";
		} else if($sql_fetch_array1["status"] == "2"){//친구에게 공개될 경우
			$status = "친구";
		} else if($sql_fetch_array1["status"] == "3"){//비공개일 경우
			$status = "비공개";
		}
		$list_count_link = $start_number + $i +1;//list_count 숫자 설정 (목록에서 링크 설정을 위한 setting)
		$list_page_count_link = (int) ( ($list_count_link-1) / $list_count_on_page) +1;
		$prev_list_page_count_link = (int) ( ($list_count_link-1-1) / $list_count_on_page ) + 1;//전 페이지의 list_page_count
		$next_list_page_count_link = (int) ( ($list_count_link-1+1) / $list_count_on_page ) + 1;//다음 페이지의 list_page_count
		$sql5 = "SELECT * FROM $table_name_reply WHERE count_upperwrite = $sql_fetch_array1[count]";//댓글 검색
		$sql_query5 = mysqli_query($conn, $sql5);
		$count5 = mysqli_num_rows($sql_query5);
		$content = $sql_fetch_array1["content"];
		if($keyword != "thereisnokeyword"){//키워드 검색했을경우
			$content = search_highlight($keyword, $content);
		}
		$sql6 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num]";//작성자 이름 검색
		$sql_query6 = mysqli_query($conn, $sql6);
		$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
		if($count_link != 0){//사진을 한장만 출력할 경우
			if($sql_fetch_array1["user_num"] != $user_num){read_doc($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["read_count"]);} // 본인 글이 아닐경우 조회수를 올린다
			$sql7 = "SELECT * FROM $table_name_updown WHERE count=$sql_fetch_array1[count] AND updown='up'";//글에 좋아요 표시한 갯수를 센다
			$sql_query7 = mysqli_query($conn, $sql7);
			$count7 = mysqli_num_rows($sql_query7);
			$info_area_type = gallery_type_info_area($sql_fetch_array1["type"]);
			$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array6[user_num]";//idcard의 사진을 띄운다
			$sql_query17 = mysqli_query($conn, $sql17);
			$count17 = mysqli_num_rows($sql_query17);
			if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
			else{$user_photo_path = "../image/blank_face.png";}
			$link_addr = 'http://www.idmaru.com/web/gallery_all.php?count_link='.$sql_fetch_array1["count"];
			$html .= '
				<div id="form_area" style="padding:20px 0;">
				<div id="photo_one">
					<div id="go_prev"><div id="go_prev_arrow"></div></div>
					<div id="photo_main">
						<img id="photo_'.$sql_fetch_array1["count"].'" src="'.$photo_path.'" class="link"/>
					</div>
					<div id="go_next"><div id="go_next_arrow"></div></div>
				</div>
				<div id="info_area">
					<div id="info_area_type" class="inline">['.$info_area_type.']</div>
					<div id="info_area_writer" class="inline">'.$sql_fetch_array6["user_name"].'
						<div class="user_info" style="top:16px;"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding send_msg pointer">쪽지 보내기</div></div>
					</div>
					<div id="info_area_time">('.$sql_fetch_array1["writetime"].')</div>
					'.updown_status($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["user_num"], $sql_fetch_array1["up_total"], -1).'
					<div id="info_area_read_count">조회수: '.$sql_fetch_array1["read_count"].'</div>
				</div>
				<div id="main_writing">
				'.link_block($link_addr).'
				<div id="mywrite_bodyarea">
					<div id="photo_content">'.convert_to_tag($content).'</div>
					<div id="mywrite_func">
						<div id="see_reply_'.$sql_fetch_array1["count"].'" class="see_reply_status" onclick="see_reply('.$sql_fetch_array1["count"].')">▼ 댓글 '.$count5.'</div>
		';
		if($sql_fetch_array1["user_num"] != $user_num){//글쓴이가 본인이 아닐경우
			read_doc($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["read_count"]);//조회수를 올린다
		}
		if($sql_fetch_array1["user_num"]==$user_num){//글쓴이 본인일경우
			$html .= '
						<div id="write_modify_'.$sql_fetch_array1["count"].'" class="photo_modify" onclick="photo_modify('.$sql_fetch_array1["count"].')">수정</div>
						<div id="write_delete_'.$sql_fetch_array1["count"].'" class="photo_delete" onclick="write_delete(\''.$table_name.'\', '.$sql_fetch_array1["count"].')">삭제</div>
			';
		}
		$html .= other_link_area($link_addr, $content, $content).'
					</div>
				</div>
				</div>
				</div>
				<div id="textarea_copy"></div>
				<div id="mywrite_reply" class="mywrite_body">
					<textarea id="mywrite_reply_text" name="mywrite_reply_content"></textarea>
					<div class="mywrite_cont">
						<div id="mywrite_reply_letterleft"></div>
						<div id="mywrite_reply_enter" class="mouseover" onclick="write_reply_submit('.$sql_fetch_array1["count"].')"><img src="../image/button_enter.png"/></div>
					</div>
				</div>
				<script>
					if('.$image_width.' > '.$standard_width_one.'){
						$("#photo_'.$sql_fetch_array1["count"].'").attr("width", '.$standard_width_one.');//사진의 넓이 설정
					}
					$("#photo_one, #go_prev, #go_next").height('.$image_height_shrink.');
					$("#go_prev_arrow, #go_next_arrow").css("top", "'.$go_arrow_top.'px");
					$("#photo_main img").click(function(){
						var photo_path = $(this).attr("src");
						window.open("photo_recall_one.php?photo_path="+photo_path+"&table_name='.$table_name.'&count='.$sql_fetch_array1["count"].'", "photo_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
					});
					info_area_functions('.$sql_fetch_array1["user_num"].');
					mywrite_link_click();
					reply_keyup();
					photo_battle_check('.$sql_fetch_array1["count"].');
				</script>
			';
		} else if($count_link==0){//사진 목록을 출력할 경우
			$html .= '
				<div id="div_photo_'.$sql_fetch_array1["count"].'" class="relative"><a href="'.$url.'count_link='.$sql_fetch_array1["count"].'&list_count='.$list_count_link.$number_url.$keyword_url.$category_url.$status_url.'&gallery_type='.$gallery_type.'"><img src="'.$photo_path.'" width="'.$image_width_adjusted.'" height="'.$image_height_adjusted.'" style="margin:0px 10px 0px 0px;" /></a><div class="photo_owner">'.$sql_fetch_array6["user_name"].'</div></div>
				<script>
					var area1_height = $("#photo_area_1").height();
					var area2_height = $("#photo_area_2").height();
					var area3_height = $("#photo_area_3").height();
					if( (area1_height <= area2_height) && (area1_height <= area3_height) ){$("#photo_area_1").append($("#div_photo_'.$sql_fetch_array1["count"].'"));}
					else if( (area2_height <= area1_height) && (area2_height <= area3_height) ){$("#photo_area_2").append($("#div_photo_'.$sql_fetch_array1["count"].'"));}
					else if( (area3_height <= area1_height) && (area3_height <= area2_height) ){$("#photo_area_3").append($("#div_photo_'.$sql_fetch_array1["count"].'"));}
				</script>
			';
		}
		$output .= $html;
	}
	if($count_link==0){//사진 목록을 출력할 경우
		$output .= '
			<script>
			var height_total;
			var area1_height = $("#photo_area_1").height();
			var area2_height = $("#photo_area_2").height();
			var area3_height = $("#photo_area_3").height();
			if( (area1_height >= area2_height) && (area1_height >= area3_height) ){height_total=area1_height;}
			else if( (area2_height >= area1_height) && (area2_height >= area3_height) ){height_total=area2_height;}
			else if( (area3_height >= area1_height) && (area3_height >= area2_height) ){height_total=area3_height;}
			$("#photo_area_total").height(height_total);
			</script>
		';
	}
}
if($count_link==0){$output .= '</div>';} // photo_area_total의 끝
echo $html_list . $output . $html_list;//결과물과 list를 함께 출력
include 'list_button.php';
?>