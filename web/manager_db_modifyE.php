<?php
	//21zc 혹은 21zx를 지운다 // inner_link를 count_link로 바꾼다
	include 'header.php';
	include 'declare_php.php';
	$type = $_REQUEST["type"];
	$table_name = "home_alarm";
	$sql1 = "SELECT * FROM $table_name";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($type=="modify"){
		for($i=0; $i < $count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$description = $sql_fetch_array1["description"];
			// $description = strip_string_ci('21zc', $description); // 21zc를 지운다
			// $description = strip_string_ci('21zx', $description); // 21zx를 지운다
			// $description = strip_string_ci('http:\/\/www\.idmaru\.com\/web\/', $description);
			// $description = replaceStringCs($description, 'inner_link', 'count_link');
			$sql2 = "UPDATE $table_name SET description='$description' WHERE user_num=$sql_fetch_array1[user_num] AND table_name='$sql_fetch_array1[table_name]' AND count=$sql_fetch_array1[count] AND count2=$sql_fetch_array1[count2]"; // home_alarm 테이블에서 사용
			mysqli_query($conn, $sql2);
		}
	} else if($type=="reverse"){
	}
	echo '<script>alert("'.$table_name.' 이 '.$type.' 로  적용되었습니다");</script>';
?>