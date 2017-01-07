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
	<div class="popup_top"><div style="margin:0 auto; width:700px;"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 안전거래서비스 이용방법</div></div>
	<div style="margin:10px auto; width:700px;">
		<div style="margin:0 0 10px 0; font-size:10pt; font-weight:bold;">
			※ 안전거래 서비스는 거래 사기를 방지하기 위하여 판매자와 구매자가 상호 합의하에 안전거래를 제공하는 사이트에서 일정 수수료를 내고 거래를 진행하는 서비스입니다.
		</div>
		<div style="margin:0 0 0px 0; font-size:10pt; font-weight:bold;">※ 거래 진행 절차</div>
		<div style="margin:0 0 10px 5px; font-size:10pt; font-weight:normal;">
			① 판매자가 안전거래 사이트에 판매 물건을 등록합니다.<br/>
			② 구매자는 안전거래 사이트에 거래대금을 결제합니다.<br/>
			③ 판매자가 상품을 발송합니다.<br/>
			④ 구매자는 상품을 수령한 후, 구매를 승인 혹은 반품합니다.<br/>
			⑤-a. 구매자가 구매를 승인하면 안전거래 사이트에서 판매자에게 수수료를 차감한 거래대금을 지급합니다.<br/>
			⑤-b. 구매자가 반품하면 판매자의 동의하에 물건이 반송되고 반품이 확인되면 구매자에게 거래대금이 되돌려집니다.<br/>
		</div>
		<div style="margin:25px 0 0 0; font-size:10pt; font-weight:bold;">
			※ Google에서 "안전거래"를 검색하시면 다양한 안전거래 사이트를 확인하실 수 있습니다.
		</div>
	</div>
	<div id="temp_target"></div>
</body>
</html>