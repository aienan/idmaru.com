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
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
<?php
	include 'declare.php';
	$count = $_REQUEST["count"];
	$table_name = "market_deal";
	$sql1 = "SELECT * FROM sale WHERE count=$count";//물건에 대한 정보
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$sql2 = "SELECT * FROM $table_name WHERE count=$count ORDER BY bet_money+0 DESC";//경매에 대한 정보. 입찰액이 높은 순으로 정렬한다
	$sql_query2 = mysqli_query($conn, $sql2);
	$count2 = mysqli_num_rows($sql_query2);
	$sql3 = "SELECT * FROM $table_name WHERE count=$count AND user_num=$user_num";//입찰했는지 여부 확인
	$sql_query3 = mysqli_query($conn, $sql3);
	$count3 = mysqli_num_rows($sql_query3);
	$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
	$sql5 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[user_num]";//판매자 정보
	$sql_query5 = mysqli_query($conn, $sql5);
	$sql_fetch_array5 = mysqli_fetch_array($sql_query5);
?>
	<script>
		$(document).ready(function () {
			$("#bet_money").focus(function(){//입찰가에 커서가 찍혔을경우
				var string = $("#bet_money").val();
				if(string=="입 찰 가"){
					$("#bet_money").val("");
					$("#bet_money").css("color", "#000000").css("text-align", "right");
				} else {
					$("#bet_money").val(removeComma(string));
				}
			});
			$("#bet_money").blur(function(){//입찰가에서 커서가 나왔을경우
				var string = $("#bet_money").val();
				if(!string){//글자가 없을때
					$("#bet_money").val("입 찰 가");
					$("#bet_money").css("color", "#AAAAAA").css("text-align", "center");
				} else if(string){
					if(isNumber(string)){//숫자인지 체크
						$("#bet_money").val(addComma(string));
					} else {//숫자가 아닐때
						$("#bet_money").val("입 찰 가");
						$("#bet_money").css("color", "#AAAAAA").css("text-align", "center");
						alert("숫자만 입력할 수 있습니다");
					}
				}
			});
			$("#deal_comment").focus(function(){//남김말에 커서가 찍혔을경우
				var string = $("#deal_comment").val();
				if(string=="남김말"){
					$("#deal_comment").val("");
					$("#deal_comment").css("color", "#000000");
				}
			});
			$("#deal_comment").blur(function(){//남김말에서 커서가 나왔을경우
				var string = $("#deal_comment").val();
				if(!string){
					$("#deal_comment").val("남김말");
					$("#deal_comment").css("color", "#AAAAAA");
				}
			});
		});
		function deal_submit(type, count){
			if(user_name=="Guest"){
				alert("로그인 후 이용해주세요");
			}else if(user_name!="Guest"){
				var bet_money = removeComma($("#bet_money").val());
				if(bet_money=="입 찰 가"){
					alert("입찰가를 입력해주세요");
				} else {
					if(type=="new"){var reply = confirm("입찰가를 등록하시겠습니까?");}
					else if(type=="modify"){var reply = confirm("입찰가를 수정하시겠습니까?");}
					else if(type=="delete"){var reply = confirm("입찰가를 삭제하시겠습니까?");}
					if(reply==true){
						var user_num_other = <?php echo $sql_fetch_array1["user_num"];?>;
						var title = "<?php echo $sql_fetch_array1["title"];?>";
						var comment = $("#deal_comment").val();
						if(comment=="남김말"){comment="";}//comment가 기본값일경우 지워줌
						$.ajax({//내가 쓴 글 출력
							url:"market_deal_submit.php",
							data: {type:type, count:count, bet_money:bet_money, comment:comment, user_num_other:user_num_other, title:title},
							success: function(getdata){
								// if(type=="new"){alert("입찰가가 등록되었습니다");}
								// else if(type=="modify"){alert("입찰가가 수정되었습니다");}
								// else if(type=="delete"){alert("입찰가가 삭제되었습니다");}
								location.reload();
							}
						});
					}
				}
			}
		}
		function sale_trade_request(buyer_num, buyer_name){
			if(user_name=="Guest"){
				alert("로그인 후 이용해주세요");
			}else if(user_name!="Guest" && buyer_num != user_num){
				var reply = confirm(buyer_name+"님께 거래신청하시겠습니까?");
				if(reply==true){
					$.ajax({
						url:'sale_trade_request.php',
						data:{buyer_num:buyer_num, count:<?php echo $count;?>},
						success: function(getdata){
							if(getdata=="already"){alert("이미 거래자로 등록되어 있습니다");}
							else if(getdata=="yet"){alert("현재 거래신청한 상태입니다");}
							else if(getdata=="received"){alert(buyer_name+"님으로부터 거래신청을 받으신 상태입니다");}
							else if(getdata=="done"){alert(buyer_name+"님께 거래신청 하였습니다");}
						}
					});
				}
			}
		}
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 물건 경매장</div></div>
	<div id="bodyarea_write">
<?php
	echo '
		<div style="margin:10px 0 0 0; padding:5px; font-weight:bold; background-color:#DEF0F5;">
			<div>물품명 : '.$sql_fetch_array1["title"].'</div>
			<div style="margin:5px 0 0 0;">판매자 : '.$sql_fetch_array5["user_name"].'</div>
		</div><br/>
		<div style="padding:5px;">
			<div id="deal_mine">
				<div class="market_deal_name">'.$user_name.'</div>
				<input id="bet_money" class="input_blue" type="text" name="bet_money" value="입 찰 가" maxlength="11"/><span style="position:absolute; left:248px;">원</span>
				<input id="deal_comment" class="input_blue" type="text" name="deal_comment" value="남김말" maxlength="30"/>
	';
	if(!$count3){//아직 입찰가를 등록하지 않았을때
		echo '
					<div id="deal_submit" class="button_gb" onclick="deal_submit(\'new\', '.$count.')">입력</div>
		';
	} else if($count3){//입찰가를 등록했을때
		echo '
					<div id="deal_submit" class="button_gb" onclick="deal_submit(\'modify\', '.$count.')">수정</div>
					<script>
						$("#bet_money").val(addComma('.$sql_fetch_array3["bet_money"].'));
						$("#bet_money").css("color", "#000000").css("text-align", "right");
						$("#deal_comment").val("'.$sql_fetch_array3["comment"].'");
						$("#deal_comment").css("color", "#000000");
					</script>
		';
	}
	echo '
			</div>
		</div>
	';
	if($count2){//입찰자가 있을경우
		echo '<div class="gray_box" style="padding:5px; margin:10px 0;">';
		for($i=0; $i < $count2; $i++){
			$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
			$sql4 = "SELECT * FROM user WHERE user_num=$sql_fetch_array2[user_num]";//입찰자 정보
			$sql_query4 = mysqli_query($conn, $sql4);
			$sql_fetch_array4 = mysqli_fetch_array($sql_query4);
			$bet_money = addComma($sql_fetch_array2["bet_money"]);
			$sql17 = "SELECT * FROM idcard_photo WHERE user_num=$sql_fetch_array2[user_num]";//idcard의 사진을 띄운다
			$sql_query17 = mysqli_query($conn, $sql17);
			$count17 = mysqli_num_rows($sql_query17);
			if($count17){$sql_fetch_array17 = mysqli_fetch_array($sql_query17); $user_photo_path = get_thumbnail_path($sql_fetch_array17["idcard_photo_path"]);}
			else{$user_photo_path = "../image/blank_face.png";}
			if($i != 0){echo '<div style="height:10px;"></div>';}
			echo '
				<div id="market_deal'.$i.'" class="market_deal">
					<div class="market_deal_name">'.$sql_fetch_array4["user_name"].'<div class="user_info pointer" style="position:absolute;"><img class="user_photo pointer" src="'.$user_photo_path.'" width="85"/><div class="select_padding sale_request" onclick="sale_trade_request('.$sql_fetch_array4["user_num"].', \''.$sql_fetch_array4["user_name"].'\')">거래 신청</div><div class="select_padding send_msg pointer">쪽지 보내기</div></div></div>
			';
			if($sql_fetch_array4["user_name"] != $user_name){//판매자 본인일경우
				echo '
					<script>
						$("#market_deal'.$i.' .market_deal_name").hover(function(){
							$("#market_deal'.$i.' .user_info").css("display", "block");
						}, function(){
							$("#market_deal'.$i.' .user_info").css("display", "none");
						});
					</script>
				';
			}
			if($user_num!=$sql_fetch_array1["user_num"] && $sql_fetch_array4["user_name"] != $user_name){//판매자가 아니면서 타인의 아이디일 경우
				echo '
					<script>
						$("#market_deal'.$i.' .market_deal_name").hover(function(){
							$("#market_deal'.$i.' .sale_request").css("display", "none");
						}, function(){
							$("#market_deal'.$i.' .sale_request").css("display", "block");
						});
					</script>
				';
			}
			echo '
					<div class="market_deal_money">'.$bet_money.' 원</div>
					<div class="market_deal_comment">
						'.$sql_fetch_array2["comment"].'
						<br/><span style="position:relative; top:-2px; margin:0 0 0 0px;">('.$sql_fetch_array2["writetime"].')';
			if($sql_fetch_array2["user_num"]==$user_num){
				echo '<span id="deal_mine_delete" class="button_sw" onclick="deal_submit(\'delete\', '.$count.')">삭제</span>';
			}
			echo '
						</span>
					</div>
				</div>
				<script>
					var height = $("#market_deal'.$i.' .market_deal_comment").height();
					$("#market_deal'.$i.'").height(height);
					$("#market_deal'.$i.' .user_photo").click(function(){//사진을 클릭할 경우
						if('.$user_num.'==0){
							alert("로그인 후 이용해주세요");
						} else {
							var photo_path = $(this).attr("src");
							window.open("photo_recall_one.php?photo_path="+photo_path+"&table_name=idcard_photo", "photo_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
						}
					});
					$("#market_deal'.$i.' .send_msg").click(function(){//쪽지보내기를 클릭할 경우
						if('.$user_num.'==0){
							alert("로그인 후 이용해주세요");
						} else {
							window.open("guest_private_write.php?user_num_receive='.$sql_fetch_array2["user_num"].'", "guest_private_write", "width=770,height=500,resizable=no,scrollbars=yes,location=no");
						}
					});
				</script>
			';
		}
		echo '</div><br/><div style="font-weight:bold; text-align:center;">※ 판매자가 거래신청하고 구매자가 승낙하면 거래자 목록에서 서로의 정보를 확인할 수 있습니다.<br/>※ 물건을 거래할때는 상대방을 거래자로 등록하시어 서로의 정보를 확인하시기 바랍니다.</div>';
	} else if(!$count2){//경매자가 없을경우
		echo '<div style="margin:20px 0 0 0; padding:5px; font-weight:bold; text-align:center; background-color:#D6E4EA;">입찰 내역이 없습니다.</div>';
	}
?>
		<div id="textarea_copy" style="width:570px;"></div>
	</div>
	<div id="temp_target"></div>
</body>
</html>