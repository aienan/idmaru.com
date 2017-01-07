<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$table_name = $_REQUEST["table_name"];
	$page_name = $_REQUEST["page_name"];
	// Required: anonymous function reference number as explained above.
	$funcNum = $_GET['CKEditorFuncNum'] ;
	// Optional: instance name (might be used to load a specific configuration file or anything else).
	$CKEditor = $_GET['CKEditor'] ;
	// Optional: might be used to provide localized messages.
	$langCode = $_GET['langCode'] ;
	if(isset($_FILES['upload']['tmp_name'])){//파일이 있는 경우
		$type = $_FILES['upload']['type'];
		if(substr($type, 0, 5)!="image"){//image파일이 아닌 경우
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '', '이미지 파일이 아닙니다');</script>";
		} else if( ($type=="image/gif") && ($_FILES['upload']['size']>3145728) ){
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '', 'gif 파일은 3MB를 넘을 수 없습니다');</script>";
		} else if($_FILES['upload']['size']>(10*1024*1024) ){
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '', '이미지 파일은 10MB를 넘을 수 없습니다');</script>";
		} else {
			$path1 = "../files/$table_name/";//폴더 경로
			$file_extension = file_ext_decide($type);
			$file_name = $user_num.substr(microtime(true), 0, 10).substr(microtime(true), 11, 4).".".$file_extension;//파일명을 숫자로 변환
			$photo_path = $path1.$file_name;//저장할 파일 경로
			move_uploaded_file($_FILES['upload']['tmp_name'], $photo_path);//사진파일 저장
			$photo_path = img_size_reduce($photo_path, $user_num);
			$sql = "INSERT INTO temp_image (user_num, table_name, page_name, photo_path) VALUES ($user_num, '$table_name', '$page_name', '$photo_path')";//사진을 임시로 저장
			mysqli_query($conn, $sql);
			echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$photo_path', '');</script>";
		}
	} else {//파일이 없는경우
		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '', '이미지 파일을 선택해주세요');</script>";
	}
?>