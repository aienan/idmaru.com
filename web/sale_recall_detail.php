<?php
	$table_name_main = $table_name."_main";
	$table_name_delta = $table_name."_delta";
	$table_name_reply = $table_name."_reply";
	if($status==4){//전체보기일 경우
		if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 때
			if($selling_type=="all"){$sql4 = "SELECT * FROM $table_name WHERE user_num=$user_num";}//list_show를 만들기 위해
			else {$sql4 = "SELECT * FROM $table_name WHERE user_num=$user_num AND type=$type";}
		} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
			$sphinx->SetFilter("user_num", array($user_num) );
			if($selling_type=="all"){}
			else{$sphinx->SetFilter("type", array($type));}
			$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
			$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
		}
	} else if($status!=4){//전체보기가 아닐 때
		if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 때
			if($selling_type=="all"){$sql4 = "SELECT * FROM $table_name WHERE user_num=$user_num AND status='$status'";}//list_show를 만들기 위해
			else {$sql4 = "SELECT * FROM $table_name WHERE user_num=$user_num AND status='$status' AND type=$type";}
		} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
			$sphinx->SetFilter("user_num", array($user_num) );
			$sphinx->SetFilter("status", array($status) );
			if($selling_type=="all"){}
			else{$sphinx->SetFilter("type", array($type));}
			$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
			$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
		}
	}
	if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을경우
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);//list에 count된 총 갯수
	} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
		$count4 = $search["total_found"];
	}
	if($count4 != 0){//위에서 결과물이 있었을경우
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
			$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
			if($count_link != 0){
				$sphinx->SetLimits($start_number, 1);
			}else if($count_link==0){
				$sphinx->SetLimits($start_number, $number);//$start_number 번호를 시작으로 $number 갯수만큼 검색
			}
			$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
			foreach($search["matches"] as $key => $value){//검색물 count 정보 추출
				$arr10[] = $key;
			}
			$count1 = count($search["matches"]);//검색물 갯수
		}
	} else {
		$count1=0;
		$html_list = '';
		$total_list_count = 0;
	}
?>