<?php
	if($table_name=='writing'){
		$extra_post = '&news_type='.$news_type;
	} else if($table_name=='photo'){
		$extra_post = '&gallery_type='.$gallery_type;
	} else if($table_name=='sale'){
		$extra_post = '&selling_type='.$selling_type;
		$status_sql = "";
	} else if($table_name=='club_event'){
		$extra_post = '';
	}
	if($outer_link==1){ // 외부링크로 들어왔을 때
		if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았거나 작성자 검색일 경우
			$sql14 = $sql4." AND count>$count_link";//쓴 글 검색
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
	if($count_link != 0){//세부목록일때
		$total_list_count = (int)($count4);//리스트 갯수
		$start_number = ( $list_count -1);//검색 시작 count
		$list_end_for_i = $list_num_startB+$list_count_on_pageB;
		for($i=$list_num_startB; $i < $list_end_for_i; $i++){
			if(isset($reply_arr[$i])){$arr12[] = $reply_arr[$i];}
		}
	} else if($count_link==0){//세부목록이 아닐때
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
				if($list_num_start != 1){$count_link_temp = $arr12[$j];}
				else {$count_link_temp = $arr12[$j-1];}
				if($count_link_temp!=0) {$count_link_temp_url = 'count_link='.$count_link_temp.'&';}
				if(isset($count_link_temp)){$html_list_show_number_temp = '<a href="'.$url.$count_link_temp_url.'list_count='.$list_num.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_number">'. $list_num.'</div></a>';}
				else {$html_list_show_number_temp = '';}
				if($count_link != 0){ // 세부목록일 때
					if($list_num==($list_count-1)){$count_link_go_prev = $count_link_temp;}
					else if($list_num==($list_count+1)){$count_link_go_next = $count_link_temp;}
				}
			} else { // 세부목록이 아닐때
				$html_list_show_number_temp = '<a href="'.$url.'list_count='.$list_num.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_number">'. $list_num.'</div></a>';
			}
		} else if($list_count == $list_num){//현재 페이지에 해당하는 경우
			$html_list_show_number_temp = '<div class="list_show_number list_show_number_selected">'. $list_num.'</div>';
		}
		$html_list_show_number .= $html_list_show_number_temp;
	}
	$html_list_show_left = '<div class="list_show_left"></div>';//초기 설정
	$html_list_show_right = '<div class="list_show_right"></div>';
	if($list_page_count>1){//현재 list_page_count가 1보다 크면
		$list_page_count_prev = $list_page_count-1;
		$list_page_count_prev_last = ($list_page_count-1) * $list_count_on_page;
		if($count_link != 0){ // 세부목록일 때
			$count_link_temp = $arr12[0];
			if($count_link_temp!=0) {$count_link_temp_url = 'count_link='.$count_link_temp.'&';}
			if(isset($count_link_temp)){$html_list_show_left = '<a href="'.$url.$count_link_temp_url.'list_count='.$list_page_count_prev_last.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_left mouseover">◀</div></a>';}
			else {$html_list_show_left = '';}
			if($list_count==$list_num_start){$count_link_go_prev = $count_link_temp;}
		} else { // 세부목록이 아닐때
			$html_list_show_left = '<a href="'.$url.'list_count='.$list_page_count_prev_last.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_left mouseover">◀</div></a>';
		}
	}
	if($list_page_count < $total_list_page_count){//현재 list_page_count가 끝에 오지 않았으면
		$list_page_count_next = $list_page_count+1;
		$list_page_count_next_first = ($list_page_count) * $list_count_on_page+1;
		if($count_link != 0){ // 세부목록일 때
			if($list_num_start != 1){$count_link_temp = $arr12[$list_count_on_page+1];}
			else {$count_link_temp = $arr12[$list_count_on_page];}
			if($count_link_temp!=0) {$count_link_temp_url = 'count_link='.$count_link_temp.'&';}
			if(isset($count_link_temp)){$html_list_show_right = '<a href="'.$url.$count_link_temp_url.'list_count='.$list_page_count_next_first.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_right mouseover">▶</div></a>';}
			else {$html_list_show_right = '';}
			if($list_count==($list_num_start + $list_count_on_page - 1)){$count_link_go_next = $count_link_temp;}
		} else { // 세부목록이 아닐 때
			$html_list_show_right = '<a href="'.$url.'list_count='.$list_page_count_next_first.$number_url.$keyword_url.$category_url.$extra_post.'" class="inline"><div class="list_show_right mouseover">▶</div></a>';
		}
	}
	$html_list = '<div class="list_show">'.$html_list_show_left.$html_list_show_number.$html_list_show_right.'</div>';
?>