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
	$table_name = "club_event";
	$page_name = "event_recall_one";
	include 'declare.php';
	$url = "event_recall_one.php?";
	$count = $_REQUEST["count"];//글번호
	$order_column = $_REQUEST["order_column"];//조회수 기준
	$count_number = $_REQUEST["count_number"];//조회수에 따른 순서
	$status = $_REQUEST["status"];
	if($_REQUEST["start_time_y"]){//시작년도가 입력됐을경우
		$start_time_y = $_REQUEST["start_time_y"];
	} else if(!$_REQUEST["start_time_y"]){//시작년도가 입력되지 않았을경우
		$start_time_y = 0;
	}
	if($_REQUEST["start_time_y"] && $_REQUEST["start_time_m"]){//시작년월이 입력됐을경우
		$start_time_m = $_REQUEST["start_time_m"];
	} else if(!$_REQUEST["start_time_y"] || !$_REQUEST["start_time_m"]){//시작년월이 입력되지 않았을경우
		$start_time_m = 0;
	}
	if($_REQUEST["start_time_y"] && $_REQUEST["start_time_m"] && $_REQUEST["start_time_d"]){//시작년월일이 입력됐을경우
		$start_time_d = $_REQUEST["start_time_d"];
	} else if(!$_REQUEST["start_time_y"] || !$_REQUEST["start_time_m"] || !$_REQUEST["start_time_d"]){//시작년월일이 입력되지 않았을경우
		$start_time_d = 0;
	}
	if($_REQUEST["end_time_y"]){//종료년도가 입력됐을경우
		$end_time_y = $_REQUEST["end_time_y"];
	} else if(!$_REQUEST["end_time_y"]){//종료년도가 입력되지 않았을경우
		$end_time_y = 9999;
	}
	if($_REQUEST["end_time_y"] && $_REQUEST["end_time_m"]){//종료년월이 입력됐을경우
		$end_time_m = $_REQUEST["end_time_m"];
	} else if(!$_REQUEST["end_time_y"] || !$_REQUEST["end_time_m"]){//종료년월이 입력되지 않았을경우
		$end_time_m = 13;
	}
	if($_REQUEST["end_time_y"] && $_REQUEST["end_time_m"] && $_REQUEST["end_time_d"]){//종료년월일이 입력됐을경우
		$end_time_d = $_REQUEST["end_time_d"];
	} else if(!$_REQUEST["end_time_y"] || !$_REQUEST["end_time_m"] || !$_REQUEST["end_time_d"]){//종료년월일이 입력되지 않았을경우
		$end_time_d = 32;
	}
	$table_name_reply = $table_name."_reply";
	$table_name_up = $table_name."_up";
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
	if($status=="4"){//전체보기일경우
		if($order_column=="count"){//등록순 정렬일경우
			$sql2 = "SELECT * FROM $table_name WHERE ( (start_time_y='') OR (start_time_y<$end_time_y) OR (start_time_y=$end_time_y AND ( (start_time_m='') OR (start_time_m<$end_time_m) OR (start_time_m=$end_time_m AND ( (start_time_d='') OR (start_time_d<=$end_time_d) ) ) ) ) ) AND ( (end_time_y='') OR (end_time_y>$start_time_y) OR (end_time_y=$start_time_y AND ( (end_time_m='') OR (end_time_m>$start_time_m) OR (end_time_m=$start_time_m AND ( (end_time_d='') OR (end_time_d>=$start_time_d) ) ) ) ) ) ORDER BY $order_column DESC LIMIT $count_start, $display_number";
		} else if($order_column != "count"){//등록순 정렬이 아닐경우
			$sql2 = "SELECT * FROM $table_name WHERE ( (start_time_y='') OR (start_time_y<$end_time_y) OR (start_time_y=$end_time_y AND ( (start_time_m='') OR (start_time_m<$end_time_m) OR (start_time_m=$end_time_m AND ( (start_time_d='') OR (start_time_d<=$end_time_d) ) ) ) ) ) AND ( (end_time_y='') OR (end_time_y>$start_time_y) OR (end_time_y=$start_time_y AND ( (end_time_m='') OR (end_time_m>$start_time_m) OR (end_time_m=$start_time_m AND ( (end_time_d='') OR (end_time_d>=$start_time_d) ) ) ) ) ) ORDER BY $order_column DESC, count DESC LIMIT $count_start, $display_number";
		}
	} else {//전체보기가 아닐경우
		if($order_column=="count"){//등록순 정렬일경우
			$sql2 = "SELECT * FROM $table_name WHERE status=$status AND ( (start_time_y='') OR (start_time_y<$end_time_y) OR (start_time_y=$end_time_y AND ( (start_time_m='') OR (start_time_m<$end_time_m) OR (start_time_m=$end_time_m AND ( (start_time_d='') OR (start_time_d<=$end_time_d) ) ) ) ) ) AND ( (end_time_y='') OR (end_time_y>$start_time_y) OR (end_time_y=$start_time_y AND ( (end_time_m='') OR (end_time_m>$start_time_m) OR (end_time_m=$start_time_m AND ( (end_time_d='') OR (end_time_d>=$start_time_d) ) ) ) ) ) ORDER BY $order_column DESC LIMIT $count_start, $display_number";
		} else if($order_column != "count"){//등록순 정렬이 아닐경우
			$sql2 = "SELECT * FROM $table_name WHERE status=$status AND ( (start_time_y='') OR (start_time_y<$end_time_y) OR (start_time_y=$end_time_y AND ( (start_time_m='') OR (start_time_m<$end_time_m) OR (start_time_m=$end_time_m AND ( (start_time_d='') OR (start_time_d<=$end_time_d) ) ) ) ) ) AND ( (end_time_y='') OR (end_time_y>$start_time_y) OR (end_time_y=$start_time_y AND ( (end_time_m='') OR (end_time_m>$start_time_m) OR (end_time_m=$start_time_m AND ( (end_time_d='') OR (end_time_d>=$start_time_d) ) ) ) ) ) ORDER BY $order_column DESC, count DESC LIMIT $count_start, $display_number";
		}
	}
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
	$sql1 = "SELECT * FROM $table_name WHERE count=$count";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if(!$count1){
		echo '<script>window.close();</script>';
	}
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	if($sql_fetch_array1["user_num"] != $user_num){read_doc($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["read_count"]);} // 본인 글이 아닐경우 조회수를 올린다
	if($sql_fetch_array1["status"]==1){
		$status_name="행사";
	} else if($sql_fetch_array1["status"]==2){
		$status_name="개인";
	} else if($sql_fetch_array1["status"]==3){
		$status_name="봉사";
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
		var page_name = "'.$page_name.'";
		var count_upperwrite = '.$count.';
		var url = "'.$url.'";
		var order_column = "'.$order_column.'";
		var count_number = '.$count_number.';
		var status = '.$status.';
		var start_time_y = '.$start_time_y.';
		var start_time_m = '.$start_time_m.';
		var start_time_d = '.$start_time_d.';
		var end_time_y = '.$end_time_y.';
		var end_time_m = '.$end_time_m.';
		var end_time_d = '.$end_time_d.';
	';
?>
		var table_name_reply = table_name + "_reply";
		var keyword = "thereisnokeyword";
		$(document).ready(function(){
			date_set_change();
		});
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body class="popup_body">
	<div id="writing_area" class="popup_writing_area">
		<div id="form_area">
<?php
	$start_time = '';
	if($sql_fetch_array1["start_time_y"]){//시작 년이 있을때
		$start_time .= $sql_fetch_array1["start_time_y"].'년 ';
		if($sql_fetch_array1["start_time_m"]){//시작 월이 있을때
			$start_time .= $sql_fetch_array1["start_time_m"].'월 ';
			if($sql_fetch_array1["start_time_d"]){//시작 일이 있을때
				$start_time .= $sql_fetch_array1["start_time_d"].'일';
			}
		}
	}
	$end_time = '';
	if($sql_fetch_array1["end_time_y"]){//종료 년이 있을때
		$end_time .= $sql_fetch_array1["end_time_y"].'년 ';
		if($sql_fetch_array1["end_time_m"]){//종료 월이 있을때
			$end_time .= $sql_fetch_array1["end_time_m"].'월 ';
			if($sql_fetch_array1["end_time_d"]){//종료 일이 있을때
				$end_time .= $sql_fetch_array1["end_time_d"].'일';
			}
		}
	}
	$time_period = '';
	if($start_time){//시작시간이 있을때
		$time_period .= $start_time;
	} else if(!$start_time){
		$time_period .= '시작일';
	}
	$time_period .= ' ~ ';
	if($end_time){//종료시간이 있을때
		$time_period .= $end_time;
	} else if(!$end_time){
		$time_period .= '종료일';
	}
	$title = $sql_fetch_array1["title"];
	$content = $sql_fetch_array1["content"];
	$link_addr = 'http://www.idmaru.com/web/event_all.php?count_link='.$sql_fetch_array1["count"];
	$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array6[user_num]";//idcard의 사진을 띄운다
	$sql_query17 = mysqli_query($conn, $sql17);
	$count17 = mysqli_num_rows($sql_query17);
	if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
	else{$user_photo_path = "../image/blank_face.png";}
	echo '<div class="list_menu" style="margin:0 0 10px 0;">'; // 이전, 다음 버튼
	if(isset($count_before)){
		echo '<a href="'.$url.'count='.$count_before.'&order_column='.$order_column.'&count_number='.$count_number_before.'&status='.$status.'&start_time_y='.$start_time_y.'&start_time_m='.$start_time_m.'&start_time_d='.$start_time_d.'&end_time_y='.$end_time_y.'&end_time_m='.$end_time_m.'&end_time_d='.$end_time_d.'"><div class="go_prev_list"><img src="../image/go_prev_listA.png"/></div></a>';
	}
	if(isset($count_after)){
		echo '<a href="'.$url.'count='.$count_after.'&order_column='.$order_column.'&count_number='.$count_number_after.'&status='.$status.'&start_time_y='.$start_time_y.'&start_time_m='.$start_time_m.'&start_time_d='.$start_time_d.'&end_time_y='.$end_time_y.'&end_time_m='.$end_time_m.'&end_time_d='.$end_time_d.'"><div class="go_next_list"><img src="../image/go_next_listA.png"/></div></a>';
	}
	echo '
	</div>
	<div id="info_area">
		<div id="info_area_status">이벤트 종류 : <div id="write_content_status" class="inline">'.$status_name.'</div></div>
		<div id="info_area_time">이벤트 기간 : '.$time_period.'</div>
		<div id="info_area_read_count">조회수: '.$sql_fetch_array1["read_count"].'</div>
		<div id="info_area_writer" style="position:absolute; right:6px; top:26px;">작성자 : '.$sql_fetch_array6["user_name"].'
			<div class="user_info"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding send_msg pointer">쪽지 보내기</div></div>
		</div>
	</div>
	<div id="modify_status" class="inline">
		<h6 class="inline">이벤트 종류 : &nbsp;행사&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="party" tabindex=""/><h6 class="inline basicmargin">&nbsp;&nbsp;개인&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="social" tabindex=""/><h6 class="inline basicmargin">&nbsp;&nbsp;봉사&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="volunteer" tabindex=""/>
		<div id="time_period"><h6 class="inline">이벤트 기간 : </h6><h6 class="inline">&nbsp;시작일</h6><select id="start_time_y" class="inline" name="start_time_y">'.$select_option_year_event_start.'</select>년<select id="start_time_m" class="inline" name="start_time_m">'.$select_option_month.'</select>월<select id="start_time_d" class="inline" name="start_time_d"><option selected value="">선택</option></select>일<br/><h6 class="inline" style="margin:0 0 0 90px;">&nbsp;종료일</h6><select id="end_time_y" class="inline" name="end_time_y">'.$select_option_year_event_end.'</select>년<select id="end_time_m" class="inline" name="end_time_m">'.$select_option_month.'</select>월<select id="end_time_d" class="inline" name="end_time_d"><option selected value="">선택</option></select>일</div>
		'.$add_photo_block.'
	</div>
	<div id="main_writing">
		<div id="mywrite_titlearea">
			<article id="mywrite_title" class="inline" style="top:0px;">'.$title.'</article>
				'.updown_status($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["user_num"], $sql_fetch_array1["up_total"], -1).'
			<input type="text" id="mywrite_title_modify" name="mywrite_title" class="inline" value="" maxlength="100" style="width:700px;"/>
		</div>
		'.link_block($link_addr).'
		<div id="mywrite_bodyarea">
			<div id="mywrite_body"><!--내글쓰기-->
				<article id="mywrite_content_read">'.$content.'</article>
			</div>
			<div id="mywrite_func">
				<div id="see_reply_'.$sql_fetch_array1["count"].'" class="see_reply_status" onclick="see_reply('.$sql_fetch_array1["count"].')">▼ 댓글 '.$count5.' </div>
				'.other_link_area($link_addr, $title, $content);
	if($sql_fetch_array1["user_num"]==$user_num){
		echo '
				<div id="write_modify_'.$sql_fetch_array1["count"].'" class="write_modify" onclick="write_modify_event('.$sql_fetch_array1["count"].', \''.$sql_fetch_array1["start_time_y"].'\', \''.$sql_fetch_array1["start_time_m"].'\', \''.$sql_fetch_array1["start_time_d"].'\', \''.$sql_fetch_array1["end_time_y"].'\', \''.$sql_fetch_array1["end_time_m"].'\', \''.$sql_fetch_array1["end_time_d"].'\')">수정</div>
				<div id="write_delete_'.$sql_fetch_array1["count"].'" class="write_delete" onclick="write_delete(\''.$table_name.'\', '.$sql_fetch_array1["count"].')">삭제</div>
		';
	}
	echo '
			</div>
		</div>
	</div>
		</div>
		<div id="textarea_copy"></div>
		<div id="mywrite_modify">
			<div id="mywrite_modify_body" style="width:725px; padding:0;"><!--수정용 textarea-->
				<textarea id="mywrite_modify_text" name="mywrite_modify_content"></textarea>
			</div>
			<div id="mywrite_modify_bottom" class="write_bottom">
				<div id="mywrite_modify_confirm" onclick="mywrite_modify_confirm()">수정완료</div>
				<div id="mywrite_modify_cancel" onclick="mywrite_modify_cancel()">취소</div>
			</div>
		</div>
		<div id="mywrite_reply" class="mywrite_body">
			<textarea id="mywrite_reply_text" name="mywrite_reply_content"></textarea>
			<div class="mywrite_cont">
				<div id="mywrite_reply_letterleft"></div>
				<div id="mywrite_reply_enter" class="mouseover" onclick="write_reply_submit('.$sql_fetch_array1["count"].')"><img src="../image/button_enter.png"/></div>
			</div>
		</div>
		<script>
			document.title = "'.documentTitle(strip_tags($title)).'";
			info_area_functions('.$sql_fetch_array1["user_num"].');
			mywrite_link_click();
			content_img_click('.$sql_fetch_array1["count"].');
			reply_keyup();
		</script>
	';
?>
		<div style="margin:20px 0 0 0;"><?php include 'ad_textA.php';?></div>
	</div>
	<div id="temp_target"></div>
</body>
</html>