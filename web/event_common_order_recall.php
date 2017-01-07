<?php
include 'header.php';
include 'declare_php.php';
$count_start = $_REQUEST["count_start"];//글 시작 번호
$display_number = $_REQUEST["display_number"];//글 검색 갯수
$height_total = $_REQUEST["height_total"];//article_area 높이
$width_total = $_REQUEST["width_total"];
$status = $_REQUEST["status"]; // 이벤트 종류
$order_column = $_REQUEST["order_column"];
$start_time_y = $_REQUEST["start_time_y"];
$start_time_m = $_REQUEST["start_time_m"];
$start_time_d = $_REQUEST["start_time_d"];
$end_time_y = $_REQUEST["end_time_y"];
$end_time_m = $_REQUEST["end_time_m"];
$end_time_d = $_REQUEST["end_time_d"];
if(!$_REQUEST["start_time_y"]){//시작년도가 입력되지 않았을경우
	$start_time_y_num = 0;
} else {$start_time_y_num = $start_time_y;}
if(!$_REQUEST["start_time_y"] || !$_REQUEST["start_time_m"]){//시작년월이 입력되지 않았을경우
	$start_time_m_num = 0;
} else {$start_time_m_num = $start_time_m;}
if(!$_REQUEST["start_time_y"] || !$_REQUEST["start_time_m"] || !$_REQUEST["start_time_d"]){//시작년월일이 입력되지 않았을경우
	$start_time_d_num = 0;
} else {$start_time_d_num = $start_time_d;}
if(!$_REQUEST["end_time_y"]){//종료년도가 입력되지 않았을경우
	$end_time_y_num = 9999;
} else {$end_time_y_num = $end_time_y;}
if(!$_REQUEST["end_time_y"] || !$_REQUEST["end_time_m"]){//종료년월이 입력되지 않았을경우
	$end_time_m_num = 13;
} else {$end_time_m_num = $end_time_m;}
if(!$_REQUEST["end_time_y"] || !$_REQUEST["end_time_m"] || !$_REQUEST["end_time_d"]){//종료년월일이 입력되지 않았을경우
	$end_time_d_num = 32;
} else {$end_time_d_num = $end_time_d;}
$height_total_initial = $height_total;//0일경우 맨 위에서 시작
$type_name = "event";
$table_name = "club_event";
if($height_total_initial == 0){$display_number -= 2;}
if($order_column=="up_total"){//추천순 정렬일 경우
	$element_name = $type_name."_updown";
} else if($order_column=="read_count"){
	$element_name = $type_name."_read_count";
} else if($order_column=="count"){
	$element_name = $type_name."_count";
}
$border = 3 * 2; //border를 3px로 설정
$padding = 10 * 2; //padding을 10px로 설정
if($status==4){//전체보기일경우
	$extra_sql2 = "";
} else {//전체보기가 아닐경우
	$extra_sql2 = "status='$status' AND ";
}
if($order_column=="count"){//등록순 정렬일경우
	$extra_sql = "";
} else{//등록순 정렬이 아닐경우
	$extra_sql = ", count DESC";
}
$sql1 = "SELECT * FROM $table_name WHERE ".$extra_sql2."( (start_time_y='') OR (start_time_y<$end_time_y_num) OR (start_time_y=$end_time_y_num AND ( (start_time_m='') OR (start_time_m<$end_time_m_num) OR (start_time_m=$end_time_m_num AND ( (start_time_d='') OR (start_time_d<=$end_time_d_num) ) ) ) ) ) AND ( (end_time_y='') OR (end_time_y>$start_time_y_num) OR (end_time_y=$start_time_y_num AND ( (end_time_m='') OR (end_time_m>$start_time_m_num) OR (end_time_m=$start_time_m_num AND ( (end_time_d='') OR (end_time_d>=$start_time_d_num) ) ) ) ) ) ORDER BY $order_column DESC".$extra_sql." LIMIT $count_start, $display_number";
$sql_query1 = mysqli_query($conn, $sql1);
$count1 = mysqli_num_rows($sql_query1);
$output = '';
if(!$count1 && $height_total_initial==0){//글이 없을경우
	$output .= '
		<div class="empty_list">등록된 이벤트가 없습니다</div>
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
		$content = tile_content_event($sql_fetch_array1["content"]);
		$photo_width = $width - $padding;
		$html .= '
			<div id="'.$element_name.'_'.$sql_fetch_array1["count"].'" class="'.$type_name.'_article" style="width:'.$width.'px; height:'.$height.'px; '.$style_tag.'">
				<div class="'.$type_name.'_title">'.$sql_fetch_array1["title"].'</div>
		';
		$html .= '
				<div class="'.$type_name.'_content">'.$content.'</div>
			</div>
			<script>
				$("#'.$element_name.'_'.$sql_fetch_array1["count"].'").click(function(){
					window.open("'.$type_name.'_recall_one.php?count='.$sql_fetch_array1["count"].'&order_column='.$order_column.'&count_number='.$count_number.'&status='.$status.'&start_time_y='.$start_time_y.'&start_time_m='.$start_time_m.'&start_time_d='.$start_time_d.'&end_time_y='.$end_time_y.'&end_time_m='.$end_time_m.'&end_time_d='.$end_time_d.'", "'.$type_name.'_recall_one", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no");
				});
				
				$("#'.$element_name.'_'.$sql_fetch_array1["count"].' img").width('.$photo_width.');
			</script>
		';
		$output .= $html;
	}
	if($count1==$display_number){//아직 검색할 글이 더 남아있는경우
		$count_start_new = $count_start+$display_number;
		$output .= '
			<div id="article_more" class="mouseover">더 보 기</div>
			<script>
				$("#article_more").click(function(){
					$("#'.$type_name.'_article_area").after("<div id=\"loading_more\" class=\"loading48x48\" style=\"left:340px;\"></div>");
					$(this).remove();
					var count_start = '.$count_start_new.';
					var height_total = $("#'.$type_name.'_article_area").height();
					var width_total = '.$width_total.';
					var status = '.$status.';
					var order_column = "'.$order_column.'";
					var start_time_y = "'.$start_time_y.'";
					var start_time_m = "'.$start_time_m.'";
					var start_time_d = "'.$start_time_d.'";
					var end_time_y = "'.$end_time_y.'";
					var end_time_m = "'.$end_time_m.'";
					var end_time_d = "'.$end_time_d.'";
					$.ajax({
						url:"event_common_order_recall.php",
						data: {count_start:count_start, display_number:display_number, height_total:height_total, width_total:width_total, status:status, order_column:order_column, start_time_y:start_time_y, start_time_m:start_time_m, start_time_d:start_time_d, end_time_y:end_time_y, end_time_m:end_time_m, end_time_d:end_time_d},
						success: function(getdata){
							$("#'.$type_name.'_article_area").append(getdata);
							$("#loading_more").remove();
						}
					});
				});
			</script>
		';
		if($height_total_initial==0){$height_total += 58;}//처음에만 더보기 높이를 더해줌
	}
	$output .= '
		<script>
			$("#'.$type_name.'_article_area").height('.$height_total.');
		</script>
	';
}
echo $output;

?>