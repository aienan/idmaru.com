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
		});
	</script>
</head>
<body>
	<div id="toparea">
<?php include 'toparea.php'; ?>
	</div>
<?php
	include 'mysql_setting.php';
	$sql1 = "SELECT * FROM user";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$sql2 = "SELECT * FROM user WHERE user_stop='1'";
	$sql_query2 = mysqli_query($conn, $sql2);
	$count2 = mysqli_num_rows($sql_query2);
	$sql3 = "SELECT * FROM user WHERE user_stop='2'";
	$sql_query3 = mysqli_query($conn, $sql3);
	$count3 = mysqli_num_rows($sql_query3);
	$sql4 = "SELECT * FROM stranger_call WHERE status='1'";
	$sql_query4 = mysqli_query($conn, $sql4);
	$count4 = mysqli_num_rows($sql_query4);
	$sql5 = "SELECT * FROM stranger_call WHERE status='2'";
	$sql_query5 = mysqli_query($conn, $sql5);
	$count5 = mysqli_num_rows($sql_query5);
	$sql6 = "SELECT * FROM stranger_call WHERE status='3'";
	$sql_query6 = mysqli_query($conn, $sql6);
	$count6 = mysqli_num_rows($sql_query6);
	$sql7 = "SELECT * FROM writing";
	$sql_query7 = mysqli_query($conn, $sql7);
	$count7 = mysqli_num_rows($sql_query7);
	$news_view = 0;
	for($i=0; $i < $count7; $i++){
		$sql_fetch_array7 = mysqli_fetch_array($sql_query7);
		$news_view += $sql_fetch_array7["read_count"];
	}
	$sql8 = "SELECT * FROM photo";
	$sql_query8 = mysqli_query($conn, $sql8);
	$count8 = mysqli_num_rows($sql_query8);
	$photo_view = 0;
	for($i=0; $i < $count8; $i++){
		$sql_fetch_array8 = mysqli_fetch_array($sql_query8);
		$photo_view += $sql_fetch_array8["read_count"];
	}
	$sql9 = "SELECT * FROM sale";
	$sql_query9 = mysqli_query($conn, $sql9);
	$count9 = mysqli_num_rows($sql_query9);
	$sale_view = 0;
	for($i=0; $i < $count9; $i++){
		$sql_fetch_array9 = mysqli_fetch_array($sql_query9);
		$sale_view += $sql_fetch_array9["read_count"];
	}
	$sql10 = "SELECT * FROM club_event";
	$sql_query10 = mysqli_query($conn, $sql10);
	$count10 = mysqli_num_rows($sql_query10);
	$event_view = 0;
	for($i=0; $i < $count10; $i++){
		$sql_fetch_array10 = mysqli_fetch_array($sql_query10);
		$event_view += $sql_fetch_array10["read_count"];
	}
	$sql11 = "SELECT * FROM club_group";
	$sql_query11 = mysqli_query($conn, $sql11);
	$count11 = mysqli_num_rows($sql_query11);
	$group_member = 0;
	for($i=0; $i < $count11; $i++){
		$sql_fetch_array11 = mysqli_fetch_array($sql_query11);
		$group_member += $sql_fetch_array11["member"];
	}
	$sql12 = "SELECT * FROM about_question";
	$sql_query12 = mysqli_query($conn, $sql12);
	$count12 = mysqli_num_rows($sql_query12);
	$question_view = 0;
	for($i=0; $i < $count12; $i++){
		$sql_fetch_array12 = mysqli_fetch_array($sql_query12);
		$question_view += $sql_fetch_array12["read_count"];
	}
	$sql13 = "SELECT * FROM club_group_writing";
	$sql_query13 = mysqli_query($conn, $sql13);
	$count13 = mysqli_num_rows($sql_query13);
	$group_writing_view = 0;
	for($i=0; $i < $count13; $i++){
		$sql_fetch_array13 = mysqli_fetch_array($sql_query13);
		$group_writing_view += $sql_fetch_array13["read_count"];
	}
?>
	<div id="bodyarea">
		<div id="mainbar">
			<div id="mainbody">
				<a href="about.php"><div id="go_upper" class="button_gb" style="top:3px; right:3px;">위로</div></a>
				<div class="popup_title bold font12"><img src="../image/list_pine.png" style="position:relative; top:2px;"/> &nbsp;관리자 화면</div><br/>
				<a href="manager_member_list.php"><div class="manager_item mouseover">
					<span>▶ 회원수 : &nbsp;</span><?php echo $count1-$count2-$count3;?> &nbsp;&nbsp;&nbsp;
					( <span>총 가입 회원수 : </span><?php echo $count1;?> , 
					<span>탈퇴 회원수 : </span><?php echo $count2;?> , 
					<span>강제 정지 회원수 : </span><?php echo $count3;?> )
				</div></a>
				<br/>
				<div class="manager_item">뉴스 글 갯수 : <?php echo $count7;?> <span style="margin:0 0 0 15px; font-weight:normal;">(총 조회수 : <?php echo $news_view;?>)</span></div>
				<div class="manager_item">갤러리 글 갯수 : <?php echo $count8;?> <span style="margin:0 0 0 15px; font-weight:normal;">(총 조회수 : <?php echo $photo_view;?>)</span></div>
				<div class="manager_item">장터 글 갯수 : <?php echo $count9;?> <span style="margin:0 0 0 15px; font-weight:normal;">(총 조회수 : <?php echo $sale_view;?>)</span></div>
				<div class="manager_item">이벤트 글 갯수 : <?php echo $count10;?> <span style="margin:0 0 0 15px; font-weight:normal;">(총 조회수 : <?php echo $event_view;?>)</span></div>
				<div class="manager_item">모임 갯수 : <?php echo $count11;?> <span style="margin:0 0 0 15px; font-weight:normal;">(총 모임회원수 : <?php echo $group_member;?>)</span></div>
				<div class="manager_item">모임 글 갯수 : <?php echo $count13;?> <span style="margin:0 0 0 15px; font-weight:normal;">(총 조회수 : <?php echo $group_writing_view;?>)</span></div>
				<div class="manager_item">문의하기 글 갯수 : <?php echo $count12;?> <span style="margin:0 0 0 15px; font-weight:normal;">(총 조회수 : <?php echo $question_view;?>)</span></div>
				<br/>
				<a href="manager_stranger_call.php"><div class="manager_item mouseover">
					<span>▶ 신고 접수 건수 : &nbsp;</span><?php echo $count4 + $count5 + $count6;?> &nbsp;&nbsp;&nbsp;
					( <span>접수중 : </span><?php echo $count4;?> , 
					<span>문제없음 : </span><?php echo $count5;?> , 
					<span>삭제처리 : </span><?php echo $count6;?> )
				</div></a>
				<a href="manager_login_history.php"><div class="manager_item mouseover">
					<span>▶ 회원 로그인 기록</span>
				</div></a>
				<a href="manager_email_private.php"><div class="manager_item mouseover">
					<span>▶ 개별 E-Mail 보내기</span>
				</div></a>
				<a href="manager_email_joongo.php"><div class="manager_item mouseover">
					<span>▶ 중고나라 E-Mail 보내기</span>
				</div></a>
				<a href="manager_news_send.php"><div class="manager_item mouseover">
					<span>▶ 전체 공지 새소식 보내기</span>
				</div></a>
				<a href="manager_email.php"><div class="manager_item mouseover">
					<span>▶ 전체 공지 E-Mail 보내기</span>
				</div></a>
				<a href="manager_db_control.php"><div class="manager_item mouseover">
					<span>▶ DB 정보 수정하기</span>
				</div></a>
				<a href="manager_send_certify_email.php"><div class="manager_item mouseover">
					<span>▶ 인증메일 전송하기</span>
				</div></a>
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