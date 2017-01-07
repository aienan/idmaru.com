<?php
	include 'header.php';
	include 'declare_php.php';
	$type_name = "group";
	$count_start = $_REQUEST["count_start"];
	$display_number = $_REQUEST["display_number"];
	$group_initial = $_REQUEST["group_initial"];
	$keyword = $_REQUEST["keyword"];
	$category = $_REQUEST["category"];
	if($category=="all_content"){
		$search_field = "group_name,description";
	} else if($category=="founder"){
		$search_field=="user_name";
	} else if($category=="group_name"){
		$search_field = "group_name";
	} else if($category=="description"){
		$search_field = "description";
	}
	$table_name = "club_group";
	$table_name_main = $table_name."_main";
	$table_name_delta = $table_name."_delta";
	$order_column = "member";
	if($keyword != "thereisnokeyword" && $category=="founder"){//키워드 검색이 작성자일경우
		$sql9 = "SELECT * FROM user WHERE user_name='$keyword'";
		$sql_query9 = mysqli_query($conn, $sql9);
		$sql_fetch_array9 = mysqli_fetch_array($sql_query9);
		$sql4 = "SELECT * FROM $table_name WHERE user_num=$sql_fetch_array9[user_num] AND status='1' ORDER BY $order_column DESC LIMIT $count_start, $display_number";
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);
	} else if($keyword=="thereisnokeyword" && $category=="thereisnocategory"){//keyword 검색을 하지 않았을 때
		$sql4 = "SELECT * FROM $table_name WHERE status='1' ORDER BY $order_column DESC LIMIT $count_start, $display_number";
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);
	} else if($keyword != "thereisnokeyword" && $category != "founder"){//작성자 검색이 아니고 keyword 검색을 했을 때
		$sphinx->SetFilter("status", array(1));
		$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
		$sphinx->SetLimits($count_start, $display_number);//$count_start를 시작으로 $display_number 갯수만큼 검색
		$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
		foreach($search["matches"] as $key => $value){//검색물 count 정보 추출
			$arr10[] = $key;
		}
		$count4 = count($search["matches"]);//검색물 갯수
	}
	$output = '<div class="content_area">';
	if($group_initial==1){
		if($count4 != 0){
			$output .= '
				<div id="list_head" style="border-top:#0776CD solid 2px; border-bottom:#0776CD solid 2px;">
					<div id="club_group_list_founder">모&nbsp;임&nbsp;장</div>
					<div id="club_group_list_title">모&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;임</div>
					<div id="club_group_list_status">회원수</div>
				</div>
			';
		} else if($count4==0){
			$output .= '<div class="empty_list">등록된 모임이 없습니다</div>';
		}
	}
	for($i=0; $i<$count4; $i++){//검색결과 출력
		$count_number = $count_start + $i;
		if(($keyword == "thereisnokeyword" && $category == "thereisnocategory") || ($keyword != "thereisnokeyword" && $category=="founder")){//keyword 검색을 하지 않았거나 작성자 검색일 경우
			$sql_fetch_array4 = mysqli_fetch_array($sql_query4);
		} else if($keyword != "thereisnokeyword" && $category != "founder"){//작성자 검색이 아니고 keyword 검색을 했을 때
			$sql11 = "SELECT * FROM $table_name WHERE count_group = $arr10[$i]";
			$sql_query11 = mysqli_query($conn, $sql11);
			$sql_fetch_array4 = mysqli_fetch_array($sql_query11);
		}
		$sql2 = "SELECT * FROM user WHERE user_num = $sql_fetch_array4[user_num]";//모임장의 아이디를 알아본다
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$html = '
			<div id="club_group_area_article'.$sql_fetch_array4["count_group"].'" class="writing_area_article">
				<div class="club_group_founder">'.$sql_fetch_array2["id"].'</div>
				<div class="club_title_group">'.$sql_fetch_array4["group_name"].'</div>
				<div class="club_status_group">'.$sql_fetch_array4["member"].'</div>
			</div>
			<script>
				var height = $(".club_title_group").height();
				$("#club_group_area_article'.$sql_fetch_array4["count_group"].'").height(height+10);
				$("#club_group_area_article'.$sql_fetch_array4["count_group"].' .club_group_founder").height(height);
				$("#club_group_area_article'.$sql_fetch_array4["count_group"].' .club_status_group").height(height);
				$("#club_group_area_article'.$sql_fetch_array4["count_group"].' > .club_title_group").click(function(){
					window.open("'.$type_name.'_recall_one.php?count_group='.$sql_fetch_array4["count_group"].'&order_column='.$order_column.'&count_number='.$count_number.'&status=1&keyword='.$keyword.'&category='.$category.'", "'.$type_name.'_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
				});
			</script>
		';
		$output .= $html;
	}
	if($count4==$display_number){//아직 검색할 글이 더 남아있는경우
		$count_start_new = $count_start+$display_number;
		$output .= '
			<div id="article_more" class="mouseover" style="float:none;">더 보 기</div>
			<script>
				$("#article_more").click(function(){
					$("#'.$type_name.'_article_area").after("<div id=\"loading_more\" class=\"loading48x48\" style=\"left:340px;\"></div>");
					$(this).remove();
					var count_start = '.$count_start_new.';
					var display_number = '.$display_number.';
					var group_initial = 0;
					$.ajax({
						url:"event_group_recall.php",
						data: {count_start:count_start, display_number:display_number, group_initial:group_initial},
						success: function(getdata){
							$("#'.$type_name.'_article_area").append(getdata);
							$("#loading_more").remove();
						}
					});
				});
			</script>
		';
	}
	$output .= '</div>'; // writing_list div를 닫음
	echo $output;//결과물과 list를 함께 출력
?>