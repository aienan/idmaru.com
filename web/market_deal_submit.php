<?php
	include 'header.php';
	include 'mysql_setting.php';
	if($user_num==0){exit;}
	$type = $_REQUEST["type"];
	$count = $_REQUEST["count"];
	$bet_money = $_REQUEST["bet_money"];
	$comment = $_REQUEST["comment"];
	$user_num_other = $_REQUEST["user_num_other"];
	$title = $_REQUEST["title"];
	$writetime = date("Y-m-d, H:i:s");
	$table_name = "market_deal";
	if($type=="new"){//입찰을 새로 등록하는 것일경우
		$sql = "INSERT INTO $table_name (count, user_num, bet_money, comment, writetime) VALUES ($count, $user_num, '$bet_money', '$comment', '$writetime')";
		mysqli_query($conn, $sql);
		if($user_num != $user_num_other){
			$description = '<a href="market.php?count_link='.$count.'" class="link">"'.$title.'"에 '.$user_name.'님이 입찰하셨습니다.</a>';
			$sql2 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($user_num_other, 'market_deal_new', $user_num, $count, '$description', '$writetime')";
			mysqli_query($conn, $sql2);
		}
	} else if($type=="modify"){
		$sql = "UPDATE $table_name SET bet_money='$bet_money', comment='$comment', writetime='$writetime' WHERE count=$count AND user_num=$user_num";
		mysqli_query($conn, $sql);
		if($user_num != $user_num_other){
			$description = '<a href="market.php?count_link='.$count.'" class="link">"'.$title.'"에서 '.$user_name.'님이 입찰정보를 수정하셨습니다.</a>';
			$sql2 = "INSERT INTO home_alarm (user_num, table_name, count, count2, description, writetime) VALUES ($user_num_other, 'market_deal_modify', $user_num, $count, '$description', '$writetime')";
			mysqli_query($conn, $sql2);
		}
	} else if($type=="delete"){
		$sql = "DELETE FROM $table_name WHERE count=$count AND user_num=$user_num";
		mysqli_query($conn, $sql);
	}
?>