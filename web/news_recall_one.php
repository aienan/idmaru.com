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
	$table_name = "writing";
	$page_name = "news_recall_one";
	include 'declare.php';
	$url = "news_recall_one.php?";
	$count = $_REQUEST["count"];//글번호
	$order_column = $_REQUEST["order_column"];//조회수 기준
	$count_number = $_REQUEST["count_number"];//조회수에 따른 순서
	$news_type = $_REQUEST["news_type"];
	if($news_type=="all"){}
	else {$type = news_type_num($news_type);}
	$table_name_reply = $table_name."_reply";
	$table_name_updown = $table_name."_updown";
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
	if($order_column=="updown_total"){
		$extra_sql1 = $table_name;
	} else if($order_column=="read_count_1" || $order_column=="read_count_7" || $order_column=="read_count_30"){
		$extra_sql1 = $table_name_read_counter;
	}
	if($news_type=="all"){
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
	$sql1 = "SELECT * FROM $table_name WHERE count=$count AND status='1'";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if(!$count1){echo '<script>window.close();</script>';} // 글이 없을경우 창을 닫는다
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	if($sql_fetch_array1["user_num"] != $user_num){read_doc($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["read_count"]);} // 본인 글이 아닐경우 조회수를 올린다
	if($sql_fetch_array1["status"]==1){
		$status="모두";
	} else if($sql_fetch_array1["status"]==2){
		$status="친구";
	} else if($sql_fetch_array1["status"]==3){
		$status="비공개";
	}
	$sql5 = "SELECT * FROM $table_name_reply WHERE count_upperwrite = $sql_fetch_array1[count]";//댓글 검색
	$sql_query5 = mysqli_query($conn, $sql5);
	$count5 = mysqli_num_rows($sql_query5);
	$sql6 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num]";//작성자 이름 검색
	$sql_query6 = mysqli_query($conn, $sql6);
	$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
	$sql7 = "SELECT * FROM $table_name_updown WHERE count=$sql_fetch_array1[count] AND updown='up'";//글에 좋아요 표시한 갯수를 센다
	$sql_query7 = mysqli_query($conn, $sql7);
	$count7 = mysqli_num_rows($sql_query7);
	$sql8 = "SELECT * FROM $table_name_updown WHERE count=$sql_fetch_array1[count] AND updown='down'";//글에 싫어요 표시한 갯수를 센다
	$sql_query8 = mysqli_query($conn, $sql8);
	$count8 = mysqli_num_rows($sql_query8);
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
		var news_type = "'.$news_type.'";
	';
?>
		var table_name_reply = table_name + "_reply";
		var keyword = "thereisnokeyword";
		$(document).ready(function(){
			var ajaxform_options = {
				target: "#temp_target"
			};
		});
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body class="popup_body">
	<div id="writing_area" class="popup_writing_area">
		<div id="form_area">
<?php
	$info_area_type = news_type_info_area($sql_fetch_array1["type"]);
	$title = $sql_fetch_array1["title"];
	$content = $sql_fetch_array1["content"];
	$link_addr = 'http://www.idmaru.com/web/news_all.php?count_link='.$sql_fetch_array1["count"];
	$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array6[user_num]";//idcard의 사진을 띄운다
	$sql_query17 = mysqli_query($conn, $sql17);
	$count17 = mysqli_num_rows($sql_query17);
	if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
	else{$user_photo_path = "../image/blank_face.png";}
	echo '<div class="list_menu" style="margin:0 0 10px 0;">'; // 이전, 다음 버튼
	if(isset($count_before)){
		echo '<a href="'.$url.'count='.$count_before.'&order_column='.$order_column.'&count_number='.$count_number_before.'&news_type='.$news_type.'"><div class="go_prev_list"><img src="../image/go_prev_listA.png"/></div></a>';
	}
	if(isset($count_after)){
		echo '<a href="'.$url.'count='.$count_after.'&order_column='.$order_column.'&count_number='.$count_number_after.'&news_type='.$news_type.'"><div class="go_next_list"><img src="../image/go_next_listA.png"/></div></a>';
	}
	echo '
	</div>
	<div id="info_area">
		<div id="info_area_type" class="inline">['.$info_area_type.']</div>
		<div id="info_area_writer" class="inline">'.$sql_fetch_array6["user_name"].'
			<div class="user_info" style="top:16px;"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding send_msg pointer">쪽지 보내기</div></div>
		</div>
		<div id="info_area_time">('.$sql_fetch_array1["writetime"].')</div>
		<div id="info_area_read_count">조회수: '.$sql_fetch_array1["read_count"].'</div>
		<div id="write_content_status" style="display:none;">'.$status.'</div>
	</div>
	<div id="modify_status">
		<h6>뉴스분류 : <select id="news_type_mod" name="news_type_mod">'.$select_category_writing_mod.'</select></h6>
		<h6 class="inline">공개여부 : &nbsp;모두&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="all" tabindex=""/><h6 class="inline basicmargin">&nbsp;&nbsp;친구&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="friend" tabindex=""/><h6 class="inline basicmargin">&nbsp;&nbsp;비공개&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="private" tabindex=""/>
		'.$add_photo_block.'
	</div>
	<div id="main_writing">
		<div id="mywrite_titlearea">
			<article id="mywrite_title" class="inline" style="top:0px;">'.$title.'</article>
				'.updown_status($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["user_num"], $count7, $count8).'
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
				<div id="write_modify_'.$sql_fetch_array1["count"].'" class="write_modify" onclick="write_modify_news('.$sql_fetch_array1["count"].', '.$sql_fetch_array1["type"].')">수정</div>
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
			<textarea id="mywrite_reply_text" class="input_blue" name="mywrite_reply_content"></textarea>
			<div class="mywrite_cont">
				<div id="mywrite_reply_letterleft"></div>
				<div id="mywrite_reply_enter" class="mouseover" onclick="write_reply_submit_index('.$sql_fetch_array1["count"].', '.$sql_fetch_array1["status"].')"><img src="../image/button_enter.png"/></div>
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
		<div class="ad_text_marginTop"><?php include 'ad_textA.php';?></div>
	</div>
	<div id="temp_target"></div>
</body>
</html>