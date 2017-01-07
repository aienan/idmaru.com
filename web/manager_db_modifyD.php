<?php
	//table_name 테이블의 type를 read_counter의 type에 입력한다
	include 'header.php';
	include 'declare_php.php';
	$type = $_REQUEST["type"];
	$table_name = "photo";
	// $table_name_photo = $table_name."_photo";
	$table_name_read_counter = $table_name."_read_counter";
	$sql1 = "SELECT * FROM $table_name";//read_counter 테이블의 정보를 검색한다
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($type=="modify"){
		for($i=0; $i < $count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$sql2 = "SELECT * FROM $table_name_read_counter WHERE count=$sql_fetch_array1[count]";//테이블의 count와 read_counter의 count가 일치하는지 확인
			$sql_query2 = mysqli_query($conn, $sql2);
			$count2 = mysqli_num_rows($sql_query2);
			if($count2){//count가 일치할 경우 writing 테이블의 count 값을 read_counter에 대입한다
				$sql3 = "UPDATE $table_name_read_counter SET type=$sql_fetch_array1[type] WHERE count=$sql_fetch_array1[count]";
				mysqli_query($conn, $sql3);
			}
		}
		echo '<script>alert("수정이 완료되었습니다");</script>';
	}
	
?>