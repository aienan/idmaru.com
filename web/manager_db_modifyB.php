<?php
//글 안의 사진이 테이블에도 등록되어 있는지 확인
include 'header.php';
include 'declare_php.php';
$type = $_REQUEST["type"];
$table_name = $_REQUEST["table_name"];
$table_name_photo = $table_name."_photo";
$sql1 = "SELECT * FROM $table_name";
$sql_query1 = mysqli_query($conn, $sql1);
$count1 = mysqli_num_rows($sql_query1);
if($type=="modify"){
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$content = $sql_fetch_array1["content"];
		$img_arr = make_img_array($content);//글 안의 이미지 배열
		$img_arr_number = count($img_arr);//이미지 갯수
		$sql2 = "SELECT * FROM $table_name_photo WHERE count=$sql_fetch_array1[count]";//$table_name_photo에 등록된 사진 검색
		$sql_query2 = mysqli_query($conn, $sql2);
		$count2 = mysqli_num_rows($sql_query2);
		if($count2==$img_arr_number){continue;}//사진이 모두 등록됐을때
		else {
			$sql3 = "DELETE FROM $table_name_photo WHERE count=$sql_fetch_array1[count]";//사진 경로 삭제
			mysqli_query($conn, $sql3);
			for($j=0; $j < $img_arr_number; $j++){//사진 경로를 등록
				$photo_path = $img_arr[$j];
				$sql4 = "INSERT INTO $table_name_photo (count, photo_path) VALUES ($sql_fetch_array1[count], '$photo_path')";
				mysqli_query($conn, $sql4);
			}
		}
	}
}
echo '<script>alert("'.$table_name.' 이 '.$type.' 로  적용되었습니다");</script>';
?>