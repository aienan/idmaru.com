<?php
// table_name_photo 정보를 table_name의 본문 내용을 바탕으로 갱신하기
include 'header.php';
include 'declare_php.php';
$type = $_REQUEST["type"];
$table_name = $_REQUEST["table_name"];
$table_name_photo = $table_name."_photo";
$sql4 = "DELETE FROM $table_name_photo";
mysqli_query($conn, $sql4);
$sql1 = "SELECT * FROM $table_name";
$sql_query1 = mysqli_query($conn, $sql1);
$count1 = mysqli_num_rows($sql_query1);
for($i=0; $i < $count1; $i++) {
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$image_arr = make_img_array($sql_fetch_array1["content"]);
	$image_arr_count = count($image_arr);
	for($j=0; $j < $image_arr_count; $j++){
		$photo_path = $image_arr[$j];
		$regExp = '/http/i';
		if(preg_match($regExp, $photo_path)==1){continue;}
		$sql3 = "INSERT INTO $table_name_photo (count, photo_path) VALUES ($sql_fetch_array1[count], '$photo_path')";
		mysqli_query($conn, $sql3);
	}
}
echo '<script>alert("'.$table_name.' 이 '.$type.' 로  적용되었습니다");</script>';
?>