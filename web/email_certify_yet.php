<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-회원가입</title>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/join.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script>
		var id = '<?php echo $_REQUEST["id"]; ?>';
		$(document).ready(function () {
			$("#email_certify_send").click(function(){
				$.ajax({
					url: "email_certify_send.php",
					data: {id:id},
					success: function(getdata){
						$("body").append(getdata);
					}
				});
			});
			$("#email_certify_change").click(function(){
				var reply = confirm("이메일 주소를 변경하고 싶으시면 등록하신 아이디를 삭제하고 새로 회원가입을 신청해주셔야 합니다.\n\n등록하셨던 아이디는 자동으로 삭제되고 다시 사용하실 수 있습니다.\n\n아이디 삭제를 진행하시겠습니까?");
				if(reply==true){
					$.ajax({
						url: "email_certify_change.php",
						data: {id:id},
						success: function(getdata){
							alert("등록하신 아이디가 삭제되었습니다. 재가입 해주시기 바랍니다.");
						}
					});
				}
			});
		});
	</script>
</head>
<body style="padding:20px;">
	<div class="title">이메일 인증 안내</div>
	<div>※ 현재 이메일 인증이 완료되지 않았습니다. 인증 메일을 확인하시고 인증 과정을 진행해 주시기 바랍니다. 이메일이 스팸함에 있을 수 있으니 확인해 주시기 바랍니다.</div><br/>
	<div id="email_certify_send" class="button_gb">인증메일 재전송 하기</div>
	<div id="email_certify_change" class="button_gb" style="left:185px;">이메일 주소 변경하기</div>
	<div id="temp_target"></div>
</body>
</html>