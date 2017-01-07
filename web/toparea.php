<nav id="toparea_up">
	<div id="menu_bars">
		<a href="idmaru.php"><div id="menu_idmaru"></div></a>
		<a href="news.php"><div id="menu_news" class="font_menu"><img src="../image/menu_newsC.jpg" id="newsC" class="absolute0" style="z-index:6;"/><img src="../image/menu_newsA.jpg" id="newsA" class="absolute0" style="z-index:4;"/></div></a>
		<a href="gallery.php"><div id="menu_gallery" class="font_menu"><img src="../image/menu_galleryC.jpg" id="galleryC" class="absolute0" style="z-index:6;"/><img src="../image/menu_galleryA.jpg" id="galleryA" class="absolute0" style="z-index:4;"/></div></a>
		<a href="market.php"><div id="menu_market" class="font_menu"><img src="../image/menu_marketC.jpg" id="marketC" class="absolute0" style="z-index:6;"/><img src="../image/menu_marketA.jpg" id="marketA" class="absolute0" style="z-index:4;"/>></div></a>
		<a href="event.php"><div id="menu_event" class="font_menu"><img src="../image/menu_eventC.jpg" id="eventC" class="absolute0" style="z-index:6;"/><img src="../image/menu_eventA.jpg" id="eventA" class="absolute0" style="z-index:4;"/></div></a>
		<a href="about.php"><div id="menu_about" class="font_menu"><img src="../image/menu_aboutC.jpg" id="aboutC" class="absolute0" style="z-index:6;"/><img src="../image/menu_aboutA.jpg" id="aboutA" class="absolute0" style="z-index:4;"/></div></a>
<script>
	$("#menu_news").hover(function(){
		$("#newsA").css({"z-index":"7"});
	}, function(){
		$("#newsA").css({"z-index":"4"});
	});
	$("#menu_gallery").hover(function(){
		$("#galleryA").css({"z-index":"7"});
	}, function(){
		$("#galleryA").css({"z-index":"4"});
	});
	$("#menu_market").hover(function(){
		$("#marketA").css({"z-index":"7"});
	}, function(){
		$("#marketA").css({"z-index":"4"});
	});
	$("#menu_event").hover(function(){
		$("#eventA").css({"z-index":"7"});
	}, function(){
		$("#eventA").css({"z-index":"4"});
	});
	$("#menu_about").hover(function(){
		$("#aboutA").css({"z-index":"7"});
	}, function(){
		$("#aboutA").css({"z-index":"4"});
	});
</script>
		<div id="login_box">
			<div id="idcard_login"></div>
			<div id="idcard_join"></div>
			<div id="idcard_logout"></div>
		</div>
	</div>
</nav>
<nav id="toparea_down">
	<div id="menu_bars2">
		<div id="menu_bars2_box"></div>
	</div>
</nav>