<?php
	include 'header.php';
	include 'declare_php.php';
	$type = $_REQUEST["type"];
	$count_start = $_REQUEST["count_start"];
	$section_list_number = 5;
	$section_list_gallery = 5;
	if($type=="news"){
		$sql1 = "SELECT * FROM writing WHERE status='1' ORDER BY count DESC LIMIT $count_start, $section_list_number";
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
		if($count1==0){echo 'endofSection';}
		else {
			for($i=0; $i < $count1; $i++){
				$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
				echo '<a href="news_all.php?count_link='.$sql_fetch_array1["count"].'"><div class="main_section_content"> · '.$sql_fetch_array1["title"].'</div></a>';
			}
			if($count1 != $section_list_number){echo '<script>section_end_'.$type.' = 1;</script>';}
		}
	} else if($type=="gallery"){
		$sql1 = "SELECT * FROM photo WHERE status='1' ORDER BY count DESC LIMIT $count_start, $section_list_gallery";
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
		if($count1==0){echo 'endofSection';}
		else {
			for($i=0; $i < $count1; $i++){
				$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
				echo '<a href="gallery_all.php?count_link='.$sql_fetch_array1["count"].'"><div class="main_section_body_img"><div class="relative">'.img_adjust(get_thumbnail_path($sql_fetch_array1["photo_path"]), 114, 114).'</div></div></a>';
			}
			if($count1 != $section_list_number){echo '<script>section_end_'.$type.' = 1;</script>';}
		}
	} else if($type=="market"){
		$sql1 = "SELECT * FROM sale WHERE status='1' ORDER BY count DESC LIMIT $count_start, $section_list_number";
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
		if($count1==0){echo 'endofSection';}
		else {
			for($i=0; $i < $count1; $i++){
				$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
				echo '<a href="market.php?count_link='.$sql_fetch_array1["count"].'"><div class="main_section_content"> · '.$sql_fetch_array1["title"].'</div></a>';
			}
			if($count1 != $section_list_number){echo '<script>section_end_'.$type.' = 1;</script>';}
		}
	} else if($type=="event"){
		$sql1 = "SELECT * FROM club_event ORDER BY count DESC LIMIT $count_start, $section_list_number";
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
		if($count1==0){echo 'endofSection';}
		else {
			for($i=0; $i < $count1; $i++){
				$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
				echo '<a href="event_all.php?count_link='.$sql_fetch_array1["count"].'"><div class="main_section_content"> · '.$sql_fetch_array1["title"].'</div></a>';
			}
			if($count1 != $section_list_number){echo '<script>section_end_'.$type.' = 1;</script>';}
		}
	} else if($type=="group"){
		$sql1 = "SELECT count_group FROM club_group WHERE status='1'";
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
		$rand_num_arr = array();
		for($i=0; $i < $section_list_number && $i < $count1 ; $i++){
			do{
				$exist = 0;
				$rand_num = rand(0, $count1-1);
				for($j=0; $j < count($rand_num_arr); $j++){
					if($rand_num_arr[$j]==$rand_num){$exist = 1; break;}
				}
			} while($exist==1);
			if($exist==0){
				$rand_num_arr[] = $rand_num;
				mysqli_data_seek($sql_query1, $rand_num);
				$row = mysqli_fetch_row($sql_query1);
				$sql2 = "SELECT * FROM club_group WHERE count_group=$row[0]";
				$sql_query2 = mysqli_query($conn, $sql2);
				$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
				echo '<div class="main_section_content mouseover" onclick="club_group_click('.$sql_fetch_array2["count_group"].')"> · '.$sql_fetch_array2["group_name"].'</div>';
			}
		}
		// if($count1 != $section_list_number){echo '<script>section_end_'.$type.' = 1;</script>';}
	} else if($type=="guest_all"){
		$sql1 = "SELECT * FROM idmaru_guest WHERE upperwrite=0 ORDER BY count DESC LIMIT $count_start, $section_list_number";
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
		if($count1==0){echo 'endofSection';}
		else {
			for($i=0; $i < $count1; $i++){
				$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
				echo '<a href="idmaru_guest.php"><div class="main_section_content"> · '.$sql_fetch_array1["content"].'</div></a>';
			}
			if($count1 != $section_list_number){echo '<script>section_end_'.$type.' = 1;</script>';}
		}
	}
	
?>