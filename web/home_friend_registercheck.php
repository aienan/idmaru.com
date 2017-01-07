<?php
	include 'header.php';
	$search_id = $_REQUEST["search_id"];
	include 'mysql_setting.php';
	if($id==$search_id){
		echo "
			{ \"check\": \"myself\" }
		";
	} elseif ($id!=$search_id) {
		$sql = "SELECT user_num FROM user WHERE id='$search_id'";
		$sql_query = mysqli_query($conn, $sql);
		$count = mysqli_num_rows($sql_query);
		if ($count) {
			echo "
				{ \"check\": \"exist\" }
			";
		} elseif (!$count) {
			echo "
				{ \"check\": \"notyet\" }
			";
		}
	}
	
?>