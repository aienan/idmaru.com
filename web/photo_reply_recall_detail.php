<?php
	$table_name_main = $table_name."_main";
	$table_name_delta = $table_name."_delta";
	$table_name_reply = $table_name."_reply";
	$table_name_updown = $table_name."_up";
	$reply_arr_all = array();
	$reply_arr = array();
	$arr11 = array();
	$reply_arr_keyword = array();
	$sql11 = "SELECT * FROM $table_name_reply WHERE user_num=$user_num ORDER BY count DESC";//reply 테이블에서 내가 쓴글을 추출
	$sql_query11 = mysqli_query($conn, $sql11);
	$count11 = mysqli_num_rows($sql_query11);
	for($i=0; $i < $count11; $i++){//count_upperwrite를 목록으로 추출
		$sql_fetch_array11 = mysqli_fetch_array($sql_query11);
		$reply_arr_temp[] = $sql_fetch_array11["count_upperwrite"];
	}
	for($i=0; $i < count($reply_arr_temp); $i++){//count_upperwrite에서 중복된 글을 제거
		$exist = 0;
		for($j=0; $j < count($reply_arr_all); $j++){
			if($reply_arr_all[$j]==$reply_arr_temp[$i]){$exist = 1; break;}
		}
		if($exist==0){$reply_arr_all[]=$reply_arr_temp[$i];}
	}
	for($i=0; $i < count($reply_arr_all); $i++){
		if($gallery_type=="all"){$sql12 = "SELECT * FROM $table_name WHERE count=$reply_arr_all[$i] AND user_num != $user_num AND status != '3'";}
		else{$sql12 = "SELECT * FROM $table_name WHERE count=$reply_arr_all[$i] AND user_num != $user_num AND status != '3' AND type=$type";}
		$sql_query12 = mysqli_query($conn, $sql12);
		$count12 = mysqli_num_rows($sql_query12);
		if($count12){
			$sql_fetch_array12 = mysqli_fetch_array($sql_query12);
			if($sql_fetch_array12["status"]==1){$reply_arr[] = $reply_arr_all[$i];}
			else if($sql_fetch_array12["status"]==2){
				$sql13 = "SELECT * FROM friend WHERE user_num = $user_num AND friend_num = $sql_fetch_array12[user_num]";
				$sql_query13 = mysqli_query($conn, $sql13);
				$count13 = mysqli_num_rows($sql_query13);
				if($count13==1){$reply_arr[] = $reply_arr_all[$i];}
			}
		}
	}
	if($keyword != "thereisnokeyword" && $category=="writer"){//키워드 검색이 작성자일경우
		$keyword = strip_space($keyword);
		$sql9 = "SELECT * FROM user WHERE user_name='$keyword'";
		$sql_query9 = mysqli_query($conn, $sql9);
		$sql_fetch_array9 = mysqli_fetch_array($sql_query9);
		for($i=0; $i < count($reply_arr); $i++){
			if($gallery_type=="all"){$sql15 = "SELECT * FROM $table_name WHERE count=$reply_arr[$i] AND user_num=$sql_fetch_array9[user_num] AND status != '3'";}
			else{$sql15 = "SELECT * FROM $table_name WHERE count=$reply_arr[$i] AND user_num=$sql_fetch_array9[user_num] AND status != '3' AND type=$type";}
			$sql_query15 = mysqli_query($conn, $sql15);
			$count15 = mysqli_num_rows($sql_query15);
			if($count15==1){$reply_arr_writer[]=$reply_arr[$i];}
		}
		$reply_arr = $reply_arr_writer;
		$count4 = count($reply_arr);
		
	} else if($keyword=="thereisnokeyword" && $category=="thereisnocategory"){//keyword 검색을 하지 않았을 때
		$count4 = count($reply_arr);
		
	} else if($keyword != "thereisnokeyword" && $category != "writer"){//작성자 검색이 아니고 keyword 검색을 했을 때
		$sphinx->SetFilter("status", array(3), true );//비공개 글을 제외
		if($gallery_type=="all"){}
		else{$sphinx->SetFilter("type", array($type));}
		$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
		$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
		foreach($search["matches"] as $key => $value){//검색물 count 정보 추출
			$arr11[] = $key;
		}
		for($i=0; $i < count($reply_arr); $i++){
			$exist = 0;
			for($j=0; $j < count($arr11); $j++){
				if($reply_arr[$i]==$arr11[$j]){$exist=1; break;}
			}
			if($exist==1){$reply_arr_keyword[]=$reply_arr[$i];}
		}
		$reply_arr = $reply_arr_keyword;
		$count4 = count($reply_arr);
		
	}
	
	if($count4){
		include 'reply_recall_detailB.php';
		if($keyword != "thereisnokeyword" && $category=="writer"){//키워드 검색이 작성자일경우
			if($count_link != 0){
				$sql1 = "SELECT * FROM $table_name WHERE count=$reply_arr[$start_number]";
				$sql_query1 = mysqli_query($conn, $sql1);
				$count1 = mysqli_num_rows($sql_query1);
			}else if($count_link==0){$count1 = $count4 - $start_number; if($count1 > $number) {$count1 = $number;}}
			
		} else if($keyword=="thereisnokeyword" && $category=="thereisnocategory"){//keyword 검색을 하지 않았을 때
			if($count_link != 0){
				$sql1 = "SELECT * FROM $table_name WHERE count=$reply_arr[$start_number]";
				$sql_query1 = mysqli_query($conn, $sql1);
				$count1 = mysqli_num_rows($sql_query1);
			}else if($count_link==0){$count1 = $count4 - $start_number; if($count1 > $number) {$count1 = $number;}}
		} else if($keyword != "thereisnokeyword" && $category != "writer"){//작성자 검색이 아니고 keyword 검색을 했을 때
			if($count_link != 0){
				$sql1 = "SELECT * FROM $table_name WHERE count=$reply_arr[$start_number]";
				$sql_query1 = mysqli_query($conn, $sql1);
				$count1 = mysqli_num_rows($sql_query1);
			}else if($count_link==0){$count1 = $count4 - $start_number; if($count1 > $number) {$count1 = $number;}}
		}
	} else {
		$count1=0;
		$html_list = '';
		$total_list_count = 0;
	}
?>