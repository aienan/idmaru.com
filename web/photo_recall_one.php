<?php
include 'header.php';
include 'declare_php.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script>
		function window_close(){
			window.close();
		}
	</script>
</head>
<body>
	<div id="bodyarea_photo" style="margin:0 auto;">
<?php
$photo_path = $_REQUEST["photo_path"];
$table_name = $_REQUEST["table_name"];
$photo_see = 0; // 처음에는 못보는 걸로 설정
if(isset($_REQUEST["count"])){
	$count = $_REQUEST["count"];
	$sql1 = "SELECT * FROM $table_name WHERE count=$count";
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$friend_check = friend_check($sql_fetch_array1["user_num"]);
	if($sql_fetch_array1["user_num"]==$user_num || $sql_fetch_array1["status"]==1 || ($table_name != "about_question" && $sql_fetch_array1["status"]==2 && $friend_check==1) || ($table_name=="about_question" && $sql_fetch_array1["status"]==3)){//글쓴이 본인이거나 전체공개이거나 친구관계일 경우
		$photo_see = 1;
	}
}
if($table_name=="sale" || $table_name=="club_event" || $table_name=="idcard_photo"){$photo_see = 1;}
if($photo_see==1){
	if($table_name=="idcard_photo"){$photo_path = get_original_path($photo_path);}
	echo '
		<img id="photo_image" style="cursor:pointer;" src="'.$photo_path.'" onclick="window_close()"/>
		<script>
			var width = $("#photo_image").width();
			var height = $("#photo_image").height();
			$("#bodyarea_photo").width(width);
			window.resizeTo(width+50, height+105);
		</script>
	';
} else {
	echo '<script>
		alert("사진을 볼 수 없습니다");
		window.close();
	</script>';
}
?>
	</div>
	<div id="temp_target"></div>
</body>
</html>