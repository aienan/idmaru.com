<?php
	include "mysql_setting.php";
	$type = $_REQUEST["type"];//see:보러가기, dispose:(처리)
	$caller_num = $_REQUEST["caller_num"];
	$table_name = $_REQUEST["table_name"];
	$table_name_photo = $table_name."_photo";
	$table_name_reply = $table_name."_reply";
	$count = $_REQUEST["count"];
	$count_upperwrite = $_REQUEST["count_upperwrite"];
	if(isset($_REQUEST["status"])){$status = $_REQUEST["status"];}
	$sql2 = "SELECT * FROM $table_name WHERE count=$count_upperwrite";
	$sql_query2 = mysqli_query($conn, $sql2);
	$count2 = mysqli_num_rows($sql_query2);
	if(!$count2){
		echo '
			<script>alert("게시물이 존재하지 않습니다");</script>
		';
	} else if($type=="see"){
		if($table_name=="writing"){
			echo '
				<script>window.open("news_all.php?count_link='.$count_upperwrite.'", "stranger_call_see");</script>
			';
		} else if($table_name=="photo"){
			echo '
				<script>window.open("gallery_all.php?count_link='.$count_upperwrite.'", "stranger_call_see");</script>
			';
		} else if($table_name=="sale"){
			echo '
				<script>window.open("market.php?count_link='.$count_upperwrite.'", "stranger_call_see");</script>
			';
		} else if($table_name=="club_event"){
			echo '
				<script>window.open("event_all.php?count_link='.$count_upperwrite.'", "stranger_call_see");</script>
			';
		}
	} else if($type=="dispose"){
		$sql1 = "UPDATE stranger_call SET status='$status' WHERE caller_num=$caller_num AND table_name='$table_name' AND count=$count AND count_upperwrite=$count_upperwrite";
		mysqli_query($conn, $sql1);
	}
?>