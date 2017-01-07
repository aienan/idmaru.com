function setSideBarLeft(element){// sidebar의 left 위치를 구합니다.
	var site_width = 950;
	var mainbar_width = 803;
	if ( $(window).width() >= site_width) {
		var sideLeft =  mainbar_width + ($(window).width()-site_width)/2 - $(window).scrollLeft();
	} else {
		var sideLeft = mainbar_width - $(window).scrollLeft();
	}
	$(element).css('left', sideLeft);
}
function setSideBarGroup(){ // 위치를 조정해야 할 element
	setSideBarLeft("#page_up");
}
function setSideBar(){ // 창이 스크롤되거나 조정될때
	$(window).scroll(function(){setSideBarGroup();});
	$(window).resize(function(){setSideBarGroup();});
}
function blueStyle(){
	$("#menu_idmaru").html('<img src="../image/idmaru_logo_blue.png"/>');
	$("#toparea_down").css({"background-color":"#377EB6", "border-bottom":"#0067B8 solid 1px"});
	$("#sidebody_topedge").css("background", "url(../image/sidebody_topedge_gray.png) 0 0 no-repeat");
	$("#sidebody_botedge").css("background", "url(../image/sidebody_botedge_gray.png) 0 0 no-repeat");
	$("#sidebody").css({"border-left":"#CCCCCC solid 1px", "border-right":"#CCCCCC solid 1px", "background-color":"#F7F7F7"});
	$("#idcard_name").css("color", "#666666");
	var img_alt = $("#idcard_photo > img").attr("alt");
	if(img_alt != "user_pic"){
		$("#idcard_photo").css({"border":"#F7F7F7 1px solid"});
		if(img_alt=="no_pic_green"){
			$("#idcard_photo").html('<img src="../image/blank_face_gray.png" alt="no_pic_gray"/>');
		} else if(img_alt=="guest_green"){
			$("#idcard_photo").html('<img src="../image/blank_face_gray.png" alt="guest_gray"/>');
		}
	} else {
		$("#idcard_photo").css({"border":"#CCCCCC 1px solid"});
	}
	$("#menu_home_text").css("background", "url(../image/menu_home_gray.png) 0 0 no-repeat");
	$("#menu_writing_text").css("background", "url(../image/menu_writing_gray.png) 0 0 no-repeat");
	$("#menu_photo_text").css("background", "url(../image/menu_photo_gray.png) 0 0 no-repeat");
	$("#menu_sale_text").css("background", "url(../image/menu_sale_gray.png) 0 0 no-repeat");
	$("#menu_club_text").css("background", "url(../image/menu_club_gray.png) 0 0 no-repeat");
	$("#menu_guest_text").css("background", "url(../image/menu_guest_gray.png) 0 0 no-repeat");
	$(".menu_button_bg").css("background", "url(../image/side_button_bg_gray.png) 0 0 no-repeat");
	$(".ad_side_item").css({"border":"#0776CD 1px solid"});
	$("#page_up").css("background", "url(../image/page_up_blue.png) 0 0 no-repeat");
	$("#page_back").css("background", "url(../image/page_back_blue.png) 0 0 no-repeat");
	$("#page_forward").css("background", "url(../image/page_forward_blue.png) 0 0 no-repeat");
	$("#page_reload").css("background", "url(../image/page_reload_blue.png) 0 0 no-repeat");
	$("#user_memo").css("background", "url(../image/user_memo_blue.png) 0 0 no-repeat");
	$("#menu_sides > a > div").bind({
		mouseenter:function(){
			$(this).children(".menu_button_bg").css("display", "block");
		}, mouseleave:function(){
			$(this).children(".menu_button_bg").css("display", "none");
		}
	});
	$(".select_category").css({"border":"#0776CD 2px solid"});
	$("#list_head").css("background-color", "#FAFDFF");
	$("#list_head").css("border-bottom", "#0776CD solid 1px");
	$("#list_box").css("border-top", "#0776CD solid 2px");
	$("#list_box").css("border-bottom", "#0776CD solid 2px");
	$("#list_search_word").css("border", "#0776CD solid 3px");
	$("#list_start_number_set").css("border", "#0776CD solid 2px");
	$("#list_number_set").css("border", "#0776CD solid 2px");
	$(".list_go_back").html('<img src="../image/list_go_backA.png"/>');
	$(".go_prev_list").html('<img src="../image/go_prev_listA.png"/>');
	$(".go_next_list").html('<img src="../image/go_next_listA.png"/>');
	$("#list_search_word_button").append('<img src="../image/search_buttonA.png"/>');
	$("#list_search_word_cancel").append('<img src="../image/search_cancelA.png"/>');
	$("#form_area").css({"border-top":"#0776CD 2px solid", "border-bottom":"#0776CD 2px solid"});
}
function greenStyle(){
	$("#menu_idmaru").html('<img src="../image/idmaru_logo_green.png"/>');
	$("#toparea_down").css({"background-color":"#A2BA45", "border-bottom":"#82A400 solid 1px"});
	$("#sidebody_topedge").css("background", "url(../image/sidebody_topedge_green.png) 0 0 no-repeat");
	$("#sidebody_botedge").css("background", "url(../image/sidebody_botedge_green.png) 0 0 no-repeat");
	$("#sidebody").css({"border-left":"#A2BA45 solid 1px", "border-right":"#A2BA45 solid 1px", "background-color":"#C8DC8E"});
	$("#idcard_name").css("color", "#617a00");
	var img_alt = $("#idcard_photo > img").attr("alt");
	if(img_alt != "user_pic"){
		$("#idcard_photo").css({"border":"#C8DC8E 1px solid"});
		if(img_alt=="no_pic_gray"){
			$("#idcard_photo").html('<img src="../image/blank_face_green.png" alt="no_pic_green"/>');
		} else if(img_alt=="guest_gray"){
			$("#idcard_photo").html('<img src="../image/blank_face_green.png" alt="guest_green"/>');
		}
	} else {
		$("#idcard_photo").css({"border":"#A2BA45 1px solid"});
	}
	$("#menu_home_text").css("background", "url(../image/menu_home_brown.png) 0 0 no-repeat");
	$("#menu_writing_text").css("background", "url(../image/menu_writing_brown.png) 0 0 no-repeat");
	$("#menu_photo_text").css("background", "url(../image/menu_photo_brown.png) 0 0 no-repeat");
	$("#menu_sale_text").css("background", "url(../image/menu_sale_brown.png) 0 0 no-repeat");
	$("#menu_club_text").css("background", "url(../image/menu_club_brown.png) 0 0 no-repeat");
	$("#menu_guest_text").css("background", "url(../image/menu_guest_brown.png) 0 0 no-repeat");
	$(".menu_button_bg").css("background", "url(../image/side_button_bg_green.png) 0 0 no-repeat");
	$(".ad_side_item").css({"border":"#A2BA45 1px solid"});
	$("#page_up").css("background", "url(../image/page_up_green.png) 0 0 no-repeat");
	$("#page_back").css("background", "url(../image/page_back_green.png) 0 0 no-repeat");
	$("#page_forward").css("background", "url(../image/page_forward_green.png) 0 0 no-repeat");
	$("#page_reload").css("background", "url(../image/page_reload_green.png) 0 0 no-repeat");
	$("#user_memo").css("background", "url(../image/user_memo_green.png) 0 0 no-repeat");
	$("#menu_sides > a > div").bind({
		mouseenter:function(){
			$(this).children(".menu_button_bg").css("display", "block");
		}, mouseleave:function(){
			$(this).children(".menu_button_bg").css("display", "none");
		}
	});
	$(".select_category").css({"border":"#A2BA45 2px solid"});
	$("#list_head").css("background-color", "#FAFCF3");
	$("#list_head").css("border-bottom", "#A2BA45 solid 1px");
	$("#list_box").css("border-top", "#A2BA45 solid 2px");
	$("#list_box").css("border-bottom", "#A2BA45 solid 2px");
	$("#list_search_word").css("border", "#A2BA45 solid 3px");
	$("#list_number_set").css("border", "#A2BA45 solid 2px");
	$(".list_go_back").html('<img src="../image/list_go_backB.png"/>');
	$(".go_prev_list").html('<img src="../image/go_prev_listB.png"/>');
	$(".go_next_list").html('<img src="../image/go_next_listB.png"/>');
	$("#list_search_word_button").append('<img src="../image/search_buttonB.png"/>');
	$("#list_search_word_cancel").append('<img src="../image/search_cancelB.png"/>');
	$("#form_area").css({"border-top":"#A2BA45 1px solid", "border-bottom":"#A2BA45 1px solid"});
}
function menuNews(){
	$("#menu_news").html('<img src="../image/menu_newsB.jpg"/>');
	$("#menu_bars2_box").html('<div id="newsType_all" class="menu_bars2_item" onclick="newsTypeSelect(\'all\')">전체</div><div id="newsType_humor" class="menu_bars2_item" onclick="newsTypeSelect(\'humor\')">유머</div><div id="newsType_music" class="menu_bars2_item" onclick="newsTypeSelect(\'music\')">음악</div><div id="newsType_sport" class="menu_bars2_item" onclick="newsTypeSelect(\'sport\')">스포츠</div><div id="newsType_stock" class="menu_bars2_item" onclick="newsTypeSelect(\'stock\')">주식</div><div id="newsType_computer" class="menu_bars2_item" onclick="newsTypeSelect(\'computer\')">컴퓨터</div><div id="newsType_info" class="menu_bars2_item" onclick="newsTypeSelect(\'info\')">정보</div><div id="newsType_debate" class="menu_bars2_item" onclick="newsTypeSelect(\'debate\')">토론</div><div id="newsType_etc" class="menu_bars2_item" onclick="newsTypeSelect(\'etc\')">일상</div>');
	$("#page_title").append('<img src="../image/page_title_news.png"/>');
	$("#newsType_"+news_type).css({"background-color":"#295E88", "color":"#FFFFFF"});
	$("#order_"+order_column).css({"color":"#0776CD"});
	$(".select_category_item").hover(function(){
		$(this).css({"border":"#98C0E2 1px solid"});
	}, function(){
		$(this).css({"border":"#FFFFFF 1px solid"});
	});
	$("#category_status").html("* <span class='border_bottom'>" + news_type_kor + "</span> 뉴스중에서 " + order_column_status(order_column));
	$('#writing_write').click(function(){//글쓰기 클릭시
		window.open("writing_write.php", "writing_write", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no,toolbar=no");
	});
}
function newsTypeSelect(value){
	if(order_column=="all"){location.href = "news_all.php?news_type=" + value;}
	else {location.href = url + "news_type=" + value + "&order_column=" + order_column;}
}
function newsOrderSelect(value){
	if(value=="all"){location.href = "news_all.php?news_type=" + news_type;}
	else {location.href = "news.php?news_type=" + news_type + "&order_column=" + value;}
}
function news_type_status(news_type){
	var news_type_kor;
	if(news_type=="all"){news_type_kor = "전체";}
	else if(news_type=="humor"){news_type_kor = "유머";}
	else if(news_type=="music"){news_type_kor = "음악";}
	else if(news_type=="sport"){news_type_kor = "스포츠";}
	else if(news_type=="stock"){news_type_kor = "주식";}
	else if(news_type=="computer"){news_type_kor = "컴퓨터";}
	else if(news_type=="info"){news_type_kor = "정보";}
	else if(news_type=="debate"){news_type_kor = "토론";}
	else if(news_type=="etc"){news_type_kor = "일상";}
	return news_type_kor;
}
function order_column_status(order_column){
	var output;
	if(order_column=="all"){output = "<span class='border_bottom'>게시물이 등록된 순서</span>대로 정렬됩니다";}
	else if(order_column=="read_count_1"){output = "<span class='border_bottom'>1일 조회수</span>가 높은순으로 정렬됩니다";}
	else if(order_column=="updown_total"){output = "<span class='border_bottom'>추천수</span>가 높은순으로 정렬됩니다";}
	else if(order_column=="up_total"){output = "<span class='border_bottom'>추천수</span>가 높은순으로 정렬됩니다";}
	else if(order_column=="read_count_7"){output = "<span class='border_bottom'>주간 조회수</span>가 높은순으로 정렬됩니다";}
	else if(order_column=="read_count_30"){output = "<span class='border_bottom'>월간 조회수</span>가 높은순으로 정렬됩니다";}
	return output;
}
function menuGallery(){
	$("#menu_gallery").html('<img src="../image/menu_galleryB.jpg"/>');
	$("#menu_bars2_box").html('<div id="galleryType_all" class="menu_bars2_item" onclick="galleryTypeSelect(\'all\')">전체</div><div id="galleryType_common" class="menu_bars2_item" onclick="galleryTypeSelect(\'common\')">일반</div><div id="galleryType_celeb" class="menu_bars2_item" onclick="galleryTypeSelect(\'celeb\')">연예인</div><div id="galleryType_stylish" class="menu_bars2_item" onclick="galleryTypeSelect(\'stylish\')">얼짱</div><div id="galleryType_humor" class="menu_bars2_item" onclick="galleryTypeSelect(\'humor\')">유머</div><div id="galleryType_unusual" class="menu_bars2_item" onclick="galleryTypeSelect(\'unusual\')">엽기</div><div id="galleryType_fashion" class="menu_bars2_item" onclick="galleryTypeSelect(\'fashion\')">패션</div><div id="galleryType_nature" class="menu_bars2_item" onclick="galleryTypeSelect(\'nature\')">자연</div><div id="galleryType_animal" class="menu_bars2_item" onclick="galleryTypeSelect(\'animal\')">동물</div><div id="galleryType_thing" class="menu_bars2_item" onclick="galleryTypeSelect(\'thing\')">물건</div>');
	$("#page_title").append('<img src="../image/page_title_gallery.png"/>');
	$("#galleryType_"+gallery_type).css({"background-color":"#295E88", "color":"#FFFFFF"});
	$("#order_"+order_column).css({"color":"#0776CD"});
	$(".select_category_item").hover(function(){
		$(this).css({"border":"#98C0E2 1px solid"});
	}, function(){
		$(this).css({"border":"#FFFFFF 1px solid"});
	});
	$("#category_status").html("* <span class='border_bottom'>" + gallery_type_kor + "</span> 갤러리에서 " + order_column_status(order_column));
	$("#photo_area_total").css("border-top", "#0776CD solid 2px");
	$("#photo_area_total").css("border-bottom", "#0776CD solid 2px");
	$('#photo_upload').click(function(){//글쓰기 클릭시
		window.open("photo_upload.php", "photo_upload", "width=770,height=685,resizable=yes,scrollbars=yes,location=no");
	});
}
function galleryTypeSelect(value){
	if(order_column=="all"){location.href = "../web/gallery_all.php?gallery_type=" + value;}
	else {location.href = "../web/gallery.php?gallery_type=" + value + "&order_column=" + order_column;}
}
function galleryOrderSelect(value){
	if(value=="all"){location.href = "gallery_all.php?gallery_type=" + gallery_type;}
	else {location.href = "gallery.php?gallery_type=" + gallery_type + "&order_column=" + value;}
}
function gallery_type_status(gallery_type){
	var gallery_type_kor;
	if(gallery_type=="all"){gallery_type_kor = "전체";}
	else if(gallery_type=="common"){gallery_type_kor = "일반";}
	else if(gallery_type=="celeb"){gallery_type_kor = "연예인";}
	else if(gallery_type=="humor"){gallery_type_kor = "유머";}
	else if(gallery_type=="unusual"){gallery_type_kor = "엽기";}
	else if(gallery_type=="fashion"){gallery_type_kor = "패션";}
	else if(gallery_type=="nature"){gallery_type_kor = "자연";}
	else if(gallery_type=="animal"){gallery_type_kor = "동물";}
	else if(gallery_type=="thing"){gallery_type_kor = "물건";}
	else if(gallery_type=="stylish"){gallery_type_kor = "얼짱";}
	return gallery_type_kor;
}
function menuPhotoBattle(){
	order_column = "read_count_1";
	$("#menu_bars2_box").html('<div id="galleryType_all" class="menu_bars2_item" onclick="galleryTypeSelect(\'all\')">전체</div><div id="galleryType_common" class="menu_bars2_item" onclick="galleryTypeSelect(\'common\')">일반</div><div id="galleryType_celeb" class="menu_bars2_item" onclick="galleryTypeSelect(\'celeb\')">연예인</div><div id="galleryType_stylish" class="menu_bars2_item" onclick="galleryTypeSelect(\'stylish\')">얼짱</div><div id="galleryType_humor" class="menu_bars2_item" onclick="galleryTypeSelect(\'humor\')">유머</div><div id="galleryType_unusual" class="menu_bars2_item" onclick="galleryTypeSelect(\'unusual\')">엽기</div><div id="galleryType_fashion" class="menu_bars2_item" onclick="galleryTypeSelect(\'fashion\')">패션</div><div id="galleryType_nature" class="menu_bars2_item" onclick="galleryTypeSelect(\'nature\')">자연</div><div id="galleryType_animal" class="menu_bars2_item" onclick="galleryTypeSelect(\'animal\')">동물</div><div id="galleryType_thing" class="menu_bars2_item" onclick="galleryTypeSelect(\'thing\')">물건</div>');
	$("#galleryType_battle").css({"background-color":"#295E88", "color":"#FFFFFF"});
	$("#menu_gallery").html('<img src="../image/menu_galleryB.jpg"/>');
	$("#page_title").html('<img src="../image/page_title_photo_battle.jpg"/>').css({"padding":"0", "margin":"0"});
	$("#photo_battle_submit").css({"width":"32px"});
	$("#photo_battle_submit").click(function(){
		window.open("photo_battle_upload.php", "photo_battle_upload", "width=770,height=685,resizable=yes,scrollbars=yes,location=no");
	});
}
function menuMarket(){
	$("#menu_market").html('<img src="../image/menu_marketB.jpg"/>');
	$("#menu_bars2_box").html('<div id="marketType_list" class="menu_bars2_item" onclick="marketTypeSelect(\'list\')">목록보기</div><div id="marketType_pic" class="menu_bars2_item" onclick="marketTypeSelect(\'pic\')">사진보기</div>');
	$("#page_title").append('<img src="../image/page_title_market.png"/>');
	$("#marketType_"+market_type).css({"background-color":"#295E88", "color":"#FFFFFF"});
	$("#select_category_sale").css({"border":"#0776CD 2px solid"});
	$(".select_category_item2").hover(function(){
		$(this).css({"border":"#98C0E2 1px solid"});
	}, function(){
		$(this).css({"border":"#FFFFFF 1px solid"});
	});
	$('#sale_write').click(function(){//글쓰기 클릭시
		window.open("sale_write.php", "sale_write", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no");
	});
	$("#selling_type_example").click(function(){
		window.open("selling_type_example.php", "selling_type_example", "width=770,height=630,resizable=yes,scrollbars=yes,location=no");
	});
}
function marketTypeSelect(value){
	if(value=="list"){location.href = "../web/market.php";}
	else if(value=="pic"){location.href = "../web/market_pic.php";}
}
function sellingTypeSelect(value){
	if(value=="전체"){value="all";}
	location.href = url + "selling_type=" + value;
}
function sale_email(count, writer_num){
	if(user_num==0){alert("로그인 후 이용해주세요");}
	else if(user_num==writer_num){alert("본인에게 E-mail을 보낼 수 없습니다");}
	else {window.open("sale_email.php?count="+count, "sale_email", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");}
}
function sellingTypeName(selling_type, color){
	var sellingType_name;
	if(selling_type=="all"){sellingType_name="all";}
	else if(selling_type=="all"){sellingType_name="all";}
	else if(selling_type=="게임"){sellingType_name="game";}
	else if(selling_type=="도서"){sellingType_name="book";}
	else if(selling_type=="모바일"){sellingType_name="mobile";}
	else if(selling_type=="미용"){sellingType_name="cosmetic";}
	else if(selling_type=="부동산"){sellingType_name="estate";}
	else if(selling_type=="산업용품"){sellingType_name="industry";}
	else if(selling_type=="상품권"){sellingType_name="giftcard";}
	else if(selling_type=="생활용품"){sellingType_name="household";}
	else if(selling_type=="스포츠"){sellingType_name="sports";}
	else if(selling_type=="여행"){sellingType_name="travel";}
	else if(selling_type=="영상기기"){sellingType_name="video";}
	else if(selling_type=="예술"){sellingType_name="art";}
	else if(selling_type=="음악"){sellingType_name="music";}
	else if(selling_type=="의류패션"){sellingType_name="fashion";}
	else if(selling_type=="차량용품"){sellingType_name="car";}
	else if(selling_type=="카메라"){sellingType_name="camera";}
	else if(selling_type=="컴퓨터"){sellingType_name="computer";}
	else if(selling_type=="기타용품"){sellingType_name="etc";}
	if(color=="blue"){$("#sellingType_"+sellingType_name).css({"background-color":"#0776CD", "color":"#FFF"});}
	else if(color=="green"){$("#sellingType_"+sellingType_name).css({"background-color":"#A2BA45", "color":"#FFF"});}
}
function menuEvent(){
	$("#menu_event").html('<img src="../image/menu_eventB.jpg"/>');
	$("#menu_bars2_box").html('<div id="eventType_tile" class="menu_bars2_item" onclick="eventTypeSelect(\'tile\')">이벤트</div><div id="eventType_group" class="menu_bars2_item" onclick="eventTypeSelect(\'group\')">모임</div>');
	if(event_type=="tile" || event_type=="list"){$("#page_title").append('<img src="../image/page_title_event.png"/>');}
	else if(event_type=="group"){$("#page_title").append('<img src="../image/page_title_group.png"/>');}
	if(event_type=="tile" || event_type=="list"){$("#eventType_tile").css({"background-color":"#295E88", "color":"#FFFFFF"});}
	else if(event_type=="group"){$("#eventType_group").css({"background-color":"#295E88", "color":"#FFFFFF"});}
	$("#menu_square_"+event_type).css("background-color", "#377EB6");
}
function club_event_admit(){
	window.open("club_event_write.php", "club_event_write", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no");
}
function eventTypeSelect(value){
	if(value=="tile"){location.href = "event.php";}
	else if(value=="list"){location.href = "event_all.php";}
	else if(value=="group"){location.href = "event_group.php";}
}
function event_type_status(event_type){
	var event_type_kor;
	if(event_type=="tile"){event_type_kor = "이벤트 (타일형 보기)";}
	else if(event_type=="list"){event_type_kor = "이벤트 (목록형 보기)";}
	else if(event_type=="group"){event_type_kor = "모임";}
	return event_type_kor;
}
function menuAbout(){
	$("#menu_about").html('<img src="../image/menu_aboutB.jpg"/>');
	$("#menu_bars2_box").html('<div id="aboutType_idmaru" class="menu_bars2_item" onclick="aboutTypeSelect(\'idmaru\')">이드마루란?</div><div id="aboutType_question" class="menu_bars2_item" onclick="aboutTypeSelect(\'question\')">문의하기</div>');
	$("#page_title").append('<img src="../image/page_title_idmaru.png"/>');
	if(about_type=="idmaru"){$("#aboutType_idmaru").css({"background-color":"#295E88", "color":"#FFFFFF"});}
	else if(about_type=="question"){$("#aboutType_question").css({"background-color":"#295E88", "color":"#FFFFFF"});}
	$('#about_question_write').click(function(){//글쓰기 클릭시
		if(user_name=="Guest"){
			alert("로그인 후 이용해주세요");
		}else if(user_name!="Guest"){
			window.open("about_question_write.php", "writing_write", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no");
		}
	});
}
function aboutTypeSelect(value){
	if(value=="idmaru"){location.href = "about.php";}
	else if(value=="question"){location.href="about_question.php";}
}
function menuMyinfo(){
	$("#page_title").append('<img src="../image/page_title_myinfo.jpg"/>');
}
function menuHome(){
	$("#menu_home_text").css("background", "url(../image/menu_home_white.png) 0 0 no-repeat");
	$("#menu_home > .menu_button_bg2").css("display", "block");
	$("#page_title").append('<img src="../image/page_title_home.jpg"/>');
	if(home_type=="home"){$("#menu_square_home").css("background-color", "#A2BA45");}
	else if(home_type=="friend"){$("#menu_square_friend").css("background-color", "#A2BA45");}
}
function menuWriting(){
	$("#menu_writing_text").css("background", "url(../image/menu_writing_white.png) 0 0 no-repeat");
	$("#menu_writing > .menu_button_bg2").css("display", "block");
	$("#page_title").append('<img src="../image/page_title_writing.jpg"/>');
	$("#news_type_"+news_type).css("color", "#A2BA45");
	$("#menu_square_"+writing_type).css("background-color", "#A2BA45");
	$(".select_category_item").hover(function(){
		$(this).css({"border":"#C8DC8E 1px solid"});
	}, function(){
		$(this).css({"border":"#FFFFFF 1px solid"});
	});
	$('#writing_write').click(function(){//글쓰기 클릭시
		window.open("writing_write.php", "writing_write", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no,toolbar=no");
	});
}
function writingTypeSelect(value){
	location.href = url + "news_type=" + value;
}
function menuPhoto(){
	$("#menu_photo_text").css("background", "url(../image/menu_photo_white.png) 0 0 no-repeat");
	$("#menu_photo > .menu_button_bg2").css("display", "block");
	$("#page_title").append('<img src="../image/page_title_photo.jpg"/>');
	$("#gallery_type_"+gallery_type).css("color", "#A2BA45");
	$("#menu_square_"+photo_type).css("background-color", "#A2BA45");
	$(".select_category_item").hover(function(){
		$(this).css({"border":"#C8DC8E 1px solid"});
	}, function(){
		$(this).css({"border":"#FFFFFF 1px solid"});
	});
	$("#photo_area_total").css({"border-top":"#A2BA45 solid 2px", "border-bottom":"#A2BA45 solid 2px"});
	$('#photo_upload').click(function(){//글쓰기 클릭시
		window.open("photo_upload.php", "photo_upload", "width=770,height=685,resizable=yes,scrollbars=yes,location=no");
	});
	$("#photo_watch").val(status);
}
function photoTypeSelect(value){
	location.href = url + "gallery_type=" + value;
}
function menuSale(){
	$("#menu_sale_text").css("background", "url(../image/menu_sale_white.png) 0 0 no-repeat");
	$("#menu_sale > .menu_button_bg2").css("display", "block");
	$("#page_title").append('<img src="../image/page_title_sale.jpg"/>');
	$("#menu_square_"+sale_type).css("background-color", "#A2BA45");
	$("#select_category_sale").css({"border":"#A2BA45 2px solid"});
	$(".select_category_item2").hover(function(){
		$(this).css({"border":"#C8DC8E 1px solid"});
	}, function(){
		$(this).css({"border":"#FFFFFF 1px solid"});
	});
	$('#sale_write').click(function(){//글쓰기 클릭시
		window.open("sale_write.php", "sale_write", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no");
	});
	$("#selling_type_example").click(function(){
		window.open("selling_type_example.php", "selling_type_example", "width=770,height=630,resizable=yes,scrollbars=yes,location=no");
	});
}
function menuClub(){
	$("#menu_club_text").css("background", "url(../image/menu_club_white.png) 0 0 no-repeat");
	$("#menu_club > .menu_button_bg2").css("display", "block");
	if(club_type=="myGroup"){$("#page_title").append('<img src="../image/page_title_group.jpg"/>');}
	else {$("#page_title").append('<img src="../image/page_title_event.jpg"/>');}
	$("#menu_square_"+club_type).css("background-color", "#A2BA45");
}
function club_group_admit(){
	if(user_num==0){alert("로그인 후 이용해주세요");}
	else {
		window.open("club_group_register.php", "club_group_register", "width=770,height=650,resizable=yes,scrollbars=yes,location=no");
	}
}
function menuClubGroup(){
	$("#page_title").append('<img src="../image/page_title_group.jpg"/>');
}
function menuGuest(){
	$("#menu_guest_text").css("background", "url(../image/menu_guest_white.png) 0 0 no-repeat");
	$("#menu_guest > .menu_button_bg2").css("display", "block");
	if(guest_type=="guestPrivate"){$("#page_title").append('<img src="../image/page_title_guest.jpg"/>');}
	else if(guest_type=="idmaruGuest"){$("#page_title").append('<img src="../image/page_title_idmaru_guest.jpg"/>');}
	$("#menu_square_"+guest_type).css("background-color", "#A2BA45");
}
function myWrite(element){
	element.css({"background-color":"#DEF0F5", "border-top":"#377EB6 1px solid"});
}
function othersWrite(element){
	element.css({"background-color":"#EEF6D4", "border-top":"#84BA45 1px solid"});
}
function setCookie(name, value, time){//쿠키설정. time은 초단위.
	var date = new Date();
	date.setTime(date.getTime() + time*1000);
	var willCookie = '';
	willCookie += name + '=' + encodeURIComponent(value) + ';';
	willCookie += 'expires=' + date.toUTCString() + '';
	document.cookie = willCookie;
}
function getCookie(name){//쿠키값 추출.
	var cookies = document.cookie.split(';');
	for (var i in cookies) {
		var string = cookies[i];
		var regExp = /\s/;
		string = string.replace(regExp, '');//공백문자제거
		regExp = /=.*/;
		string = string.replace(regExp, '');//=뒤에 있는 값제거
		if (string == name) {//string은 cookie의 name
			var result = cookies[i];
			regExp = /\s/;
			result = result.replace(regExp, '');//공백문자제거
			result = result.replace(name + '=', '');//name을 지우고 value만 남김
			return decodeURIComponent(result);
		}
	}
}
function removeCookie(name){//쿠키제거.
	var date = new Date();
	date.setTime(date.getTime() - 1000);
	var willCookie = '';
	willCookie += name + '=Value;';
	willCookie += 'expires=' + date.toUTCString();
	document.cookie = willCookie;
}
function Descbox(parent, comment, width, direction){//설명하고 싶은 parent객체에 comment를 답니다.
	if(width != 0){
		var commbox = '<div class="input_gray" style="position:absolute; line-height:1.4; text-align:right; width:'+width+'px;">'+comment+'</div>';
	} else {
		var commbox = '<div class="input_gray" style="position:absolute; line-height:1.4; text-align:right;">'+comment+'</div>';
	}
	$(parent).append(commbox);
	$(parent + '> .descbox').css('display', 'none').css('top', $(parent).height()).css(direction, '0');
	$(parent).bind({
		mouseenter: function () {
				$(parent +'> .descbox').css('display', 'block');
		},
		mouseleave: function () {
				$(parent +'> .descbox').css('display', 'none');
		}
	});
}
function isEmail(string){// email 형식이면 true를, 아니면 false를 리턴합니다.
	var regExp = /\w+@\w+\.\w+/;
	return regExp.test(string);
}
function isthereEnglish(string){//영문이 있는지 검사
	var regExp = /[a-z]/g;
	return string.search(regExp);
}
function isPhone(string){// 핸드폰 형식 체크
	if(!string){ return false; }
	var regExp = /01\d{8,9}/;
	if (string.replace(regExp, '').length == 0) {
		return true;
	} else {
		return false;
	}
}
function isSSN(string){// SSN 형식 체크
	if(!string){ return false; }
	var regExp = /\d{6}-[1234]\d{6}/;
	if (string.replace(regExp, '').length == 0) {
		return true;
	} else {
		return false;
	}
}
function isNocap(string){// 영문이고, 대문자가 없는지 체크
	if(!string){ return false; }
	var regExp = /([0-9]|[a-z])/g;
	if (string.replace(regExp, '').length == 0) {
		return true;
	} else {
		return false;
	}
}
function isEnglish(string){// 영어인지 체크
	if(!string){ return false; }
	var regExp = /([a-z])/g;
	if (string.replace(regExp, '').length == 0) {
		return true;
	} else {
		return false;
	}
}
function isKorean(string){// 한글인지 체크
	if(!string){ return false; }
	var regExp = /([가-히])/g;
	if (string.replace(regExp, '').length == 0) {
		return true;
	} else {
		return false;
	}
}
function isNumber(string){//숫자인지 체크
	var regExp = /(\d)/g;
	if (string.replace(regExp, '').length == 0) {
		return true;
	} else {
		return false;
	}
}
function afterModifyUrl(string){
	var regExp = /&.*/g;
	output = string.replace(regExp, '');
	return output;
}
function changeQuotation(string){
	var regExp = /'/g;
	output = string.replace(regExp, '"');
	return output;
}
function strip_string(string, start, end){//start와 end 사이의 글을 제거한다
	var string_before = string.substring(0, start);
	var string_after = string.substring(end, string.length);
	return string_before+string_after;
}
function count_tag(tag, string){//img의 갯수를 센다
	var offset = 0;
	var i=0;
	do {
		var pos1 = string.indexOf(tag, offset);
		if(pos1 != -1){i+=1;}
		offset = pos1 + 4;
	} while(pos1 != -1)
	return i;
}
function img_array(content){//content에서 <img 태그를 ((사진1)) 형식으로 변환한다
	var content_lowercase = content.toLowerCase();
	var output = new Array();
	var find1 = "<img";
	var find2 = ">";
	var offset = 0;
	var i = 0;
	do{
		var pos1 = content_lowercase.indexOf(find1, offset);
		if(pos1 != -1){
			var pos2 = content_lowercase.indexOf(find2, pos1+4);
			if(pos2 != -1){
				var pos2_end = pos2 + 1;
				output[i] = content_lowercase.substring(pos1, pos2_end);
				i++;
				content_lowercase = content_lowercase.substring(pos2_end);
			}
		}
	} while(pos1 != -1 && pos2 != -1);
	return output;
}
// function sub_img_tag(content){//content에서 <img 태그를 ((사진1)) 형식으로 변환한다
	// var content_lowercase = content.toLowerCase();
	// var find1 = "<img";
	// var find2 = ">";
	// var offset = 0;
	// var content_new = content;
	// var i = 0;
	// do{
		// var pos1 = content_lowercase.indexOf(find1, offset);
		// if(pos1 != -1){
			// var pos2 = content_lowercase.indexOf(find2, pos1+4);
			// if(pos2 != -1){
				// i++;
				// var pos2_end = pos2 + 1;
				// var photo_str = content_new.substring(pos1, pos2_end);
				// var photo_str_new = "((사진"+i+"))";
				// content_new = content_new.replace(photo_str, photo_str_new);
				// photo_str_lowercase = content_lowercase.substring(pos1, pos2_end);
				// content_lowercase = content_lowercase.replace(photo_str_lowercase, photo_str_new);
				// offset = pos1 + 4;//"((사진" 뒷 부분부터 시작
			// }
		// }
	// } while(pos1 != -1 && pos2 != -1);
	// return content_new;
// }
function img_file_name(table_name, path){//img 파일의 파일명과 확장자를 알아냅니다
	var find1 = table_name+"/";
	var find2 = '"';
	var pos1 = path.indexOf(find1, 0);
	if(pos1 != -1){
		var pos2 = path.indexOf(find2, pos1+table_name.length+1);
		if(pos2 != -1){
			var file_name = path.substring(pos1+table_name.length+1, pos2);
		} else if(pos2==-1){
			pos3 = path.indexOf("'", pos1+table_name.length+1);
			if(pos3 != -1){
				var file_name = path.substring(pos1+table_name.length+1, pos3);
			}
		}
	}
	return file_name;
}
function get_selling_type(content){//거래에서 [ ]의 selling_type을 알아낸다
	var find1 = "]";
	var offset = 0;
	var pos1 = content.indexOf(find1, offset);
	var output;
	if(pos1 != -1){//pos1이 있을경우
		output = content.substring(1, pos1);
	}
	return output;
}
function strip_selling_type(content){//거래에서 [ ]의 selling_type을 제거한다
	var find1 = "]";
	var offset = 0;
	var content_new = content;
	var pos1 = content_new.indexOf(find1, offset);
	if(pos1 != -1){//pos1이 있을경우
		var pos1_end = pos1 + 2;// ] 뒤에 있는 띄어쓰기까지 제거한다
		content_new = content_new.substring(pos1_end);
	}
	return content_new;
}
function strip_span_start(content){//<span>의 시작 부분만 제거한다
	var find1 = "<span";
	var find2 = ">";
	var offset = 0;
	var content_new = content;
	do{
		var pos1 = content_new.toLowerCase().indexOf(find1, offset);
		if(pos1 != -1){//pos1이 있을경우
			var pos2 = content_new.toLowerCase().indexOf(find2, pos1+5);
			if(pos2 != -1){
				var pos2_end = pos2 + 1;
				content_new = strip_string(content_new, pos1, pos2_end);
			}
		}
	} while(pos1 != -1 && pos2 != -1);
	return content_new;
}
function strip_span_end(content){//</span>만 제거한다
	var find1 = "</span>";
	var offset = 0;
	var content_new = content;
	do{
		var pos1 = content_new.toLowerCase().indexOf(find1, offset);
		if(pos1 != -1){//pos1이 있을경우
			var pos1_end = pos1+7;
			content_new = strip_string(content_new, pos1, pos1_end);
		}
	} while(pos1 != -1);
	return content_new;
}
function strip_span_keyword(content){//<span>의 시작 부분만 제거한다
	var find1 = "<span style=\"background-color: #fff286;\">";//기본
	var find2 = "</span>";
	var offset = 0;
	var content_new = content;
	do{
		var pos1 = content_new.toLowerCase().indexOf(find1, offset);
		if(pos1 != -1){//pos1이 있을경우
			var pos1_end = pos1+41;
			content_new = strip_string(content_new, pos1, pos1_end);
			var pos2 = content_new.toLowerCase().indexOf(find2, pos1);
			if(pos2 != -1){
				var pos2_end = pos2 + 7;
				content_new = strip_string(content_new, pos2, pos2_end);
				offset = pos2;
			}
		}
	} while(pos1 != -1 && pos2 != -1);
	var find3 = "<span style=\"background-color: #fff286\">";//IE7, 8에서 발견
	var find2 = "</span>";
	offset = 0;
	do{
		var pos3 = content_new.toLowerCase().indexOf(find3, offset);
		if(pos3 != -1){//pos1이 있을경우
			var pos3_end = pos3+40;
			content_new = strip_string(content_new, pos3, pos3_end);
			var pos2 = content_new.toLowerCase().indexOf(find2, pos3);
			if(pos2 != -1){
				var pos2_end = pos2 + 7;
				content_new = strip_string(content_new, pos2, pos2_end);
				offset = pos2;
			}
		}
	} while(pos3 != -1 && pos2 != -1);
	var find4 = "<span style=\"background-color: rgb(255, 242, 134);\">";//IE9에서 발견
	var find2 = "</span>";
	offset = 0;
	do{
		var pos4 = content_new.toLowerCase().indexOf(find4, offset);
		if(pos4 != -1){//pos1이 있을경우
			var pos4_end = pos4+52;
			content_new = strip_string(content_new, pos4, pos4_end);
			var pos2 = content_new.toLowerCase().indexOf(find2, pos4);
			if(pos2 != -1){
				var pos2_end = pos2 + 7;
				content_new = strip_string(content_new, pos2, pos2_end);
				offset = pos2;
			}
		}
	} while(pos4 != -1 && pos2 != -1);
	return content_new;
}
function strip_span(content){//<span></span>안의 내용은 놔두고 태그만 제거한다
	var content_new = strip_span_start(content);
	content_new = strip_span_end(content_new);
	return content_new;
}
function addComma(number) {//천 단위마다 콤마를 찍습니다
	var regExp = /(^[+-]?\d+)(\d{3})/;
	var string = String(number);
	while (regExp.test(string)) {
		string = string.replace(regExp, '$1,$2');
	}
	return string;
}
function removeComma(number) {//천 단위마다 콤마를 찍습니다
	var regExp = /(,)/g;
	var string = String(number);
	var output = string.replace(regExp, '');
	return output;
}
function add_br(content){
	var regExp = /\n/igm;
	var string = content;
	var output = string.replace(regExp, '<br/>');
	return output;
}
function add_nbsp(content){
	var regExp = / /igm;
	var string = content;
	var output = string.replace(regExp, '&nbsp;');
	return output;
}
function replace_br(content){
	var regExp = /<br\/?>/igm;
	var string = content;
	var output = string.replace(regExp, '\n');
	return output;
}
function replace_nbsp(content){
	var regExp = /&nbsp;/igm;
	var string = content;
	var output = string.replace(regExp, ' ');
	return output;
}
function replace_html_tag(content){
	var output = content;
	output = replace_br(output);
	output = replace_nbsp(output);
	return output;
}
function replace_lt(content){
	var regExp = /&lt;/igm;
	var string = content;
	var output = string.replace(regExp, '<');
	return output;
}
function replace_gt(content){
	var regExp = /&gt;/igm;
	var string = content;
	var output = string.replace(regExp, '>');
	return output;
}
function replace_to_lt(content){
	var regExp = /</igm;
	var string = content;
	var output = string.replace(regExp, '&lt;');
	return output;
}
function replace_to_gt(content){
	var regExp = />/igm;
	var string = content;
	var output = string.replace(regExp, '&gt;');
	return output;
}
function replace_end_space(title){
	var regExp = /\s+$/;
	var string = title;
	var output = string.replace(regExp, '');
	return output;
}
function reverse_from_tag(content){
	var output = content;
	output = replace_br(output);
	output = replace_nbsp(output);
	output = strip_span_keyword(output);
	output = replace_lt(output);
	output = replace_gt(output);
	return output;
}
function convert_to_tag(content){
	var output = content;
	output = replace_to_lt(output);
	output = replace_to_gt(output);
	output = add_nbsp(output);
	output = add_br(output);
	return output;
}
function reverse_from_tag_title(content){
	var output = content;
	output = strip_span_keyword(output);
	output = replace_lt(output);
	output = replace_gt(output);
	output = replace_end_space(output);
	return output;
}
function ismaxlength(obj){
	var maxlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
	if (obj.getAttribute && obj.value.length>maxlength) {
		obj.value=obj.value.substring(0,maxlength);
	}
}
function is_idmaru_id(content){//id의 맨 앞에 idmaru가 붙어있는지 확인
	var regExp = /^idmaru/ig;
	var string = content;
	return string.search(regExp);
}
function is_guest_id(content){
	var regExp = /^guest/ig;
	var string = content;
	return string.search(regExp);
}
function facebook_link(url, title, summary, image){
	window.open("http://www.facebook.com/sharer.php?s=100&p[url]="+url+"&p[title]="+title+"&p[summary]="+summary+"&p[images][0]="+image, "facebook_link","width=770,height=600,toolbar=0,status=0");
}
function twitter_link(text){
	window.open("http://www.twitter.com/intent/tweet?source=webclient&text="+text, "twitter_link", "width=770,height=600,toolbar=0,status=0");
}
function me2day_link(body){
	window.open("http://me2day.net/plugins/post/new?new_post[body]="+body+"&new_post[tags]=idMaru", "me2day_link", "toolbar=0,status=0");
}
function get_popup_height(){
	var output = parseInt(screen.height * 2 / 3);
	return output;
}
function get_textarea_height(){
	var output = parseInt(screen.height * 2 / 3) - 320;
	return output;
}
function calender_date(year, month){
	if( !year || !month ) {return '<option value="">선택</option>';}
	else {
	var year = parseInt(year);
	var month = parseInt(month);
	if((month==1) || (month==3) || (month==5) || (month==7) || (month==8) || (month==10) || (month==12)){
		return '<option value="">선택</option><option value="01"> 1 </option><option value="02"> 2 </option><option value="03"> 3 </option><option value="04"> 4 </option><option value="05"> 5 </option><option value="06"> 6 </option><option value="07"> 7 </option><option value="08"> 8 </option><option value="09"> 9 </option><option value="10"> 10 </option><option value="11"> 11 </option><option value="12"> 12 </option><option value="13"> 13 </option><option value="14"> 14 </option><option value="15"> 15 </option><option value="16"> 16 </option><option value="17"> 17 </option><option value="18"> 18 </option><option value="19"> 19 </option><option value="20"> 20 </option><option value="21"> 21 </option><option value="22"> 22 </option><option value="23"> 23 </option><option value="24"> 24 </option><option value="25"> 25 </option><option value="26"> 26 </option><option value="27"> 27 </option><option value="28"> 28 </option><option value="29"> 29 </option><option value="30"> 30 </option><option value="31"> 31 </option>';
	} else if((month==4) || (month==6) || (month==9) || (month==11)){
		return '<option value="">선택</option><option value="01"> 1 </option><option value="02"> 2 </option><option value="03"> 3 </option><option value="04"> 4 </option><option value="05"> 5 </option><option value="06"> 6 </option><option value="07"> 7 </option><option value="08"> 8 </option><option value="09"> 9 </option><option value="10"> 10 </option><option value="11"> 11 </option><option value="12"> 12 </option><option value="13"> 13 </option><option value="14"> 14 </option><option value="15"> 15 </option><option value="16"> 16 </option><option value="17"> 17 </option><option value="18"> 18 </option><option value="19"> 19 </option><option value="20"> 20 </option><option value="21"> 21 </option><option value="22"> 22 </option><option value="23"> 23 </option><option value="24"> 24 </option><option value="25"> 25 </option><option value="26"> 26 </option><option value="27"> 27 </option><option value="28"> 28 </option><option value="29"> 29 </option><option value="30"> 30 </option>';
	} else if((month==2) && (year%4==0) && (year%100!=0) && (year%400==0)){//윤달
		return '<option value="">선택</option><option value="01"> 1 </option><option value="02"> 2 </option><option value="03"> 3 </option><option value="04"> 4 </option><option value="05"> 5 </option><option value="06"> 6 </option><option value="07"> 7 </option><option value="08"> 8 </option><option value="09"> 9 </option><option value="10"> 10 </option><option value="11"> 11 </option><option value="12"> 12 </option><option value="13"> 13 </option><option value="14"> 14 </option><option value="15"> 15 </option><option value="16"> 16 </option><option value="17"> 17 </option><option value="18"> 18 </option><option value="19"> 19 </option><option value="20"> 20 </option><option value="21"> 21 </option><option value="22"> 22 </option><option value="23"> 23 </option><option value="24"> 24 </option><option value="25"> 25 </option><option value="26"> 26 </option><option value="27"> 27 </option><option value="28"> 28 </option><option value="29"> 29 </option>';
	} else if(month==2){
		return '<option value="">선택</option><option value="01"> 1 </option><option value="02"> 2 </option><option value="03"> 3 </option><option value="04"> 4 </option><option value="05"> 5 </option><option value="06"> 6 </option><option value="07"> 7 </option><option value="08"> 8 </option><option value="09"> 9 </option><option value="10"> 10 </option><option value="11"> 11 </option><option value="12"> 12 </option><option value="13"> 13 </option><option value="14"> 14 </option><option value="15"> 15 </option><option value="16"> 16 </option><option value="17"> 17 </option><option value="18"> 18 </option><option value="19"> 19 </option><option value="20"> 20 </option><option value="21"> 21 </option><option value="22"> 22 </option><option value="23"> 23 </option><option value="24"> 24 </option><option value="25"> 25 </option><option value="26"> 26 </option><option value="27"> 27 </option><option value="28"> 28 </option>';
	}
	}
}
function content_img_click(count){
	$("#mywrite_content_read img").click(function(){//사진을 클릭할경우
		var photo_path = $(this).attr("src");
		window.open("photo_recall_one.php?photo_path="+photo_path+"&table_name="+table_name+"&count="+count, "photo_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
	});
}
function reply_keyup(){
	$("textarea[name=mywrite_reply_content]").keyup(function () {//글쓰기textarea 설정
		$("#textarea_copy").html(convert_to_tag($(this).val()));
		$(this).height($("#textarea_copy").height()+30);//textarea의 height 조정
	});
}
function write_delete(table_name, count){//글 삭제
	var reply = confirm("글을 삭제하시겠습니까?");
	if(reply==true){
		if(table_name=="photo"){
			$.ajax({ //이상형월드컵에 등록되었는지 확인
				url:"photo_battle_check.php",
				data:{count:count},
				success: function(getdata){
					if(!getdata){
						write_delete_run(table_name, count);
					} else {
						var reply2 = confirm("해당 사진은 이상형월드컵에서 함께 삭제됩니다. 삭제하시겠습니까?");
						if(reply2==true){
							write_delete_run(table_name, count);
						}
					}
				}
			});
		} else {write_delete_run(table_name, count);}
	}
}
function write_delete_run(table_name, count){
	$.ajax({
		url:"delete_write.php",
		data: {table_name:table_name, count:count},
		success: function(getdata){
			alert("글이 삭제되었습니다.");
			location.reload();
		}
	});
}
function see_reply(count_upperwrite){//댓글 클릭
	$("#main_writing").after("<div class=\"loading24x24\" style=\"left:350px; display:block;\"></div>");
	$.ajax({//댓글 recall
		url:"reply_recall.php",
		data: {table_name:table_name, count_upperwrite:count_upperwrite, keyword:keyword, start_number:-1},
		success: function(getdata){//글번호로 가서 결과물 달기
			$("#main_writing").next().remove();
			$("#main_writing").after(getdata);
			$("#see_reply_"+count_upperwrite).css("display", "none");
			$("#see_reply_"+count_upperwrite).after("<div class=\"see_reply_status reply_fold\" onclick=\"write_fold("+count_upperwrite+")\">▲ 댓글 접기</div>");
			window.scrollTo(0, $("#mywrite_func").offset().top-400);
		}
	});
}
function reply_more(elem, count_upperwrite, start_number){
	$.ajax({//댓글 recall
		url:"reply_recall.php",
		data: {table_name:table_name, count_upperwrite:count_upperwrite, keyword:keyword, start_number:start_number},
		success: function(getdata){//글번호로 가서 결과물 달기
			$(elem).after(getdata);
			$(elem).remove();
		}
	});
}
function write_reply(count){//댓글쓰기 클릭시
	$("textarea[name=mywrite_reply_content]").val("").height(20+30);
	$("#form_area").append($("#mywrite_reply"));
	$(".write_reply_confirm").css("display", "none");//댓글쓰기 항목 숨기기
	$("#mywrite_reply, .write_reply_confirm_cancel").css("display", "block");
	window.scrollTo(0, $(".write_reply_confirm").offset().top+200);
	if(user_num==0){$("textarea[name=mywrite_reply_content]").val("로그인 후 이용해주세요").attr("readonly", "readonly");}
}
function write_reply_cancel(count){//댓글취소 클릭시
	$("#textarea_copy").after($("#mywrite_reply"));
	$(".write_reply_confirm_cancel").css("display", "none");//댓글취소 항목 숨기기
	$("#mywrite_reply").css("display", "none");//댓글쓰기 칸 숨기기
	$(".write_reply_confirm").css("display", "block");//댓글쓰기 항목 보이기
}
function reply_modify(count_i, count_upperwrite, count){//댓글 수정을 눌렀을때
	if($("#reply_modify")){//다른 수정 버튼이 눌려있을때
		$("#reply_modify").parent().next().find(".reply_modify_cancel").click();//수정취소 버튼을 찾아서 클릭한다
	}
	var content = $("#reply_count"+count_i+" > .replyarea_content").html();//댓글 내용
	content = reverse_from_tag(content);
	var height = $("#reply_count"+count_i+" > .replyarea_content").height();//댓글 높이
	$("#reply_count"+count_i+" > .replyarea_content").css("display", "none");
	$("#reply_count"+count_i+" > .replyarea_content").after('<div class="replyarea_content"><textarea id="reply_modify" class="input_blue" name="reply_modify">'+content+'</textarea></div>');//댓글 수정용textarea 생성
	$("#reply_modify").height(height);
	$("#reply_count"+count_i+" .write_modify").css("display", "none");//수정 버튼 숨기기
	$("#reply_count"+count_i+" .write_delete").css("display", "none");//삭제 버튼 숨기기
	$("#reply_count"+count_i+" .replyarea_func").append('<div class="reply_modify_confirm" onclick="reply_modify_confirm('+count_i+', '+count_upperwrite+', '+count+')">수정완료</div><div class="reply_modify_cancel" onclick="reply_modify_cancel('+count_i+', '+count_upperwrite+', '+count+')">취소</div>');//수정완료, 취소 버튼 붙이기
	$("textarea[name=reply_modify]").keyup(function () {//수정용textarea 설정
		$("#textarea_copy").width($("#reply_modify").width());
		$("#textarea_copy").html(convert_to_tag($(this).val()));
		$(this).height($("#textarea_copy").height()+30);//textarea의 height 조정
		if($(this).height() > 1900){$(this).css("overflow", "auto")}
	});
}
function reply_modify_cancel(count_i, count_upperwrite, count){//댓글 수정 취소를 눌렀을때
	$("#reply_modify").parent().remove();//textarea를 제거한다
	$(".reply_modify_confirm, .reply_modify_cancel").remove();//수정완료, 최소 버튼을 제거한다.
	$("#reply_count"+count_i+" > .replyarea_content").css("display", "block");//글내용 보이기
	$("#reply_count"+count_i+" .write_modify").css("display", "block");//수정 버튼 보이기
	$("#reply_count"+count_i+" .write_delete").css("display", "block");//삭제 버튼 보이기
}
function write_fold(num){//댓글접기 클릭
	var mywrite_replyNode = document.getElementById("mywrite_reply");//reply textarea를 이동한다.
	mywrite_replyNode.style.display = "none";
	var see_reply_num = "see_reply_"+num;
	document.getElementById(see_reply_num).style.display="inline";
	var reply_count = $(".replyarea_body").length;
	$("#see_reply_"+num).html("▼ 댓글 "+reply_count);
	document.getElementById(see_reply_num).parentNode.removeChild(document.getElementById(see_reply_num).nextSibling);//댓글접기 제거
	$("#reply_setting, #mywrite_replyarea, .write_reply_confirm, .write_reply_confirm_cancel").remove();
}
function photo_modify(count){//글 수정
	window.open("photo_modify.php?count="+count, "photo_upload", "width=770,height="+get_popup_height()+",resizable=yes,scrollbars=yes,location=no");
}
function writer_report(seller_num, seller_name){
	if(user_num==0){alert("로그인 후 이용해주세요");}
	else {window.open("market_seller_report.php?seller_num="+seller_num+"&seller_name="+seller_name, "writer_report", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");}
}
function sale_trader_list(){
	if(user_num==0){alert("로그인 후 이용해주세요");}
	else {
		window.open("sale_trader_list.php", "sale_trader_list", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
	}
}
function market_deal(count){
	window.open("market_deal.php?count="+count, "market_deal", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
}
function sale_reserve_box(count, writer_num){
	if(user_num==0){
		alert("로그인 후 이용해주세요");
	} else if(user_num==writer_num){
		alert("본인 글은 장바구니에 담을 수 없습니다");
	} else {
		var reply = confirm("이 물건을 장바구니에 담으시겠습니까?");
		if(reply==true){
			$.ajax({
				url:"sale_reserve_box_submit.php",
				data: {count:count},
				success: function(getdata){
					if(getdata=="already"){alert("물건이 이미 장바구니에 담겨 있습니다");}//이미 장바구니에 담겼을경우
					else if(getdata=="done"){alert("물건을 장바구니에 담았습니다");}
				}
			});
		}
	}
}
function write_reply_submit(count_upperwrite){//댓글 입력을 눌렀을때
	if(user_name=="Guest"){
		alert("로그인 후 이용해주세요");
	}else if(user_name!="Guest"){
		if($("#mywrite_reply_text").val().length==0){
			alert("댓글을 입력해주세요");
		} else {
			var reply = confirm("댓글을 입력하시겠습니까?");
			if(reply==true){
				var content = $("#mywrite_reply_text").val();
				$.ajax({//내가 쓴 글 출력
					url:"reply_submit.php",
					data: {table_name_reply:table_name_reply, count_upperwrite:count_upperwrite, content:content},
					success: function(getdata){
						write_fold(count_upperwrite);
						see_reply(count_upperwrite);
					}
				});
			}
		}
	}
}
function write_reply_submit_index(count_upperwrite, status){//댓글 입력을 눌렀을때
	if(user_name=="Guest"){
		alert("로그인 후 이용해주세요");
	}else if(user_name!="Guest"){
		if($("#mywrite_reply_text").val().length==0){
			alert("댓글을 입력해주세요");
		} else {
			var reply = confirm("댓글을 입력하시겠습니까?");
			if(reply==true){
				var content = $("#mywrite_reply_text").val();
				$.ajax({//내가 쓴 글 출력
					url:"reply_submit.php",
					data: {table_name_reply:table_name_reply, count_upperwrite:count_upperwrite, content:content, status:status},
					success: function(getdata){
						write_fold(count_upperwrite);
						see_reply(count_upperwrite);
					}
				});
			}
		}
	}
}
function reply_delete(count_upperwrite, count){//댓글 삭제를 눌렀을때
	var reply = confirm("댓글을 삭제하시겠습니까?");
	if(reply== true){
		$.ajax({
			url:"reply_delete.php",
			data: {table_name_reply:table_name_reply, count_upperwrite:count_upperwrite, count:count},
			success: function(getdata){
				alert("댓글이 삭제되었습니다.");
				location.reload();
			}
		});
	}
}
function reply_modify_confirm(count_i, count_upperwrite, count){//댓글 수정완료를 눌렀을때
	var content = $("#reply_modify").val();//textarea의 내용
	if(content.length==0){
		alert("댓글을 입력해주세요");
	} else {
		var reply = confirm("댓글을 수정하시겠습니까?");
		if(reply==true){
			$.ajax({
				url:"reply_modify.php",
				data: {table_name_reply:table_name_reply, count_upperwrite:count_upperwrite, count:count, content:content},
				success: function(getdata){
					$("#reply_modify").parent().remove();//textarea를 제거한다
					$(".reply_modify_confirm, .reply_modify_cancel").remove();//수정완료, 최소 버튼을 제거한다.
					$("#reply_count"+count_i+" > .replyarea_content").html(convert_to_tag(content));//글내용 변경
					$("#reply_count"+count_i+" > .replyarea_content").css("display", "block");//글내용 보이기
					$("#reply_count"+count_i+" .write_modify").css("display", "block");//수정 버튼 보이기
					$("#reply_count"+count_i+" .write_delete").css("display", "block");//삭제 버튼 보이기
					alert("댓글이 수정되었습니다.");
				}
			});
		}
	}
}
function reply_modify_cancel(count_i, count_upperwrite, count){//댓글 수정 취소를 눌렀을때
	$("#reply_modify").parent().remove();//textarea를 제거한다
	$(".reply_modify_confirm, .reply_modify_cancel").remove();//수정완료, 최소 버튼을 제거한다.
	$("#reply_count"+count_i+" > .replyarea_content").css("display", "block");//글내용 보이기
	$("#reply_count"+count_i+" .write_modify").css("display", "block");//수정 버튼 보이기
	$("#reply_count"+count_i+" .write_delete").css("display", "block");//삭제 버튼 보이기
}
function reply_updown(count_i, count_upperwrite, count, updown, num_before){//댓글에서 updown 했을때
	if(updown=="up"){//up 했을때
		var reply = confirm("이 댓글에 '좋아요' 의견을 표시하겠습니까?");
		if(reply==true){
			$.ajax({
				url:"reply_updown.php",
				data: {table_name_reply:table_name_reply, count_upperwrite:count_upperwrite, count:count, updown:updown},
				success: function(getdata){
					if(getdata=="already"){
						var reply2 = confirm("이미 의견을 표시한 글입니다. 의견을 취소하시겠습니까?");
						if(reply2==true){
							$.ajax({
								url:"reply_updown_cancel.php",
								data:{table_name_reply:table_name_reply, count_upperwrite:count_upperwrite, count:count},
								success: function(getdata){
									alert("의견이 취소되었습니다");
									location.reload();
								}
							});
						}
					} else if(getdata=="done"){
						var num_new = num_before + 1;
						var dom = "#reply_count"+count_i+" .updown_like_num";
						$(dom).html(" "+num_new);
						alert("'좋아요' 의견을 표시했습니다");
					}
				}
			});
		}
	} else if(updown=="down"){//down 했을때
		var reply = confirm("이 댓글에 '싫어요' 의견을 표시하겠습니까?");
		if(reply==true){
			$.ajax({
				url:"reply_updown.php",
				data: {table_name_reply:table_name_reply, count_upperwrite:count_upperwrite, count:count, updown:updown},
				success: function(getdata){
					if(getdata=="already"){
						var reply2 = confirm("이미 의견을 표시한 글입니다. 의견을 취소하시겠습니까?");
						if(reply2==true){
							$.ajax({
								url:"reply_updown_cancel.php",
								data:{table_name_reply:table_name_reply, count_upperwrite:count_upperwrite, count:count},
								success: function(getdata){
									alert("의견이 취소되었습니다");
									location.reload();
								}
							});
						}
					} else if(getdata=="done"){
						var num_new = num_before + 1;
						var dom = "#reply_count"+count_i+" .updown_dislike_num";
						$(dom).html(" "+num_new);
						alert("'싫어요' 의견을 표시했습니다");
					}
				}
			});
		}
	}
}
function updown_submit(count, updown, num_before){//댓글에서 updown 했을때
	if(user_num==0){
		alert("로그인 후 이용해주세요");
	} else {
		if(updown=="up"){//up 했을때
			var reply = confirm("이 글에 '좋아요' 의견을 표시하겠습니까?");
			if(reply==true){
				$.ajax({
					url:"updown.php",
					data: {table_name:table_name, count:count, updown:updown, num_before:num_before},
					success: function(getdata){
						if(getdata=="already"){
							var reply2 = confirm("이미 의견을 표시한 글입니다. 의견을 취소하시겠습니까?");
							if(reply2==true){
								$.ajax({
									url:"updown_cancel.php",
									data:{table_name:table_name, count:count},
									success: function(getdata){
										alert("의견이 취소되었습니다");
										location.reload();
									}
								});
							}
						} else if(getdata=="done"){
							var num_new = num_before + 1;
							$("#updown_like_num").html(" "+num_new);
							alert("'좋아요' 의견을 표시했습니다");
						}
					}
				});
			}
		} else if(updown=="down"){//down 했을때
			var reply = confirm("이 글에 '싫어요' 의견을 표시하겠습니까?");
			if(reply==true){
				$.ajax({
					url:"updown.php",
					data: {table_name:table_name, count:count, updown:updown, num_before:num_before},
					success: function(getdata){
						if(getdata=="already"){
							var reply2 = confirm("이미 의견을 표시한 글입니다. 의견을 취소하시겠습니까?");
							if(reply2==true){
								$.ajax({
									url:"updown_cancel.php",
									data:{table_name:table_name, count:count},
									success: function(getdata){
										alert("의견이 취소되었습니다");
										location.reload();
									}
								});
							}
						} else if(getdata=="done"){
							var num_new = num_before + 1;
							$("#updown_dislike_num").html(" "+num_new);
							alert("'싫어요' 의견을 표시했습니다");
						}
					}
				});
			}
		}
	}
}
function stranger_call(stranger_num, table_name, count){
	if(user_num==0){
		alert("로그인 후 이용해주세요");
	} else if(user_num==stranger_num){
		alert("본인 글은 신고할 수 없습니다");
	} else {
		var reply = confirm("이 글을 신고하시겠습니까?");
		if(reply==true){
			window.open("stranger_call.php?stranger_num="+stranger_num+"&table_name="+table_name+"&count="+count, "stranger_call", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
		}
	}
}
function stranger_call_reply(stranger_num, table_name, count, count_upperwrite){
	if(user_num==0){
		alert("로그인 후 이용해주세요");
	} else {
		var reply = confirm("이 댓글을 신고하시겠습니까?");
		if(reply==true){
			window.open("stranger_call_reply.php?stranger_num="+stranger_num+"&table_name="+table_name+"&count="+count+"&count_upperwrite="+count_upperwrite, "stranger_call", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
		}
	}
}
function user_pic(user_num, photo_path){
	if(user_num==0){alert("로그인 후 이용해주세요");}
	else {
		window.open("photo_recall_one.php?photo_path="+photo_path+"&table_name=idcard_photo", "photo_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
	}
}
function send_message(user_num, user_num_receive){
	if(user_num==0){alert("로그인 후 이용해주시기 바랍니다");}
	else if(user_num==user_num_receive){alert("본인에게 쪽지를 보낼 수 없습니다");}
	else {
		window.open("guest_private_write.php?user_num_receive="+user_num_receive, "guest_private_write", "width=770,height=500,resizable=no,scrollbars=yes,location=no");
	}
}
function user_info_see(user_num){
	window.open("home_friend_search_info.php?user_num="+user_num, "home_friend_search_info", "width=770,height=650,resizable=yes,scrollbars=yes,location=no");
}
function trader_info(others_num){
	window.open("sale_trader_info.php?user_num_other="+others_num, "sale_trader_info", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
}
function trader_delete(others_num, trader_name){
	var reply = confirm(trader_name + "님을 거래자 목록에서 삭제하시겠습니까?");
	if(reply==true){
		$.ajax({//이벤트 출력
			url:"sale_trader_list_delete.php",
			data: {user_num_other:others_num},
			success: function(getdata){
				alert(trader_name + "님이 거래자 목록에서 삭제되었습니다");
				location.reload();
			}
		});
	}
}
function friend_submit(user_num, friend_name){
	if(user_num==0){
		alert("로그인 후 이용해주시기 바랍니다");
	} else {
		var isidmaruid = is_idmaru_id(friend_name);
		if(isidmaruid != -1){
			alert("이드마루 관리자는 친구 신청에서 제외됩니다.");
		} else {
			var reply = confirm(friend_name+"님께 친구 신청하시겠습니까?");
			if(reply==true){
				var senddata = {friend_name:friend_name};
				$.getJSON("../web/home_friend_register.php", senddata, function (getdata) {
					$.each(getdata, function (key, value) {
						if(value=="user_stop"){
							alert("탈퇴한 회원입니다.");
						} else if(value=="myself"){
							alert("본인은 친구로 등록할 수 없습니다.");
						}else if(value=="not_certified"){
							alert("아직 인증되지 않은 회원입니다.");
						}else if (value=="exist"){
							alert("친구로 이미 등록되어 있습니다.");
						}else if(value=="on_request"){
							alert("친구로 신청한 상태입니다.");
						} else if(value=="on_receiving"){
							alert("친구 신청을 받은 상태입니다. 새로운 소식을 확인해보세요.");
							location.href = "home.php";
						} else if (value=="submit"){
							alert("친구 신청이 완료되었습니다. 상대방이 승인할 때 친구로 등록됩니다.");
						} else if (value=="cannot"){
							alert("등록된 아이디가 아닙니다.");
						}
					});
				});
			}
		}
	}
}
function group_exit(user_num, others_num, others_name, count_group){
	if(user_num==others_num){alert("모임장은 탈퇴시킬 수 없습니다");}
	else {
		var reply = confirm(others_name+"님을 탈퇴하시겠습니까?");
		if(reply==true){
			$.ajax({//이벤트 출력
				url:"club_group_admin_quit.php",
				data: {user_num:others_num, count_group:count_group},
				success: function(getdata){
					alert("탈퇴 처리가 완료되었습니다");
					location.reload();
				}
			});
		}
	}
}
function info_area_functions(user_num_receive){
	$("#info_area_writer").bind({
		mouseenter: function () {
			$("#info_area_writer .user_info").css("display", "block");
		},
		mouseleave: function () {
			$("#info_area_writer .user_info").css("display", "none");
		}
	});
	$("#info_area_writer .send_msg").click(function(){//쪽지보내기를 클릭할 경우
		if(user_num==0){
			alert("로그인 후 이용해주세요");
		} else if(user_num_receive==user_num){
			alert("본인에게 쪽지를 보낼 수 없습니다");
		} else {
			window.open("guest_private_write.php?user_num_receive="+user_num_receive, "guest_private_write", "width=770,height=500,resizable=no,scrollbars=yes,location=no");
		}
	});
	$("#info_area_writer .user_photo").click(function(){//사진을 클릭할 경우
		if('.$user_num.'==0){
			alert("로그인 후 이용해주세요");
		} else {
			var photo_path = $(this).attr("src");
			window.open("photo_recall_one.php?photo_path="+photo_path+"&table_name=idcard_photo", "photo_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
		}
	});
}
function user_info_bind(elem){
	$(elem).bind({
		mouseenter: function () {
			$(elem + " .user_info").css("display", "block");
			$(elem).parents(".replyarea_info").css("z-index", "6");
		},
		mouseleave: function () {
			$(elem + " .user_info").css("display", "none");
			$(elem).parents(".replyarea_info").css("z-index", "2");
		}
	});
}
function mywrite_link_click(){
	if(table_name=="photo"){
		$(".link_block").css({
			"border":"none"
		});
	}
	$("#mywrite_link").click(function(){
		$("#mywrite_link").css("display", "none"); 
		$("#mywrite_link_address").css("display", "block");
	});
	$("#mywrite_link_address").attr("title", "주소를 복사한 후 붙여넣으면 바로 연결됩니다");
}
function write_modify_setting(count, title){
	$(".list_menu, #info_area, #mywrite_title, #mywrite_titlearea > .updown_status, #mywrite_bodyarea, .link_block, .market_box1").css("display", "none");
	$("#modify_status, #mywrite_title_modify, #mywrite_modify").css("display","block");
	$("#mywrite_bodyarea").after($("#mywrite_modify"));
	var url_modify = table_name + "_modify.php";
	$("#mywrite_title_modify").val(reverse_from_tag_title(title));
	$("#form_area").before("<form action=\""+url_modify+"\" enctype=\"multipart/form-data\" method=\"post\" accept-charset=\"UTF-8\"></form>");
	$("form").append($("#form_area"));
	$("form").append("<input type=\"hidden\" name=\"location\" value=\""+afterModifyUrl(location.href)+"\" /><input type=\"hidden\" name=\"count\" value=\""+count+"\"/><input type=\"hidden\" name=\"page_name\" value=\""+page_name+"\"/><input type=\"hidden\" name=\"write_new\" value=\"modify\" /><input type=\"submit\" name=\"submit\" style=\"display:none;\" />");
	$("#mywrite_modify_body").html("");
	$("#mywrite_modify_body").append("<textarea id=\"mywrite_modify_text\" name=\"mywrite_modify_content\"></textarea>");
	ckeditor = CKEDITOR.replace( "mywrite_modify_content", {
		filebrowserImageUploadUrl: "image_upload.php?table_name="+table_name+"&page_name="+page_name,
		height: get_textarea_height()
	});
	ckeditor.setData($("#mywrite_content_read").html());
	window.scrollTo(0, 0);
}
function write_modify_news(count, type){//글 수정
	var title = $("#mywrite_title").html();
	var status = $("#write_content_status").html();
	$("#news_type_mod").val(type);
	if(status=="모두"){
		$("input:radio[name=status]:nth(0)").attr("checked", true);
	} else if(status=="친구"){
		$("input:radio[name=status]:nth(1)").attr("checked", true);
	} else if(status=="비공개"){
		$("input:radio[name=status]:nth(2)").attr("checked", true);
	}
	write_modify_setting(count, title);
}
function write_modify_market(count, type){//공개글 수정
	var title = $("#mywrite_title").html();
	var status = $("#write_content_status").html();
	$("#selling_type_mod").val(type);
	title = strip_selling_type(title);
	if(status=="판매중"){
		$("input:radio[name=status]:nth(0)").attr("checked", true);
	} else if(status=="판매완료"){
		$("input:radio[name=status]:nth(1)").attr("checked", true);
	} else if(status=="공유중"){
		$("input:radio[name=status]:nth(2)").attr("checked", true);
	}
	write_modify_setting(count, title);
}
function write_modify_event(count, start_time_y, start_time_m, start_time_d, end_time_y, end_time_m, end_time_d){//공개된 이벤트 글 수정
	var title = $("#mywrite_title").html();
	var status = $("#write_content_status").html();
	if(status=="행사"){
		$("input:radio[name=status]:nth(0)").attr("checked", true);
	} else if(status=="개인"){
		$("input:radio[name=status]:nth(1)").attr("checked", true);
	} else if(status=="봉사"){
		$("input:radio[name=status]:nth(2)").attr("checked", true);
	}
	$("#start_time_y").val(start_time_y);
	$("#start_time_m").val(start_time_m);
	if($("#start_time_y").val()!="" && $("#start_time_m").val()!=""){$("#start_time_d").html(calender_date($("#start_time_y").val(), $("#start_time_m").val()));}
	$("#start_time_d").val(start_time_d);
	$("#end_time_y").val(end_time_y);
	$("#end_time_m").val(end_time_m);
	if($("#end_time_y").val()!="" && $("#end_time_m").val()!=""){$("#end_time_d").html(calender_date($("#end_time_y").val(), $("#end_time_m").val()));}
	$("#end_time_d").val(end_time_d);
	write_modify_setting(count, title);
}
function write_modify_about_question(count){//개인 글 수정
	var title = $("#mywrite_title").html();
	var status = $("#write_content_status_B").html();
	if(status=="모두"){
		$("input:radio[name=status]:nth(0)").attr("checked", true);
	} else if(status=="비공개"){
		$("input:radio[name=status]:nth(1)").attr("checked", true);
	}
	write_modify_setting(count, title);
}
function write_modify_writing(count, type){//개인 글 수정
	var title = $("#mywrite_title").html();
	var status = $("#write_content_status").html();
	$("#news_type_mod").val(type);
	if(status=="모두"){
		$("input:radio[name=status]:nth(0)").attr("checked", true);
	} else if(status=="친구"){
		$("input:radio[name=status]:nth(1)").attr("checked", true);
	} else if(status=="비공개"){
		$("input:radio[name=status]:nth(2)").attr("checked", true);
	}
	write_modify_setting(count, title);
}
function mywrite_modify_confirm(){
	if ($("#mywrite_title_modify").val().length<5){
		alert("제목을 5자 이상 입력해주세요.");
		event.preventDefault ? event.preventDefault() : event.returnValue=false;
	}else if(ckeditor.getData().length<10){//글이 10자 미만일경우
		alert("글이 너무 짧습니다");
		event.preventDefault ? event.preventDefault() : event.returnValue=false;
	} else if(ckeditor.getData().length>=10){//글이 입력됐을경우
		var reply = confirm("글을 수정하시겠습니까?");
		if(reply==true){$("input[name=submit]").click();}
	}
}
function mywrite_modify_cancel(){
	$("#modify_status, #mywrite_title_modify, #mywrite_modify").css("display", "none");
	$("#mywrite_title, #mywrite_titlearea > .updown_status").css("display", "inline");
	$(".list_menu, #info_area, #mywrite_bodyarea, .link_block, .market_box1").css("display", "block");
	$("form").after($("#form_area"));
	$("form").remove();
}
function club_group_writing_delete(count){//글 삭제
	var reply = confirm("글을 삭제하시겠습니까?");
	if(reply== true){
		$.ajax({
			url:"club_group_writing_delete.php",
			data: {count:count},
			success: function(getdata){
				alert("글이 삭제되었습니다.");
				location.href = "club_group_one.php?count_group="+count_group;
			}
		});
	}
}
function date_set_change(){
	$("#start_time_y").change(function(){
		if($("#start_time_y").val()!="" && $("#start_time_m").val()!=""){
			$("#start_time_d").html(calender_date($("#start_time_y").val(), $("#start_time_m").val()));
		} else {
			$("#start_time_d").html('<option value="">선택</option>');
		}
	});
	$("#start_time_m").change(function(){
		if($("#start_time_y").val()!="" && $("#start_time_m").val()!=""){
			$("#start_time_d").html(calender_date($("#start_time_y").val(), $("#start_time_m").val()));
		} else {
			$("#start_time_d").html('<option value="">선택</option>');
		}
	});
	$("#end_time_y").change(function(){
		if($("#end_time_y").val()!="" && $("#end_time_m").val()!=""){
			$("#end_time_d").html(calender_date($("#end_time_y").val(), $("#end_time_m").val()));
		} else {
			$("#end_time_d").html('<option value="">선택</option>');
		}
	});
	$("#end_time_m").change(function(){
		if($("#end_time_y").val()!="" && $("#end_time_m").val()!=""){
			$("#end_time_d").html(calender_date($("#end_time_y").val(), $("#end_time_m").val()));
		} else {
			$("#end_time_d").html('<option value="">선택</option>');
		}
	});
}
function go_prev_arrow(){
	$("#go_prev").css("display", "block");
	$("#go_prev").hover(function(){
		$("#go_prev_arrow").css({"background":"url(../image/go_prev_arrowB.png) 0 0 no-repeat"});
	}, function(){
		$("#go_prev_arrow").css({"background":"url(../image/go_prev_arrowA.png) 0 0 no-repeat"});
	});
}
function go_next_arrow(){
	$("#go_next").css("display", "block");
	$("#go_next").hover(function(){
		$("#go_next_arrow").css({"background":"url(../image/go_next_arrowB.png) 0 0 no-repeat"});
	}, function(){
		$("#go_next_arrow").css({"background":"url(../image/go_next_arrowA.png) 0 0 no-repeat"});
	});
}
function photo_click(photo_path, table_name, count){
	window.open("photo_recall_one.php?photo_path="+photo_path+"&table_name="+table_name+"&count="+count, "photo_recall_one", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
}
function gallery_one(count){
	window.open("gallery_recall_one.php?count="+count, "gallery_recall_one", "width=770,height=700,resizable=yes,scrollbars=yes,location=no");
}
function photo_battle_check(count){
	$.ajax({ //이상형월드컵에 등록되었는지 확인
		url:"photo_battle_check.php",
		data:{count:count},
		success: function(getdata){
			if(getdata){$(".link_block").append("<span class='absolute pointer bold lineHeight1' style='left:0px; top:1px; border-bottom:1px solid;' title='이상형월드컵 등록사진'><img src='../image/photo_battle_exist.png' class='inline'/> <span class='inline font8'>"+getdata+"</span></span>");}
		}
	});
}
function enterAndBlur(elem){
	$(elem).keyup(function(){
		if(event.keyCode==13){$(elem).blur();}
	});
}
function addPhoto(){
	$("iframe[name=add_photo_iframe]").css({"display":"block"});
	$("#add_photo_box").css({"display":"none"});
	$("#add_photo_submit_box").css({"display":"block"});
}
function addPhotoSubmit(){
	window.frames['add_photo_iframe'].mywriteEnter();
	$("iframe[name=add_photo_iframe]").css({"display":"none"});
	$("#add_photo_box").css({"display":"block"});
	$("#add_photo_submit_box").css({"display":"none"});
}
function photoBattleCategoryRecall(type, start_number){
	$("#photo_battle_list").append("<div id=\"loading_more\" class=\"loading48x48\" style=\"left:340px;\"></div>");
	$("#article_moreB").remove();
	$.ajax({
		url:"photo_battle_category_recall.php",
		data: {type:type, start_number:start_number},
		success: function(getdata){
			$("#photo_battle_list").append(getdata);
			$("#loading_more").remove();
		}
	});
}