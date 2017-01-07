<?php
	include_once 'mysql_setting.php';
	include_once 'sphinx_setting.php';
	include_once 'functions_php.php';
	include_once 'select_menu.php';
	include_once 'alarm_new.php';
	echo '
		<script>
			var user_name = "'.$user_name.'";
			var user_num = '.$user_num.';
			var home_alarm = "'.$_SESSION["home_alarm"].'";
			var guest_private_not_read = "'.$_SESSION["guest_private_not_read"].'";
		</script>
	';
?>