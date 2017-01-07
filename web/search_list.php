<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="idmaru, 이드마루, SNS, 소셜, portal, 포털, secondhand, market, 중고, 거래, fun, 흥미, photo, 사진, news, 뉴스, event, 이벤트" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-검색List</title>
</head>
<body>
<?php
	// Google이 검색하도록 설정하는 페이지
	include 'mysql_setting.php';
	$sql1 = "SELECT * FROM writing WHERE status='1'";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	echo '<div>[news]</div>';
	for($i=0; $i < $count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$count_link = $sql_fetch_array1["count"];
		echo '
			<div><a href="http://www.idmaru.com/web/news_all.php?count_link='.$count_link.'">http://www.idmaru.com/web/news_all.php?count_link='.$count_link.'</a></div>
		';
	}
	$sql2 = "SELECT * FROM photo WHERE status='1'";
	$sql_query2 = mysqli_query($conn, $sql2);
	$count2 = mysqli_num_rows($sql_query2);
	echo '<div>[gallery]</div>';
	for($i=0; $i < $count2; $i++){
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$count_link = $sql_fetch_array2["count"];
		echo '
			<div><a href="http://www.idmaru.com/web/gallery_all.php?count_link='.$count_link.'">http://www.idmaru.com/web/gallery_all.php?count_link='.$count_link.'</a></div>
		';
	}
	$sql3 = "SELECT * FROM sale WHERE status='1'";
	$sql_query3 = mysqli_query($conn, $sql3);
	$count3 = mysqli_num_rows($sql_query3);
	echo '<div>[sale]</div>';
	for($i=0; $i < $count3; $i++){
		$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
		$count_link = $sql_fetch_array3["count"];
		echo '
			<div><a href="http://www.idmaru.com/web/market.php?count_link='.$count_link.'">http://www.idmaru.com/web/market.php?count_link='.$count_link.'</a></div>
		';
	}
	$sql4 = "SELECT * FROM club_event";
	$sql_query4 = mysqli_query($conn, $sql4);
	$count4 = mysqli_num_rows($sql_query4);
	echo '<div>[event]</div>';
	for($i=0; $i < $count4; $i++){
		$sql_fetch_array4 = mysqli_fetch_array($sql_query4);
		$count_link = $sql_fetch_array4["count"];
		echo '
			<div><a href="http://www.idmaru.com/web/event_all.php?count_link='.$count_link.'">http://www.idmaru.com/web/event_all.php?count_link='.$count_link.'</a></div>
		';
	}
	$sql5 = "SELECT * FROM about_question WHERE status='1'";
	$sql_query5 = mysqli_query($conn, $sql5);
	$count5 = mysqli_num_rows($sql_query5);
	echo '<div>[about_question]</div>';
	for($i=0; $i < $count5; $i++){
		$sql_fetch_array5 = mysqli_fetch_array($sql_query5);
		$count_link = $sql_fetch_array5["count"];
		echo '
			<div><a href="http://www.idmaru.com/web/about_question.php?count_link='.$count_link.'">http://www.idmaru.com/web/about_question.php?count_link='.$count_link.'</a></div>
		';
	}
?>
</body>
</html>