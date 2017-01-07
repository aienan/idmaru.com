<?php
	include 'header.php';
	include 'declare_php.php';
	if($user_num==0){exit;}
	$type = $_REQUEST["selling_type"];
	$title = $_REQUEST["mywrite_title"];
	$title = replace_symbols($title);
	$content=$_REQUEST["mywrite_content"];
	$content = error_modify($content);
	$status=$_REQUEST["status"];
	$write_new=$_REQUEST["write_new"];
	$sale_year=$_REQUEST["sale_year"];
	$sale_month=$_REQUEST["sale_month"];
	$sale_date=$_REQUEST["sale_date"];
	if(isset($_REQUEST["sale_direct"])){$sale_direct=$_REQUEST["sale_direct"];}
	else {$sale_direct=0;}
	if(isset($_REQUEST["sale_parcel"])){$sale_parcel=$_REQUEST["sale_parcel"];}
	else {$sale_parcel=0;}
	if(isset($_REQUEST["sale_safe"])){$sale_safe=$_REQUEST["sale_safe"];}
	else {$sale_safe=0;}
	$sale_place=$_REQUEST["sale_place"];
	$sale_price=$_REQUEST["sale_price"];
	if($status=="selling"){
		$status = 1;
	} else if($status=="done"){
		$status = 2;
	} else if($status=="share"){
		$status = 3;
	}
	$table_name = "sale";
	include 'photo_check.php';
	$sql1 = "INSERT INTO sale (count, user_num, type, title, content, sale_year, sale_month, sale_date, sale_direct, sale_parcel, sale_safe, sale_place, sale_price, status, read_count, index_update) VALUES (LAST_INSERT_ID(), $user_num, $type, '$title', '$content', '$sale_year', '$sale_month', '$sale_date', '$sale_direct', '$sale_parcel', '$sale_safe', '$sale_place', '$sale_price', '$status', 0, '0')";//글 내용 입력
	mysqli_query($conn, $sql1);
	echo '
		<script>
			alert("글이 입력되었습니다");
			if(window.parent.opener.location.href.search(/sale/) != -1){window.parent.opener.location.reload();}
			window.parent.close();
		</script>
	';
	
?>

