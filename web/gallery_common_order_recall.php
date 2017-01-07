<?php
include 'header.php';
include 'declare_php.php';
$count_start = $_REQUEST["count_start"];//사진 시작 번호
$display_number = $_REQUEST["display_number"];//사진 검색 갯수
$height_total = $_REQUEST["height_total"];//article_area 높이
$width_total = $_REQUEST["width_total"];
$order_column = $_REQUEST["order_column"];
$gallery_type = $_REQUEST["gallery_type"];
if($gallery_type=="all"){}
else {$type = gallery_type_num($gallery_type);}
$type_name = "gallery";
$table_name = "photo";
$table_name_read_counter = $table_name."_read_counter";
if($order_column=="up_total"){//추천순 정렬일 경우
	$order_table_name = $table_name;
} else if($order_column=="read_count_1"){
	$order_table_name = $table_name_read_counter;
} else if($order_column=="read_count_7"){
	$order_table_name = $table_name_read_counter;
} else if($order_column=="read_count_30"){
	$order_table_name = $table_name_read_counter;
}
if($gallery_type != "all"){$sql1 = "SELECT * FROM $order_table_name WHERE status='1' AND type=$type ORDER BY $order_column DESC, count DESC LIMIT $count_start, $display_number";}
else {$sql1 = "SELECT * FROM $order_table_name WHERE status='1' ORDER BY $order_column DESC, count DESC LIMIT $count_start, $display_number";}//모두에게 공개된 사진을 조회순으로 정렬한다
$sql_query1 = mysqli_query($conn, $sql1);
$count1 = mysqli_num_rows($sql_query1);
$output = '';
$standard_width = 235;
$margin = 5;
$space_add = 0;//5px 공간은 inline때문에 생김
$space_width = (int)($margin * 2) + $space_add;
$space_height = (int)($margin * 2) + $space_add;
if(stripos($_SERVER['HTTP_USER_AGENT'], "MSIE")!==false){$space_height = (int)($margin * 2) + 6;}//IE일때
if(!$count1 && $height_total==0){//사진이 없을경우
	$output .= '
		<div class="empty_list">등록된 사진이 없습니다</div>
		<script>$("#'.$type_name.'_article_area").height($(".empty_list").height()+30);</script>
	';
} else if($count1){//사진이 있는경우
	$output .= '<div id="photo_area_total" style="border:none;"><div id="photo_area_1"></div><div id="photo_area_2"></div><div id="photo_area_3"></div>';
	for($i=0; $i < $count1; $i++){
		$html = '';
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM $table_name WHERE count=$sql_fetch_array1[count]";//테이블에서 정렬된 글순서대로 글을 검색한다
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$photo_path = $sql_fetch_array2["photo_path"];
		if(file_exists($photo_path)==false){$photo_path="../image/error.jpg";}
		else {
			$photo_path = get_thumbnail_path($photo_path);
		}
		$image_size = getimagesize($photo_path);//image 넓이와 높이 구하기
		$image_width = $image_size[0];//image 넓이
		$image_height = $image_size[1];//image 높이
		if($image_width > $standard_width){//이미지 넓이가 클 경우
			$image_width_adjusted = $standard_width;
			$image_height_adjusted = $image_height * $image_width_adjusted / $image_width;
		} else {//이미지 넓이가 작을 경우
			$image_width_adjusted = $image_width;
			$image_height_adjusted = $image_height;
		}
		$count_number = $count_start + $i;
		$html .= '
			<img id="photo_'.$sql_fetch_array1["count"].'" src="'.$photo_path.'" class="mouseover" width="'.$image_width_adjusted.'" height="'.$image_height_adjusted.'" style="margin:0px 10px 0px 0;" />
			<script>
				var area1_height = $("#photo_area_1").height();
				var area2_height = $("#photo_area_2").height();
				var area3_height = $("#photo_area_3").height();
				if( (area1_height <= area2_height) && (area1_height <= area3_height) ){$("#photo_area_1").append($("#photo_'.$sql_fetch_array1["count"].'"));}
				else if( (area2_height <= area1_height) && (area2_height <= area3_height) ){$("#photo_area_2").append($("#photo_'.$sql_fetch_array1["count"].'"));}
				else if( (area3_height <= area1_height) && (area3_height <= area2_height) ){$("#photo_area_3").append($("#photo_'.$sql_fetch_array1["count"].'"));}
				$("#photo_'.$sql_fetch_array1["count"].'").click(function(){
					window.open("'.$type_name.'_recall_one.php?count='.$sql_fetch_array1["count"].'&order_column='.$order_column.'&count_number='.$count_number.'&gallery_type='.$gallery_type.'", "'.$type_name.'_recall_one", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no");
				});
			</script> 
		';
		$output .= $html;
	}
	$output .= '
		</div>
		<script>
		var height_total;
		var area1_height = $("#photo_area_1").height();
		var area2_height = $("#photo_area_2").height();
		var area3_height = $("#photo_area_3").height();
		if( (area1_height >= area2_height) && (area1_height >= area3_height) ){height_total=area1_height;}
		else if( (area2_height >= area1_height) && (area2_height >= area3_height) ){height_total=area2_height;}
		else if( (area3_height >= area1_height) && (area3_height >= area2_height) ){height_total=area3_height;}
		$("#photo_area_total").height(height_total);
		</script>
	';
	if($count1==$display_number){//아직 검색할 사진이 더 남아있는경우
		$count_start_new = $count_start+$display_number;
		$output .= '
			<div id="article_more" class="mouseover">더 보 기</div>
			<script>
				var order_column = "'.$order_column.'";
				$("#article_more").click(function(){
					$("#'.$type_name.'_article_area").after("<div id=\"loading_more\" class=\"loading48x48\" style=\"left:340px;\"></div>");
					$(this).remove();
					var count_start = '.$count_start_new.';
					var width_total = '.$width_total.';
					var gallery_type = "'.$gallery_type.'";
					$.ajax({
						url:"gallery_common_order_recall.php",
						data: {count_start:count_start, display_number:display_number, height_total:height_total, width_total:width_total, order_column:order_column, gallery_type:gallery_type},
						success: function(getdata){
							$("#'.$type_name.'_article_area").append(getdata);
							$("#loading_more").remove();
						}
					});
				});
			</script>
		';
	}
	$output .= '<script>$("#'.$type_name.'_article_area").height(height_total+39);</script>';//39는 더보기 높이
}
echo $output;
?>