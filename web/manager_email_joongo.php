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
				var reply = confirm("개별 E-Mail을 보내시겠습니까?");
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
				<div class="popup_title bold font12"><img src="../image/list_pine.png" style="position:relative; top:2px;"/> 개별 E-Mail 보내기</div><br/>
				<form action="manager_email_joongo_submit.php" enctype="multipart/form-data" method="post" accept-charset="UTF-8">
					<div class="content_area">
					<div style="padding:2px; margin:0 0 5px 0; background-color:#BAD89C; font-size:10pt;">
						<span style="font-weight:bold;">보내는사람 : </span><input type="text" id="mywrite_from" name="mywrite_from" class="" value="joongo@idmaru.co.kr" style="padding:2px; width:620px;"/>
					</div>
					<div style="padding:2px; margin:0 0 10px 0; background-color:#9DC376; font-size:10pt;">
						<span style="font-weight:bold;">받는사람 : </span><input type="text" id="mywrite_to" name="mywrite_to" class="" value="" style="padding:2px; width:630px;"/>
					</div>
					<input id="mywrite_enter" type="image" name="submit" src="../image/button_enter.png" value=""/>
					<div id="write_id" class="title_blue">
						<h6 class="inline" style="position:relative;">&nbsp;제목 : </h6>
						<input type="text" id="mywrite_title" name="mywrite_title" class="inline input_blue" value="안녕하세요~ 중고나라에 등록하신 물건을 보고 메일 드립니다." style="width:650px;" />
					</div>
					<div id="mywrite_body" style="width:725px; padding:0;"><!--내글쓰기-->
<textarea id="mywrite_content" name="mywrite_content">
안녕하세요~ 네이버 중고나라에서 물건 올리신 것을 보고 님의 물건 판매에 도움을 드릴까 해서 이렇게 메일을 드립니다.<br/><br/><br/>
저희가 이번에 <a href="http://www.idmaru.com">http://www.idmaru.com</a> 이라는 SNS형 중고거래 사이트를 오픈하게 되었습니다.<br/><br/>
그래서 저희 사이트에 님의 판매 물건을 홍보해 드리면 좋지 않을까 해서 이렇게 연락드리게 되었습니다.<br/><br/><br/>
님께서 저희 사이트에 직접 물건 판매글을 올리셔도 되고, 그게 힘드시면 저희가 대신 올려드릴수도 있습니다.<br/><br/>
후에 물건 판매가 완료되시면 저희가 올린 글은 직접 삭제해 드리겠습니다. <br/><br/><br/>
저희 사이트가 네이버 중고나라보다 좋은 점은, 중고나라에서는 게시판에 글을 쓰면 다른 분의 글 때문에 번호가 많이 밀려서 글을 재차 등록하여 상위에 보이도록 해야 하는 번거로움이 있었지만 저희 사이트에서는 모든 분들의 글이 상위에 최소 한번 이상 보여지기 때문에 글을 중복해서 올려야 하는 번거로움이 없습니다.<br/><br/><br/>
그리고 저희는 SNS형 중고거래 사이트이기 때문에 웹사이트에서 친구를 맺을 경우, 친구의 판매글을 따로 모아 볼 수 있습니다.<br/><br/>
모르는 사람과 거래하는 것 보다는 아무래도 친구와 거래하는 것이 더 편하고 쉬울 것입니다. ^^<br/><br/><br/>
그 외에도 판매자평을 볼 수 있고, 입찰을 원하시면 입찰을 할 수 있는 기능이 있기 때문에 편리합니다.<br/><br/>
물론 사이트를 이용함에 있어서 어떠한 비용도 들지 않기 때문에 편하게 회원가입 후 이용하시고, 마음에 안드시면 회원 탈퇴도 용이합니다. <br/><br/><br/>
설명이 조금 길어졌습니다만, 요점은 님의 판매물건을 저희가 홍보해드리고 싶어서 이렇게 연락드립니다.<br/><br/>
저희의 제안에 동의하시는 경우에 한해서만 님의 물건 판매글을 대신 올려드리도록 하겠습니다.<br/><br/>
혹은 위에서 말씀드린바와 같이 직접 회원가입 후, 판매글을 올리셔도 무방합니다. <br/><br/><br/>
그럼 좋은 답변 기다리겠습니다~ ^^ <br/><br/><br/>
</textarea>
						<div id="mywrite_func" style="height:32px;">
							
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