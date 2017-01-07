<?php
	include 'header.php';
	include 'mysql_setting.php';
	$table_name = $_REQUEST["table_name"];
	$page_name = $_REQUEST["page_name"];
	$photo_number = $_REQUEST["photo_number"];
	$sql1 = "SELECT * FROM temp_image WHERE user_num=$user_num AND table_name='$table_name' AND page_name='$page_name' ORDER BY number ASC";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$i_start = $count1 - $photo_number;
	$output = '';
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		if($i < $i_start){continue;}
		else {
			$image_properties = getimagesize($sql_fetch_array1["photo_path"]);
			if($image_properties[0] > 705 ){$img_width = 705;} // image가 705px을 넘으면 705로 맞춰준다
			else {$img_width = $image_properties[0];}
			$img_tag = '<br/><img src="'.$sql_fetch_array1["photo_path"].'" width="'.$img_width.'" />';
			$output .= $img_tag;
		}
	}
	echo $output;
?>