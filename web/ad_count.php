<?php
	include 'header.php';
	include 'declare_php.php';
	$ad_type = $_REQUEST["ad_type"];
	$ad_condition = $_REQUEST["ad_condition"];
	$sql2 = "SELECT * FROM $ad_type WHERE ad_condition='$ad_condition'";
	$sql_query2 = mysqli_query($conn, $sql2);
	$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
	if(isset($_SESSION[$ad_type])){//전에 본 광고가 있을경우
		$read_doc_list = $_SESSION[$ad_type];
		$read_doc_array = explode(";",$read_doc_list);//현재 세션에 있는 내용을 조각냅니다.
		$read_doc_exist = 0;//조회수를 올려도 되는지 저장하는 변수를 초기화
		for($i=0; $i < sizeof($read_doc_array); $i++){//이미 읽은 광고인지 검사
			if($read_doc_array[$i]==$ad_condition){
				$read_doc_exist = 1;
				break; 
			}
		}
		if($read_doc_exist==0){//읽은 글이 아닐경우
			$read_doc_list .= $ad_condition.";";
			$click_count = $sql_fetch_array2["click_count"] + 1;
			$sql = "UPDATE $ad_type SET click_count=$click_count WHERE ad_condition='$ad_condition'";
			mysqli_query($conn, $sql);
		}
	} else {//읽은 글이 하나도 없을경우
		$read_doc_list = $ad_condition.";";
		$click_count = $sql_fetch_array2["click_count"] + 1;
		$sql = "UPDATE $ad_type SET click_count=$click_count WHERE ad_condition='$ad_condition'";
		mysqli_query($conn, $sql);
	}
	$_SESSION[$ad_type] = $read_doc_list;
?>