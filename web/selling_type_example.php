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
<?php include 'declare.php';?>
	<script>
		$(document).ready(function () {
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 물품 분류 Tip</div></div>
	<div id="bodyarea_write" style="margin:10px auto;">
			<div class="desc_keyword"><span class="bold">▶ 게임 => </span>각종 게임소프트웨어, 게임용품, 보드게임, 장난감, 닌텐도, PSP, PS2, PS3, WII, XBOX360, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 도서 => </span>학습지, 사전, 문학서적, 과학서적, 잡지, 소설, 만화, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 모바일 => </span>휴대폰 기계, 악세사리, 충전기, 밧데리, 휴대폰용 이어폰, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 미용 => </span>화장품, 향수, 헤어 및 바디케어, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 부동산 => </span>땅, 건물, 월세, 전세, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 산업용품 => </span>드릴, 전동공구, 유압공구, 측정, 공작기계, 공구, 자재, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 상품권 => </span>도서상품권, 문화상품권, 백화점상품권, 마트상품권, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 생활용품 => </span>사무용품, 가전제품, 침구, 커튼, 욕실용품, 주방용품, 문구류, DIY용품, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 스포츠 => </span>축구, 농구, 야구, 자전거, 인라인, 스키, 골프, 헬스, 레저용품, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 여행 => </span>등산용품, 캠핑, 낚시, 여행시설 이용권, 숙박권, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 영상기기 => </span>TV, DVD, VCR, PMP, DMB, 캠코더, 프로젝터, 편집기기, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 예술 => </span>서양화, 동양화, 현대작품, 미술재료, 미술용품, 골동품, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 음악 => </span>MP3, CDP, 오디오, 홈시어터, 헤드폰, 스피커, LP, CD, DVD, 악기, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 의류패션 => </span>캐쥬얼옷, 정장, 교복, 잠옷, 작업복, 신발, 가방, 모자, 장갑, 지갑, 벨트, 시계, 안경, 선글라스, 쥬얼리, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 차량용품 => </span>자동차, 오토바이, 화물차, 버스, 카오디오, 차량용 네비, 타이어, 자동차 부속품, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 카메라 => </span>DSLR, 일반디카, 필름카메라, 렌즈, 필터, 삼각대, 메모리, 가방, 플래시, 악세사리, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 컴퓨터 => </span>데스크탑, 노트북, 태블릿PC, 모니터, CPU, 메인보드, HDD, 메모리, VGA, ODD, 케이스, 마우스, 프린터, 스피커, 공유기, 공CD, 잉크, ...</div>
			<div class="desc_keyword"><span class="bold">▶ 기타용품 => </span>그 외 물품, ...</div>
	</div>
	<div id="temp_target"></div>
</body>
</html>