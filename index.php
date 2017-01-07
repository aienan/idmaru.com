<?php include 'web/header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'web/meta_tag.php';?>
	<meta name="Keywords" content="idmaru, 이드마루, SNS, 소셜, portal, 포털, secondhand, market, 중고, 거래, fun, 흥미, photo, 사진, news, 뉴스, event, 이벤트" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루 (idMaru)</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/idmaru.js"></script>
	<script>
		window.name = 'idmaru';
		var user_num = "<?php echo $user_num;?>";
		if(user_num != 0){//로그인중일때
			location.href = "web/idmaru.php";
		} else if(getCookie("auto_login")=="agree"){//자동로그인할 경우
			$.ajax({
				url:'web/login.php',
				data: {auto_login_set:getCookie("auto_login"), save_id_set:getCookie("save_id"), secd:getCookie("secd"), secs:getCookie("secs")},
				success: function(getdata){
					if(getdata=="success"){location.href = "web/idmaru.php";}
					else{setCookie("secd", "", -1, "/", ""); setCookie("secs", "", -1, "/", ""); setCookie("auto_login", "", -1, "/", ""); setCookie("save_id", "", -1, "/", ""); location.href = "web/idmaru.php";}
				}
			});
		} else {
			location.href = "web/idmaru.php";
		}
	</script>
<?php include_once("plugin/analyticstracking.php") ?>
</head>
<body>
	<h1>뉴스보고, 사진올리고, 중고거래하고, 이벤트가 열리는 곳! - 즐겁고 유쾌하게 공유하는 세상, 모두가 함께 만들어가는 생각</h1>
</body>
</html>