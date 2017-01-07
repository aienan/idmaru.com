<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$table_name = $_REQUEST["table_name"];
	$page_name = $_REQUEST["page_name"];
	$uploader_count = $_REQUEST["uploader_count"];
	$comment='';
	$path1 = "../files/$table_name/";//폴더 경로
	// $file_name = basename(iconv("UTF-8", "CP949", $_FILES['photo']['name']));//한글파일 저장 문제 해결. 하지만 javascript가 그림파일을 제대로 인식 못해서 사용 안하게 되었음.
	// $file_name = iconv("CP949", "UTF-8", $file_name);
	$sql2 = "SELECT COUNT(*) AS count_all FROM temp_image WHERE user_num=$user_num AND table_name='$table_name' AND page_name='$page_name'";
	$sql_query2 = mysqli_query($conn, $sql2);
	$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
	for($i=0; $i < $uploader_count; $i++){
		$request_i_tmpname = "uploader_".$i."_tmpname";
		$tmpFileName = $_REQUEST[$request_i_tmpname];//temp에 저장된 파일 이름
		$photo_path_old = "../temp/".$tmpFileName;
		$file_size = filesize($photo_path_old);
		$image_properties = getimagesize($photo_path_old);
		$type = $image_properties["mime"];
		if( ($type=="image/gif") && ($file_size>3145728) ){unlink($photo_path_old); $order = $i+1; $comment .= $order.', ';}//gif파일이 3MB를 넘을경우
		else {
			$ext_pos = strrpos($tmpFileName, '.');//확장자의 시작위치 ("." 포함)
			$file_ext = substr($tmpFileName, $ext_pos);//파일 확장자
			$file_name = $user_num.substr(microtime(true), 0, 10).substr(microtime(true), 11, 4).$file_ext;//파일명을 숫자로 변환
			$photo_path = $path1.$file_name;
			rename($photo_path_old, $photo_path);//사진의 경로를 바꿔준다
			$photo_path = img_size_reduce($photo_path, $user_num);
			$photo_number = $i + 1 + $sql_fetch_array2["count_all"];
			$sql = "INSERT INTO temp_image (user_num, table_name, page_name, number, photo_path) VALUES ($user_num, '$table_name', '$page_name', $photo_number, '$photo_path')";//사진을 임시로 저장
			mysqli_query($conn, $sql);
		}
	}
	if($comment==''){
	} else{
		$comment = substr($comment, 0, -2);
		echo '<script>alert("'.$comment.'번째 사진은 등록되지 못했습니다. (파일크기 3MB 초과)");</script>';
	}
?>