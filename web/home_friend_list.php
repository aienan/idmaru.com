<?php
include 'header.php';
include 'declare_php.php';
$sql = "SELECT friend_num FROM friend WHERE user_num='$user_num'";//friend_num 리스트
$sql_query1 = mysqli_query($conn, $sql);
$count1 = mysqli_num_rows($sql_query1);
$output = '';
$column_num = 2;
$row_height = 24 + 2;
if($count1){//친구가 있을경우
	for($i=0; $i<$count1; $i++){
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);//friend의 user_num
		$sql = "SELECT user_name, familyname, firstname FROM user WHERE user_num='$sql_fetch_array1[friend_num]'";//friend의 정보
		$sql_query2 = mysqli_query($conn, $sql);
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$html = '
			<div id="user_list_'.$sql_fetch_array1["friend_num"].'" class="friend_list_content zindex1 pointer">
				<div class="friend_list_item">'.$sql_fetch_array2["user_name"];
		if($sql_fetch_array2["familyname"] && $sql_fetch_array2["firstname"]){//이름이 있을때
		$html .= ' ('.$sql_fetch_array2["familyname"].' '.$sql_fetch_array2["firstname"].')';
		}
		$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array1[friend_num]";//idcard의 사진을 띄운다
		$sql_query17 = mysqli_query($conn, $sql17);
		$count17 = mysqli_num_rows($sql_query17);
		if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
		else{$user_photo_path = "../image/blank_face.png";}
		$html .= '</div>
				<div class="user_info" style="top:24px;">
					<img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/>
					<div class="user_info_detail"><div class="select_padding pointer">사용자 정보</div></div>
					<div class="user_memo_detail"><div class="select_padding pointer">쪽지 보내기</div></div>
				</div>
			</div>
			<script>
				$("#user_list_'.$sql_fetch_array1["friend_num"].'").bind({//이름에 마우스를 가져갈 경우
					mouseenter: function () {
						$("#user_list_'.$sql_fetch_array1["friend_num"].'").css("z-index", "3");
						$("#user_list_'.$sql_fetch_array1["friend_num"].' .user_info").css("display", "block");
					},
					mouseleave: function () {
						$("#user_list_'.$sql_fetch_array1["friend_num"].'").css("z-index", "1");
						$("#user_list_'.$sql_fetch_array1["friend_num"].' .user_info").css("display", "none");
					}
				});
				$("#user_list_'.$sql_fetch_array1["friend_num"].' .user_info_detail").click(function(){//사용자정보를 클릭할 경우
					window.open("home_friend_info.php?friend_num='.$sql_fetch_array1["friend_num"].'", "home_friend_info", "width=770,height=650,resizable=yes,scrollbars=yes,location=no");
				});
				$("#user_list_'.$sql_fetch_array1["friend_num"].' .user_memo_detail").click(function(){
					window.open("guest_private_write.php?user_num_receive='.$sql_fetch_array1["friend_num"].'", "guest_private_write", "width=770,height=500,resizable=no,scrollbars=yes,location=no");
				});
				$("#user_list_'.$sql_fetch_array1["friend_num"].' .user_photo").click(function(){//사진을 클릭할 경우
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
	if($count1%$column_num==0){//친구 수가 column_num으로 나누어떨어질 경우
		$height = $row_height * ($count1/$column_num);
	} else if($count1%$column_num != 0){//친구수가 column_num으로 나누어떨어지지 않을경우
		$height = $row_height * ((int)($count1/$column_num) + 1);
	}
	$output .= '<script>$("#friend_list").height('.$height.')</script>';
} else if(!$count1){
	$output .= '등록된 친구가 없습니다.';
}
echo $output;
?>