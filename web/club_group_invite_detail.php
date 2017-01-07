<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
<?php
	include 'declare.php';
	include 'mysql_setting.php';
	$count_group = $_REQUEST["count_group"];
	$sql1 = "SELECT * FROM home_alarm WHERE user_num=$user_num AND table_name='club_group_invite' AND count=$count_group";
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$sql2 = "SELECT * FROM club_group WHERE count_group=$count_group";
	$sql_query2 = mysqli_query($conn, $sql2);
	$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
?>
	<script>
		$(document).ready(function () {
			var count_group = <?php echo $count_group; ?>;
			var group_name = "<?php echo $sql_fetch_array2["group_name"]; ?>";
			var member = <?php echo $sql_fetch_array2["member"];?>;
			$("#club_group_invite_button_accept").click(function(){
				var reply = confirm("초대된 모임에 가입하시겠습니까?");
				if(reply==true){
					var decision = "accept";
					$.ajax({
						url:"club_group_invite_decide.php",
						data: {count_group:count_group, decision:decision, group_name:group_name, member:member},
						success: function(getdata){
							alert("모임에 가입 되었습니다.");
							window.opener.location.reload();
							window.close();
						}
					});
				}
			});
			$("#club_group_invite_button_refuse").click(function(){
				var reply = confirm("모임 초대를 거절하시겠습니까?");
				if(reply==true){
					var decision = "refuse";
					$.ajax({
						url:"club_group_invite_decide.php",
						data: {count_group:count_group, decision:decision, group_name:group_name},
						success: function(getdata){
							alert("모임 초대에 거절하였습니다.");
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
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 모임 가입하기</div></div>
	<div id="bodyarea_write">
		<h6 style="margin:10px 0;" class="c_00324C"><?php echo $sql_fetch_array1["description"]; ?></h6>
		<div class="title_style1">모임 설명</div>
		<div class="bold"><?php echo convert_to_tag($sql_fetch_array2["description"]); ?></div><br/>
		<div id="club_group_invite_button_accept" class="button_gb">가입하기</div>
		<div id="club_group_invite_button_refuse" class="button_gb" style="left:100px;">거절하기</div>
		<br/><br/><br/><br/>
	</div>
	<div id="temp_target"></div>
</body>
</html>