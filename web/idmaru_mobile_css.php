<?php
	include 'function_is_mobile.php';
	echo '<script>var is_mobile_check = 0;</script>'; // mobile이 아닌 것으로 표시
	if(is_mobile()){//핸드폰일경우
		echo '
			<script>var is_mobile_check = 1;</script>
			<link type="text/css" rel="stylesheet" href="../css/idmaru_mobile.css" />
		';
	} 
	// else{//작은 PC일때도 mobile css 적용
		// <script type="text/javascript">if( (screen.height < 750) || (screen.width < 1000) ){document.write(\'<link type="text/css" rel="stylesheet" href="../css/idmaru_mobile.css" />\');}</script>
	// }
?>