<?php
	if($category=="content"){$search_field = "content";}
	$table_name_main = $table_name."_main";
	$table_name_delta = $table_name."_delta";
	if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 때
		if($guest_private_type=="all"){$sql4 = "SELECT * FROM $table_name WHERE (user_num_receive=$user_num AND receiver_dont_see='0') OR (user_num_send=$user_num AND sender_dont_see='0')";}//list_show를 만들기 위해
		else if($guest_private_type=="receive"){$sql4 = "SELECT * FROM $table_name WHERE user_num_receive=$user_num AND receiver_dont_see='0'";}
		else if($guest_private_type=="send"){$sql4 = "SELECT * FROM $table_name WHERE user_num_send=$user_num AND sender_dont_see='0'";}
	} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
		if($category=="content"){
			if($guest_private_type=="all"){$search = $sphinx->Query ( "( (@(user_num_receive) $user_num @(receiver_dont_see) '0') | (@(user_num_send) $user_num @(sender_dont_see) '0') ) @($search_field) $keyword", "$table_name_main, $table_name_delta" );}//본인이 받은사람일경우 receiver_dont_see가 0이어야 하고 본인이 보낸사람일경우 sender_dont_see가 0이어야 한다. search_field에 keyword가 존재해야 한다.
			else if($guest_private_type=="receive"){$search = $sphinx->Query ( "@(user_num_receive) $user_num @(receiver_dont_see) '0' @($search_field) $keyword", "$table_name_main, $table_name_delta" );}
			else if($guest_private_type=="send"){$search = $sphinx->Query ( "@(user_num_send) $user_num @(sender_dont_see) '0' @($search_field) $keyword", "$table_name_main, $table_name_delta" );}
		} else if($category=="writer"){
			$keyword = strip_space($keyword);
			$sql5 = "SELECT * FROM user WHERE user_name='$keyword'";
			$sql_query5 = mysqli_query($conn, $sql5);
			$sql_fetch_array5 = mysqli_fetch_array($sql_query5);
			if($guest_private_type=="all"){$sql4 = "SELECT * FROM $table_name WHERE (user_num_receive=$sql_fetch_array5[user_num] AND user_num_send=$user_num) OR (user_num_receive=$user_num AND user_num_send=$sql_fetch_array5[user_num])";}
			else if($guest_private_type=="receive"){$sql4 = "SELECT * FROM $table_name WHERE user_num_receive=$user_num AND user_num_send=$sql_fetch_array5[user_num]";}
			else if($guest_private_type=="send"){$sql4 = "SELECT * FROM $table_name WHERE user_num_receive=$sql_fetch_array5[user_num] AND user_num_send=$user_num";}
		}
	}
	if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 경우
		$sql_query4 = mysqli_query($conn, $sql4);
		$count4 = mysqli_num_rows($sql_query4);//list에 count된 총 갯수
	} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
		if($category=="content"){
			$count4 = $search["total_found"];
		} else if($category=="writer"){
			$sql_query4 = mysqli_query($conn, $sql4);
			$count4 = mysqli_num_rows($sql_query4);//list에 count된 총 갯수
		}
	}
	$output = '';
	$output .= '<div id="list_box">';
	if($count4==0){//검색결과가 없을때
		if($keyword=="thereisnokeyword"){
			$output .= '<div class="empty_list">보내거나 받은 글이 없습니다</div>';
		} else if($keyword!="thereisnokeyword"){
			$output .= '<div class="empty_list">검색된 글이 없습니다</div>';
		}
	} else if($count4 != 0){//검색 결과가 있을때
		include 'recall_detailB.php';
		if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 때
			$sql1 = $sql4." ORDER BY count DESC LIMIT $start_number, $number";//쓴 글 검색
			$sql_query1 = mysqli_query($conn, $sql1);
			$count1 = mysqli_num_rows($sql_query1);
		} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
			if($category=="content"){
				$sphinx->SetSortMode( SPH_SORT_EXTENDED, "@id DESC");//count 내림차순으로 정렬
				$sphinx->SetLimits($start_number, $number);//$start_number 번호를 시작으로 $number 갯수만큼 검색
				if($guest_private_type=="all"){$search = $sphinx->Query ( "( (@(user_num_receive) $user_num @(receiver_dont_see) '0') | (@(user_num_send) $user_num @(sender_dont_see) '0') ) @($search_field) $keyword", "$table_name_main, $table_name_delta" );}
				else if($guest_private_type=="receive"){$search = $sphinx->Query ( "@(user_num_receive) $user_num @(receiver_dont_see) '0' @($search_field) $keyword", "$table_name_main, $table_name_delta" );}
				else if($guest_private_type=="send"){$search = $sphinx->Query ( "@(user_num_send) $user_num @(sender_dont_see) '0' @($search_field) $keyword", "$table_name_main, $table_name_delta" );}
				$count1 = count($search["matches"]);//검색물 갯수
				foreach($search["matches"] as $key => $value){//검색물 count 정보 추출
					$arr10[] = $key;
				}
			} else if($category=="writer"){
				$sql1 = $sql4." ORDER BY count DESC LIMIT $start_number, $number";//쓴 글 검색
				$sql_query1 = mysqli_query($conn, $sql1);
				$count1 = mysqli_num_rows($sql_query1);
			}
		}
		for($i=0; $i<$count1; $i++){//검색결과 출력
			if($keyword == "thereisnokeyword" && $category == "thereisnocategory"){//keyword 검색을 하지 않았을 때
				$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			} else if($keyword != "thereisnokeyword"){//keyword 검색을 했을 때
				if($category=="content"){
					$sql11 = "SELECT * FROM $table_name WHERE count = $arr10[$i]";
					$sql_query11 = mysqli_query($conn, $sql11);
					$sql_fetch_array1 = mysqli_fetch_array($sql_query11);
				} else if($category=="writer"){
					$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
				}
			}
			$count = $sql_fetch_array1["count"];
			$sql2 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num_send]";//쪽지 보낸 사람 정보 검색
			$sql_query2 = mysqli_query($conn, $sql2);
			$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
			$write_id = $sql_fetch_array2["user_name"];
			$sql3 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num_receive]";//쪽지 받는 사람 정보 검색
			$sql_query3 = mysqli_query($conn, $sql3);
			$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
			$receive_id = $sql_fetch_array3["user_name"];
			$list_count_link = $start_number + $i +1;//list_count 숫자 설정 (목록에서 링크 설정을 위한 setting)
			$list_page_count_link = (int) ( ($list_count_link-1) / $list_count_on_page) +1;
			$prev_list_page_count_link = (int) ( ($list_count_link-1-1) / $list_count_on_page ) + 1;//전 페이지의 list_page_count
			$next_list_page_count_link = (int) ( ($list_count_link-1+1) / $list_count_on_page ) + 1;//다음 페이지의 list_page_count
			$content = $sql_fetch_array1["content"];
			if($keyword != "thereisnokeyword"){//키워드 검색했을경우
				$content = search_highlight($keyword, $content);
			}
			$content = convert_to_tag($content);
			if($sql_fetch_array1["user_num_send"]!=$user_num){$user_num_idcard=$sql_fetch_array1["user_num_send"];}
			else if($sql_fetch_array1["user_num_receive"]!=$user_num){$user_num_idcard=$sql_fetch_array1["user_num_receive"];}
			$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$user_num_idcard";//idcard의 사진을 띄운다
			$sql_query17 = mysqli_query($conn, $sql17);
			$count17 = mysqli_num_rows($sql_query17);
			if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
			else{$user_photo_path = "../image/blank_face.png";}
			$html = '
				<div id="write_'.$count.'" class="write">
					<div class="write_main">
						<div class="write_id ">
							<div class="write_name">
								<div class="">보낸이 : <span class="write_id_name">'.$write_id.'</span></div>
								<div class="user_info"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding send_msg pointer">쪽지 보내기</div></div>
							</div>
							<div class="write_to">받는이 : '.$receive_id.'<div class="user_info"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding send_msg pointer">쪽지 보내기</div></div></div>
							<div class="write_date">'.$sql_fetch_array1["writetime"].'</div>
						</div>
						<div id="writearea_'.$count.'" class="writearea">
							<div id="write_body_'.$count.'" class="write_body_private">'.$content.'</div>
			';
			if($write_id==$user_name){//본인이 보낸사람일경우
				$html .= '
							<div id="write_bottom_'.$count.'" class="write_bottom">
				';
				if($sql_fetch_array1["read_check"]=='0'){//아직 상대방이 보지 않았을경우 수정 가능
					$html .= '
									<div id="write_modify_'.$count.'" class="write_modify" onclick="write_modify('.$count.')">수정</div>
					';
				}
				$html .= '
								<div id="write_delete_'.$count.'" class="write_delete" onclick="sender_dont_see('.$count.')">삭제</div>
							</div>
				';
			} else if($write_id != $user_name){//본인이 받은사람일경우
				$html .= '
							<div id="write_bottom_'.$count.'" class="write_bottom">
								<div id="write_delete_'.$count.'" class="write_delete" onclick="receiver_dont_see('.$count.')">삭제</div>
							</div>
				';
			}
			$html .= '
						</div>
					</div>
				</div>
				';
			$html .='
				<script>
					$("#write_'.$count.'").height( $("#write_'.$count.' > div[class=write_main]").height() );//write_main이 absolute이므로 write_XX의 높이를 설정해준다
					if("'.$write_id.'"!="'.$user_name.'"){//from에서 본인이 아닐 때 쪽지보내기 표시
						$("#write_'.$count.' .write_name").bind({
							mouseenter: function () {
								$("#write_'.$count.' .write_name .user_info").css("display", "block");
								$(this).parents(".write_id").css("z-index", "6");
							},
							mouseleave: function () {
								$("#write_'.$count.' .write_name .user_info").css("display", "none");
								$(this).parents(".write_id").css("z-index", "5");
							}
						});
						othersWrite($("#write_'.$count.' .write_id"));//본인글이 아닐때 write_id 클래스 색 바꾸기
					} else if("'.$write_id.'"=="'.$user_name.'"){//본인글일 때 write_id 클래스 색 바꾸기
						myWrite($("#write_'.$count.' .write_id"));
					}
					if("'.$receive_id.'"!="'.$user_name.'"){//to에서 본인이 아닐 때 쪽지보내기 표시
						$("#write_'.$count.' .write_to").bind({
							mouseenter: function () {
								$("#write_'.$count.' .write_to .user_info").css("display", "block");
								$(this).parents(".write_id").css("z-index", "6");
							},
							mouseleave: function () {
								$("#write_'.$count.' .write_to .user_info").css("display", "none");
								$(this).parents(".write_id").css("z-index", "5");
							}
						});
					}
					$("#write_'.$count.' .write_name .send_msg").click(function(){//from에서 쪽지보내기를 클릭할 경우
						window.open("guest_private_write.php?user_num_receive='.$sql_fetch_array2["user_num"].'", "guest_private_write", "width=770,height=500,resizable=no,scrollbars=yes,location=no");
					});
					$("#write_'.$count.' .write_to .send_msg").click(function(){//to에서 쪽지보내기를 클릭할 경우
						window.open("guest_private_write.php?user_num_receive='.$sql_fetch_array3["user_num"].'", "guest_private_write", "width=770,height=500,resizable=no,scrollbars=yes,location=no");
					});
					$("#write_'.$count.' .user_photo").click(function(){//사진을 클릭할 경우
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
	}
	$output .= '</div>'; // list_box div의 끝
	echo $html_list . $output . $html_list;//결과물과 list를 함께 출력
	include 'list_button.php';
	$sql = "UPDATE guest_private SET read_check='1' WHERE user_num_receive=$user_num";//read_check를 yes로 설정
	mysqli_query($conn, $sql);
	$_SESSION["guest_private_not_read"] = 0;//모두 읽음 표시
?>