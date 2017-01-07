<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
<?php
	include 'declare.php';
	include 'mysql_setting.php';
	$count = $_REQUEST["count"];
	$sql1 = "SELECT * FROM manager_news WHERE count=$count";
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
?>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script>
		$(document).ready(function () {
			$('#manager_news_delete').click(function(){//공지확인 클릭시
				var reply = confirm("공지사항을 그만 보시겠습니까?");
				if(reply==true){
					var count = <?php echo $count;?>;
					$.ajax({
						url:'manager_news_see_stop.php',
						data: {count:count},
						success: function(getdata){
							window.opener.location.reload();
							window.close();
						}
					});
				}
			});
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 공지 사항</div></div>
	<div id="bodyarea_write">
		<div style="margin:15px 0 5px 0;font-weight:bold;">작성시간 : <?php echo $sql_fetch_array1["writetime"];?></div>
		<div class="title_blue" style="position:relative; width:725px; min-height:25px; padding:2px 10px; width:705px; font-weight:bold;"><?php echo $sql_fetch_array1["title"];?></div>
		<div style="position:relative; width:705px; padding:10px 10px 10px 10px; background-color:#FEFEFE; overflow: hidden;">
			<article id="mywrite_content_read"><?php echo $sql_fetch_array1["content"];?></article>
		</div>
		<div id="manager_news_delete" class="button_gb" style="margin:10px 0 0 0; padding:5px 10px;">공지확인</div>
	</div>
	<div id="temp_target"></div>
</body>
</html>