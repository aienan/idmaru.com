<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<link rel="stylesheet" href="../plugin/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script type="text/javascript" src="../plugin/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>
<?php
	include 'declare.php';
	$table_name = "photo";
	$url = "gallery_recall_one.php?";
	$count = $_REQUEST["count"];//글번호
	$order_column = $_REQUEST["order_column"];//조회수 기준
	$count_number = $_REQUEST["count_number"];//조회수에 따른 순서
	$gallery_type = $_REQUEST["gallery_type"];
	if($gallery_type=="all"){}
	else {$type = gallery_type_num($gallery_type);}
	$standard_width_one = 645;
	$minimum_height = 300;
	$table_name_reply = $table_name."_reply";
	$table_name_updown = $table_name."_up";
	$table_name_read_counter = $table_name."_read_counter";
	if($count_number==0){//맨 첫글일 경우
		$count_number_after = $count_number + 1;
		$count_start = $count_number;
		$display_number = 2;
	} else if($count_number != 0){//첫글이 아닐경우
		$count_number_before = $count_number - 1;
		$count_number_after = $count_number + 1;
		$count_start = $count_number_before;
		$display_number = 3;
	}
	if($order_column=="up_total"){
		$extra_sql1 = $table_name;
	} else if($order_column=="read_count_1" || $order_column=="read_count_7" || $order_column=="read_count_30"){
		$extra_sql1 = $table_name_read_counter;
	}
	if($gallery_type=="all"){
		$extra_sql2 = "";
	}else{
		$extra_sql2 = " AND type=$type";
	}
	$sql2 = "SELECT * FROM $extra_sql1 WHERE status=1".$extra_sql2." ORDER BY $order_column DESC, count DESC LIMIT $count_start, $display_number";//앞글과 뒷글의 count를 구한다
	$sql_query2 = mysqli_query($conn, $sql2);
	for($i=0; $i <$display_number; $i++){
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		if($count_number==0){//맨 첫글일 경우
			if($i==1){
				$count_after = $sql_fetch_array2["count"];
			}
		} else if($count_number != 0){
			if($i==0){
				$count_before = $sql_fetch_array2["count"];//앞글의 count
			} else if($i==2){
				$count_after = $sql_fetch_array2["count"];//뒷글의 count
			}
		}
	}
	$sql1 = "SELECT * FROM $table_name WHERE count=$count AND (status='1' OR status='2')";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	if(!$count1){//게시물이 없을경우
		echo '<script>alert("게시물을 볼 수 없습니다");</script>';
		exit();
	} else if($sql_fetch_array1["status"]=='2'){ // 친구 공개일 때
		$friend_check = friend_check($sql_fetch_array1["user_num"]);
		if($friend_check==0){echo '<script>alert("게시물을 볼 수 없습니다");</script>'; exit();} // 친구가 아닐경우
	}
	$content = $sql_fetch_array1["content"];
	$photo_path = $sql_fetch_array1["photo_path"];
	if(file_exists($photo_path)==false){$photo_path="../image/error.jpg";}
	$image_size = getimagesize($photo_path);//image 넓이와 높이 구하기
	$image_width = $image_size[0];//image 넓이
	$image_height = $image_size[1];//image 높이
	if($image_width > $standard_width_one){//하나 보기에서 image가 커서 보정이 될 경우
		$image_height_shrink = $image_height / ($image_width / $standard_width_one);
	} else if($image_width <= $standard_width_one){//하나 보기에서 image가 작아서 보정이 안될 경우
		$image_height_shrink = $image_height;
	}
	if($image_height_shrink < $minimum_height){$photo_one_padding = (int)($minimum_height-$image_height_shrink)/2;} // 그림 크기가 최소값보다 작을경우 photo_one div에 margin을 준다
	else{$photo_one_padding = 0;}
	$go_arrow_top = height_middle($image_height_shrink, 36);//화살표의 top 수치
	if($sql_fetch_array1["user_num"] != $user_num){read_doc($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["read_count"]);} // 본인 글이 아닐경우 조회수를 올린다
	if($sql_fetch_array1["status"] == "1"){//모두에게 공개될 경우
		$status = "모두";
	} else if($sql_fetch_array1["status"] == "2"){//친구에게 공개될 경우
		$status = "친구";
	} else if($sql_fetch_array1["status"] == "3"){//비공개일 경우
		$status = "비공개";
	}
	$sql5 = "SELECT * FROM $table_name_reply WHERE count_upperwrite = $sql_fetch_array1[count]";//댓글 검색
	$sql_query5 = mysqli_query($conn, $sql5);
	$count5 = mysqli_num_rows($sql_query5);
	$sql6 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num]";//작성자 이름 검색
	$sql_query6 = mysqli_query($conn, $sql6);
	$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
?>
	<script>
<?php
	echo '
		var table_name = "'.$table_name.'";
		var table_name_reply = table_name + "_reply";
		var count_upperwrite = '.$count.';
		var keyword = "thereisnokeyword";
	';
?>
	</script>
	<script>
		$(document).ready(function(){
			reply_keyup();
		});
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body class="popup_body">
	<div id="writing_area" class="popup_writing_area">
<?php
	$info_area_type = gallery_type_info_area($sql_fetch_array1["type"]);
	$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array6[user_num]";//idcard의 사진을 띄운다
	$sql_query17 = mysqli_query($conn, $sql17);
	$count17 = mysqli_num_rows($sql_query17);
	if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
	else{$user_photo_path = "../image/blank_face.png";}
	$link_addr = 'http://www.idmaru.com/web/gallery_all.php?count_link='.$sql_fetch_array1["count"];
	echo '
		<div id="photo_one" style="padding:'.$photo_one_padding.'px 0;">
			<div id="go_prev"><div id="go_prev_arrow"></div></div>
			<div id="photo_main"><img id="photo_'.$sql_fetch_array1["count"].'" src="'.$photo_path.'" class="link"/></div>
			<div id="go_next"><div id="go_next_arrow"></div></div>
		</div>
		<div id="info_area">
			<div id="info_area_type" class="inline">['.$info_area_type.']</div>
			<div id="info_area_writer" class="inline">'.$sql_fetch_array6["user_name"].'
				<div class="user_info" style="top:16px;"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding send_msg pointer">쪽지 보내기</div></div>
			</div>
			<div id="info_area_time">('.$sql_fetch_array1["writetime"].')</div>
			'.updown_status($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["user_num"], $sql_fetch_array1["up_total"], -1).'
			<div id="info_area_read_count">조회수: '.$sql_fetch_array1["read_count"].'</div>
		</div>
		<div id="main_writing">
		'.link_block($link_addr).'
		<div id="mywrite_bodyarea">
			<div id="photo_content">'.convert_to_tag($content).'</div>
			<div id="mywrite_func">
				<div id="see_reply_'.$sql_fetch_array1["count"].'" class="see_reply_status" onclick="see_reply('.$sql_fetch_array1["count"].')">▼ 댓글 '.$count5.'</div>
				'.other_link_area($link_addr, $content, $content);
	if($sql_fetch_array1["user_num"]==$user_num){//글쓴이가 본인일때
		echo '
				<div id="write_modify_'.$sql_fetch_array1["count"].'" class="photo_modify" onclick="photo_modify('.$sql_fetch_array1["count"].')">수정</div>
				<div id="write_delete_'.$sql_fetch_array1["count"].'" class="photo_delete" onclick="write_delete(\''.$table_name.'\', '.$sql_fetch_array1["count"].')">삭제</div>
		';
	}
	echo '
			</div>
		</div>
		</div>
		<div id="textarea_copy"></div>
		<div id="mywrite_reply" class="mywrite_body">
			<textarea id="mywrite_reply_text" class="input_blue" name="mywrite_reply_content"></textarea>
			<div class="mywrite_cont">
				<div id="mywrite_reply_letterleft"></div>
				<div id="mywrite_reply_enter" class="mouseover" onclick="write_reply_submit_index('.$sql_fetch_array1["count"].', '.$sql_fetch_array1["status"].')"><img src="../image/button_enter.png"/></div>
			</div>
		</div>
		<script>
			if('.$image_width.' > '.$standard_width_one.'){
				$("#photo_'.$sql_fetch_array1["count"].'").attr("width", '.$standard_width_one.');//사진의 넓이 설정
			}
			$("#photo_one, #go_prev, #go_next").height('.$image_height_shrink.');
			$("#go_prev_arrow, #go_next_arrow").css("top", "'.$go_arrow_top.'px");
			$("#photo_main img").click(function(){
				window.open("photo_recall_one.php?photo_path='.$photo_path.'&table_name='.$table_name.'&count='.$sql_fetch_array1["count"].'", "photo_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
			});
			document.title = "'.documentTitle(strip_tags($content)).'";
			info_area_functions('.$sql_fetch_array1["user_num"].');
			mywrite_link_click();
			reply_keyup();
			photo_battle_check('.$sql_fetch_array1["count"].');
		</script>
	';
	if(isset($count_before)){
		echo '
			<script>
				go_prev_arrow();
				$("#go_prev").click(function(){
					location.href = "'.$url.'count='.$count_before.'&order_column='.$order_column.'&count_number='.$count_number_before.'&gallery_type='.$gallery_type.'";
				});
			</script>
		';
	}
	if(isset($count_after)){
		echo '
			<script>
				go_next_arrow();
				$("#go_next").click(function(){
					location.href = "'.$url.'count='.$count_after.'&order_column='.$order_column.'&count_number='.$count_number_after.'&gallery_type='.$gallery_type.'";
				});
			</script>
		';
	}
?>
		<div style="margin:20px 0 0 0;"><?php include 'ad_textA.php';?></div>
	</div>
	<div id="temp_target"></div>
</body>
</html>