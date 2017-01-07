<?php
	include 'header.php';
	include 'declare_php.php';
	$count_start = $_REQUEST["count_start"];//글 시작 번호
	$display_number = $_REQUEST["display_number"];//글 검색 갯수
	$height_total = $_REQUEST["height_total"];//article_area 높이
	$width_total = $_REQUEST["width_total"];
	$order_column = $_REQUEST["order_column"];
	$news_type = $_REQUEST["news_type"];
	if($news_type=="all"){}
	else {$type = news_type_num($news_type);}
	$height_total_initial = $height_total;//0일경우 맨 위에서 시작
	$type_name = "news";
	$table_name = "writing";
	$table_name_read_counter = $table_name."_read_counter";
	if($height_total_initial == 0){$display_number -= 2;} // 맨 처음 나오는 글 갯수를 조절한다
	if($order_column=="updown_total"){//추천순 정렬일 경우
		$order_table_name = $table_name;
		$element_name = $type_name."_updown";
	} else if($order_column=="read_count_1"){
		$order_table_name = $table_name_read_counter;
		$element_name = $type_name."_1count";
	} else if($order_column=="read_count_7"){
		$order_table_name = $table_name_read_counter;
		$element_name = $type_name."_7count";
	} else if($order_column=="read_count_30"){
		$order_table_name = $table_name_read_counter;
		$element_name = $type_name."_30count";
	}
	$border = 3 * 2; //border를 3px로 설정
	if($news_type != "all"){$sql1 = "SELECT * FROM $order_table_name WHERE status='1' AND type=$type ORDER BY $order_column DESC, count DESC LIMIT $count_start, $display_number";}//모두에게 공개된 글을 조회순으로 정렬한다
	else{$sql1 = "SELECT * FROM $order_table_name WHERE status='1' ORDER BY $order_column DESC, count DESC LIMIT $count_start, $display_number";}
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$output = '';
	if(!$count1 && $height_total_initial==0){//글이 없을경우
		$output .= '
			<div class="empty_list">작성된 글이 없습니다</div>
			<script>$("#'.$type_name.'_article_area").height($(".empty_list").height()+30);</script>
		';
	} else if($count1){//글이 있는경우
		for($i=0; $i < $count1; $i++){
			$count_number = $count_start + $i;
			if($height_total_initial==0){//맨 처음일경우
				if($i < 6){
					$width=235 - $border; $height=200; $height_img=100;
					if ( $i % 3 == 0 ) { $style_tag = 'margin:5px 5px 5px 0;'; $space_width = 5 + $border; $space_height = 10 + $border;}
					else if ( $i % 3 == 2 ) { $style_tag = 'margin:5px 0 5px 5px;'; $space_width = 5 + $border; $space_height = 10 + $border;}
					else { $style_tag = 'margin:5px;'; $space_width = 10 + $border; $space_height = 10 + $border;}
					if( $i == 0 ) { $height_total += $height + $space_height; } // 맨 처음에 높이를 맞춰준다
				}
				else {
					$width=175 - $border; $height=140; $height_img=70;
					if ( ($i-6) % 4 == 0 ) { $style_tag = 'margin:4px 4px 4px 0;'; $space_width = 4 + $border; $space_height = 8 + $border;}
					else if ( ($i-6) % 4 == 3 ) { $style_tag = 'margin:4px 0 4px 5px;'; $space_width = 5 + $border; $space_height = 8 + $border;}
					else { $style_tag = 'margin:4px;'; $space_width = 8 + $border; $space_height = 8 + $border;}
				}
			} else {
				$width=175 - $border; $height=140; $height_img=70;
				if ( $i % 4 == 0 ) { $style_tag = 'margin:4px 4px 4px 0;'; $space_width = 4 + $border; $space_height = 8 + $border;}
				else if ( $i % 4 == 3 ) { $style_tag = 'margin:4px 0 4px 5px;'; $space_width = 5 + $border; $space_height = 8 + $border;}
				else { $style_tag = 'margin:4px;'; $space_width = 8 + $border; $space_height = 8 + $border;}
			}
			$width_total += $width + $space_width;
			if(($width_total / 725)>1){//다음줄로 넘어가야 할 경우
				$width_total = $width + $space_width;
				$height_total += $height + $space_height;
			}
			$html = '';
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$sql2 = "SELECT * FROM $table_name WHERE count=$sql_fetch_array1[count]";//글쓰기 테이블에서 정렬된 글순서대로 글을 검색한다
			$sql_query2 = mysqli_query($conn, $sql2);
			$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
			$content = tile_content($sql_fetch_array2["content"]);//각종 태그를 변환한다
			$first_img = find_first_img($sql_fetch_array2["content"], 0, $height_img);//글안에 있는 첫번째 그림파일을 얻는다
			$html .= '
				<div id="'.$element_name.'_'.$sql_fetch_array1["count"].'" class="'.$type_name.'_article" style="width:'.$width.'px; height:'.$height.'px; '.$style_tag.'">
					<div class="'.$type_name.'_title">'.$sql_fetch_array2["title"].'</div>
			';
			if($first_img){//글 안에 이미지가 있을경우
				$html .= '
					<div class="first_img">'.$first_img.'</div>
				';
			}
			$html .= '
					<div class="'.$type_name.'_content">'.$content.'</div>
				</div>
				<script>
					$("#'.$element_name.'_'.$sql_fetch_array1["count"].'").click(function(){
						window.open("'.$type_name.'_recall_one.php?count='.$sql_fetch_array1["count"].'&order_column='.$order_column.'&count_number='.$count_number.'&news_type='.$news_type.'", "'.$type_name.'_recall_one", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no");
					});
				</script>
			';
			$output .= $html;
		}
		if($count1==$display_number){//아직 검색할 글이 더 남아있는경우
			$count_start_new = $count_start+$display_number;
			$output .= '
				<div id="article_more">더 보 기</div>
				<script>
					$("#article_more").click(function(){
						$("#'.$type_name.'_article_area").after("<div id=\"loading_more\" class=\"loading48x48\" style=\"left:340px;\"></div>");
						$(this).remove();
						var count_start = '.$count_start_new.';
						var height_total = $("#'.$type_name.'_article_area").height();
						var width_total = '.$width_total.';
						$.ajax({
							url:"news_common_order_recall.php",
							data: {count_start:count_start, display_number:display_number, height_total:height_total, width_total:width_total, order_column:order_column, news_type:news_type},
							success: function(getdata){
								$("#'.$type_name.'_article_area").append(getdata);
								$("#loading_more").remove();
							}
						});
					});
				</script>
			';
			if($height_total_initial == 0){$height_total += 58;}//처음에만 더보기 높이를 더해줌
		}
		$output .= '
			<script>$("#'.$type_name.'_article_area").height('.$height_total.');</script>
		';
	}
	echo $output;
	
?>