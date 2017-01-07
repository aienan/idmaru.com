<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$count=$_REQUEST["count"];
	$type = $_REQUEST["selling_type_mod"];
	$title=$_REQUEST["mywrite_title"];
	$title = replace_symbols($title);
	$content=$_REQUEST["mywrite_modify_content"];
	$content = error_modify($content);
	$sale_year_mod = $_REQUEST["sale_year_mod"];
	$sale_month_mod = $_REQUEST["sale_month_mod"];
	$sale_date_mod = $_REQUEST["sale_date_mod"];
	if(isset($_REQUEST["sale_direct_mod"])){$sale_direct_mod=$_REQUEST["sale_direct_mod"];}
	else {$sale_direct_mod=0;}
	if(isset($_REQUEST["sale_parcel_mod"])){$sale_parcel_mod=$_REQUEST["sale_parcel_mod"];}
	else {$sale_parcel_mod=0;}
	if(isset($_REQUEST["sale_safe_mod"])){$sale_safe_mod=$_REQUEST["sale_safe_mod"];}
	else {$sale_safe_mod=0;}
	$sale_place_mod = $_REQUEST["sale_place_mod"];
	$sale_price_mod = $_REQUEST["sale_price_mod"];
	$status=$_REQUEST["status"];
	$write_new=$_REQUEST["write_new"];
	$table_name = "sale";
	if($status=="selling"){
		$status = 1;
	} else if($status=="done"){
		$status = 2;
	} else if($status=="share"){
		$status = 3;
	}
	$location = $_REQUEST["location"];
	include 'photo_check.php';
	$sql = "UPDATE sale SET type=$type, title='$title', content='$content', sale_year='$sale_year_mod', sale_month='$sale_month_mod', sale_date='$sale_date_mod', sale_direct='$sale_direct_mod', sale_parcel='$sale_parcel_mod', sale_safe='$sale_safe_mod', sale_place='$sale_place_mod', sale_price='$sale_price_mod', status='$status', index_update='0' WHERE count=$count AND user_num=$user_num";
	mysqli_query($conn, $sql); 
	echo "
		<script>window.parent.location.href = '$location';</script>
	";
	
?>
