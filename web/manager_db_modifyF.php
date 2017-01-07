<?php
// Thumbnail 사진 만들기
include 'header.php';
include 'declare_php.php';
$type = $_REQUEST["type"];
$table_name = $_REQUEST["table_name"];
$table_name_photo = $table_name."_photo";
$sql1 = "SELECT * FROM $table_name_photo";
$sql_query1 = mysqli_query($conn, $sql1);
$count1 = mysqli_num_rows($sql_query1);
for($i=0; $i < $count1; $i++) {
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$photo_path = $sql_fetch_array1["idcard_photo_path"];
	$thumb_width_dst = 235;
	list($photo_path_width,$photo_path_height) = getimagesize($photo_path);
	$thumb_height_dst = round($thumb_width_dst * $photo_path_height / $photo_path_width);
	$thumbnail_path = get_thumbnail_path($photo_path);
	make_thumbnail($photo_path, $thumb_width_dst, $thumb_height_dst, $thumbnail_path);
}
echo '<script>alert("'.$table_name.' 이 '.$type.' 로  적용되었습니다");</script>';
?>