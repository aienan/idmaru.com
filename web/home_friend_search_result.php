<?php
	include 'header.php';
	include 'mysql_setting.php';
	$type=$_REQUEST["type"];
	$column_num = 2;
	$row_height = 28;//이름 한줄당 height
	if($type=='email'){
		$input=$_REQUEST["input"];
		$sql1 = "SELECT * FROM user WHERE email='$input'";
	} else if($type=='phone'){
		$input=$_REQUEST["input"];
		$sql1 = "SELECT * FROM user WHERE phone='$input'";
	} else if($type=='name'){
		$familyname=$_REQUEST["familyname"];
		$firstname=$_REQUEST["firstname"];
		$birthday_y=$_REQUEST["birthday_y"];
		$birthday_m=$_REQUEST["birthday_m"];
		$birthday_d=$_REQUEST["birthday_d"];
		if($birthday_y){$sql_birthday_y = " AND birthday_y='$birthday_y'";}//생년을 입력했을경우
		else {$sql_birthday_y="";}
		if($birthday_m){$sql_birthday_m = " AND birthday_m='$birthday_m'";}//생월을 입력했을경우
		else {$birthday_m="";}
		if($birthday_d){$sql_birthday_d = " AND birthday_d='$birthday_d'";}//생일을 입력했을경우
		else {$birthday_d="";}
		$sql1 = "SELECT * FROM user WHERE familyname='$familyname' AND firstname='$firstname'".$sql_birthday_y.$sql_birthday_m.$sql_birthday_d;
	}
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$output = "";
	if ($count1){//검색결과가 있을경우
		for($i=0; $i<$count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);//friend의 user_num
			$html = '
				<div id="user_search_'.$sql_fetch_array1["user_num"].'" class="friend_list_content zindex1 pointer">
					<div class="friend_search_item">'.$sql_fetch_array1["user_name"];
			if($sql_fetch_array1["familyname"] && $sql_fetch_array1["firstname"]){//이름이 있을때
			$html .= ' ('.$sql_fetch_array1["familyname"].' '.$sql_fetch_array1["firstname"].')';
			}
			$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array1[user_num]";//idcard의 사진을 띄운다
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
					$("#user_search_'.$sql_fetch_array1["user_num"].'").bind({//이름에 마우스를 가져갈 경우
						mouseenter: function () {
							$("#user_search_'.$sql_fetch_array1["user_num"].'").css("z-index", "3");
							$("#user_search_'.$sql_fetch_array1["user_num"].' .user_info").css("display", "block");
						},
						mouseleave: function () {
							$("#user_search_'.$sql_fetch_array1["user_num"].'").css("z-index", "1");
							$("#user_search_'.$sql_fetch_array1["user_num"].' .user_info").css("display", "none");
						}
					});
					$("#user_search_'.$sql_fetch_array1["user_num"].' .user_info_detail").click(function(){//사용자정보를 클릭할 경우
						window.open("home_friend_search_info.php?user_num='.$sql_fetch_array1["user_num"].'", "home_friend_search_info", "width=770,height=650,resizable=yes,scrollbars=yes,location=no");
					});
					$("#user_search_'.$sql_fetch_array1["user_num"].' .user_memo_detail").click(function(){//쪽지를 보낼경우
						if('.$user_num.'=='.$sql_fetch_array1["user_num"].'){
							alert("본인에게 쪽지를 보낼 수 없습니다");
						}else if('.$user_num.'==0){
							alert("로그인 후 이용해주세요");
						} else {
							window.open("guest_private_write.php?user_num_receive='.$sql_fetch_array1["user_num"].'", "guest_private_write", "width=770,height=500,resizable=no,scrollbars=yes,location=no");
						}
					});
					$("#user_search_'.$sql_fetch_array1["user_num"].' .user_photo").click(function(){//사진을 클릭할 경우
						var photo_path = $(this).attr("src");
						window.open("photo_recall_one.php?photo_path="+photo_path+"&table_name=idcard_photo", "photo_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
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
		$output .= '<script>$("#friend_search_list").height('.$height.')</script>';
	} else if (!$count1) {//검색결과가 없을경우
		$output .= "none";
	}
	echo $output;
	
?>