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
	$seller_num = $_REQUEST["seller_num"];
	$seller_name = $_REQUEST["seller_name"];
	$table_name = "market_seller_report";
	$sql1 = "SELECT * FROM $table_name WHERE seller_num=$seller_num ORDER BY writetime DESC";
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	$sql3 = "SELECT * FROM $table_name WHERE seller_num=$seller_num AND reporter_num=$user_num";
	$sql_query3 = mysqli_query($conn, $sql3);
	$count3 = mysqli_num_rows($sql_query3);
	$sql_fetch_array3 = mysqli_fetch_array($sql_query3);
?>
	<script>
		$(document).ready(function () {
			var string = $("textarea[name=report_comment]").val();
			if(string){//텍스트가 있을때
				var height = $("#textarea_copy").height()+25;
				$("textarea[name=report_comment]").height(height);//textarea의 height 조정
				$("#report_mine").height(height+5);
				var regExp = /[^\n]/gm;//줄바꿈을 제외한 임의의 문자
				var enter = string.replace(regExp, "");//줄바꿈만 남긴다
				var inputLength = $("textarea[name=report_comment]").val().length;
				$("#comment_letterleft").html( (inputLength+enter.length) + " / 255");// 글자 수를 구합니다
			} else if(!string){
				var height = $("#textarea_copy").height()+25;
				$("textarea[name=report_comment]").height(height);//textarea의 height 조정
				$("#report_mine").height(height+5);
			}
			$("textarea[name=report_comment]").keyup(function () {//글쓰기textarea 설정
				$("#textarea_copy").html(convert_to_tag($(this).val()));
				var height = $("#textarea_copy").height()+25;
				$(this).height(height);//textarea의 height 조정
				$("#report_mine").height(height+5);
				var string = $(this).val();//enter는 글자수에 2씩 더해야한다
				var regExp = /[^\n]/gm;//줄바꿈을 제외한 임의의 문자
				var enter = string.replace(regExp, "");//줄바꿈만 남긴다
				var inputLength = $(this).val().length;
				$("#comment_letterleft").html( (inputLength+enter.length) + " / 255");// 글자 수를 구합니다
			});
		});
		function report_enter(type, seller_num){
			if(user_name=="Guest"){
				alert("로그인 후 이용해주세요");
			}else if(user_name!="Guest"){
				var string = $("textarea[name=report_comment]").val();
				if(string){
					if(type=="new"){var reply = confirm("판매자평을 입력하시겠습니까?");}
					else if(type=="modify"){var reply = confirm("판매자평을 수정하시겠습니까?");}
					else if(type=="delete"){var reply = confirm("판매자평을 삭제하시겠습니까?");}
					if(reply==true){
						var comment = $("#report_comment").val();
						$.ajax({//내가 쓴 글 출력
							url:"market_seller_report_submit.php",
							data: {type:type, seller_num:seller_num, comment:comment},
							success: function(getdata){
								if(type=="new"){alert("판매자평이 입력되었습니다");}
								else if(type=="modify"){alert("판매자평이 수정되었습니다");}
								else if(type=="delete"){alert("판매자평이 삭제되었습니다");}
								location.reload();
							}
						});
					}
				} else if(!string){
					alert("판매자평을 입력해주세요");
				}
			}
		}
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 판매자 평가</div></div>
	<div id="bodyarea_write" style="margin:10px auto 0 auto;">
<?php
	echo '
		<div id="textarea_copy" style="width:570px;">'.convert_to_tag($sql_fetch_array3["comment"]).'</div>
		<div style="padding:5px 20px; font-weight:bold; background-color:#DEF0F5;">'.$seller_name.' 님의 판매자평 입니다.</div><br/>
		<div style="position:relative; padding:5px;">
			<div id="report_mine" style="height:60px;">
				<div class="market_report_name">'.$user_name.'</div>
				<textarea id="report_comment" class="market_report_comment input_blue" name="report_comment" maxlength="255" onkeyup="return ismaxlength(this)"></textarea>
			</div>
			<div style="position:relative; height:35px;">
				<div id="comment_letterleft">0 / 255</div>
	';
	if(!$count3){//아직 판매자평을 작성하지 않았을때
		echo '
				<div id="report_mine_enter" class="button_gb" onclick="report_enter(\'new\', '.$seller_num.')">입&nbsp;&nbsp;&nbsp;력</div>
		';
	} else if($count3){
		echo '
				<div id="report_mine_enter" class="button_gb" onclick="report_enter(\'modify\', '.$seller_num.')">수&nbsp;&nbsp;&nbsp;정</div>
				<script>$("#report_comment").val(reverse_from_tag($("#textarea_copy").html()));</script>
		';
	}
	echo '
			</div>
		</div>
		<script>
			var height = $("#report_mine textarea").height();
			$("#report_mine").height(height+10);
		</script>
	';
	if($count1){//판매자평이 있을경우
		echo '<div class="gray_box relative" style="padding:5px; margin:10px 0;">';
		for($i=0; $i < $count1; $i++){
			$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
			$writetime = substr($sql_fetch_array1["writetime"], 0, 10);
			$sql2 = "SELECT * FROM user WHERE user_num=$sql_fetch_array1[reporter_num]";
			$sql_query2 = mysqli_query($conn, $sql2);
			$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
			if($i != 0){echo '<div style="height:10px;"></div>';}
			echo '
				<div id="market_report'.$i.'" class="market_report">
					<div class="market_report_name">'.$sql_fetch_array2["user_name"].'</div>
					<div class="market_report_comment">'.convert_to_tag($sql_fetch_array1["comment"]).' <span style="margin:0 0 0 20px; font-size:9pt;">('.$writetime.')</span>';
			if($sql_fetch_array1["reporter_num"]==$user_num){
				echo '<span id="report_mine_delete" class="button_sw" onclick="report_enter(\'delete\', '.$seller_num.')">삭제</span>';
			}
			echo '</div>
				</div>
				<script>
					var height = $("#market_report'.$i.' .market_report_comment").height();
					$("#market_report'.$i.'").height(height);
				</script>
			';
		}
		echo '</div>';
	} else if(!$count1){//판매자평이 없을경우
		echo '<div style="margin:20px 0 0 0; padding:5px; font-weight:bold; text-align:center; background-color:#D6E4EA;">판매자평이 없습니다.</div>';
	}
	
?>
	</div>
	<div id="temp_target"></div>
</body>
</html>