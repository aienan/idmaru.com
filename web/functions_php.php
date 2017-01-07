<?php
//if(!function_exists('XXX')){}//함수가 중복 선언되지 않게 하기 위한 선언
function valid_ip($ip) {//getip()에서 쓰이는 함수
	if (!empty($ip) && ip2long($ip)!=-1) {
		$reserved_ips = array (
			array('0.0.0.0','2.255.255.255'),
			array('10.0.0.0','10.255.255.255'),
			array('127.0.0.0','127.255.255.255'),
			array('169.254.0.0','169.254.255.255'),
			array('172.16.0.0','172.31.255.255'),
			array('192.0.2.0','192.0.2.255'),
			array('192.168.0.0','192.168.255.255'),
			array('255.255.255.0','255.255.255.255')
		);
		foreach ($reserved_ips as $r) {
			$min = ip2long($r[0]);
			$max = ip2long($r[1]);
			if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;
		}
		return true;
	} else { 
		return false;
	}
}
function get_ip() {//ip 주소를 가져온다
	if (valid_ip($_SERVER["HTTP_CLIENT_IP"])) {
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	foreach (explode(",",$_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {
		if (valid_ip(trim($ip))) {
			return $ip;
		}
	}
	if (valid_ip($_SERVER["HTTP_X_FORWARDED"])) {
		return $_SERVER["HTTP_X_FORWARDED"];
	} else if (valid_ip($_SERVER["HTTP_FORWARDED_FOR"])) {
		return $_SERVER["HTTP_FORWARDED_FOR"];
	} else if (valid_ip($_SERVER["HTTP_FORWARDED"])) {
		return $_SERVER["HTTP_FORWARDED"];
	} else {
		return $_SERVER["REMOTE_ADDR"];
	}
}
function search_highlight($keyword, $content){//띄어쓰기로 구분된 검색어에 노란색을 칠한다
	$keyword_arr = explode(" ", $keyword);//키워드를 띄어쓰기로 분리한다
	$content_highlight = $content;
	for($j=0; $j < count($keyword_arr); $j++){
		$arr = explode("$keyword_arr[$j]", $content_highlight);//각 단어들에 노란색을 칠하도록 한다
		$arr_num = count($arr);
		for($i=0; $i < $arr_num-1; $i++){
			$arr[$i] = $arr[$i].'<span style="background-color: #FFF286;">'.$keyword_arr[$j].'</span>';
		}
		$content_highlight = implode("", $arr);
	}
	return $content_highlight;
}
function read_counter_up($table_name, $count){//read_counter의 조회수를 1씩 올린다
	include 'mysql_setting.php';
	$table_name_read_counter = $table_name."_read_counter";
	$sql1 = "SELECT * FROM $table_name_read_counter WHERE count=$count";
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$read_count_1 = $sql_fetch_array1["read_count_1"] + 1;
	$read_count_7 = $sql_fetch_array1["read_count_7"] + 1;
	$read_count_30 = $sql_fetch_array1["read_count_30"] + 1;
	$sql = "UPDATE $table_name_read_counter SET read_count_1=$read_count_1, read_count_7=$read_count_7, read_count_30=$read_count_30  WHERE count=$count";
	mysqli_query($conn, $sql);
}
function read_doc($table_name, $count, $read_count){//읽은 글인지 확인 후 조회수를 올린다
	include 'mysql_setting.php';
	if(isset($_SESSION[$table_name])){//전에 읽은 다른 글이 있을경우
		$read_doc_list = $_SESSION[$table_name];
		$read_doc_array = explode(";",$read_doc_list);//현재 세션에 있는 내용을 조각냅니다.
		$read_doc_exist = 0;//조회수를 올려도 되는지 저장하는 변수를 초기화
		for($i=0; $i < sizeof($read_doc_array); $i++){//이미 읽은 글인지 검사
			if($read_doc_array[$i]==$count){
				$read_doc_exist = 1;
				break; 
			}
		}
		if($read_doc_exist==0){//읽은 글이 아닐경우
			$read_doc_list .= $count.";";
			$read_count += 1;
			$sql = "UPDATE $table_name SET read_count=$read_count WHERE count=$count";
			mysqli_query($conn, $sql);
			if($table_name=="writing" || $table_name=="photo"){//read_counter가 있는 것을 update한다
				read_counter_up($table_name, $count);
			}
		}
	} else {//읽은 글이 하나도 없을경우
		$read_doc_list = $count.";";
		$read_count += 1;
		$sql = "UPDATE $table_name SET read_count=$read_count WHERE count=$count";
		mysqli_query($conn, $sql);
		if($table_name=="writing" || $table_name=="photo"){//read_counter가 있는 것을 update한다
			read_counter_up($table_name, $count);
		}
	}
	$_SESSION[$table_name] = $read_doc_list;
}
function friend_list($user_num){//friend_list를 세션에 등록한다
	include 'mysql_setting.php';
	$friend_list = '';
	$sql = "SELECT * FROM friend WHERE user_num=$user_num";//친구들의 user_num 검색
	$sql_result = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($sql_result);
	for($i=0; $i<$count; $i++){
		$sql_fetch_array = mysqli_fetch_array($sql_result);
		if($i==0){//맨 처음일경우
			$friend_list .= $sql_fetch_array["friend_num"];
		} else if($i != 0){//처음이 아닐경우
			$friend_list .= ";".$sql_fetch_array["friend_num"];
		}
	}
	return $friend_list;
}
function friend_list_delete($friend_num){//세션에서 friend_num에 해당하는 번호를 friend_list에서 지운다
	$friend_list = $_SESSION["friend_list"];
	$friend_list_array = explode(";",$friend_list);
	$first_match = 0;//맨 처음에 번호가 서로 같은지 알아보는 변수
	$friend_list_new = '';
	for($i=0; $i < sizeof($friend_list_array); $i++){
		if($i==0 && $friend_list_array[$i]!=$friend_num){//맨 처음에 번호가 서로 다를경우
			$friend_list_new .= $friend_list_array[$i];
		} else if($i==0 && $friend_list_array[$i]==$friend_num){//맨 처음에 번호가 서로 같을경우
			$first_match = 1;
			continue;
		} else if($i != 0 && $friend_list_array[$i]!=$friend_num){//맨처음이 아니고 번호가 서로 다를경우
			if($first_match==1 && $i==1){//맨 처음에 번호가 같았고 $i가 1일때
				$friend_list_new .= $friend_list_array[$i];
			} else{
				$friend_list_new .= ";".$friend_list_array[$i];
			}
		} else {
			continue;
		}
	}
	$_SESSION["friend_list"] = $friend_list_new;
}
function friend_check($friend_num){//친구가 맞는지 검사한다
	if($friend_num==0){//Guest 입장시 검사할 경우
		return 0;
	} else {
		$friend_list = $_SESSION["friend_list"];
		$friend_list_array = explode(";",$friend_list);
		$exist = 0;
		for($i=0; $i < sizeof($friend_list_array); $i++){
			if($friend_list_array[$i]==$friend_num){//친구가 맞을경우
				$exist = 1;
				break;
			}
		}
		return $exist;//친구가 맞으면 1, 아니면 0을 반환
	}
}
function mysql_friend_check($column_name){//컬럼이름을 받고 친구번호인지 확인해주는 mysql문을 만들어준다
	$friend_list = $_SESSION["friend_list"];
	$friend_list_array = explode(";",$friend_list);
	$mysql_string = '(';
	for($i=0; $i < sizeof($friend_list_array); $i++){
		if($friend_list_array[$i]){//친구번호가 있을경우
			if($i==0){//맨 처음일경우
				$mysql_string .= "$column_name = $friend_list_array[$i]";
			} else if($i != 0){//맨 처음이 아닐경우
				$mysql_string .= " OR $column_name = $friend_list_array[$i]";
			}
		}
	}
	$mysql_string .= ')';
	return $mysql_string;
}
function insert_string($content, $position, $inserting_string){//content 안에 position의 위치에 inserting_string을 집어넣는다
	$string_before = substr($content, 0, $position);
	$string_after = substr($content, $position);
	return $string_before.$inserting_string.$string_after;
}
function strip_string($string, $start, $end){//$start와 $end 사이의 글을 제거한다
	$string_before = substr($string, 0, $start);
	$string_after = substr($string, $end, strlen($string));
	return $string_before.$string_after;
}
function replace_string($string, $start, $end, $new_part){
	$string_before = substr($string, 0, $start);
	$string_after = substr($string, $end, strlen($string));
	return $string_before.$new_part.$string_after;
}
function strip_img($content){//<img> 태그를 제거한다
	$find1 = "<img";
	$find2 = ">";
	$offset = 0;
	$content_new = strtolower($content);
	do{
		$pos1 = stripos($content_new, $find1, $offset);//"<img"의 위치
		if($pos1 !== false){//$pos1을 찾을경우
			$pos2 = stripos($content_new, $find2, $pos1+4);//"/>"의 위치
			if($pos2 !== false){
				$pos2_end = $pos2 + 1;
				$content_new = strip_string($content_new, $pos1, $pos2_end);
				$content = strip_string($content, $pos1, $pos2_end);
			}
		}
	}while( ($pos1 !== false) && ($pos2 !== false) );
	return $content;
}
function replace_iframe($content){
	$regExp = '/<iframe[^>]+>[.]*<\/iframe>/i';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '<img src="../image/film.jpg"/>', $output);
	}
	return $output;
}
function replace_embed($content){
	$output = $content;
	$regExp = '/<embed[^>]+>[.]*<\/embed>/i';
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '<img src="../image/film.jpg"/>', $output);
	}
	$regExp = '/<embed[^>]+>/i';
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '<img src="../image/film.jpg"/>', $output);
	}
	return $output;
}
function replace_object($content){
	$find1 = "<object";
	$find2 = "</object>";
	$offset = 0;
	$content_new = $content;
	do{
		$pos1 = stripos($content_new, $find1, $offset);//"<object>"의 위치
		if($pos1 !== false){//$pos1을 찾을경우
			$pos2 = stripos($content_new, $find2, $pos1);//"</object>"의 위치
			if($pos2 !== false){
				$pos2_end = $pos2 + 9;
				$content_new = replace_string($content_new, $pos1, $pos2_end, '<img src="../image/film.jpg"/>');
			}
		}
	}while( ($pos1 !== false) && ($pos2 !== false) );
	return $content_new;
}
function img_src_change($content){// img 태그의 src를 thumbnail 경로로 바꾼다.
	$output = $content;
	$find1 = "<img";
	$find2 = 'src="';
	$find3 = '"';
	$offset = 0;
	$image_arr = array();
	do{
		$pos1 = stripos($output, $find1, $offset);//"<img"의 위치
		if($pos1 !== false){
			$pos2 = stripos($output, $find2, $pos1+4);//src="를 찾는다
			if($pos2 !== false){
				$pos2_end = $pos2+5;
				$pos3 = stripos($output, $find3, $pos2_end);// src="뒤에 있는 " 의 위치
				$image_src = substr($output, $pos2_end, $pos3-$pos2_end);// 원래의 img src
				$thumbnail_path = get_thumbnail_path($image_src);// thumbnail 경로
				$output = substr($output, 0, $pos2_end).$thumbnail_path.substr($output, $pos3);
				$offset = $pos3;
			}
		}
	}while( ($pos1 !== false) && ($pos2 !== false) && ($pos3 !== false) );//<img가 있을 때 다음 <img를 계속 찾는다
	return $output;
}
function strip_iframe($content){
	$regExp = '/<iframe[^>]+>[.]*<\/iframe>/i';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	return $output;
}
function strip_embed($content){
	$regExp = '/<embed[^>]+>/i';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	return $output;
}
function tile_content($content){
	$output = $content;
	$output = strip_img($output);
	$output = replace_iframe($output);
	$output = replace_object($output);
	$output = replace_embed($output);
	return $output;
}
function tile_content_event($content){
	$output = $content;
	$output = strip_iframe($output);
	$output = strip_embed($output);
	$output = img_src_change($output);
	return $output;
}
function replace_dir_mark($content){
	$regExp = '/\\/';
	$output = $content;
	while(preg_match($regExp, $output)){
		$output = preg_replace($regExp, '/', $output);
	}
	return $output;
}
function replace_quotation($content){
	$regExp = '/\'/';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '&#39;', $output);
	}
	$regExp2 = '/"/';
	while (preg_match($regExp2, $output)){
		$output = preg_replace($regExp2, '&quot;', $output);
	}
	return $output;
}
function replace_to_lt($content){
	$regExp = '/</';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '&lt;', $output);
	}
	return $output;
}
function replaceFromlt($content){
	$regExp = '/&lt;/';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '<', $output);
	}
	return $output;
}
function replace_to_gt($content){
	$regExp = '/>/';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '&gt;', $output);
	}
	return $output;
}
function replaceFromgt($content){
	$regExp = '/&gt;/';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '>', $output);
	}
	return $output;
}
function replace_symbols($content){
	$output = $content;
	$output = strip_script($output);
	$output = replace_quotation($output);
	$output = replace_to_lt($output);
	$output = replace_to_gt($output);
	return $output;
}
function documentTitle($content){ // document.title에 올라갈 때 필요한 조치를 취한다
	$output = $content;
	$output = replaceFromlt($output);
	$output = replaceFromgt($output);
	$output = replaceBR2($output);
	$output = removeEnter($output);
	$regExp = '/"/';
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	$regExp2 = '/&quot;/i';
	while (preg_match($regExp2, $output)){
		$output = preg_replace($regExp2, '', $output);
	}
	$regExp3 = '/&#39;/i';
	while (preg_match($regExp3, $output)){
		$output = preg_replace($regExp3, '', $output);
	}
	return $output;
}
function img_link_src($content){//img의 src 뒤에 "" 가 없으면 삽입
	$find1 = "<img";
	$find2 = "src=";
	$find3 = ' ';
	$find4 = '>';
	$offset = 0;
	do{
		$pos1 = stripos($content, $find1, $offset);//<img 를 찾는다
		if($pos1 !== false){//<img 가 있을경우
			$pos1_end = $pos1 + 4;
			$pos2 = stripos($content, $find2, $pos1_end);//src= 을 찾는다
			if($pos2 !== false){//src= 이 있을경우
				$pos2_end = $pos2 + 4;
				$src_behind = substr($content,$pos2_end, 1);//src= 뒤에 있는 문자
				if($src_behind != '"'){//src= 뒤에 " 가 없을 경우
					$pos3 = stripos($content, $find3, $pos2_end);//src= 뒤에 있는 띄어쓰기를 찾는다
					$pos4 = stripos($content, $find4, $pos2_end);//src= 뒤의 >를 찾는다
					if( ($pos3 !== false) && ($pos3 < $pos4) ){//띄어쓰기가 img태그 안에 있을경우
						$content = substr($content, 0, $pos2_end).'"'.substr($content, $pos2_end, $pos3 - $pos2_end).'"'.substr($content, $pos3);//src 에 ""을 삽입
					} else {//띄어쓰기가 없거나 img 태그 밖에 있는경우
						if(substr($content, $pos4-1, 1)=="/"){// img태그가 />로 끝날경우
							$img_end = $pos4 - 1;
							$content = substr($content, 0, $pos2_end).'"'.substr($content, $pos2_end, $img_end - $pos2_end).'"'.substr($content, $img_end);//src 에 ""을 삽입
						} else {//img태그가 >로 끝날경우
							$img_end = $pos4;
							$content = substr($content, 0, $pos2_end).'"'.substr($content, $pos2_end, $img_end - $pos2_end).'" /'.substr($content, $img_end);//src 에 ""을 삽입
						}
					}
				}
			}
			$offset = $pos1_end;
		}
	}while($pos1 !== false);
	return $content;
}
function changeQuotation($content){
	$regExp = '/\'/';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '"', $output);
	}
	return $output;
}
function error_modify($content){
	$output = $content;
	$output = strip_script($output);
	$output = changeQuotation($output);
	$output = img_link_src($output);
	return $output;
}
function strip_script($content){//<script></script> 태그를 제거한다
	$find1 = "<script>";
	$find2 = "</script>";
	$offset = 0;
	$content_new = strtolower($content);
	do{
		$pos1 = stripos($content_new, $find1, $offset);//"<script>"의 위치
		if($pos1 !== false){//$pos1을 찾을경우
			$pos2 = stripos($content_new, $find2, $pos1);//"</script>"의 위치
			if($pos2 !== false){
				$pos2_end = $pos2 + 9;
				$content_new = strip_string($content_new, $pos1, $pos2_end);
				$content = strip_string($content, $pos1, $pos2_end);
			}
		}
	}while( ($pos1 !== false) && ($pos2 !== false) );
	return $content;
}
function strip_a_tag($content){//<a></a> 태그를 제거한다
	$find1 = "<a";
	$find2 = "</a>";
	$offset = 0;
	$content_new = $content;
	do{
		$pos1 = stripos($content_new, $find1, $offset);//"<a"의 위치
		if($pos1 !== false){//$pos1을 찾을경우
			$pos2 = stripos($content_new, $find2, $pos1+2);//"</a>"의 위치
			if($pos2 !== false){
				$pos2_end = $pos2 + 4;
				$content_new = strip_string($content_new, $pos1, $pos2_end);
			}
		}
	}while( ($pos1 !== false) && ($pos2 !== false) );
	return $content_new;
}
function strip_img_script($content){//img와 script 태그를 제거한다
	$content_new = strip_img($content);
	$content_new = strip_script($content_new);
	return $content_new;
}
function strip_span($content){//span 태그만 없앤다
	$output = $content;
	$regExp = '/<span[^>]*>/i'; // g를 사용할경우 에러 발생
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	$regExp2 = '/<\/span>/i';
	while (preg_match($regExp2, $output)){
		$output = preg_replace($regExp2, '', $output);
	}
	return $output;
}
function strip_string_ci($string, $content){ // 대소문자 구별 하지 않고 해당 string을 지운다
	$output = $content;
	$regExp = '/'.$string.'/i';
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	return $output;
}
function strip_string_cs($string, $content){ // 대소문자를 구별하여 해당 string을 지운다
	$output = $content;
	$regExp = '/'.$string.'/';
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	return $output;
}
function find_first_img($content, $width, $height){//글 안에서 첫번째로 올라온 img를 찾아낸다
	$find1 = "<img";
	$find2 = "src=";
	$find3 = '"';
	$pos1 = stripos($content, $find1, 0);//"<img"의 위치
	if($pos1 !== false){//$pos1을 찾을경우
		$pos2 = stripos($content, $find2, $pos1);//src="의 위치
		$pos2_end = $pos2 + 5;
		$pos3 = stripos($content, $find3, $pos2_end);//src=" 뒤에 있는 "의 위치
		$src_len = $pos3 - $pos2_end;
		$photo_path = substr($content,$pos2_end, $src_len);
		$regExp = '/http:\/\//';
		if(preg_match($regExp, $photo_path)){$content_new = '<img src="'.$photo_path.'" height="'.$height.'"/>';}//img가 링크일때
		else {
			$photo_path = get_thumbnail_path($photo_path);
			$image_size = getimagesize($photo_path);
			$image_width = $image_size[0];
			$image_height = $image_size[1];
			//크기를 조정하지 않은경우
			$image_width_adjusted = $width;
			$image_height_adjusted = $height;
			//크기를 조정한경우
			// $image_height_adjusted = $height;//높이를 맞춘다
			// $image_width_adjusted = $image_width * $image_height_adjusted / $image_height;
			// if($image_width_adjusted > $width){//넓이가 기준을 초과하게 됐을경우
				// $image_width_adjusted = $width;//넓이를 맞춘다
				// $image_height_adjusted = $image_height * $image_width_adjusted / $image_width;
			// }
			if(!$width && !$height){//width와 height가 없을때
				$content_new = '<img src="'.$photo_path.'"/>';
			} else if(!$width && $height){//width가 없을때
				$content_new = '<img src="'.$photo_path.'" height="'.$image_height_adjusted.'"/>';
			} else if($width && $height){//width와 height가 다 있을때
				$content_new = '<img src="'.$photo_path.'" width="'.$image_width_adjusted.'" height="'.$image_height_adjusted.'"/>';
			}
		}
	} else if($pos1 === false){
		$content_new = '';
	}
	return $content_new;
}
function find_first_img_link($content){//글 안에서 첫번째로 올라온 img를 찾아낸다
	$find1 = "<img";
	$find2 = "src=";
	$find3 = '"';
	$pos1 = stripos($content, $find1, 0);//"<img"의 위치
	if($pos1 !== false){//$pos1을 찾을경우
		$pos2 = stripos($content, $find2, $pos1);//src="의 위치
		$pos2_end = $pos2 + 5;
		$pos3 = stripos($content, $find3, $pos2_end);//src=" 뒤에 있는 "의 위치
		$src_len = $pos3 - $pos2_end;
		$photo_path = substr($content,$pos2_end, $src_len);
		$content_new = substr($content,$pos2_end, $src_len);
		$regExp = '/^\./';
		while (preg_match($regExp, $content_new)){
			$content_new = preg_replace($regExp, '', $content_new);
		}
		$content_new = "http://www.idmaru.com".$content_new;
	} else if($pos1 === false){
		$content_new = '';
	}
	return $content_new;
}
function make_img_space($content){//<img> 태그 앞뒤로 공백을 넣는다
	$find1 = "<img";
	$find2 = ">";
	$pos1 = stripos($content, $find1, 0);//"<img"의 위치
	while($pos1 !== false){//<img가 있을 때 다음 <img를 계속 찾는다
		$pos2 = stripos($content, $find2, $pos1);//">"를 찾는다
		$pos1_before = substr($content, $pos1-1, 1);//<img 바로 앞의 글자를 추출
		$pos2_after = substr($content, $pos2+1, 1);// > 바로 뒤의 글자를 추출
		$before_check = strcmp($pos1_before, " ");//앞글자가 공백인지 체크
		$after_check = strcmp($pos2_after, " ");//뒷글자가 공백인지 체크
		if($before_check!=0){//앞글자가 공백이 아닐경우
			$content = insert_string($content, $pos1, " ");//<img 앞에 공백을 넣는다
			if($after_check!=0){//뒷글자가 공백이 아닐경우
				$content = insert_string($content, $pos2+2, " ");// > 뒤에 공백을 넣는다 (공백으로 위치가 1 밀렸고 > 의 위치 1을 더해서 총 2가 된다
			}
		} else if($before_check==0){//앞글자가 공백일경우
			if($after_check!=0){//뒷글자가 공백이 아닐경우
				$content = insert_string($content, $pos2+1, " ");// > 뒤에 공백을 넣는다
			}
		}
		$pos1 = stripos($content, $find1, $pos2+2);//다음 위치에서 다시 <img를 찾는다
	}
	return $content;
}
function make_img_array($content){//<img> 태그의 src를 array로 만든다
	$find1 = "<img";
	$find2 = 'src="';
	$find3 = '"';
	$offset = 0;
	$image_arr = array();
	do{
		$pos1 = stripos($content, $find1, $offset);//"<img"의 위치
		if($pos1 !== false){
			$pos2 = stripos($content, $find2, $pos1+4);//src="를 찾는다
			if($pos2 !== false){
				$pos2_end = $pos2+5;
				$pos3 = stripos($content, $find3, $pos2_end);
				$image_arr[] = substr($content, $pos2_end, $pos3-$pos2_end);
				$offset = $pos3+1;
			}
		}
	}while( ($pos1 !== false) && ($pos2 !== false) && ($pos3 !== false) );//<img가 있을 때 다음 <img를 계속 찾는다
	return $image_arr;
}
function adjust_img_width($content){ // style 태그 안에 있는 width, height를 이용하여 width를 설정한다
	$find1 = "<img";
	$find2 = 'width: ';
	$find3 = 'px;';
	$find4 = 'height: ';
	$find5 = '/>';
	$offset = 0;
	$output = $content;
	do{
		$pos1 = stripos($output, $find1, $offset);//"<img"의 위치
		if($pos1 !== false){//<img를 찾았을경우
			$pos1_end = $pos1 + 4;
			$pos2 = stripos($output, $find2, $pos1_end);//width: 를 찾는다
			if($pos2 !== false){//width: 를 찾았을경우
				$pos2_end = $pos2+7;
				$pos3 = stripos($output, $find3, $pos2_end);//width의 끝(;)을 찾는다
				$pos3_end = $pos3 + 3;
				$width = substr($output, $pos2_end, $pos3-$pos2_end);//width의 숫자를 알아낸다
				$width = (int)($width);
				if($width > 700){//넓이가 700px보다 클경우
					$width = 700;
					$output = substr($output, 0, $pos2_end).$width.substr($output, $pos3);//width를 바꾼다
					$pos4 = stripos($output, $find4, $pos2_end);//height: 을 찾는다
					if($pos4 !== false){//height: 을 찾았을경우
						$pos4_end = $pos4 + 8;
						$pos5 = stripos($output, $find5, $pos3_end);//<img/>의 끝을 찾는다
						if($pos4 < $pos5){//img 태그 내의 height일 경우
							$pos3b = stripos($output, $find3, $pos4_end);//height의 숫자를 알아낸다
							$pos3b_end = $pos3b + 3;
							$output = substr($output, 0, $pos4).substr($output, $pos3b_end);
						}
					}
				}
				$offset = $pos2_end;
			} else {//width: 를 못 찾았을경우
				$offset = $pos1_end;
			}
		}
	}while($pos1 !== false);//<img가 있을 때 다음 <img를 계속 찾는다
	return $output;
}
function img_adjust($src, $width, $height){//img의 크기를 $width, $height 칸 안에 맞추고 img 태그를 absolute로 반환한다
	$image_size = getimagesize($src);
	$image_width = $image_size[0];
	$image_height = $image_size[1];
	if($image_width <= $width && $image_height <= $height){//가로 세로 모두 작을경우
		$left = (int)(($width - $image_width) / 2);
		$top = (int)(($height - $image_height) / 2);
		$img_tag = '<img src="'.$src.'" style="position:absolute; left:'.$left.'px; top:'.$top.'px;" />';
	} else if($image_width > $width && $image_height <= $height){//가로가 크고 세로는 작을경우
		$width_adjusted = $width;
		$height_adjusted = $image_height * $width_adjusted / $image_width;
		$left = 0;
		$top = (int)(($height - $height_adjusted) / 2);
		$img_tag = '<img src="'.$src.'" width="'.$width_adjusted.'" height="'.$height_adjusted.'" style="position:absolute; left:'.$left.'px; top:'.$top.'px;" />';
	} else if($image_width <= $width && $image_height > $height){//가로는 작고 세로는 클 경우
		$height_adjusted = $height;
		$width_adjusted = $image_width * $height_adjusted / $image_height;
		$top = 0;
		$left = (int)(($width - $width_adjusted) / 2);
		$img_tag = '<img src="'.$src.'" width="'.$width_adjusted.'" height="'.$height_adjusted.'" style="position:absolute; left:'.$left.'px; top:'.$top.'px;" />';
	} else if($image_width > $width && $image_height > $height){//가로, 세로 모두 클 경우
		$width_adjusted = $width;//가로에 맞추고 적용해본다
		$height_adjusted = $image_height * $width_adjusted / $image_width;
		if($height_adjusted <= $height){//조절된 height가 안에 들어갈 때
			$left = 0;
			$top = (int)(($height - $height_adjusted) / 2);
			$img_tag = '<img src="'.$src.'" width="'.$width_adjusted.'" height="'.$height_adjusted.'" style="position:absolute; left:'.$left.'px; top:'.$top.'px;" />';
		} else {//조절된 height가 더 클 때
			$height_adjusted = $height;
			$width_adjusted = $image_width * $height_adjusted / $image_height;
			$top = 0;
			$left = (int)(($width - $width_adjusted) / 2);
			$img_tag = '<img src="'.$src.'" width="'.$width_adjusted.'" height="'.$height_adjusted.'" style="position:absolute; left:'.$left.'px; top:'.$top.'px;" />';
		}
	}
	return $img_tag;
}
function img_adjust2($src, $width, $height){//img의 크기를 $width, $height 칸 안에 맞추고 img 태그를 relative로 반환한다
	$image_size = getimagesize($src);
	$image_width = $image_size[0];
	$image_height = $image_size[1];
	if($image_width <= $width && $image_height <= $height){//가로 세로 모두 작을경우
		$img_tag = '<img src="'.$src.'"/>';
	} else if($image_width > $width && $image_height <= $height){//가로가 크고 세로는 작을경우
		$width_adjusted = $width;
		$height_adjusted = $image_height * $width_adjusted / $image_width;
		$left = 0;
		$top = (int)(($height - $height_adjusted) / 2);
		$img_tag = '<img src="'.$src.'" width="'.$width_adjusted.'" height="'.$height_adjusted.'"/>';
	} else if($image_width <= $width && $image_height > $height){//가로는 작고 세로는 클 경우
		$height_adjusted = $height;
		$width_adjusted = $image_width * $height_adjusted / $image_height;
		$top = 0;
		$left = (int)(($width - $width_adjusted) / 2);
		$img_tag = '<img src="'.$src.'" width="'.$width_adjusted.'" height="'.$height_adjusted.'"/>';
	} else if($image_width > $width && $image_height > $height){//가로, 세로 모두 클 경우
		$width_adjusted = $width;//가로에 맞추고 적용해본다
		$height_adjusted = $image_height * $width_adjusted / $image_width;
		if($height_adjusted <= $height){//조절된 height가 안에 들어갈 때
			$left = 0;
			$top = (int)(($height - $height_adjusted) / 2);
			$img_tag = '<img src="'.$src.'" width="'.$width_adjusted.'" height="'.$height_adjusted.'"/>';
		} else {//조절된 height가 더 클 때
			$height_adjusted = $height;
			$width_adjusted = $image_width * $height_adjusted / $image_height;
			$top = 0;
			$left = (int)(($width - $width_adjusted) / 2);
			$img_tag = '<img src="'.$src.'" width="'.$width_adjusted.'" height="'.$height_adjusted.'"/>';
		}
	}
	return $img_tag;
}
function make_iframe_space($content){//<iframe> 태그 앞에 공백을 넣는다
	$find1 = "<iframe";
	$pos1 = stripos($content, $find1, 0);//"<iframe"의 위치
	while($pos1 !== false){//<iframe 있을 때 다음 <iframe 계속 찾는다
		$pos1_before = substr($content, $pos1-1, 1);//<iframe 바로 앞의 글자를 추출
		$before_check = strcmp($pos1_before, " ");//앞글자가 공백인지 체크
		if($before_check!=0){//앞글자가 공백이 아닐경우
			$content = insert_string($content, $pos1, " ");//<iframe 앞에 공백을 넣는다
		}
		$pos1 = stripos($content, $find1, $pos1+7);//다음 위치에서 다시 <iframe 을 찾는다
	}
	return $content;
}
function add_first_space($content){//맨 앞에 빈칸을 하나 넣는다
	$first_letter = substr($content, 0, 1);//맨 앞글자 추출
	$check = strcmp(" ", $first_letter);//글자 비교
	if($check!=0){//앞글자가 공백이 아닐경우
		$output = " ".$content;
	} else {
		$output = $content;
	}
	return $output;
}
function addComma($number) {//천 단위마다 콤마를 찍습니다
	$regExp = '/(^[+-]?\d+)(\d{3})/';
	$output = $number;
	while (preg_match($regExp, $output)) {
		$output = preg_replace($regExp, '${1},${2}', $output);
	}
	return $output;
}
function add_br($content){//\r\n에 <br/>태그를 넣는다
	$regExp = '/\r\n/i';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '<br/>', $output);
	}
	return $output;
}
function add_br_ex($content){//\n에 <br/>태그를 넣는다
	$regExp = '/\n/i';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '<br/>', $output);
	}
	return $output;
}
function add_br_tag($content){
	$output = $content;
	$output = add_br($output);
	$output = add_br_ex($output);
	return $output;
}
function replace_br($content){ // <br/>태그를 \n으로 치환한다
	$regExp = '/<br\/?>/i';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '\n', $output);
	}
	return $output;
}
function replaceBR2($content){ // <br/>태그를 공백으로 치환한다
	$regExp = '/<br\/?>/i';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, ' ', $output);
	}
	return $output;
}
function add_nbsp($content){//띄어쓰기에 &nbsp; 태그를 넣는다
	$regExp = '/ /';
	$output = $content;
	while (preg_match($regExp, $output)){//못 찾을때까지 계속 찾는다
		$output = preg_replace($regExp, '&nbsp;', $output);
	}
	return $output;
}
function nbsp_wo_tag($content){//<> 안에 있는 태그를 제외하고 띄어쓰기에 &nbsp;를 넣는다
	$find1 = "<";
	$find2 = ">";
	$offset = 0;
	$content_org = add_first_space($content);
	$content_new = "";
	do{
		$pos1 = strpos($content_org, $find1, $offset);//"<"의 위치
		if($pos1 !== false){//$pos1을 찾을경우
			$pos1_end = $pos1 + 1;
			$pos2 = strpos($content_org, $find2, $pos1_end);//">"의 위치
			if($pos2 !== false){
				$pos2_end = $pos2 + 1;//">"가 끝나는 위치
				$content_before_tag = substr($content_org, $offset, $pos1-$offset);//"<" 전의 문자열
				$content_before_tag = add_nbsp($content_before_tag);
				$content_tag = substr($content_org, $pos1, $pos2_end-$pos1);//"<>" 태그
				$content_new .= $content_before_tag.$content_tag;
				$offset = $pos2_end;
			}
		}
	}while( ($pos1 !== false) && ($pos2 !== false) );
	if($content_new != false){//태그가 있었을때
		$content_new .= add_nbsp(substr($content_org, $pos2_end));
	} else if ($content_new==false){//태그가 없었을때
		$content_new = add_nbsp($content);
	}
	return $content_new;
}
function replaceStringCs($content, $target, $string){ // 대소문자를 구별하여 target 문자를 string으로 치환한다
	$regExp = '/'.$target.'/';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, $string, $output);
	}
	return $output;
}
function afterModifyUrl($location){
	$regExp = '/^&.*/';
	$output = $location;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	return $output;
}
function replace_nbsp($content){//&nbsp;를 " "으로 치환한다
	$regExp = '/&nbsp;/';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, ' ', $output);
	}
	return $output;
}
function remove_nbsp($content){//&nbsp;를 지운다
	$regExp = '/&nbsp;/';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	return $output;
}
function remove_space($content){
	$regExp = '/ /';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	return $output;
}
function strip_space($content){
	$output = $content;
	$output = remove_nbsp($output);
	$output = remove_space($output);
	return $output;
}
function remove_br($content){
	$regExp = '/<br\/>/';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	return $output;
}
function remove_br_ex($content){
	$regExp = '/<br>/';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	return $output;
}
function remove_br_tag($content){
	$output = $content;
	$output = remove_br($output);
	$output = remove_br_ex($output);
	return $output;
}
function removeWhitespace($content){// 공백을 제거한다
	$regExp = '/\s/';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, '', $output);
	}
	return $output;
}
function removeEnter($content){ // Enter를 눌렀을 때 나오는 \r\n 혹은 \n을 제거한다.
	$regExp = '/\r\n/i';
	$output = $content;
	while (preg_match($regExp, $output)){
		$output = preg_replace($regExp, ' ', $output);
	}
	$regExp2 = '/\n/i';
	while (preg_match($regExp2, $output)){
		$output = preg_replace($regExp2, ' ', $output);
	}
	return $output;
}
function isThereString($string, $content){ // content 안에 string이 있는지 확인한다
	$regExp = '/'.$string.'/';
	return preg_match($regExp, $content);
}
function remove_tags($content){
	$output = $content;
	$output = removeWhitespace($output);
	$output = replace_nbsp($output);
	return $output;
}
function convert_to_tag($content){ // white-space를 태그로 바꾼다
	$output = $content;
	// $output = add_first_space($output);
	// $output = replace_to_lt($output);
	// $output = replace_to_gt($output);
	$output = nbsp_wo_tag($output);
	$output = add_br_tag($output); // 줄바꿈을 <br/>로 치환한다
	return $output;
}
function is_idmaru_id($content){
	$regExp = '/^idmaru/';
	$output = strtolower($content);
	return preg_match($regExp, $output);
}
function file_ext_decide($type){
	$ext = substr($type, 6);
	if($ext=="png"){$output = "png";}
	else if($ext=="gif"){$output = "gif";}
	else {$output = "jpg";}
	return $output;
}
function img_ext_change($content, $ext){//ooo/ooo.jpg 형식으로 끝나는 그림파일을 ext 형식으로 변환한다
	$find1 = ".";
	$pos1 = strripos($content, $find1, 0);//"."의 위치를 뒤에서부터 찾는다
	$pos1_before = substr($content, 0, $pos1);//"."의 앞 string
	$output = $pos1_before.".".$ext;//ext로 변환
	return $output;
}
function img_direction_rotate($image_path, $image_source) {
	$exifData = exif_read_data($image_path);
	if($exifData['Orientation'] == 6) {
		$degree = 270;
	} else if($exifData['Orientation'] == 8) {
		$degree = 90;
	} else if($exifData['Orientation'] == 3) {
		$degree = 180;
	}
	if($degree) {
		$image_source = imagerotate ($image_source, $degree, 0);
	}
	return $image_source;
}
function img_size_reduce($image_path, $special_char){//$image_path는 사진의 경로. $special_char는 임시파일의 중복을 막기 위한 변수. 사진파일 크기를 줄이고 image_path경로를 return한다.
	$temp_path = '../temp/';//$_SERVER["DOCUMENT_ROOT"]."/devel/temp/"
	$size_limit = 1 * 1024 * 1024;//byte 단위
	$file_size = filesize($image_path);
	$image_path_org = $image_path;
	$image_properties = getimagesize($image_path);
	$image_width = $image_properties[0];
	$image_height = $image_properties[1];
	$type = $image_properties["mime"];
	$width = $image_width;
	$height = $image_height;
	if($type=="image/gif"){//gif파일일 경우
		$tmp_path = $temp_path.$special_char.substr(microtime(true), 11, 4).".gif";
		$image_source = imagecreatefromgif($image_path_org);
		$image_source = img_direction_rotate($image_path_org, $image_source);
		imagegif($image_source, $tmp_path);
		unlink($image_path_org);
		imagedestroy($image_source);
		rename($tmp_path, $image_path_org);
		$result_path = $image_path_org;
	} else {//gif파일이 아닐경우
		require_once ('class/pel/PelJpeg.php');
		$jpeg = new PelJpeg($image_path);
		$exif = $jpeg->getExif();
		$tmp_path = $temp_path.$special_char.substr(microtime(true), 11, 4).".jpg";//.file_ext_decide($type)
		$result_path = img_ext_change($image_path_org, "jpg");//원본 경로를 jpg 형식으로 변환
		if($type == "image/png") {
			$image_source = imagecreatefrompng($image_path_org);
		} else {
			$image_source = imagecreatefromjpeg($image_path_org);
		}
		if($file_size <= $size_limit){//파일사이즈가 작을 경우
			$image_source = img_direction_rotate($image_path_org, $image_source);
			imagejpeg($image_source, $tmp_path, 72);
			unlink($image_path_org);
			imagedestroy($image_source);
		} else {//사진의 화질을 줄이고 모두 jpg로 변환한다
			$image_source_af = imagecreatetruecolor($width, $height);
			imagecopyresampled($image_source_af, $image_source, 0, 0, 0, 0, $width, $height, $width, $height);
			$image_source_af = img_direction_rotate($image_path_org, $image_source_af);
			imagejpeg($image_source_af, $tmp_path, 72);
			unlink($image_path_org);
			imagedestroy($image_source);
			imagedestroy($image_source_af);
		}
		if($exif !== NULL){
			$tiff = $exif->getTiff();
			$ifd0 = $tiff->getIfd();
			$ifd1 = $ifd0->getNextIfd();
			if($ifd0 !== NULL && $ifd0->getEntry(PelTag::ORIENTATION) !== NULL) {$ifd0->getEntry(PelTag::ORIENTATION)->setValue(1);}
			if($ifd1 !== NULL && $ifd1->getEntry(PelTag::ORIENTATION) !== NULL) {$ifd1->getEntry(PelTag::ORIENTATION)->setValue(1);}
			$jpeg_fnl = new PelJpeg($tmp_path);
			$jpeg_fnl->setExif($exif);
			$jpeg_fnl->saveFile($tmp_path);
		}
		rename($tmp_path, $result_path);
	}
	return $result_path;
}
function height_middle($area_height, $object_height){
	$output = (int)(($area_height - $object_height)/2);
	return $output;
}
function user_info($user_num, $others_num, $others_name, $others_photo_path){
	if($user_num != $others_num){return '<div class="user_info" style="top:24px;"><img class="user_photo pointer" src="'.$others_photo_path.'" width="85" onclick="user_pic('.$user_num.', \''.$others_photo_path.'\')"/><div class="select_padding send_msg pointer" onclick="send_message('.$user_num.', '.$others_num.')">쪽지 보내기</div><div class="select_padding pointer" onclick="friend_submit('.$user_num.', \''.$others_name.'\')">친구 신청</div></div>';}
}
function user_info_trader($user_num, $others_num, $others_name, $others_photo_path){
	if($user_num != $others_num){return '<div class="user_info" style="top:24px;"><img class="user_photo pointer" src="'.$others_photo_path.'" width="85" onclick="user_pic('.$user_num.', \''.$others_photo_path.'\')"/><div class="select_padding send_msg pointer" onclick="trader_info('.$others_num.')">사용자 정보</div><div class="select_padding send_msg pointer" onclick="send_message('.$user_num.', '.$others_num.')">쪽지 보내기</div><div class="select_padding pointer" onclick="trader_delete('.$others_num.', \''.$others_name.'\')">삭제</div></div>';}
}
function user_info_groupA($user_num, $others_num, $others_name, $others_photo_path, $count_group){
	if($user_num != $others_num){return '<div class="user_info" style="top:24px;"><img class="user_photo pointer" src="'.$others_photo_path.'" width="85" onclick="user_pic('.$user_num.', \''.$others_photo_path.'\')"/><div class="select_padding send_msg pointer" onclick="send_message('.$user_num.', '.$others_num.')">쪽지 보내기</div><div class="select_padding pointer" onclick="friend_submit('.$user_num.', \''.$others_name.'\')">친구 신청</div><div class="select_padding pointer" onclick="group_exit('.$user_num.', '.$others_num.', \''.$others_name.'\', '.$count_group.')">탈퇴하기</div></div>';}
}
function updown_status($table_name, $count, $writer_num, $updown_up, $updown_down){
	$output = '';
	$output .= '<div class="updown_status">';
	if($updown_up != -1){ // 좋아요가 없을경우 -1로 지정한다
		$output .= '<div class="updown_up" onclick="updown_submit('.$count.', \'up\', '.$updown_up.')" title="좋아요">
			<div class="button_updown_like"><img src="../image/button_like.png"/></div>
			<div id="updown_like_num"> '.$updown_up.'</div>
		</div>';
	}
	if($updown_down != -1){ // 싫어요가 없을경우 -1로 지정한다
		$output .= '<div class="updown_down" onclick="updown_submit('.$count.', \'down\', '.$updown_down.')" title="싫어요">
			<div class="button_updown_dislike"><img src="../image/button_dislike.png"/></div>
			<div id="updown_dislike_num"> '.$updown_down.'</div>
		</div>';
	}
	$output .= '<div id="stranger_call" onclick="stranger_call('.$writer_num.', \''.$table_name.'\', '.$count.')" title="신고"><img src="../image/stranger_call.png"/></div>
	</div>';
	return $output;
}
function link_block($link_addr){
	return '<div class="link_block"><div id="mywrite_link" class="button_small">Link 주소</div><div id="mywrite_link_address">'.$link_addr.'</div></div>';
}
function other_link_area($link_addr, $title, $content){
	return '<div id="other_link_area">
		<a onClick="facebook_link(\''.urlencode($link_addr).'\', \''.urlencode($title).'\', \''.urlencode(substr(strip_tags(remove_tags($content)), 0, 500)).'\', \''.urlencode(find_first_img_link($content)).'\')"><img src="../image/facebook_link.gif" class="other_link_item" alt="Facebook" title="Facebook"/></a>
		<a onClick="twitter_link(\''.urlencode('"'.$title.'" '.$link_addr).'\')"><img src="../image/twitter_link.png" class="other_link_item" alt="Twitter" title="Twitter"/></a>
		<a onClick="me2day_link(\''.urlencode('"'.$title.'":'.$link_addr.' '.substr(strip_tags(remove_tags($content)), 0, 100)).'\')"><img src="../image/me2day_link.png" class="other_link_item" alt="me2day" title="me2day"/></a>
	</div>';
}
function news_type_info_area($type){
	if($type==0){$info_area_type="일상";}
	else if($type==1){$info_area_type="유머";}
	else if($type==4){$info_area_type="음악";}
	else if($type==5){$info_area_type="스포츠";}
	else if($type==6){$info_area_type="주식";}
	else if($type==7){$info_area_type="컴퓨터";}
	else if($type==2){$info_area_type="정보";}
	else if($type==3){$info_area_type="토론";}
	return $info_area_type;
}
function news_type_num($news_type){
	if($news_type=="etc"){$type=0;} // 일상
	else if($news_type=="humor"){$type=1;} // 유머
	else if($news_type=="music"){$type=4;} // 음악
	else if($news_type=="sport"){$type=5;} // 스포츠
	else if($news_type=="stock"){$type=6;} // 주식
	else if($news_type=="computer"){$type=7;} // 컴퓨터
	else if($news_type=="info"){$type=2;} // 정보
	else if($news_type=="debate"){$type=3;} // 토론
	return $type;
}
function gallery_type_info_area($type){
	if($type==0){$info_area_type="일반";}
	else if($type==1){$info_area_type="연예인";}
	else if($type==2){$info_area_type="유머";}
	else if($type==3){$info_area_type="엽기";}
	else if($type==8){$info_area_type="패션";}
	else if($type==4){$info_area_type="자연";}
	else if($type==5){$info_area_type="동물";}
	else if($type==6){$info_area_type="물건";}
	else if($type==7){$info_area_type="얼짱";}
	return $info_area_type;
}
function gallery_type_num($gallery_type){
	if($gallery_type=="common"){$type=0;}
	else if($gallery_type=="celeb"){$type=1;}
	else if($gallery_type=="humor"){$type=2;}
	else if($gallery_type=="unusual"){$type=3;}
	else if($gallery_type=="fashion"){$type=8;}
	else if($gallery_type=="nature"){$type=4;}
	else if($gallery_type=="animal"){$type=5;}
	else if($gallery_type=="thing"){$type=6;}
	else if($gallery_type=="stylish"){$type=7;}
	return $type;
}
function selling_type_name($type){
	if($type==1){$selling_type="게임";}
	else if($type==2){$selling_type="도서";}
	else if($type==3){$selling_type="모바일";}
	else if($type==4){$selling_type="미용";}
	else if($type==5){$selling_type="부동산";}
	else if($type==6){$selling_type="산업용품";}
	else if($type==7){$selling_type="상품권";}
	else if($type==8){$selling_type="생활용품";}
	else if($type==9){$selling_type="스포츠";}
	else if($type==10){$selling_type="여행";}
	else if($type==11){$selling_type="영상기기";}
	else if($type==12){$selling_type="예술";}
	else if($type==13){$selling_type="음악";}
	else if($type==14){$selling_type="의류패션";}
	else if($type==15){$selling_type="차량용품";}
	else if($type==16){$selling_type="카메라";}
	else if($type==17){$selling_type="컴퓨터";}
	else if($type==18){$selling_type="기타용품";}
	else {$selling_type="기타용품";}
	return $selling_type;
}
function selling_type_num($selling_type){
	if($selling_type=="게임"){$type=1;}
	else if($selling_type=="도서"){$type=2;}
	else if($selling_type=="모바일"){$type=3;}
	else if($selling_type=="미용"){$type=4;}
	else if($selling_type=="부동산"){$type=5;}
	else if($selling_type=="산업용품"){$type=6;}
	else if($selling_type=="상품권"){$type=7;}
	else if($selling_type=="생활용품"){$type=8;}
	else if($selling_type=="스포츠"){$type=9;}
	else if($selling_type=="여행"){$type=10;}
	else if($selling_type=="영상기기"){$type=11;}
	else if($selling_type=="예술"){$type=12;}
	else if($selling_type=="음악"){$type=13;}
	else if($selling_type=="의류패션"){$type=14;}
	else if($selling_type=="차량용품"){$type=15;}
	else if($selling_type=="카메라"){$type=16;}
	else if($selling_type=="컴퓨터"){$type=17;}
	else if($selling_type=="기타용품"){$type=18;}
	return $type;
}
function make_thumbnail($src_path, $width_dst, $height_dst, $thumbnail_path=""){
	list($width_src,$height_src, $type) = getimagesize($src_path);
	if ($type!=1 && $type!=2 && $type!=3 && $type!=15) return;
	if ($type==1) $img_src = imagecreatefromgif($src_path);
	else if ($type==2 ) $img_src = imagecreatefromjpeg($src_path);
	else if ($type==3 ) $img_src = imagecreatefrompng($src_path);
	else if ($type==15) $img_src = imagecreatefromwbmp($src_path);
	$x_dst = 0; $y_dst = 0;
	if ($width_src <= $width_dst && $height_src <= $height_dst) {
		$x_src = 0;
		$y_src = 0;
		$img_dst = imagecreatetruecolor($width_src, $height_src);
		imagecopy($img_dst,$img_src,$x_dst,$y_dst,$x_src,$y_src,$width_src,$height_src);
	} else if($width_src <= $width_dst && $height_src >= $height_dst) {
		$x_src = 0;
		$y_src = round(($height_src-$height_dst)/2);
		$img_dst = imagecreatetruecolor($width_src, $height_dst);
		imagecopy($img_dst,$img_src,$x_dst,$y_dst,$x_src,$y_src,$width_src,$height_src);
	} else if($width_src >= $width_dst && $height_src <= $height_dst) {
		$x_src = round(($width_src-$width_dst)/2);
		$y_src = 0;
		$img_dst = imagecreatetruecolor($width_dst, $height_src);
		imagecopy($img_dst,$img_src,$x_dst,$y_dst,$x_src,$y_src,$width_src,$height_src);
	} else if($width_src >= $width_dst && $height_src >= $height_dst) {
		$width_dst_med = $height_dst*$width_src/$height_src;
		if($width_dst_med > $width_dst){
			$cut_src = "width";
		} else {
			$cut_src = "height";
		}
		if ($cut_src=="width") {
			$width_src_med = round($height_dst*$width_src/$height_src);
			$height_src_med = $height_dst;
			$x_src_med = round(($width_src_med-$width_dst)/2);
			$y_src_med = 0;
		} else {// if cut_src=="height",
			$width_src_med = $width_dst;
			$height_src_med = round($width_dst*$height_src/$width_src);
			$x_src_med = 0;
			$y_src_med = round(($height_src_med-$height_dst)/2);
		}
		$img_med = imagecreatetruecolor($width_src_med,$height_src_med); 
		imagecopyresampled($img_med, $img_src,0,0,0,0,$width_src_med,$height_src_med,$width_src,$height_src); 
		$img_dst = imagecreatetruecolor($width_dst,$height_dst); 
		imagecopy($img_dst,$img_med,$x_dst,$y_dst,$x_src_med,$y_src_med,$width_src_med,$height_src_med);
		imagedestroy($img_med);
	}
	if (!$thumbnail_path) {
		$path_parts = pathinfo($src_path);
		$thumbnail_path = $path_parts["dirname"].'/tb_'.$path_parts["basename"];
	}
	if ($type==1) imagegif($img_dst, $thumbnail_path);
	else if ($type==2 ) imagejpeg($img_dst, $thumbnail_path);
	else if ($type==3 ) imagepng($img_dst, $thumbnail_path);
	else if ($type==15) imagewbmp($img_dst, $thumbnail_path);
	imagedestroy($img_src);
	imagedestroy($img_dst);
}
function get_thumbnail_path($photo_path){
	$path_parts = pathinfo($photo_path);
	$thumbnail_path = $path_parts["dirname"].'/thumb/tb_'.$path_parts["basename"];
	return $thumbnail_path;
}
function get_original_path($thumbnail_path){
	$regExp = '/thumb\/tb_/i';
	$original_path = preg_replace($regExp, '', $thumbnail_path);
	return $original_path;
}
?>