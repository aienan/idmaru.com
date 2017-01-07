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
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
	<script type="text/javascript" src="../plugin/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>
<?php
	include 'declare.php';
	$table_name = "club_group";
	$table_name_main = $table_name."_main";
	$table_name_delta = $table_name."_delta";
	$url = "group_recall_one.php?";
	$count_group = $_REQUEST["count_group"];//글번호
	$order_column = $_REQUEST["order_column"];//조회수 기준
	$count_number = $_REQUEST["count_number"];//조회수에 따른 순서
	$status = $_REQUEST["status"];
	$keyword = $_REQUEST["keyword"];
	$category = $_REQUEST["category"];
	if($category=="all_content"){
		$search_field = "group_name,description";
	} else if($category=="founder"){
		$search_field=="user_name";
	} else if($category=="group_name"){
		$search_field = "group_name";
	} else if($category=="description"){
		$search_field = "description";
	}
	if($count_number==0){//맨 첫글일 경우
		$count_number_after = $count_number + 1;
		$count_start = $count_number;
		$display_number = 2;
	} else if($count_number != 0){//첫글이 아닐경우
		$count_number_before = $count_number - 1;
		$count_number_after = $count_number + 1;
		$count_start = $count_number_before;
		$display_number = 3;
	}
	if($keyword=="thereisnokeyword"){//키워드 검색을 안했을때
		$sql2 = "SELECT * FROM $table_name WHERE status='$status' ORDER BY $order_column DESC, count_group ASC LIMIT $count_start, $display_number";
		$sql_query2 = mysqli_query($conn, $sql2);
		for($i=0; $i <$display_number; $i++){
			$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
			if($count_number==0){//맨 첫글일 경우
				if($i==1){
					$count_after = $sql_fetch_array2["count_group"];
				}
			} else if($count_number != 0){
				if($i==0){
					$count_before = $sql_fetch_array2["count_group"];//앞글의 count_group
				} else if($i==2){
					$count_after = $sql_fetch_array2["count_group"];//뒷글의 count_group
				}
			}
		}
	} else {//키워드 검색을 했을때
		$sphinx->SetFilter("status", array($status));
		$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC, @weight DESC");
		$sphinx->SetLimits($count_start, $display_number);//$count_start를 시작으로 $display_number 갯수만큼 검색
		$search = $sphinx->Query ( "@($search_field) $keyword", "$table_name_main, $table_name_delta" );
		foreach($search["matches"] as $key => $value){//검색물 count 정보 추출
			$arr10[] = $key;
		}
		for($i=0; $i <$display_number; $i++){
			if($count_number==0){//맨 첫글일 경우
				if($i==1){
					$count_after = $arr10[$i];
				}
			} else if($count_number != 0){
				if($i==0){
					$count_before = $arr10[$i];//앞글의 count_group
				} else if($i==2){
					$count_after = $arr10[$i];//뒷글의 count_group
				}
			}
		}
	}
	$sql1 = "SELECT * FROM $table_name WHERE count_group=$count_group";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if(!$count1){
		echo '<script>window.close();</script>';
	}
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$sql6 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num]";//모임장 이름 검색
	$sql_query6 = mysqli_query($conn, $sql6);
	$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
?>
</head>
<body class="popup_body" style="background-color:#FDFFF8;">
	<div id="writing_area" class="popup_writing_area">
<?php
	$group_name=$sql_fetch_array1["group_name"];
	echo '<div class="list_menu" style="margin:0 0 10px 0;">'; // 이전, 다음 버튼
	if(isset($count_before)){
		echo '<a href="'.$url.'count_group='.$count_before.'&order_column='.$order_column.'&count_number='.$count_number_before.'&status='.$status.'&keyword='.$keyword.'&category='.$category.'"><div class="go_prev_list"><img src="../image/go_prev_listB.png"/></div></a>';
	}
	if(isset($count_after)){
		echo '<a href="'.$url.'count_group='.$count_after.'&order_column='.$order_column.'&count_number='.$count_number_after.'&status='.$status.'&keyword='.$keyword.'&category='.$category.'"><div class="go_next_list"><img src="../image/go_next_listB.png"/></div></a>';
	}
	echo '
		</div>
		<div id="club_group_info">
			<div id="club_group_name">'.$group_name.'</div>
			<div id="club_group_desc"><span style="color:#3C847F;">모임 설명 : </span>&nbsp;&nbsp;'.convert_to_tag($sql_fetch_array1["description"]).'<div id="club_group_founder"><span style="color:#3C847F;">모임장 : </span>'.$sql_fetch_array6["user_name"];
	if($sql_fetch_array6["user_num"] != $user_num){
		$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array6[user_num]";//idcard의 사진을 띄운다
		$sql_query17 = mysqli_query($conn, $sql17);
		$count17 = mysqli_num_rows($sql_query17);
		if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
		else{$user_photo_path = "../image/blank_face.png";}
		echo '<div class="user_info"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding send_msg pointer">쪽지 보내기</div></div><script>
					$("#club_group_founder").bind({
						mouseenter: function () {
							$("#club_group_founder .user_info").css("display", "block");
						},
						mouseleave: function () {
							$("#club_group_founder .user_info").css("display", "none");
						}
					});
					$("#club_group_founder .send_msg").click(function(){//쪽지보내기를 클릭할 경우
						if('.$user_num.'==0){
							alert("로그인 후 이용해주세요");
						} else {
							window.open("guest_private_write.php?user_num_receive='.$sql_fetch_array6["user_num"].'", "guest_private_write", "width=770,height=500,resizable=no,scrollbars=yes,location=no");
						}
					});
					$("#club_group_founder .user_photo").click(function(){//사진을 클릭할 경우
						if('.$user_num.'==0){
							alert("로그인 후 이용해주세요");
						} else {
							var photo_path = $(this).attr("src");
							window.open("photo_recall_one.php?photo_path="+photo_path+"&table_name=idcard_photo", "photo_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
						}
					});
				</script>';
	}
	echo '</div><div id="club_group_member_count"><span style="color:#3C847F;">회원수 : </span>'.$sql_fetch_array1["member"].'</div></div>
		</div>
	';
	if($sql_fetch_array1["user_num"]==$user_num){//모임장일 경우
		echo '
		<div style="position:relative; font-weight:bold;">
			<div id="club_group_modify" class="button_gb" style="right:75px;">모임정보수정</div>
			<div id="club_group_admin" class="button_gb">회원관리</div>
		</div>
		<script>
			$("#club_group_modify").click(function(){//모임정보수정을 눌렀을 때
				if(user_name=="Guest"){
					alert("로그인 후 이용해주세요");
				}else if(user_name!="Guest"){
					window.open("club_group_modify.php?count_group='.$count_group.'", "club_group_modify", "width=770,height=650,resizable=yes,scrollbars=yes,location=no");
				}
			});
			$("#club_group_admin").click(function(){//회원관리를 눌렀을 때
				if(user_name=="Guest"){
					alert("로그인 후 이용해주세요");
				}else if(user_name!="Guest"){
					window.open("club_group_admin.php?count_group='.$count_group.'", "club_group_admin", "width=770,height=650,resizable=yes,scrollbars=yes,location=no");
				}
			});
		</script>
		';
	} else if($sql_fetch_array1["user_num"] != $user_num && $user_num != 0){//모임장이 아니고 Guest가 아닌경우
		$sql4 = "SELECT * FROM club_group_member WHERE count_group=$count_group AND user_num=$user_num";//회원 가입이 되어있는지 확인
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);
		if($count4){//회원가입이 되어있을경우
			echo '
				<div class="group_alarm">현재 회원으로 가입된 모임입니다.</div>
			';
		} else if(!$count4){//회원가입이 안되어 있을경우
			$sql5 = "SELECT * FROM club_group_admit WHERE count_group=$count_group AND user_num_admit=$user_num";//회원가입 신청을 했는지 확인
			$sql_query5 = mysqli_query($conn, $sql5);
			$count5 = mysqli_num_rows($sql_query5);
			if(!$count5){//회원가입 신청을 안했을경우
				$sql3 = "SELECT * FROM club_group_invite WHERE count_group=$count_group AND user_num=$user_num";//이미 초대를 받았는지 확인
				$sql_query3 = mysqli_query($conn, $sql3);
				$count3 = mysqli_num_rows($sql_query3);
				if(!$count3){//초대를 안받았을경우
					echo '
						<div id="group_join_admit" class="button_gb" style="margin:10px 0;">가입 신청</div>
						<script>
							$("#group_join_admit").click(function(){
								var reply = confirm("모임( '.$group_name.' )에 가입 신청 하시겠습니까?");
								if(reply==true){
									var group_founder_num = '.$sql_fetch_array1["user_num"].';
									var count_group = '.$sql_fetch_array1["count_group"].';
									var group_name = "'.$group_name.'";
									$.ajax({
										url:"group_join_admit.php",
										data: {group_founder_num:group_founder_num, count_group:count_group, group_name:group_name},
										success: function(getdata){
											alert("가입 신청이 완료되었습니다.");
											location.reload();
										}
									});
								}
							});
						</script>
					';
				} else if($count3){//이미 초대를 받았을경우
					echo '
						<div class="group_alarm">이 모임으로부터 가입 권유를 받으셨습니다.</div>
						<div id="group_join_permit" class="button_gb">보러가기</div>
						<script>
							$("#group_join_permit").click(function(){
								window.open("club_group_invite_detail.php?count_group='.$sql_fetch_array1["count_group"].'", "home_alarm_one", "width=770,height=650,resizable=yes,scrollbars=yes,location=no");
							});
						</script>
					';
				}
			} else if($count5){//회원가입신청을 했을경우
				echo '
					<div class="group_alarm">이 모임에 가입 신청한 상태입니다.</div>
				';
			}
		}
	} else if($user_num==0){
		echo '
			<div id="group_join_admit" class="button_gb" style="margin:10px 0;">가입 신청</div>
			<script>
				$("#group_join_admit").click(function(){
					alert("로그인 후 이용해주세요");
				});
			</script>
		';
	}
?>
	</div>
	<div id="temp_target"></div>
</body>
</html>