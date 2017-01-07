<?php
	include 'header.php';
	include 'declare_php.php';
	$idmaru_guest_count = $_REQUEST["idmaru_guest_count"];
	$upperwrite = $_REQUEST["upperwrite"];
	$number = $_REQUEST["number"];
	if($upperwrite==0){//최상위글일때
		$sql1 = "SELECT * FROM idmaru_guest WHERE upperwrite=$upperwrite ORDER BY count DESC LIMIT $idmaru_guest_count,$number";//최상위글을 idmaru_guest_count부터 25개씩 글을 뽑는다.
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
	} else if($upperwrite!=0){//댓글일때
		$sql1 = "SELECT * FROM idmaru_guest WHERE upperwrite=$upperwrite ORDER BY count ASC";
		$sql_query1 = mysqli_query($conn, $sql1);
		$count1 = mysqli_num_rows($sql_query1);
	}
	$output = '';
	if($upperwrite==0){//최상위글일때
	} else if($upperwrite!=0){//댓글일때 replyarea 클래스
		$output .= '<div class="replyarea">';
	}
	for($i=0; $i<$count1; $i++){//검색결과 출력
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$sql2 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num]";//글 작성자 정보 검색
		$sql_query2 = mysqli_query($conn, $sql2);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$sql3 = "SELECT * FROM idmaru_guest WHERE upperwrite=$sql_fetch_array1[count] ORDER BY count ASC";//댓글 검색
		$sql_query3 = mysqli_query($conn, $sql3);
		$count3 = mysqli_num_rows($sql_query3);
		if($sql_fetch_array1["user_num"]==0){$write_id='Guest';}
		else{$write_id = $sql_fetch_array2["user_name"];}
		$sql4 = "SELECT * FROM idmaru_guest_updown WHERE count=$sql_fetch_array1[count]";//글의 updown 구하기
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);
		$updown=0;
		for($j=0; $j<$count4; $j++){
			$sql_fetch_array4 = mysqli_fetch_array($sql_query4);
			if($sql_fetch_array4["updown"]=="up"){//글이 up이면 +1
				$updown+=1;
			} else if($sql_fetch_array4["updown"]=="down"){//글이 down이면 -1
				$updown-=1;
			}
		}
		$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array1[user_num]";//idcard의 사진을 띄운다
		$sql_query17 = mysqli_query($conn, $sql17);
		$count17 = mysqli_num_rows($sql_query17);
		if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
		else{$user_photo_path = "../image/blank_face.png";}
		$html = '
			<div id="write_'.$sql_fetch_array1["count"].'" class="write">
				<div class="rate_area ">
					<div id="rate_up_'.$sql_fetch_array1["count"].'" class="rate_check" onclick="rate_upB('.$sql_fetch_array1["count"].', '.$sql_fetch_array1["user_num"].')">▲</div>
					<div id="rate_'.$sql_fetch_array1["count"].'" class="rate_status">'.$updown.'</div>
					<div id="rate_down_'.$sql_fetch_array1["count"].'" class="rate_check" onclick="rate_downB('.$sql_fetch_array1["count"].', '.$sql_fetch_array1["user_num"].')">▼</div>
				</div>
				<div class="write_main_B">
					<div class="write_id_ig">
						<div class="write_name">
							<div>'.$write_id.'</div>
							<div class="user_info">
								<img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/>
								<div id="guest_message" class="select_padding pointer">쪽지 보내기</div>
							</div>
						</div>
						<div class="write_date">'.$sql_fetch_array1["writetime"].'</div>
					</div>
					<div id="writearea_'.$sql_fetch_array1["count"].'" class="writearea">
						<div id="write_body_'.$sql_fetch_array1["count"].'" class="write_body">'.convert_to_tag($sql_fetch_array1["content"]).'</div>
						<div id="write_bottom_'.$sql_fetch_array1["count"].'" class="write_bottom">
							<div id="see_reply_'.$sql_fetch_array1["count"].'" class="see_reply_status" onclick="see_replyB('.$sql_fetch_array1["count"].')">▼ 댓글 '.$count3.'</div>
		';
		if($user_num==$sql_fetch_array1["user_num"] && $user_num != 0){ // guest가 아닌 회원일때
			$html .= '
							<div id="write_modify_'.$sql_fetch_array1["count"].'" class="write_modify" onclick="write_modifyB('.$sql_fetch_array1["count"].')">수정</div>
							<div id="write_delete_'.$sql_fetch_array1["count"].'" class="write_delete" onclick="write_deleteB('.$sql_fetch_array1["count"].')">삭제</div>
			';
		} else if(is_idmaru_id($user_name)==1){ // 이드마루 운영자일 경우
			$html .= '
				<div id="write_delete_'.$sql_fetch_array1["count"].'" class="write_delete" onclick="write_deleteB('.$sql_fetch_array1["count"].')">삭제</div>
			';
		}
		$html .= '
						</div>
					</div>
				</div>
			</div>
			';
		$html .='
			<script>
				$("#write_'.$sql_fetch_array1["count"].'").height( $("#write_'.$sql_fetch_array1["count"].' > div[class=write_main_B]").height() );//write_main이 absolute이므로 write_XX의 높이를 설정해준다
				if('.$user_num.' != '.$sql_fetch_array1["user_num"].'){//본인이 아닐 때 쪽지보내기 표시
					othersWrite($("#write_'.$sql_fetch_array1["count"].' .write_id_ig"));//본인글이 아닐때 write_id 클래스 색 바꾸기
				} else {//본인글일 때 write_id 클래스 색 바꾸기
					myWrite($("#write_'.$sql_fetch_array1["count"].' .write_id_ig"));
				}
				if('.$sql_fetch_array1["user_num"].' != 0){
					$("#write_'.$sql_fetch_array1["count"].' .write_name").bind({
						mouseenter: function () {
							$("#write_'.$sql_fetch_array1["count"].' .user_info").css("display", "block");
							$(this).parents(".write_id_ig").css("z-index", "6");
						},
						mouseleave: function () {
							$("#write_'.$sql_fetch_array1["count"].' .user_info").css("display", "none");
							$(this).parents(".write_id_ig").css("z-index", "5");
						}
					});
				}
				$("#write_'.$sql_fetch_array1["count"].' #guest_message").click(function(){//쪽지보내기를 클릭할 경우
					if(user_num==0){
						alert("로그인 후 이용해주시기 바랍니다");
					} else if(user_num=='.$sql_fetch_array1["user_num"].'){
						alert("본인에게 쪽지를 보낼 수 없습니다");
					}else{
						window.open("guest_private_write.php?user_num_receive='.$sql_fetch_array1["user_num"].'", "guest_private_write", "width=770,height=500,resizable=no,scrollbars=yes,location=no");
					}
				});
				$("#write_'.$sql_fetch_array1["count"].' .user_photo").click(function(){//사진을 클릭할 경우
					if('.$user_num.'==0){
						alert("로그인 후 이용해주세요");
					} else {
						var photo_path = $(this).attr("src");
						window.open("photo_recall_one.php?photo_path="+photo_path+"&table_name=idcard_photo", "photo_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
					}
				});
			</script>
		';
		$output .= $html;
	}
	if($upperwrite==0){//최상위글일때
		if($count1==$number){
			$idmaru_guest_count = $idmaru_guest_count+$count1;
			$output .= '<script>
				idmaru_guest_count = '.$idmaru_guest_count.';
				$("#article_moreB").css("display", "block");
			</script>';
		} else if ($count1 < $number){
			$output .= '<script>$("#article_moreB").css("display", "none");</script>';
		}
	} else if($upperwrite!=0){//댓글일때 replyarea 클래스
		$output .= '
			<div id="write_reply_'.$upperwrite.'" class="write_reply_confirm" onclick="write_replyB('.$upperwrite.')"><img src="../image/list_pine.png" style="position:relative; top:3px;"/> 댓글쓰기</div>
			<div id="write_reply_cancel_'.$upperwrite.'" class="write_reply_confirm_cancel" onclick="write_reply_cancelB('.$upperwrite.')">▲ 댓글취소</div>
		</div>
		<script>//댓글 넓이 줄이기
			$("#write_"+'.$upperwrite.').next().find(".write_main_B").width($("#write_"+'.$upperwrite.').width() - 70);
		</script>
		';
	}
	echo $output;
?>