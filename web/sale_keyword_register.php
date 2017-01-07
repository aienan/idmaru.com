<?php
	include 'header.php';
	include 'mysql_setting.php';
	$keyword=$_REQUEST["keyword"];
	$max_num = 5;
	$sql3 = "SELECT * FROM sale_keyword WHERE user_num = $user_num";//키워드 등록된 갯수를 세기 위함
	$sql_query3 = mysqli_query($conn, $sql3);
	$count3 = mysqli_num_rows($sql_query3);
	$sql1 = "SELECT * FROM sale_keyword WHERE user_num = $user_num AND keyword = '$keyword'";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count3 >= $max_num){//키워드 등록 최대 갯수를 넘을 때
		echo "max_num";
	} else if($count3 <= $max_num){//키워드 등록 최대 갯수를 넘지 않을 때
		if($count1 == 1){//이미 키워드가 등록되어 있을 때
			echo "already";
		} else if(!$count1){//키워드가 없을 때
			$sql2 = "INSERT INTO sale_keyword (user_num, keyword) VALUES ($user_num, '$keyword')";
			mysqli_query($conn, $sql2);
			echo "done";
		}
	}
	
?>