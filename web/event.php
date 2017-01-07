 <?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="Event, 이벤트" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>이드마루-이벤트</title>
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
<?php
	$url = "event.php?";
	$ad_fixbar_cond = "event";
	$ad_pop_cond = "event";
	$ad_side_cond = "event";
	include 'declare.php';
	include 'personal.php';
?>
	<script>
		var type_name = "event";//php_tile_list에서 사용
		var display_number = 40;
		var url = "<?php echo $url;?>";
		var url_all = "event_all.php?";//검색시에 해당 사이트로 이동
		var order_column;
		var start_time_y = '';
		var start_time_m = '';
		var start_time_d = '';
		var end_time_y = '';
		var end_time_m = '';
		var end_time_d = '';
<?php
	if(isset($_REQUEST["event_type"])){//event_type 변수가 넘어왔을때
		echo 'var event_type = "'.$_REQUEST["event_type"].'";';
		$event_type = $_REQUEST["event_type"];
	} else {//event_type 변수가 안 넘어왔을때
		echo 'var event_type = "tile";';//selling_type에 값이 없을때
		$event_type = "tile";
	}
	if(isset($_REQUEST["order_column"])){//정렬의 기준이 되는 column이 주어질경우
		echo 'order_column = "'.$_REQUEST["order_column"].'";';
	}
	if(isset($_REQUEST["start_time_y"])){//시작년이 주어질경우
		echo 'start_time_y = "'.$_REQUEST["start_time_y"].'";';
	}
	if(isset($_REQUEST["start_time_y"]) && isset($_REQUEST["start_time_m"])){//시작년월이 입력됐을경우
		echo 'start_time_m = "'.$_REQUEST["start_time_m"].'";';
	}
	if(isset($_REQUEST["start_time_y"]) && isset($_REQUEST["start_time_m"]) && isset($_REQUEST["start_time_d"])){//시작년월일이 입력됐을경우
		echo 'start_time_d = "'.$_REQUEST["start_time_d"].'";';
	}
	if(isset($_REQUEST["end_time_y"])){//종료년도가 입력됐을경우
		echo 'end_time_y = "'.$_REQUEST["end_time_y"].'";';
	}
	if(isset($_REQUEST["end_time_y"]) && isset($_REQUEST["end_time_m"])){//종료년월이 입력됐을경우
		echo 'end_time_m = "'.$_REQUEST["end_time_m"].'";';
	}
	if(isset($_REQUEST["end_time_y"]) && isset($_REQUEST["end_time_m"]) && isset($_REQUEST["end_time_d"])){//종료년월일이 입력됐을경우
		echo 'end_time_d = "'.$_REQUEST["end_time_d"].'";';
	}
?>
		var event_type_kor = event_type_status(event_type);
		$(document).ready(function () {
			<?php include 'list_tile.php'; ?>
			blueStyle();
			menuEvent();
			if(status=="4"){//전체
				$("input:radio[name=status]:nth(0)").attr("checked", true);
				$("#search_filter_show_type").html("전체");
			} else if(status=="1"){//행사
				$("input:radio[name=status]:nth(1)").attr("checked", true);
				$("#search_filter_show_type").html("행사");
			} else if(status=="2"){//개인
				$("input:radio[name=status]:nth(2)").attr("checked", true);
				$("#search_filter_show_type").html("개인");
			} else if(status=="3"){//봉사
				$("input:radio[name=status]:nth(3)").attr("checked", true);
				$("#search_filter_show_type").html("봉사");
			}
			if(typeof(order_column) != "undefined"){
				if(order_column=="up_total"){//추천수
					$("input:radio[name=order_column]:nth(0)").attr("checked", true);
					$("#search_filter_show_order").html("추천수");
				} else if(order_column=="count"){//등록순
					$("input:radio[name=order_column]:nth(1)").attr("checked", true);
					$("#search_filter_show_order").html("등록순");
				} else if(order_column=="read_count"){//조회수
					$("input:radio[name=order_column]:nth(2)").attr("checked", true);
					$("#search_filter_show_order").html("조회수");
				}
			} else {//order_column이 안 주어졌을경우
				order_column = "count";
				$("#search_filter_show_order").html("등록순");
			}
			if(start_time_y){$("select[name=start_time_y]").val(start_time_y);}
			if(start_time_m){$("select[name=start_time_m]").val(start_time_m);}
			if(start_time_d){$("select[name=start_time_d]").val(start_time_d);}
			if(end_time_y){$("select[name=end_time_y]").val(end_time_y);}
			if(end_time_m){$("select[name=end_time_m]").val(end_time_m);}
			if(end_time_d){$("select[name=end_time_d]").val(end_time_d);}
			$.ajax({
				url:'event_common_order_recall.php',
				data: {count_start:count_start, display_number:display_number, height_total:height_total, width_total:width_total, status:status, order_column:order_column, start_time_y:start_time_y, start_time_m:start_time_m, start_time_d:start_time_d, end_time_y:end_time_y, end_time_m:end_time_m, end_time_d:end_time_d},
				success: function(getdata){
					$("#event_article_area").append(getdata);
					$("#loading_more").remove();
				}
			});
			$("#search_filter_submit").click(function(){
				var status = $("input:radio[name=status]:checked").val();
				var order_column = $("input:radio[name=order_column]:checked").val();
				var start_time_y = $("select[name=start_time_y] > option:selected").val();
				var start_time_m = $("select[name=start_time_m] > option:selected").val();
				var start_time_d = $("select[name=start_time_d] > option:selected").val();
				var end_time_y = $("select[name=end_time_y] > option:selected").val();
				var end_time_m = $("select[name=end_time_m] > option:selected").val();
				var end_time_d = $("select[name=end_time_d] > option:selected").val();
				if( (start_time_y>end_time_y) || (start_time_y==end_time_y && start_time_m>end_time_m) || (start_time_y==end_time_y && start_time_m==end_time_m && start_time_d>end_time_d) ){
					alert("시작일 혹은 종료일 설정이 잘못되었습니다");
				} else{
					location.href = url + "status="+status+"&order_column="+order_column+"&start_time_y="+start_time_y+"&start_time_m="+start_time_m+"&start_time_d="+start_time_d+"&end_time_y="+end_time_y+"&end_time_m="+end_time_m+"&end_time_d="+end_time_d;
				}
			});
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
			$("#start_time_d").html(calender_date($("#start_time_y").val(), $("#start_time_m").val()));
			$("#end_time_d").html(calender_date($("#end_time_y").val(), $("#end_time_m").val()));
		});
	</script>
<?php include_once("../plugin/analyticstracking.php") ?>
</head>
<body>
	<div id="toparea">
<?php include 'toparea.php'; ?>
	</div>
	<div id="bodyarea">
		<div id="mainbar">
			<div id="mainbody">
				<header id="page_title"></header>
				<nav class="menu_square">
					<a href="event.php"><div id="menu_square_tile" class="menu_square_item">타일형</div></a>
					<a href="event_all.php"><div id="menu_square_list" class="menu_square_item">목록형</div></a>
				</nav>
				<div id="search_filter_show">* 현재 <span id="search_filter_show_type" class="border_bottom"></span>&nbsp;보기에서 <span id="search_filter_show_order" class="border_bottom"></span>&nbsp;정렬 되었습니다</div>
				<div class="select_category round_border">
					<div id="search_filter_submit" class="button_gb">설정</div>
					<div id="search_filter_type" class="round_border">종류 : 
						<span>&nbsp;전체</span>
						<input class="inline radio1" type="radio" name="status" value="4" tabindex="" checked />
						<span>&nbsp;행사</span>
						<input class="inline radio1" type="radio" name="status" value="1" tabindex=""/>
						<span>&nbsp;개인</span>
						<input class="inline radio1" type="radio" name="status" value="2" tabindex=""/>
						<span>&nbsp;봉사</span>
						<input class="inline radio1" type="radio" name="status" value="3" tabindex=""/>
					</div>
					<div id="search_filter_order" class="round_border">정렬 : 
						<span>&nbsp;추천수</span>
						<input class="inline radio1" type="radio" name="order_column" value="up_total" tabindex=""/>
						<span>&nbsp;등록순</span>
						<input class="inline radio1" type="radio" name="order_column" value="count" tabindex="" checked />
						<span>&nbsp;조회수</span>
						<input class="inline radio1" type="radio" name="order_column" value="read_count" tabindex=""/>
					</div>
					<div id="search_filter_date" class="round_border">
						<div id="search_filter_date_start">시작일 : 
							<select id="start_time_y" class="inline" name="start_time_y">
								<?php echo $select_option_year_event_start;?>
							</select>년
							<select id="start_time_m" class="inline" name="start_time_m"><?php echo $select_option_month; ?></select>월
							<select id="start_time_d" class="inline" name="start_time_d"><option selected value="">선택</option></select>일
						</div>
						<div id="search_filter_date_end"> ~ 종료일 : 
							<select id="end_time_y" class="inline" name="end_time_y">
								<?php echo $select_option_year_event_end;?>
							</select>년
							<select id="end_time_m" class="inline" name="end_time_m"><?php echo $select_option_month; ?></select>월
							<select id="end_time_d" class="inline" name="end_time_d"><option selected value="">선택</option></select>일
						</div>
					</div>
				</div>
				<div id="list_search">
					<div id="list_search_box">
					<div id="list_search_tip" title="검색 Tip"><img src="../image/list_search_tip.png"/></div>
					<select id="list_search_category" name="list_search_category">
						<option selected value="all_content">전체</option><option value="writer"> 작성자 </option><option value="title"> 제목 </option><option value="content"> 글내용 </option>
					</select>
					<input id="list_search_word" type="text" name="list_search_word" value="" maxlength="40" tabindex=""/>
					<div id="list_search_word_button" title="검색"></div>
					<div id="list_search_word_cancel" title="검색 취소"></div>
					</div>
				</div>
				<div id="list_button">
					<div id="club_event_admit" class="menu_button" onclick="club_event_admit()"></div>
					<input id="list_start_number_set" type="text" name="list_start_number_set" value="" maxlength="4" tabindex="" title="목록 시작번호"/>
				</div>
				<div id="loading_more" class="loading48x48" style="left:340px;"></div>
				<div id="event_article_area" class="tile_area"></div>
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