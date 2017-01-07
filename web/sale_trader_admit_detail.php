<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
<?php
	include 'declare.php';
	include 'mysql_setting.php';
	$seller_num = $_REQUEST["count"];//판매자 번호
	$count = $_REQUEST["count2"];//sale 테이블 게시물번호
	$sql1 = "SELECT * FROM home_alarm WHERE user_num=$user_num AND table_name='sale_trader_admit' AND count=$seller_num";//home_alarm 테이블의 정보 추출
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$sql2 = "SELECT * FROM user WHERE user_num=$seller_num";//판매자 정보 추출
	$sql_query2 = mysqli_query($conn, $sql2);
	$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
	$sql3 = "SELECT * FROM sale WHERE count=$count";
	$sql_query3 = mysqli_query($conn, $sql3);
	$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
?>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script>
		$(document).ready(function () {
			var seller_num = <?php echo $seller_num; ?>;
			var count = "<?php echo $count; ?>";
			var seller_name = '<?php echo $sql_fetch_array2["user_name"];?>';
			$("#sale_trader_button_accept").click(function(){
				var reply = confirm(seller_name + "님을 거래자로 등록하시겠습니까?");
				if(reply==true){
					var decision = "accept";
					$.ajax({
						url:"sale_trader_decide.php",
						data: {seller_num:seller_num, decision:decision},
						success: function(getdata){
							alert(seller_name + "님이 거래자로 등록되었습니다.");
							window.opener.location.reload();
							window.close();
						}
					});
				}
			});
			$("#sale_trader_button_refuse").click(function(){
				var reply = confirm("거래 신청을 거절하시겠습니까?");
				if(reply==true){
					var decision = "refuse";
					$.ajax({
						url:"sale_trader_decide.php",
						data: {seller_num:seller_num, decision:decision},
						success: function(getdata){
							alert(seller_name + "님의 거래신청이 거절되었습니다.");
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
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 거래자 등록하기</div></div>
	<div id="bodyarea_write">
		<div class="popup_content bold">
<?php
	if($count1){//home_alarm에 정보가 있을경우
		echo '
				<h6 class="title_style1">  '.$sql_fetch_array1["description"].'</h6>
				<div id="club_group_desc1" class="" style="margin:20px 0 0 0;">물품명 : '.$sql_fetch_array3["title"].'</div>
				<div class="c_FF8383">(거래자로 등록할 경우 상대방의 정보를 "거래자 목록" 에서 확인할 수 있습니다.)</div><br/>
				<div id="sale_trader_button_accept" class="button_gb">승낙하기</div>
				<div id="sale_trader_button_refuse" class="button_gb" style="left:85px;">거절하기</div>
		';
	}
?>
		</div>
	</div>
	<div id="temp_target"></div>
</body>
</html>