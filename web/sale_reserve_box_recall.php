<?php
	$sql1 = "SELECT * FROM sale_reserve_box WHERE user_num=$user_num ORDER BY writetime DESC";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$output = '';
	if(!$count1){//장바구니에 물건이 없을때
		$output .= '<div class="empty_list">장바구니에 물건이 없습니다</div>';
	} else if($count1){//장바구니에 물건이 있을때
		$output .= '
			<div id="list_box">
			<div id="list_head">
				<div id="reserve_list_seller">판&nbsp;매&nbsp;자</div>
				<div id="reserve_list_title">물&nbsp;&nbsp;&nbsp;품&nbsp;&nbsp;&nbsp;명</div>
				<div id="reserve_list_read">상태</div>
			</div>
		';
		for($i=0; $i < $count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$sql4 = "SELECT * FROM sale WHERE count=$sql_fetch_array1[count]";
			$sql_query4 = mysqli_query($conn, $sql4);
			$sql_fetch_array4 = mysqli_fetch_array($sql_query4);
			$sql5 = "SELECT * FROM sale_reply WHERE count_upperwrite = $sql_fetch_array4[count]";//댓글 검색
			$sql_query5 = mysqli_query($conn, $sql5);
			$count5 = mysqli_num_rows($sql_query5);
			$sql6 = "SELECT * FROM user WHERE user_num=$sql_fetch_array4[user_num]";//작성자 이름 검색
			$sql_query6 = mysqli_query($conn, $sql6);
			$sql_fetch_array6 = mysqli_fetch_array($sql_query6);
			$title = $sql_fetch_array4["title"];
			$title = '['.selling_type_name($sql_fetch_array4["type"]).'] '.$title;
			if($sql_fetch_array4["status"]==1){
				$status="판매중";
			} else if($sql_fetch_array4["status"]==2){
				$status="판매완료";
			} else if($sql_fetch_array4["status"]==3){
				$status="공유중";
			}
			$output .= '
				<div id="writing_area_article'.$sql_fetch_array4["count"].'" class="writing_area_article">
					<div class="reserve_list_seller">'.$sql_fetch_array6["user_name"].'</div>
					<div class="reserve_list_title">'.$title.' &nbsp;<span style="color:#3C847F; font-weight:normal;">('.$count5.')</span></div>
					<div class="reserve_list_read">'.$status.'</div>
				</div>
				<script>
					var height = $("#writing_area_article'.$sql_fetch_array4["count"].' .reserve_list_title").height();
					$("#writing_area_article'.$sql_fetch_array4["count"].'").height(height+8);
					$("#writing_area_article'.$sql_fetch_array4["count"].' .reserve_list_seller").height(height);
					$("#writing_area_article'.$sql_fetch_array4["count"].' .reserve_list_title").height(height);
					$("#writing_area_article'.$sql_fetch_array4["count"].' .reserve_list_read").height(height);
					$("#writing_area_article'.$sql_fetch_array4["count"].' .reserve_list_title").click(function(){
						window.open("sale_reserve_box_one.php?count='.$sql_fetch_array4["count"].'&count_number='.$i.'", "sale_reserve_box_one", "width=770,height="+get_popup_height()+",resizable=no,scrollbars=yes,location=no");
					});
				</script>
			';
		}
		$output .= '</div>'; // list_box의 div 끝
	}
	echo $output;
	
?>