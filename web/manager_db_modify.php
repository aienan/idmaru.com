<?php
	//띄어쓰기와 \n에 nbsp와 br태그를 넣는다
	include 'header.php';
	include 'declare_php.php';
	$type = $_REQUEST["type"];
	$table_name = "";
	$sql1 = "SELECT * FROM $table_name";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($type=="modify"){
		for($i=0; $i < $count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$content = $sql_fetch_array1["content"];
			$content = replace_nbsp($content); // 일단 &nbsp;를 띄어쓰기로 바꾼다
			$content = nbsp_wo_tag($content);//띄어쓰기에 nbsp를 넣는다
			$content = add_br_tag($content);// br 태그를 넣는다
			// $sql2 = "UPDATE $table_name SET content='$content' WHERE count=$sql_fetch_array1[count]";
			// $sql2 = "UPDATE $table_name SET content='$content' WHERE count_upperwrite=$sql_fetch_array1[count_upperwrite] AND count=$sql_fetch_array1[count]"; // reply 테이블에서 사용
			$sql2 = "UPDATE $table_name SET content='$content' WHERE caller_num=$sql_fetch_array1[caller_num] AND stranger_num=$sql_fetch_array1[stranger_num] AND count_upperwrite=$sql_fetch_array1[count_upperwrite] AND count=$sql_fetch_array1[count]"; // stranger_call 테이블에서 사용
			mysqli_query($conn, $sql2);
		}
	} else if($type=="reverse"){
		for($i=0; $i < $count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$content = $sql_fetch_array1["content"];
			$content = replace_nbsp($content);
			$content = replace_br($content);
			
			// $sql2 = "UPDATE $table_name SET content='$content' WHERE count=$sql_fetch_array1[count]";
			
			$sql2 = "UPDATE $table_name SET content='$content' WHERE count_upperwrite=$sql_fetch_array1[count_upperwrite] AND count=$sql_fetch_array1[count]"; // reply 테이블에서 사용
			
			mysqli_query($conn, $sql2);
		}
	}
	echo '<script>alert("'.$table_name.' 이 '.$type.' 로  적용되었습니다");</script>';
	
?>