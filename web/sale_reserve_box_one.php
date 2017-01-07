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
	$count = $_REQUEST["count"];//글번호
	$count_number = $_REQUEST["count_number"];
	$table_name = "sale";
	$table_name_reserve_box = $table_name."_reserve_box";
	$table_name_reply = $table_name."_reply";
	$url = "sale_reserve_box_one.php?";
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
	$sql2 = "SELECT * FROM $table_name_reserve_box WHERE user_num=$user_num ORDER BY writetime DESC LIMIT $count_start, $display_number";
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
	$sql1 = "SELECT * FROM $table_name WHERE count=$count";//게시물 검색
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	if(!$count1){echo '<script>window.close();</script>';}
	$title = $sql_fetch_array1["title"];
	$title = '['.selling_type_name($sql_fetch_array1["type"]).'] '.$title;
	$content = $sql_fetch_array1["content"];
	if($sql_fetch_array1["status"]==1){
		$status="판매중";
	} else if($sql_fetch_array1["status"]==2){
		$status="판매완료";
	} else if($sql_fetch_array1["status"]==3){
		$status="공유중";
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
		var count_upperwrite = '.$count.';
	';
?>
		var table_name_reply = table_name + "_reply";
		var keyword = "thereisnokeyword";
		$(document).ready(function(){
		});
		function sale_reserve_box_delete(count){
			var reply = confirm("물건을 장바구니에서 제거하시겠습니까?");
			if(reply==true){
				$.ajax({
					url:"sale_reserve_box_delete.php",
					data: {count:count},
					success: function(getdata){
						alert("물건이 장바구니에서 제거되었습니다");
						window.opener.location.reload();
						window.close();
					}
				});
			}
		}
	</script>
</head>
<body class="popup_body">
	<div id="writing_area" class="popup_writing_area">
<?php
	if($sql_fetch_array1["user_num"] != $user_num){read_doc($table_name, $sql_fetch_array1["count"], $sql_fetch_array1["read_count"]);} // 본인 글이 아닐경우 조회수를 올린다
	$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array6[user_num]";//idcard의 사진을 띄운다
	$sql_query17 = mysqli_query($conn, $sql17);
	$count17 = mysqli_num_rows($sql_query17);
	if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
	else{$user_photo_path = "../image/blank_face.png";}
	$sql16 = "SELECT * FROM market_deal WHERE count=$sql_fetch_array1[count]";
	$sql_query16 = mysqli_query($conn, $sql16);
	$count16 = mysqli_num_rows($sql_query16);
	$link_addr = 'http://www.idmaru.com/web/'.$url.'count_link='.$sql_fetch_array1["count"];
	$sale_input_date = "";
	if($sql_fetch_array1["sale_year"]!=""){$sale_input_date .= $sql_fetch_array1["sale_year"]."년";}
	if($sql_fetch_array1["sale_month"]!=""){$sale_input_date .= " ".$sql_fetch_array1["sale_month"]."월";}
	if($sql_fetch_array1["sale_date"]!=""){$sale_input_date .= " ".$sql_fetch_array1["sale_date"]."일";}
	$sale_input_how = "";
	if($sql_fetch_array1["sale_direct"]==1){$sale_input_how .= " [ 직거래 ]";}
	if($sql_fetch_array1["sale_parcel"]==1){$sale_input_how .= " [ 택배 ]";}
	if($sql_fetch_array1["sale_safe"]==1){$sale_input_how .= " [ 안전거래 ]";}
	if($sql_fetch_array1["status"]==2){echo '<div class="special_notice1">※ 판매완료된 물품입니다.</div>';}
	echo '<div class="list_menu" style="margin:0 0 10px 0;">'; // 이전, 다음 버튼
	if(isset($count_before)){
		echo '<a href="'.$url.'count='.$count_before.'&count_number='.$count_number_before.'"><div class="go_prev_list"><img src="../image/go_prev_listA.png"/></div></a>';
	}
	if(isset($count_after)){
		echo '<a href="'.$url.'count='.$count_after.'&count_number='.$count_number_after.'"><div class="go_next_list"><img src="../image/go_next_listA.png"/></div></a>';
	}
	echo '
		<div id="sale_reserve_box_delete" class="button_gb" onclick="sale_reserve_box_delete('.$count.')">장바구니에서 제거</div>
	</div>
	<div id="info_area">
		<div id="info_area_writer">판매자 : '.$sql_fetch_array6["user_name"].' <div id="writer_report" class="button_small" style="padding:2px;" onclick="writer_report('.$sql_fetch_array6["user_num"].', \''.$sql_fetch_array6["user_name"].'\')">판매자평</div></div>
		<div id="info_area_status"> 거래상태 : <div id="write_content_status" class="inline">'.$status.'</div></div>
		<div id="info_area_read_count">조회수: '.$sql_fetch_array1["read_count"].'</div>
	</div>
	<div id="main_writing">
		<div id="mywrite_titlearea">
			<article id="mywrite_title" class="inline" style="top:0px;">'.$title.'</article>
		</div>
		'.link_block($link_addr).'
		<div id="mywrite_bodyarea">
			<article id="mywrite_body"><!--내글쓰기-->
				<div class="market_box1">
				<div id="market_deal" class="button_gb" onclick="market_deal('.$sql_fetch_array1["count"].')">입찰수 '.$count16.'</div><div id="sale_email" class="button_gb" onclick="sale_email('.$sql_fetch_array1["count"].', '.$sql_fetch_array1["user_num"].')">E-Mail 전송</div>
				</div>
				<div class="market_box3">
				<p><strong>구입시기 :</strong> &nbsp; '.$sale_input_date.'</p>
				<p><strong>거래방법 :</strong> &nbsp; '.$sale_input_how.'</p>
				<p><strong>직거래 장소 :</strong> &nbsp; '.$sql_fetch_array1["sale_place"].'</p>
				<p><strong>입찰 시작가 :</strong> &nbsp; <span id="sale_price"></span></p>
				<script>var sale_price = addComma("'.$sql_fetch_array1["sale_price"].'"); if(sale_price){$("#sale_price").html(sale_price+" 원");}</script>
				</div>
				<div id="mywrite_content_read">'.convert_to_tag($content).'</div>
			</article>
			<div id="mywrite_func">
				<div id="see_reply_'.$sql_fetch_array1["count"].'" class="see_reply_status" onclick="see_reply('.$sql_fetch_array1["count"].')">▼ 댓글 '.$count5.' </div>
				'.other_link_area($link_addr, $title, $content).'
			</div>
		</div>
	</div>
	<div id="textarea_copy"></div>
	<div id="mywrite_reply" class="mywrite_body">
		<textarea id="mywrite_reply_text" name="mywrite_reply_content"></textarea>
		<div class="mywrite_cont">
			<div id="mywrite_reply_letterleft"></div>
			<div id="mywrite_reply_enter" class="mouseover" onclick="write_reply_submit('.$sql_fetch_array1["count"].')"><img src="../image/button_enter.png"/></div>
		</div>
	</div>
	<script>
		info_area_functions('.$sql_fetch_array1["user_num"].');
		mywrite_link_click();
		content_img_click('.$sql_fetch_array1["count"].');
		reply_keyup();
	</script>
	';
?>
	<div id="temp_target"></div>
</body>
</html>