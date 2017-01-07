<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$type = $_FILES['idcard_photo']['type'];
	if(!$_FILES['idcard_photo']['name']){//파일을 선택하지 않은경우
		echo "<script>alert('파일을 선택해 주십시오.');location.href='idcard_photo.php';</script>";
	} else if(substr($type, 0, 5)!="image"){//image파일이 아닌 경우
		echo "<script>alert('image 파일이 아닙니다.');location.href='idcard_photo.php';</script>";
	} else if( ($type=="image/gif") && ($_FILES['idcard_photo']['size']>3145728) ){
		echo "<script>alert('gif 파일은 3MB를 넘을 수 없습니다.');location.href='idcard_photo.php';</script>";
	} else if($_FILES['upload']['size']>(10*1024*1024)){
		echo "<script type='text/javascript'>alert('이미지 파일은 10MB를 넘을 수 없습니다');location.href='idcard_photo.php';</script>";
	} else {
		$sql = "SELECT * FROM idcard_photo WHERE user_num=$user_num";
		$sql_query = mysqli_query($conn, $sql);
		$count = mysqli_num_rows($sql_query);
		$sql_fetch_array = mysqli_fetch_array($sql_query);
		$remove_file = $sql_fetch_array["idcard_photo_path"];
		if(file_exists($remove_file)){//파일이 존재할 경우
			unlink($remove_file);//파일 제거
		}
		$path1 = "../files/idcard/";//user_num 폴더 경로
		// $path2 = $path1 . basename($_FILES['idcard_photo']['name']);//저장할 파일 경로
		$file_extension = file_ext_decide($type);
		$path2 = $path1.$user_num.substr(microtime(true), 11, 4).".".$file_extension;
		$file = $_FILES['idcard_photo']['tmp_name'];
		move_uploaded_file($file, $path2);//사진파일 저장
		$path2 = img_size_reduce($path2, $user_num);
		if(!$count){//처음 등록일 경우
			$sql1 = "INSERT INTO idcard_photo (user_num, idcard_photo_path) VALUES ($user_num, '$path2')";
		} else if($count){//재등록일 경우
			$sql1 = "UPDATE idcard_photo SET idcard_photo_path='$path2' WHERE user_num=$user_num";
		}
		mysqli_query($conn, $sql1);
		
		echo" <script>alert('사진이 등록되었습니다'); location.href='idcard_photo.php';</script>";
	} 
?>