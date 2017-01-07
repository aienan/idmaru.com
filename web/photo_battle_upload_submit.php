<?php
	include 'header.php';
	include 'declare_php.php';
	$photo_battle_category = $_REQUEST["photo_battle_category"];
	$gallery_type = $_REQUEST["gallery_type"];
	$content = $_REQUEST["mywrite_content"];
	$content = replace_symbols($content);
	$writetime = date("Y-m-d, H:i:s");
	$photo_ext = $_FILES['photo_battle']['type'];
	if(!$_FILES['photo_battle']['name']){//파일을 선택하지 않은경우
		echo "<script>alert('파일을 선택해 주십시오.');location.href='photo_battle_upload.php';</script>";
	} else if(substr($photo_ext, 0, 5)!="image"){//image파일이 아닌 경우
		echo "<script>alert('image 파일이 아닙니다.');location.href='photo_battle_upload.php';</script>";
	} else if( ($photo_ext=="image/gif") && ($_FILES['photo_battle']['size']>3145728) ){
		echo "<script>alert('gif 파일은 3MB를 넘을 수 없습니다.');location.href='photo_battle_upload.php';</script>";
	} else if($_FILES['upload']['size']>(10*1024*1024)){
		echo "<script type='text/javascript'>alert('이미지 파일은 10MB를 넘을 수 없습니다');location.href='photo_battle_upload.php';</script>";
	} else {
		$sql = "INSERT INTO counter (name, value) VALUES('photo', LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE value = LAST_INSERT_ID(value+1)";
		mysqli_query($conn, $sql);
		$path1 = "../files/photo/";
		$file_ext = file_ext_decide($photo_ext);
		$file_name = $user_num.substr(microtime(true), 0, 10).substr(microtime(true), 11, 4).".".$file_ext;//파일명을 숫자로 변환
		$photo_path = $path1.$file_name;
		$file = $_FILES['photo_battle']['tmp_name'];
		move_uploaded_file($file, $photo_path);//사진파일 저장
		$photo_path = img_size_reduce($photo_path, $user_num);
		$sql2 = "INSERT INTO photo_battle_type (photo_type, count) VALUES ('$photo_battle_category', LAST_INSERT_ID())";
		mysqli_query($conn, $sql2);
		$sql4 = "UPDATE photo_battle_category SET number=number + 1 WHERE photo_type='$photo_battle_category'";
		mysqli_query($conn, $sql4);
		$sql = "INSERT INTO photo (count, user_num, type, photo_path, content, status, writetime, read_count, up_total, index_update) VALUES (LAST_INSERT_ID(), $user_num, $gallery_type, '$photo_path', '$content', '1', '$writetime', 0, 0, '0')";
		mysqli_query($conn, $sql); 
		$sql3 = "INSERT INTO photo_read_counter (count, status, type, read_count_1, read_count_7, read_count_30) VALUES (LAST_INSERT_ID(), '1', $gallery_type, 0, 0, 0)";
		mysqli_query($conn, $sql3);
		
		echo "<script>alert('사진이 등록되었습니다'); location.href='photo_battle_upload.php';</script>";
	} 
?>