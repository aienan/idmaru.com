<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$gallery_type = $_REQUEST["gallery_type"];
	$status = $_REQUEST["status"];
	if($status=="all"){
		$status = 1;
	} else if($status=="friend"){
		$status = 2;
	} else if($status=="private"){
		$status = 3;
	}
	$content = $_REQUEST["mywrite_content"];
	$content = replace_symbols($content);
	$writetime = date("Y-m-d, H:i:s");
	$uploader_count = $_REQUEST["uploader_count"];
	$comment='';
	$path1 = "../files/photo/";//폴더 경로
	for($i=0; $i < $uploader_count; $i++){
		$request_i_tmpname = "uploader_".$i."_tmpname";
		$tmpFileName = $_REQUEST[$request_i_tmpname];//temp에 저장된 파일 이름
		$photo_path_old = "../temp/".$tmpFileName;
		$file_size = filesize($photo_path_old);
		$image_properties = getimagesize($photo_path_old);
		$type = $image_properties["mime"];
		if( ($type=="image/gif") && ($file_size>3145728) ){unlink($photo_path_old); $order = $i+1; $comment .= $order.', ';}//gif파일이 3MB를 넘을경우
		else{
			$ext_pos = strrpos($tmpFileName, '.');//확장자의 시작위치 ("." 포함)
			$file_ext = substr($tmpFileName, $ext_pos);//파일 확장자
			$file_name = $user_num.substr(microtime(true), 0, 10).substr(microtime(true), 11, 4).$file_ext;//파일명을 숫자로 변환
			$photo_path_new = $path1.$file_name;
			rename($photo_path_old, $photo_path_new);//사진의 경로를 바꿔준다
			$photo_path_new = img_size_reduce($photo_path_new, $user_num);
			$sql = "INSERT INTO counter (name, value) VALUES('photo', LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE value = LAST_INSERT_ID(value+1)";
			mysqli_query($conn, $sql);
			$sql = "INSERT INTO photo (count, user_num, type, photo_path, content, status, writetime, read_count, up_total, index_update) VALUES (LAST_INSERT_ID(), $user_num, $gallery_type, '$photo_path_new', '$content', '$status', '$writetime', 0, 0, '0')";
			mysqli_query($conn, $sql); 
			$thumb_width_dst = 235;
			list($photo_path_new_width,$photo_path_new_height) = getimagesize($photo_path_new);
			$thumb_height_dst = round($thumb_width_dst * $photo_path_new_height / $photo_path_new_width);
			$thumbnail_path = get_thumbnail_path($photo_path_new);
			make_thumbnail($photo_path_new, $thumb_width_dst, $thumb_height_dst, $thumbnail_path);
			$sql3 = "INSERT INTO photo_read_counter (count, status, type, read_count_1, read_count_7, read_count_30) VALUES (LAST_INSERT_ID(), '$status', $gallery_type, 0, 0, 0)";
			mysqli_query($conn, $sql3);
		}
	}
	if($comment==""){
		echo '
			<script>
				alert("사진이 등록되었습니다");
				if(window.parent.opener.location.href.search(/photo/) != -1){window.parent.opener.location.reload();}
				window.parent.location.href="photo_upload.php";
			</script>
		';
	} else{
		$comment = substr($comment, 0, -2);
		echo '
			<script>
				alert("'.$comment.'번째 사진은 등록되지 못했습니다. (파일크기 3MB 초과)");
				if(window.parent.opener.location.href.search(/photo/) != -1){window.parent.opener.location.reload();}
				window.parent.location.href="photo_upload.php";
			</script>
		';
	}
?>