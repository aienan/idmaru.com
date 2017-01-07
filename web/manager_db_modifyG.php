<?php
// 특정 문자열을 가진 row를 찾아서 값 변경하기
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
	$photo_path = $sql_fetch_array1["photo_path"];
	$regExp = '/[0-9]+\.peg$/i';
	if(preg_match($regExp, $photo_path)){
		$path_parts = pathinfo($photo_path);
		$rename_path = $path_parts["dirname"]."/".$path_parts["filename"].'.jpg';
		rename($photo_path, $rename_path);
		$sql5 = "UPDATE $table_name_photo SET photo_path='$rename_path' WHERE count=$sql_fetch_array1[count]";
		mysqli_query($conn, $sql5);
	}
	$sql2 = "SELECT * FROM $table_name WHERE count=$sql_fetch_array1[count]";
	$sql_query2 = mysqli_query($conn, $sql2);
	$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
	$regExp = '/'.$path_parts["filename"].'.peg/i';
	if(preg_match($regExp, $sql_fetch_array2["content"])){
		$output = preg_replace($regExp, $path_parts["filename"].'.jpg', $sql_fetch_array2["content"]);
		$sql3 = "UPDATE $table_name SET content='$output' WHERE count=$sql_fetch_array1[count]";
		mysqli_query($conn, $sql3);
	}
}
echo '<script>alert("'.$table_name_photo.' 이 '.$type.' 로  적용되었습니다");</script>';
?>