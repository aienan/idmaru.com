<?php
	include 'header.php';
	include 'mysql_setting.php';
	$count = $_REQUEST["count"];
	$sql = "DELETE FROM idmaru_guest WHERE count=$count";
	mysqli_query($conn, $sql);
	$sql3 = "DELETE FROM idmaru_guest_updown WHERE count=$count";
	mysqli_query($conn, $sql3);
	function idmaru_guest_reply_delete($upperwrite){
		include 'mysql_setting.php';
		$sql1 = "SELECT * FROM idmaru_guest WHERE upperwrite=$upperwrite";
		$sql_result1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_result1);
		for($i=0; $i < $count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_result1);
			idmaru_guest_reply_delete($sql_fetch_array1["count"]);
			$sql2 = "DELETE FROM idmaru_guest WHERE count=$sql_fetch_array1[count]";
			mysqli_query($conn, $sql2);
			$sql4 = "DELETE FROM idmaru_guest_updown WHERE count=$sql_fetch_array1[count]";
			mysqli_query($conn, $sql4);
		}
	}
	idmaru_guest_reply_delete($count);
	
?>