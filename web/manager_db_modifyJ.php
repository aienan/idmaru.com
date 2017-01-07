<?php
// ..jpg 를 .jpg로 바꾸기
include 'header.php';
include 'declare_php.php';
$type = $_REQUEST["type"];
$table_name = $_REQUEST["table_name"];
$table_name_photo = $table_name."_photo";
$sql1 = "SELECT * FROM $table_name";
$sql_query1 = mysqli_query($conn, $sql1);
$count1 = mysqli_num_rows($sql_query1);
for($i=0; $i < $count1; $i++) {
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$output = $sql_fetch_array1["content"];
	$regExp = '/\.\.jpg/i';
	while(preg_match($regExp, $output)){
		$output = preg_replace($regExp, '.jpg', $output);
	}
	$sql3 = "UPDATE $table_name SET content='$output' WHERE count=$sql_fetch_array1[count]";
	mysqli_query($conn, $sql3);
}
echo '<script>alert("'.$table_name_photo.' 이 '.$type.' 로  적용되었습니다");</script>';
?>