<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="이드마루, customer center, 고객센터, customer, 고객, member, member center" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-관리자 화면</title>
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
<?php include 'personal.php';?>
	<script>
		var isidmaruid = is_idmaru_id(user_name);
		if(isidmaruid == -1){//idmaru 관리자 아이디가 아니면,
			location.href="about.php";
		}
		$(document).ready(function () {
			blueStyle();
			ckeditor = CKEDITOR.replace( 'mywrite_content', {
			});
			$('#mywrite_enter').click(function(){
				var reply = confirm("공지 새소식을 보내시겠습니까?");
				if(reply==true){}
				else if(reply==false){event.preventDefault ? event.preventDefault() : event.returnValue=false;}
			});
		});
	</script>
</head>
<body>
	<div id="toparea">
<?php include 'toparea.php'; ?>
	</div>
	<div id="bodyarea">
		<div id="mainbar">
			<div id="mainbody">
				<a href="manager_page.php"><div id="go_upper" class="button_gb" style="top:3px; right:3px;">위로</div></a>
				<div class="popup_title bold font12"><img src="../image/list_pine.png" style="position:relative; top:2px;"/> 공지 새소식 보내기</div><br/>
				<form action="manager_news_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
					<div class="content_area">
					<div id="write_id" class="title_blue">
						<h6 class="inline" style="position:relative;">&nbsp;제목 : </h6>
						<input type="text" id="mywrite_title" name="mywrite_title" class="inline input_blue" value="" style="width:650px;"/>
					</div>
					<div id="mywrite_body" style="width:725px; padding:0;"><!--내글쓰기-->
						<textarea id="mywrite_content" name="mywrite_content"><?php echo $sql_fetch_array1["content"];?></textarea>
						<div id="mywrite_func" style="height:32px;">
							<input id="mywrite_enter" type="image" name="submit" src="../image/button_enter.png" value=""/>
						</div>
					</div>
					</div>
				</form>
			</div>
		</div>
<?php include 'sidebar.php'; ?>
	</div>
	<div id="endarea">
<?php include 'pineforest.php'; ?>
	</div>
	<div id="temp_target"></div>
</body>
</html>