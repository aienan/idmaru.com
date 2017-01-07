<?php
	// 이전, 다음, 목록 버튼을 삽입하는 내용 (갤러리는 갤러리 파일에 삽입됨)
	// 링크 주소에 붙는 parameter가 맞는지 주의!
	if($list_count==0){ // 외부링크일 경우
		$list_go_back_list_count = 1;
	} else if(is_int($list_count / $number)){//리스트 갯수가 나누어 떨어지면
		$list_go_back_list_count = (int) ($list_count / $number);//리스트 갯수
	} else if(!is_int($list_count / $number)){//리스트 갯수가 나누어 떨어지지 않으면
		$list_go_back_list_count = (int) ($list_count / $number) + 1;//리스트 갯수
	}
	$list_count_prev = $list_count - 1;
	$list_count_next = $list_count + 1;
	$output = '';
	if($table_name=="writing"){$extra_post = '&news_type='.$news_type;}
	else if($table_name=="photo"){$extra_post = '&gallery_type='.$gallery_type;}
	else if($table_name=="sale"){$extra_post = '&selling_type='.$selling_type;}
	else if($table_name=="club_event"){$extra_post = '';}
	else if($table_name=="club_group_writing"){$extra_post = '';}
	else if($table_name=="about_question"){$extra_post = '';}
	else {$extra_post = '';}
	$list_show = '.list_show'; // .list_show   .list_show:eq(0)
	$output .= '<script>';
	if($table_name=="photo"){
		if($count_link != 0){//세부 목록 내용에서
			$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_go_back_list_count.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="list_go_back"></div></a>\');';
			if($list_count != 1 && $list_count != 0){//list_count가 처음이 아닐 경우
				$output .= '
					go_prev_arrow();
					$("#go_prev").click(function(){
						location.href = "'.$url.'count_link='.$count_link_go_prev.'&list_count='.$list_count_prev.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'";
					});
				';
			}
			if($list_count != $total_list_count && $list_count != 0){//list_count가 끝이 아닐 경우
				$output .= '
					go_next_arrow();
					$("#go_next").click(function(){
						location.href = "'.$url.'count_link='.$count_link_go_next.'&list_count='.$list_count_next.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'";
					});
				';
			}
		} else if($count_link==0){//사진 목록을 출력할 경우
			if($list_count != 1){//list_count가 처음이 아닐 경우
				$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_count_prev.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_prev_list"></div></a>\');';
			}
			if($list_count != $total_list_count){//list_count가 끝이 아닐 경우
				$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_count_next.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_next_list"></div></a>\');';
			}
		}
	} else if($table_name=="guest"){ // 방명록에서
		$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_go_back_list_count.$number_url.$keyword_url.$category_url.$status_url.'"><div class="list_go_back"></div></a>\');';
		if($list_count != 1){//list_count가 처음이 아닐 경우 (이전 버튼)
			$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_count_prev.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_prev_list"></div></a>\');';
		}
		if($list_count != $total_list_count){//list_count가 끝이 아닐 경우 (다음 버튼)
			$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_count_next.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_next_list"></div></a>\');';
		}
	} else {
		if($count_link != 0){//세부 목록 내용에서
			$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_go_back_list_count.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="list_go_back"></div></a>\');'; // 목록 버튼
			if($list_count != 1 && $list_count != 0){//list_count가 처음이 아닐 경우 (이전 버튼)
				$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'count_link='.$count_link_go_prev.'&list_count='.$list_count_prev.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_prev_list"></div></a>\');';
			}
			if($list_count != $total_list_count && $list_count != 0){//list_count가 끝이 아닐 경우 (다음 버튼)
				$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'count_link='.$count_link_go_next.'&list_count='.$list_count_next.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_next_list"></div></a>\');';
			}
		} else if($count_link==0){// 세부 목록이 아닐때
			if($list_count != 1){//list_count가 처음이 아닐 경우 (이전 버튼)
				$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_count_prev.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_prev_list"></div></a>\');';
			}
			if($list_count != $total_list_count){//list_count가 끝이 아닐 경우 (다음 버튼)
				$output .= '$("'.$list_show.'").append(\'<a href="'.$url.'list_count='.$list_count_next.$number_url.$keyword_url.$category_url.$status_url.$extra_post.'"><div class="go_next_list"></div></a>\');';
			}
		}
	}
	$output .= '</script>';
	echo $output;
?>