<?php
if($user_num==0){exit;}
$page_name = $_REQUEST["page_name"];
$table_name_photo = $table_name."_photo";
if($write_new=="new"){//새로 등록할 경우
	$sql = "INSERT INTO counter (name, value) VALUES('$table_name', LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE value = LAST_INSERT_ID(value+1)";
	mysqli_query($conn, $sql);
	$image_arr = make_img_array($content);
	$image_arr_count = count($image_arr);
	$sql3 = "SELECT * FROM temp_image WHERE user_num=$user_num AND table_name='$table_name' AND page_name='$page_name'";//temp_image 테이블 검색
	$sql_query3 = mysqli_query($conn, $sql3);
	$count3 = mysqli_num_rows($sql_query3);
	for($i=0; $i < $count3; $i++){//temp_image 테이블의 이미지
		$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
		$dont_delete = 0;//0으로 남으면 지운다
		for($j=0; $j < $image_arr_count; $j++){
			if($sql_fetch_array3["photo_path"]==$image_arr[$j]){//글에서 이미지가 쓰였을경우
				$sql2 = "INSERT INTO $table_name_photo (count, photo_path) VALUES (LAST_INSERT_ID(), '$sql_fetch_array3[photo_path]')";//글 안의 사진, DB에 입력
				mysqli_query($conn, $sql2);
				$photo_path_new = $sql_fetch_array3["photo_path"];
				$thumb_width_dst = 235;
				list($photo_path_new_width,$photo_path_new_height) = getimagesize($photo_path_new);
				$thumb_height_dst = round($thumb_width_dst * $photo_path_new_height / $photo_path_new_width);
				$thumbnail_path = get_thumbnail_path($photo_path_new);
				make_thumbnail($photo_path_new, $thumb_width_dst, $thumb_height_dst, $thumbnail_path);
				$dont_delete = 1;
				break;
			}
		}
		if($dont_delete==0){//글에서 이미지가 안 쓰였을경우
			unlink($sql_fetch_array3["photo_path"]);
		}
	}
	$sql4 = "DELETE FROM temp_image WHERE user_num=$user_num AND table_name='$table_name' AND page_name='$page_name'";//temp_image 테이블의 정보를 지운다
	mysqli_query($conn, $sql4);
} else if($write_new=="modify"){//수정일 경우
	$image_arr = make_img_array($content);
	$image_arr_count = count($image_arr);
	$sql3 = "SELECT * FROM temp_image WHERE user_num=$user_num AND table_name='$table_name' AND page_name='$page_name'";//temp_image 테이블 검색
	$sql_query3 = mysqli_query($conn, $sql3);
	$count3 = mysqli_num_rows($sql_query3);
	$sql5 = "SELECT * FROM $table_name_photo WHERE count = $count";
	$sql_query5 = mysqli_query($conn, $sql5);
	$count5 = mysqli_num_rows($sql_query5);
	$check_count = $count3 + $count5;//총 검색해야 할 이미지 수
	for($i=0; $i < $check_count; $i++){//총 검색해야할 이미지
		$dont_delete = 0;//0으로 남으면 지운다
		if($i < $count3){//temp_image의 이미지를 먼저 체크한다
			$check_path = mysqli_fetch_array($sql_query3);
		} else {//temp_image 체크 후 기존 이미지를 체크한다
			$check_path = mysqli_fetch_array($sql_query5);
		}
		for($j=0; $j < $image_arr_count; $j++){
			if($check_path["photo_path"]==$image_arr[$j]){//글에서 이미지가 쓰였을경우
				if($i < $count3){//temp_image 테이블에 있는 것일 경우
					$sql2 = "INSERT INTO $table_name_photo (count, photo_path) VALUES ($count, '$check_path[photo_path]')";//글 안의 사진, DB에 입력
					mysqli_query($conn, $sql2);
					$photo_path_new = $check_path["photo_path"];
					$thumb_width_dst = 235;
					list($photo_path_new_width,$photo_path_new_height) = getimagesize($photo_path_new);
					$thumb_height_dst = round($thumb_width_dst * $photo_path_new_height / $photo_path_new_width);
					$thumbnail_path = get_thumbnail_path($photo_path_new);
					make_thumbnail($photo_path_new, $thumb_width_dst, $thumb_height_dst, $thumbnail_path);
				}
				$dont_delete = 1;
				break;
			}
		}
		if($dont_delete==0){//글에서 이미지가 안 쓰였을경우
			unlink($check_path["photo_path"]);//파일 삭제
			if($i >= $count3){//photo 테이블에 들어가 있을경우
				$sql6 = "DELETE FROM $table_name_photo WHERE count=$count AND photo_path='$check_path[photo_path]'";
				mysqli_query($conn, $sql6);
				unlink(get_thumbnail_path($check_path["photo_path"]));//썸네일 삭제
			}
		}
	}
	$sql4 = "DELETE FROM temp_image WHERE user_num=$user_num AND table_name='$table_name' AND page_name='$page_name'";//temp_image 테이블의 정보를 지운다
	mysqli_query($conn, $sql4);
}
?>