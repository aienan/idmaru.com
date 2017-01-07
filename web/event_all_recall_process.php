<?php
	$table_name_main = $table_name."_main";
	$table_name_delta = $table_name."_delta";
	$table_name_reply = $table_name."_reply";
	$table_name_updown = $table_name."_up";
	$status_num = $status;
	if($status==4){//전체보기일 경우
		if($keyword=="thereisnokeyword" && $category=="thereisnocategory"){//keyword 검색을 하지 않았을 때
			$sql4 = "SELECT * FROM $table_name";
		} else if($keyword != "thereisnokeyword" && $category=="writer"){//키워드 검색이 작성자일경우
			$keyword = strip_space($keyword);
			$sql9 = "SELECT * FROM user WHERE user_name='$keyword'";
			$sql_query9 = mysqli_query($conn, $sql9);
			$sql_fetch_array9 = mysqli_fetch_array($sql_query9);
			$sql4 = "SELECT * FROM $table_name WHERE user_num=$sql_fetch_array9[user_num]";
		} else if($keyword != "thereisnokeyword" && $category != "writer"){//작성자 검색이 아니고 keyword 검색을 했을 때
			$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
			$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
		}
	} else if($status!=4){//전체보기가 아닐 때
		if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 때
			$sql4 = "SELECT * FROM $table_name WHERE status='$status'";//list_show를 만들기 위해
		} else if($keyword != "thereisnokeyword" && $category=="writer"){//키워드 검색이 작성자일경우
			$keyword = strip_space($keyword);
			$sql9 = "SELECT * FROM user WHERE user_name='$keyword'";
			$sql_query9 = mysqli_query($conn, $sql9);
			$sql_fetch_array9 = mysqli_fetch_array($sql_query9);
			$sql4 = "SELECT * FROM $table_name WHERE user_num=$sql_fetch_array9[user_num] AND status='$status'";
		} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
			$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
			$sphinx->SetFilter("status", array($status));
			$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
		}
	}
	if(($keyword == "thereisnokeyword" && $category == "thereisnocategory") || ($keyword != "thereisnokeyword" && $category=="writer")){//keyword 검색을 하지 않았거나 작성자 검색일 경우
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);//list에 count된 총 갯수
	} else if($keyword != "thereisnokeyword" && $category != "writer"){//작성자 검색이 아니고 keyword 검색을 했을 때
		$count4 = $search["total_found"];
	}
	if($count4 != 0){
		include 'recall_detailB.php';
		if(($keyword == "thereisnokeyword" && $category == "thereisnocategory") || ($keyword != "thereisnokeyword" && $category=="writer")){//keyword 검색을 하지 않았거나 작성자 검색일 경우
			if($count_link != 0){
				if($keyword=="thereisnokeyword" && $category=="thereisnocategory"){//keyword 검색을 하지 않았을 때
					$sql1 = $sql4." WHERE count=$count_link";//쓴 글 검색
				} else if($keyword != "thereisnokeyword" && $category=="writer"){//키워드 검색이 작성자일경우
					$sql1 = $sql4." AND count=$count_link";//쓴 글 검색
				}
			} else if($count_link==0){
				$sql1 = $sql4." ORDER BY count DESC LIMIT $start_number, $number";//쓴 글 검색
			}
			$sql_query1 = mysqli_query($conn, $sql1);
			$count1 = mysqli_num_rows($sql_query1);
		} else if($keyword != "thereisnokeyword" && $category != "writer"){//작성자 검색이 아니고 keyword 검색을 했을 때
			$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
			if($count_link != 0){//세부목록일경우
				$sphinx->SetLimits($start_number, 1);
			}else if($count_link==0){//세부목록이 아닐경우
				$sphinx->SetLimits($start_number, $number);//$start_number 번호를 시작으로 $number 갯수만큼 검색
			}
			if($category=="all_content" || $category=="title" || $category=="content"){
				$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
			}
			foreach($search["matches"] as $key => $value){//검색물 count 정보 추출
				$arr10[] = $key;
			}
			$count1 = count($search["matches"]);//검색물 갯수
		}
	} else {
		$count1 = 0;
		$html_list = '';
		$total_list_count = 0;
	}
?>