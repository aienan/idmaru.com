<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$count = $_REQUEST["count"];
	$battle_submit = $_REQUEST["battle_submit"];
	$battle_exist = $_REQUEST["battle_exist"];
	$photo_battle_category = $_REQUEST["photo_battle_category"];
	$gallery_type = $_REQUEST["gallery_type"];
	$status = $_REQUEST["status"];
	if($status=="all"){
		$status = 1;
	} else if($status=="friend"){
		$status = 2;
	} else if($status=="private"){
		$status = 3;
	}
	$content = $_REQUEST["mywrite_content"];
	$content = replace_symbols($content);
	$writetime = date("Y-m-d, H:i:s");
	$sql = "UPDATE photo SET type=$gallery_type, content='$content', status='$status', writetime='$writetime', index_update='0' WHERE count=$count AND user_num=$user_num";//사진을 제외한 나머지를 수정한다
	mysqli_query($conn, $sql);
	$sql1 = "UPDATE photo_read_counter SET status='$status', type=$gallery_type WHERE count=$count";
	mysqli_query($conn, $sql1);
	if($battle_submit=='y'){ //이상형월드컵에 등록할때
		if($battle_exist==1){ // 이미 등록된 상태일때
			$sql6 = "SELECT * FROM photo_battle_type WHERE count=$count"; // 예전 type 정보
			$sql_query6 = mysqli_query($conn, $sql6);
			$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
			if($sql_fetch_array6["photo_type"] != $photo_battle_category){ // 경기종목이 다를때
				$sql5 = "UPDATE photo_battle_category SET number=number-1 WHERE photo_type='$sql_fetch_array6[photo_type]'"; // 예전 type의 갯수를 줄임
				mysqli_query($conn, $sql5);
				$sql2 = "UPDATE photo_battle_type SET photo_type='$photo_battle_category' WHERE count=$count";
				mysqli_query($conn, $sql2);
				$sql7 = "UPDATE photo_battle_category SET number=number+1 WHERE photo_type='$photo_battle_category'";
				mysqli_query($conn, $sql7);
				$sql8 = "DELETE FROM photo_battle_score WHERE photo_type='$sql_fetch_array6[photo_type]' AND count = $count";
				mysqli_query($conn, $sql8);
			}
		} else { // 미등록 상태일때
			$sql3 = "INSERT INTO photo_battle_type (photo_type, count) VALUES ('$photo_battle_category', $count)";
			mysqli_query($conn, $sql3);
			$sql7 = "UPDATE photo_battle_category SET number=number+1 WHERE photo_type='$photo_battle_category'";
			mysqli_query($conn, $sql7);
		}
	} else { // 이상형월드컵에 미등록할 때
		if($battle_exist==1){ // 이미 등록된 상태일때
			$sql4 = "DELETE FROM photo_battle_type WHERE photo_type='$photo_battle_category' AND count=$count";
			mysqli_query($conn, $sql4);
			$sql7 = "UPDATE photo_battle_category SET number=number-1 WHERE photo_type='$photo_battle_category'";
			mysqli_query($conn, $sql7);
		}
	}
?>