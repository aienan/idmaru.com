<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="이드마루, customer center, 고객센터, customer, 고객, member, member center" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>E-Mail 보내기</title>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<link rel="stylesheet" href="../plugin/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script type="text/javascript" src="../plugin/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>
<?php include 'declare.php';?>
	<?php
	$count = $_REQUEST["count"];
	$sql1 = "SELECT * FROM sale WHERE count=$count";//게시물 정보
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count1){//게시물이 있을경우
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num] AND email_refuse='0' AND user_stop='0'";//사용자가 수신거부 상태인지 확인
		$sql_query2 = mysqli_query($conn, $sql2);
		$count2 = mysqli_num_rows($sql_query2);
	}
?>
	<script>
		$(document).ready(function () {
			ckeditor = CKEDITOR.replace( 'mywrite_content', {
			});
			if(<?php echo $count2;?>==0){alert("상대방은 현재 이메일 수신을 거부한 상태입니다"); window.close();}
			$("input[name=mywrite_title]").val($("#mywrite_title").html());
			$('#mywrite_enter').click(function(){
				var reply = confirm("E-Mail을 보내시겠습니까?");
				if(reply==true){}
				else if(reply==false){event.preventDefault ? event.preventDefault() : event.returnValue=false;}
			});
			if(<?php echo $count1;?>==0){$("#bodyarea_write").html('<div style="margin:20px 0 0 0; font-weight:bold;">※ 게시물이 존재하지 않아서 E-Mail을 보낼 수 없습니다</div>');}
			$("#write_id").height($("#mywrite_title").height()+5);
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 판매자에게 E-Mail 보내기</div></div>
	<div id="bodyarea_write">
		<div style="margin:10px 0 0 0; font-weight:bold;">※ 작성하신 분의 E-Mail 주소가 자동으로 전송됩니다.</div>
		<form action="sale_email_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
			<div id="write_id" class="round_border_top" style="padding:3px 5px; width:715px; background-color:#DEF0F5;">
				<span style="font-weight:bold; display:inline;">제목 : </span><span id="mywrite_title">이드마루 장터에서 "<?php if($count1){echo $sql_fetch_array1["title"];}?>" 을 보고 "<?php echo $user_name;?>" 님이 메일을 보내셨습니다.</span>
				<input type="hidden" name="mywrite_title"/>
			</div>
			<div id="mywrite_body" style="width:725px; padding:0;"><!--내글쓰기-->
				<textarea id="mywrite_content" name="mywrite_content"></textarea>
				<div id="mywrite_func" style="height:32px;">
					<input id="mywrite_enter" type="image" name="submit" src="../image/button_send.png" value=""/>
				</div>
			</div>
			<input type="hidden" name="count" value="<?php echo $count;?>"/>
		</form>
	</div>
	<div id="temp_target"></div>
</body>
</html>