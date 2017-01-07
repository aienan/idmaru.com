<?php
	$extra_post = '';
	$status_sql = "";
	if($start_count != 0){//세부목록일때
		$total_list_count = (int)($count4);//리스트 갯수
		$start_number = ( $start_count -1);//검색 시작 count
		if(is_int($start_count / $list_count_on_page)){//나누어 떨어질 경우
			$list_page_count = (int)($start_count / $list_count_on_page);
		} else if(!is_int($start_count / $list_count_on_page)){
			$list_page_count = (int)($start_count / $list_count_on_page)+1;
		}
		$list_count = $start_count;
	} else if($start_count==0){//세부목록이 아닐때
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
	for($j=1, $list_num=($list_page_count-1) * $list_count_on_page +1; $list_num<=$total_list_count && $j<=$list_count_on_page; $j++, $list_num++){//list_count 부분 출력
		if($list_count != $list_num){//현재 페이지가 아닌경우
			if($start_count != 0){$html_list_show_number_temp = '<a href="'.$url.'start_count='.$list_num.'&list_count='.$list_num.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'" class="inline"><div class="list_show_number">'. $list_num.'</div></a>';}
			else if($start_count==0){$html_list_show_number_temp = '<a href="'.$url.'list_count='.$list_num.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'" class="inline"><div class="list_show_number">'. $list_num.'</div></a>';}
		} else if($list_count == $list_num){//현재 페이지에 해당하는 경우
			$html_list_show_number_temp = '<div class="list_show_number list_show_number_selected">'. $list_num.'</div>';
		}
		$html_list_show_number .= $html_list_show_number_temp;
	}
	$html_list_show_left = '<div class="list_show_left"></div>';//초기 설정
	$html_list_show_right = '<div class="list_show_right"></div>';
	if($list_page_count>1){//현재 list_page_count가 1보다 크면 (◀ 관련 setting)
		$list_page_count_prev = $list_page_count-1;
		$list_page_count_prev_last = ($list_page_count-1) * $list_count_on_page;
		$html_list_show_left = '<a href="'.$url.'start_count='.$list_page_count_prev_last.'&list_count='.$list_page_count_prev_last.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'" class="inline"><div class="list_show_left mouseover">◀</div></a>';
	}
	if($list_page_count < $total_list_page_count){//현재 list_page_count가 끝에 오지 않았으면 (▶ 관련 setting)
		$list_page_count_next = $list_page_count+1;
		$list_page_count_next_first = ($list_page_count) * $list_count_on_page+1;
		$html_list_show_right = '<a href="'.$url.'start_count='.$list_page_count_next_first.'&list_count='.$list_page_count_next_first.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'" class="inline"><div class="list_show_right mouseover">▶</div></a>';
	}
	$html_list = '<div class="list_show">'.$html_list_show_left.$html_list_show_number.$html_list_show_right.'</div>';
?>