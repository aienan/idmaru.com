<?php
	$table_name_main = $table_name."_main";
	$table_name_delta = $table_name."_delta";
	$table_name_reply = $table_name."_reply";
	$type_name = $selling_type;
	if($keyword=="thereisnokeyword" && $category=="thereisnocategory"){//keyword 검색을 하지 않았을 때
		if($type_name=="all"){$sql4 = "SELECT * FROM $table_name WHERE status='1'";}
		else{$sql4 = "SELECT * FROM $table_name WHERE status='1' AND type=$type";}
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);//list에 count된 총 갯수
	} else if($keyword != "thereisnokeyword" && $category=="writer"){//키워드 검색이 작성자일경우
		$keyword = strip_space($keyword);
		$sql9 = "SELECT * FROM user WHERE user_name='$keyword'";
		$sql_query9 = mysqli_query($conn, $sql9);
		$sql_fetch_array9 = mysqli_fetch_array($sql_query9);
		if($type_name=="all"){$sql4 = "SELECT * FROM $table_name WHERE user_num=$sql_fetch_array9[user_num] AND status='1'";}//news_type에 따라 결과물이 달라진다
		else{$sql4 = "SELECT * FROM $table_name WHERE user_num=$sql_fetch_array9[user_num] AND status='1' AND type=$type";}
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);//list에 count된 총 갯수
	} else if($keyword != "thereisnokeyword" && $category != "writer"){//작성자 검색이 아니고 keyword 검색을 했을 때
		$sphinx->SetFilter("status", array(1));
		if($type_name=="all"){}
		else{$sphinx->SetFilter("type", array($type));}
		$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
		$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
		$arr_user_num = array();
		if(isset($search["matches"])){
		foreach($search["matches"] as $key => $value){//검색자 목록을 만든다. 맨 위에 뜨는 검색자는 한번씩만 뜨도록 만든다.
			$count_arr_user_num = count($arr_user_num);
			$exist = 0;//목록에 있는지를 나타내는 변수
			$sql9 = "SELECT * FROM sale WHERE count=$key";//user_num을 알아내기 위함
			$sql_query9 = mysqli_query($conn, $sql9);
			$sql_fetch_array9 = mysqli_fetch_array($sql_query9);
			for($j=0; $j<$count_arr_user_num; $j++){
				if($arr_user_num[$j]!=$sql_fetch_array9["user_num"]){continue;}//목록에 등록되어 있지 않을때
				else if($arr_user_num[$j]==$sql_fetch_array9["user_num"]){$exist=1; break;}//목록에 등록되어 있을때
			}
			if($exist==0){//목록에 등록되어 있지 않을때
				$arr_user_num[] = $sql_fetch_array9["user_num"];
				$arr_count[] = $key;
			}
			if($exist==1){//목록에 등록되어 있을때
				$arr_count2[] = $key;
			}
		}
		}
		if(isset($arr_count2)){$arr_count = array_merge($arr_count, $arr_count2);}//$arr_count2 배열이 있을때 합친다
		$count4 = $search["total_found"];
	}
	
	
// echo '<script>alert("'.$search_field.'");</script>';


if($count4 != 0){//위에서 결과물이 있었을경우
	$extra_post = '&selling_type='.$selling_type;
	if($outer_link==1){ // 외부링크로 들어왔을 때
		if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을때
			$sql14 = $sql4." AND count>$count_link";
			$sql_query14 = mysqli_query($conn, $sql14);
			$count14 = mysqli_num_rows($sql_query14);
			$list_count = $count14 + 1;
		} else {
			$list_count = 0;
		}
		$list_page_count = (int)(($list_count-1) / $list_count_on_page) + 1;
	}
	$list_num_start = ($list_page_count-1) * $list_count_on_page +1; // 현재 목록에서 시작 번호
	if($list_num_start==1){
		$list_num_startB = $list_num_start - 1;
		$list_count_on_pageB = $list_count_on_page + 1;
	} else {
		$list_num_startB = $list_num_start - 2;
		$list_count_on_pageB = $list_count_on_page + 2;
	}
	if($count_link != 0){
		$sql13 = "SELECT * FROM $table_name WHERE count=$count_link AND status='1'";//count_link로 들어온 글이 존재하는지 확인
		$sql_query13 = mysqli_query($conn, $sql13);
		$count13 = mysqli_num_rows($sql_query13);
		if($count13==0){//count_link로 들어온 글이 존재하지 않을경우
			$output .= '<script>alert("게시물을 볼 수 없습니다."); location.href=url;</script>';
		}
		$total_list_count = (int)($count4);//리스트 갯수
		$start_number = ( $list_count -1);//검색 시작 count
		if($keyword != "thereisnokeyword" && $category != "writer"){ // 작성자 검색이 아니고 keyword 검색을 했을 때
			$list_end_for_i = $list_num_startB+$list_count_on_pageB;
			for($i=$list_num_startB; $i < $list_end_for_i; $i++){
				if(isset($arr_count[$i])){$arr12[] = $arr_count[$i];}
			}
		} else { // keyword 검색을 안했을 때
			$sql12 = $sql4." ORDER BY count DESC LIMIT $list_num_startB, $list_count_on_pageB";
			$sql_query12 = mysqli_query($conn, $sql12);
		}
	} else if($count_link==0){
		$count_link_temp = 0;
		$count_link_temp_url = '';
		if(is_int($count4 / $number)){//리스트갯수가 나누어 떨어지면
			$total_list_count = (int) ($count4 / $number);//리스트 갯수
		} else if(!is_int($count4 / $number)){//리스트갯수가 나누어 떨어지지 않으면
			$total_list_count = (int) ($count4 / $number)+1;//리스트 갯수
		}
		$start_number = ( $list_count -1) * $number ;//검색 시작 count
	}
	if(is_int($total_list_count / $list_count_on_page)){//리스트페이지 갯수가 나누어 떨어지면
		$total_list_page_count = (int) ($total_list_count / $list_count_on_page);
	} else if(!is_int($total_list_count / $list_count_on_page)){//리스트페이지 갯수가 나누어 떨어지지 않으면
		$total_list_page_count = (int) ($total_list_count / $list_count_on_page)+1;//리스트페이지 갯수
	}
	$html_list_show_number = '';
	for($j=1, $list_num=$list_num_start; $j<=$list_count_on_page && $list_num<=$total_list_count; $j++, $list_num++){//list_count 부분 출력
		if($list_count != $list_num){//현재 페이지가 아닌경우
			if($count_link != 0){ // 세부목록일 때
				if($keyword != "thereisnokeyword" && $category != "writer"){ // keyword 검색을 했을 때
					if($list_num_start != 1){$count_link_temp = $arr12[$j];}
					else {$count_link_temp = $arr12[$j-1];}
				} else {
					if($count_link != 0){
						if($list_num_start != 1){mysqli_data_seek($sql_query12, $j);}
						else {mysqli_data_seek($sql_query12, $j-1);}
						$row = mysqli_fetch_row($sql_query12);
						$count_link_temp = $row[0];
					}
				}
				if($count_link_temp!=0) {$count_link_temp_url = 'count_link='.$count_link_temp.'&';}
				if(isset($count_link_temp)){$html_list_show_number_temp = '<a href="'.$url.$count_link_temp_url.'list_count='.$list_num.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_number">'. $list_num.'</div></a>';}
				else {$html_list_show_number_temp = '';}
				if($list_num==($list_count-1)){$count_link_go_prev = $count_link_temp;}
				else if($list_num==($list_count+1)){$count_link_go_next = $count_link_temp;}
			} else { // 세부목록이 아닐때
				$html_list_show_number_temp = '<a href="'.$url.'list_count='.$list_num.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_number">'. $list_num.'</div></a>';
			}
		} else if($list_count==$list_num){//현재 페이지에 해당하는 경우
			$html_list_show_number_temp = '<div class="list_show_number list_show_number_selected">'. $list_num.'</div>';
		}
		$html_list_show_number .= $html_list_show_number_temp;
	}
	$html_list_show_left = '<div class="list_show_left"></div>';//초기 설정
	$html_list_show_right = '<div class="list_show_right"></div>';
	if($list_page_count>1){//현재 list_page_count가 1보다 크면 (◀ 관련 setting)
		$list_page_count_prev = $list_page_count-1;
		$list_page_count_prev_last = ($list_page_count-1) * $list_count_on_page;
		if($count_link != 0){ // 세부목록일 때
			if($keyword != "thereisnokeyword" && $category != "writer"){ // keyword 검색을 했을 때
				$count_link_temp = $arr12[0];
			} else {
				if($count_link != 0){
					mysqli_data_seek($sql_query12, 0);
					$row = mysqli_fetch_row($sql_query12);
					$count_link_temp = $row[0];
				}
			}
			if($count_link_temp!=0) {$count_link_temp_url = 'count_link='.$count_link_temp.'&';}
			if(isset($count_link_temp)){$html_list_show_left = '<a href="'.$url.$count_link_temp_url.'list_count='.$list_page_count_prev_last.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_left mouseover">◀</div></a>';}
			else {$html_list_show_left = '';}
			if($list_count==$list_num_start){$count_link_go_prev = $count_link_temp;}
		} else { // 세부목록이 아닐때
			$html_list_show_left = '<a href="'.$url.'list_count='.$list_page_count_prev_last.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_left mouseover">◀</div></a>';
		}
	}
	if($list_page_count < $total_list_page_count){//현재 list_page_count가 끝에 오지 않았으면 (▶ 관련 setting)
		$list_page_count_next = $list_page_count+1;
		$list_page_count_next_first = ($list_page_count) * $list_count_on_page+1;
		if($count_link != 0){ // 세부목록일 때
			if($keyword != "thereisnokeyword" && $category != "writer"){ // keyword 검색을 했을 때
				if($list_num_start != 1){$count_link_temp = $arr12[$list_count_on_page+1];}
				else {$count_link_temp = $arr12[$list_count_on_page];}
			} else {
				if($count_link != 0){
					if($list_num_start != 1){mysqli_data_seek($sql_query12, $list_count_on_page+1);}
					else {mysqli_data_seek($sql_query12, $list_count_on_page);}
					$row = mysqli_fetch_row($sql_query12);
					$count_link_temp = $row[0];
				}
			}
			if($count_link_temp!=0) {$count_link_temp_url = 'count_link='.$count_link_temp.'&';}
			if(isset($count_link_temp)){$html_list_show_right = '<a href="'.$url.$count_link_temp_url.'list_count='.$list_page_count_next_first.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_right mouseover">▶</div></a>';}
			else {$html_list_show_right = '';}
			if($list_count==($list_num_start + $list_count_on_page - 1)){$count_link_go_next = $count_link_temp;}
		} else { // 세부목록이 아닐 때
			$html_list_show_right = '<a href="'.$url.'list_count='.$list_page_count_next_first.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_right mouseover">▶</div></a>';
		}
	}
	$html_list = '<div class="list_show">'.$html_list_show_left.$html_list_show_number.$html_list_show_right.'</div>';
	if(($keyword == "thereisnokeyword" && $category == "thereisnocategory") || ($keyword != "thereisnokeyword" && $category=="writer")){//keyword 검색을 하지 않았을때
		if($count_link != 0){//세부내용보기
			$sql1 = $sql4." AND count=$count_link";
		} else if($count_link==0){//목록보기
			$sql1 = $sql4." ORDER BY count DESC LIMIT $start_number, $number";
		}
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
	} else if($keyword != "thereisnokeyword" && $category != "writer"){//작성자 검색이 아니고 keyword 검색을 했을 때
		if($count_link != 0){//세부내용보기
			$arr10[] = $arr_count[$start_number];
		} else if($count_link==0){//목록보기
			$end_number = $start_number + $number;
			for($i=$start_number; $i<$end_number; $i++){
				if(isset($arr_count[$i])){$arr10[] = $arr_count[$i];}
				else {break;}
			}
		}
		$count1 = count($arr10);
	}
} else {
	$html_list = '';
	$total_list_count = 0;
}
?>