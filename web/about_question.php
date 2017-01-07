<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="이드마루, customer center, 고객센터, customer, 고객, member, member center" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-고객센터</title>
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
	$url = "about_question.php?";
	$page_name = "about_question";
	$page_type = "all";
	$table_name = "about_question";
	$ad_fixbar_cond = "about_question";
	$ad_pop_cond = "about_question";
	$ad_side_cond = "about_question";
	include 'declare.php';
	include 'personal.php';
	include 'list.php';
?>
	<script>
		var url = "<?php echo $url;?>";
		var table_name = "<?php echo $table_name;?>";
		var table_name_reply = table_name+"_reply";
		var about_type = "question";
		var page_name = "<?php echo $page_name;?>";
		$(document).ready(function () {
			blueStyle();
			menuAbout();
		});
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body>
	<div id="toparea">
<?php include 'toparea.php'; ?>
	</div>
	<div id="bodyarea">
		<div id="mainbar">
			<div id="mainbody">
				<header id="page_title"></header>
				<div id="list_search">
					<div id="list_search_box">
					<div id="list_search_tip" title="검색 Tip"><img src="../image/list_search_tip.png"/></div>
					<select id="list_search_category" name="list_search_category">
							<option selected value="all_content">전체</option><option value="title"> 제목 </option><option value="content"> 글내용 </option>
						</select>
					<input id="list_search_word" type="text" name="list_search_word" value="" maxlength="40" tabindex=""/>
					<div id="list_search_word_button" title="검색"></div>
					<div id="list_search_word_cancel" title="검색 취소"></div>
					</div>
				</div>
				<div id="list_button">
					<div id="about_question_write" class="menu_button mouseover"></div>
				</div>
				<div class="content_area">
<?php
	if($category=="all_content"){
		$search_field = "title,content";
	} else if($category=="title"){
		$search_field = "title";
	} else if($category=="content"){
		$search_field = "content";
	}
	$table_name_main = $table_name."_main";
	$table_name_delta = $table_name."_delta";
	$table_name_reply = $table_name."_reply";
	$table_name_reply_main = $table_name_reply."_main";
	$table_name_reply_delta = $table_name_reply."_delta";
	$status_num = $status;
	$output = '';
	if($category != "thereisnocategory"){
		$output .= '<script>$("select[name=list_search_category]").val("'.$category.'");</script>';
	} else if($category=="thereisnocategory"){
		$output .= '<script>$("select[name=list_search_category]").val("all_content");</script>';
	}
	if($category == "all_content" ){//댓글 검색을 하기 위함
		$sphinx1 = new SphinxClient ();
		$sphinx1->SetServer($host20, $port20);
		$sphinx1->SetMatchMode ( SPH_MATCH_EXTENDED );
	}
	if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 때
		$sql4 = "SELECT * FROM $table_name";//list_show를 만들기 위해. 목록을 볼때는 비공개도 보게 한다.
	} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
		$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
		$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
	}
	if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을때
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);//list에 count된 총 갯수
	} else if($keyword != "thereisnokeyword" && $category != "writer"){//작성자 검색이 아니고 keyword 검색을 했을 때
		$count4 = $search["total_found"];
	}
if($count4 != 0){
	include 'recall_detailB.php';
	if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 때
		if($count_link != 0){
			$sql1 = $sql4." WHERE count=$count_link";//쓴 글 검색
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
	if($count_link != 0){//세부목록 보기일때
	} else if($count_link==0){//세부목록 보기가 아닐때
		$output .= '<div id="list_box">';
		if($count4 != 0){
			$output .= '
				<div id="list_head">
					<div id="about_list_A">작성자</div>
					<div id="about_list_title">제&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;목</div>
					<div id="about_list_C">조회수</div>
					<div id="about_list_B">공개</div>
				</div>
			';
		} else if($count4==0){
			$output .= '<div class="empty_list">작성된 글이 없습니다</div>';
		}
	}
	for($i=0; $i<$count1; $i++){//개별 결과 출력
		$html = '';
		if(($keyword == "thereisnokeyword" && $category == "thereisnocategory") || ($keyword != "thereisnokeyword" && $category=="writer")){//keyword 검색을 하지 않았을 때
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
			$sql11 = "SELECT * FROM $table_name WHERE count = $arr10[$i]";
			$sql_query11 = mysqli_query($conn, $sql11);
			$sql_fetch_array1 = mysqli_fetch_array($sql_query11);
		}
 		if($sql_fetch_array1["status"]=="1"){
			$status="모두";
		} else if($sql_fetch_array1["status"]=="2"){
			$status="비공개";
		} else if($sql_fetch_array1["status"]=="3"){
			$status="공지사항";
		}
		$list_count_link = $start_number + $i +1;//list_count 숫자 설정 (목록에서 링크 설정을 위한 setting)
		$list_page_count_link = (int) ( ($list_count_link-1) / $list_count_on_page) +1;
		$prev_list_page_count_link = (int) ( ($list_count_link-1-1) / $list_count_on_page ) + 1;//전 페이지의 list_page_count
		$next_list_page_count_link = (int) ( ($list_count_link-1+1) / $list_count_on_page ) + 1;//다음 페이지의 list_page_count
		$sql5 = "SELECT * FROM $table_name_reply WHERE count_upperwrite = $sql_fetch_array1[count]";//댓글 검색
		$sql_query5 = mysqli_query($conn, $sql5);
		$count5 = mysqli_num_rows($sql_query5);
		$sql6 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num]";//작성자를 확인하기 위함
		$sql_query6 = mysqli_query($conn, $sql6);
		$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
		$title = $sql_fetch_array1["title"];
		$content = $sql_fetch_array1["content"];
		if($keyword != "thereisnokeyword"){//키워드 검색했을경우
			$title = search_highlight($keyword, $title);
			$content = search_highlight($keyword, $content);
		}
		if($count_link != 0){//세부목록으로 들어갈 경우
			if($sql_fetch_array1["user_num"] != $user_num){read_doc($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["read_count"]);} // 본인 글이 아닐경우 조회수를 올린다
			$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array6[user_num]";//idcard의 사진을 띄운다
			$sql_query17 = mysqli_query($conn, $sql17);
			$count17 = mysqli_num_rows($sql_query17);
			if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
			else{$user_photo_path = "../image/blank_face.png";}
			$link_addr = 'http://www.idmaru.com/web/'.$url.'count_link='.$sql_fetch_array1["count"];
			$html .= '
			<div id="form_area">
			<div id="info_area">
				<div id="info_area_status">
					<div id="info_area_writer" class="inline">'.$sql_fetch_array6["user_name"].'
					<div class="user_info" style="top:16px;"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding send_msg pointer">쪽지 보내기</div></div>
					</div>
					<div id="info_area_time">('.$sql_fetch_array1["writetime"].')</div>
					<div id="write_content_status_B" class="inline" style="display:none;">'.$status.'</div>
				</div>
				<div id="info_area_read_count">조회수: '.$sql_fetch_array1["read_count"].'</div>
			</div>
			<div id="modify_status">
				<h6 class="inline">공개여부 : &nbsp;모두&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="all" tabindex=""/><h6 class="inline basicmargin">&nbsp;&nbsp;비공개&nbsp;</h6><input class="inline radio1" type="radio" name="status" value="private" tabindex=""/>
				'.$add_photo_block.'
			</div>
			<div id="main_writing">
				<div id="mywrite_titlearea">
					<article id="mywrite_title" class="inline" style="top:0px;">'.$title.'</article>
					<input type="text" id="mywrite_title_modify" name="mywrite_title" class="inline" value="" maxlength="100" style="width:700px;"/>
				</div>
				'.link_block($link_addr).'
			';
			if($sql_fetch_array1["status"]==1 || ($sql_fetch_array1["status"]==2 && ((is_idmaru_id($user_name)==1) || ($sql_fetch_array1["user_num"] == $user_num)))){ // 모두 공개이거나 비공개에서 이드마루 관계자 혹은 본인일때
				$html .= '
				<div id="mywrite_bodyarea">
					<div id="mywrite_body">
						<article id="mywrite_content_read">'.$content.'</article>
					</div>
					<div id="mywrite_func">
						<div id="see_reply_'.$sql_fetch_array1["count"].'" class="see_reply_status" onclick="see_reply('.$sql_fetch_array1["count"].')">▼ 댓글 '.$count5.' </div>
						'.other_link_area($link_addr, $title, $content).'';
				if($sql_fetch_array1["user_num"]==$user_num){//글쓴이가 본인일경우
					$html .= '
						<div id="write_modify_'.$sql_fetch_array1["count"].'" class="write_modify" onclick="write_modify_about_question('.$sql_fetch_array1["count"].')">수정</div>
						<div id="write_delete_'.$sql_fetch_array1["count"].'" class="write_delete" onclick="write_delete(\''.$table_name.'\', '.$sql_fetch_array1["count"].')">삭제</div>
					';
				}
				$html .= '
					</div>
				</div>
				';
			} else {
				$html .= '
				<div id="mywrite_bodyarea">
					<div id="mywrite_body">
						<article id="mywrite_content_read">비공개 글 입니다.</article>
					</div>
					<div id="mywrite_func">
					</div>
				</div>
				';
			}
				$html .= '
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
		} else if($count_link==0){//세부 목록이 아닐 경우
			$writetime = substr($sql_fetch_array1["writetime"], 0, 10);
			$html .= '
				<div id="writing_area_article'.$sql_fetch_array1["count"].'" class="writing_area_article">
					<div class="about_A">'.$sql_fetch_array6["user_name"].'</div>
					<a href="'.$url.'count_link='.$sql_fetch_array1["count"].'&list_count='.$list_count_link.$number_url.$keyword_url.$category_url.'">
					<div class="about_title">'.$title.' &nbsp;<span style="color:#3C847F; font-weight:normal;">('.$count5.')</span></div>
					</a>
					<div class="about_C">'.$sql_fetch_array1["read_count"].'</div>
					<div class="about_B">'.$status.'</div>
				</div>
				<script>
					var height = $("#writing_area_article'.$sql_fetch_array1["count"].' .about_title").height();
					$("#writing_area_article'.$sql_fetch_array1["count"].'").height(height+8);
					$("#writing_area_article'.$sql_fetch_array1["count"].' .about_A").height(height);
					$("#writing_area_article'.$sql_fetch_array1["count"].' .about_title").height(height);
					$("#writing_area_article'.$sql_fetch_array1["count"].' .about_C").height(height);
					$("#writing_area_article'.$sql_fetch_array1["count"].' .about_B").height(height);
				</script>
			';
		}
		$output .= $html;
	}
	if($count_link==0){$output .= '</div>';} // list_box div의 끝
	echo $html_list.$output.$html_list;//결과물과 list를 함께 출력
	include 'list_button.php';
?>
				</div>
			</div>
		</div>
<?php include 'sidebar.php'; ?>
	</div>
	<div id="endarea">
<?php include 'pineforest.php'; ?>
	</div>
	<div id="temp_target"></div>
</body>
</html>