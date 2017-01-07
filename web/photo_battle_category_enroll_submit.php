<?php
	include 'header.php';
	include 'declare_php.php';
	$photo_battle_category = $_REQUEST["photo_battle_category_word"];
	$sql2 = "SELECT * FROM photo_battle_category WHERE photo_type='$photo_battle_category'";
	$sql_query2 = mysqli_query($conn, $sql2);
	$count2 = mysqli_num_rows($sql_query2);
	if(!$count2){
		$sql1 = "INSERT INTO photo_battle_category (photo_type, number) VALUES('$photo_battle_category', 0)";
		mysqli_query($conn, $sql1);
		echo 'success';
	} else {
		echo 'already';
	}
	
?>