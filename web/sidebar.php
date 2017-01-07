<nav id="sidebar">
	<div id="sidebody_topedge"></div>
	<div id="sidebody">
		<div id="idcard_name"></div>
		<div id="idcard_photo"></div>
		<div id="menu_sides" class="font_menu">
			<a href="home.php"><div id="menu_home"><div id="menu_home_text"></div><div class="menu_button_bg"></div><div class="menu_button_bg2"></div><div id="menu_home_alarm"></div></div></a>
			<a href="writing.php"><div id="menu_writing"><div id="menu_writing_text"></div><div class="menu_button_bg"></div><div class="menu_button_bg2"></div></div></a>
			<a href="photo.php"><div id="menu_photo"><div id="menu_photo_text"></div><div class="menu_button_bg"></div><div class="menu_button_bg2"></div></div></a>
			<a href="sale.php"><div id="menu_sale"><div id="menu_sale_text"></div><div class="menu_button_bg"></div><div class="menu_button_bg2"></div></div></a>
			<a href="club_event.php"><div id="menu_club"><div id="menu_club_text"></div><div class="menu_button_bg"></div><div class="menu_button_bg2"></div></div></a>
			<a href="guest.php"><div id="menu_guest"><div id="menu_guest_text"></div><div class="menu_button_bg"></div><div class="menu_button_bg2"></div><div id="menu_guest_alarm"></div></div></a>
		</div>
	</div>
	<div id="sidebody_botedge"></div>
	<div id="ad_side_cover"></div>
	<div id="ad_side">
		<div id="page_control"><div id="page_up" title="위로"></div><div id="page_back" title="뒤로"></div><div id="page_forward" title="앞으로"></div><div id="page_reload" title="새로고침"></div><div id="user_memo" title="메모장"></div></div>
<?php
	// $sql1 = "SELECT COUNT(*) AS count_all FROM ad_mine";
	// $sql_query1 = mysqli_query($conn, $sql1);
	// $sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	// if($sql_fetch_array1["count_all"] != 0){
		// $select = 0;
		// $digit4number = (int)(substr(microtime(true), 11, 4));
		// $select = $digit4number % $sql_fetch_array1["count_all"] + 1;
		// $sql3 = "SELECT * FROM ad_mine WHERE ad_num=$select";
		// $sql_query3 = mysqli_query($conn, $sql3);
		// $sql_fetch_array3 = mysqli_fetch_array($sql_query3);
		// echo '<div class="ad_side_item" style="width:150px; height:150px;">'.$sql_fetch_array3["content"].'</div>';
	// } else {
		// echo '<div class="ad_side_item" style="width:150px; height:150px;"></div>';
	// }
?>
		<div class="ad_side_item" style="width:150px; height:207px;"><SCRIPT type="text/javascript" src="http://rsense-ad.realclick.co.kr/rsense/rsense_ad.js?rid=491652347875&stamp=1355747441" charset="euc-kr"></SCRIPT></div><!--  -->
	</div>
<script>
	$("#page_up").click(function(){window.scrollTo(0, 0);});
	$("#page_back").click(function(){history.go(-1);});
	$("#page_forward").click(function(){history.go(1);});
	$("#page_reload").click(function(){location.reload();});
	$("#user_memo").click(function(){
		window.open("user_memo.php", "user_memo", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no");
	});
	if(home_alarm==1){$("#menu_home_alarm").css("display", "block");}//집에 new 버튼을 띄운다
	if(guest_private_not_read==1){$("#menu_guest_alarm").css("display", "block");}//방명록에 new 버튼을 띄운다
	if(is_mobile_check != 1){setSideBar();}
	// $("#ad_pop").click(function(){
		// var ad_type = "ad_pop";
		// var ad_condition = "<?php if(isset($ad_pop_cond)){echo $ad_pop_cond;}?>";
		// $.ajax({
			// url:"ad_count.php",
			// data: {ad_type:ad_type, ad_condition:ad_condition},
			// success: function(getdata){
			// }
		// });
	// });
	// $("#ad_side").click(function(){//ad_side를 클릭하면 클릭수를 올려준다
		// var ad_type = "ad_side";
		// var ad_condition = "<?php if(isset($ad_side_cond)){echo $ad_side_cond;}?>";
		// $.ajax({
			// url:"ad_count.php",
			// data: {ad_type:ad_type, ad_condition:ad_condition},
			// success: function(getdata){
			// }
		// });
	// });
</script>
</nav>