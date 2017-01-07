<?php
	if(isset($_REQUEST["count_link"]) && !isset($_REQUEST["list_count"])){$outer_link=1;} //외부링크일 때
	else {$outer_link=0;}
	if(!isset($page_type)){//$type가 없을때
		$page_type = "etc";
		$number_min = 10;//number의 최소 갯수
		$number_default = 20;//number의 기본값
	} else if ($page_type=="club"){//club일경우
		$number_min = 5;
		$number_default = 10;
	} else if($page_type=="all"){//전체일경우
		$number_min = 20;
		$number_default = 40;
	} else {
		$number_min = 10;//number의 최소 갯수
		$number_default = 20;//number의 기본값
	}
	if(isset($_REQUEST["count_link"])){ // 글번호
		$count_link = $_REQUEST["count_link"];
		if($count_link != 0){$count_link_url = 'count_link='.$count_link;}
		else {$count_link_url = '';}
	} else if(!isset($_REQUEST["count_link"])){ // 세부목록 보기가 아닐 때
		$count_link = 0;
		$count_link_url = '';
	}
	$list_count_on_page = 10;
	if(isset($_REQUEST["list_count"])){
		$list_count=$_REQUEST["list_count"];
	} else{
		$list_count=1;
	}
	$list_page_count = (int)(($list_count-1) / $list_count_on_page) + 1;
	if(isset($_REQUEST["number"])){//number(리스트안의 글 갯수)가 전달되었을 경우
		$number=$_REQUEST["number"];
		$number_url = '&number='.$number;
	} else if(!isset($_REQUEST["number"])){//number(리스트안의 글 갯수)가 전달되지 않았을 경우
		$number=$number_default;
		$number_url = '';
	}
	if(isset($_REQUEST["keyword"])){ // keyword 검색을 했을 경우
		$keyword = $_REQUEST["keyword"];
		$keyword_url = '&keyword='.$keyword;
	} else if(!isset($_REQUEST["keyword"])){
		$keyword = "thereisnokeyword";
		$keyword_url = '';
	}
	if(isset($_REQUEST["category"])){
		$category = $_REQUEST["category"];
		$category_url = '&category='.$category;
	} else if(!isset($_REQUEST["category"])){
		$category = "thereisnocategory";
		$category_url = '';
	}
	if(isset($_REQUEST["status"])){
		$status = $_REQUEST["status"];
		$status_url = '&status='.$status;
	} else if(!isset($_REQUEST["status"])){
		$status = 4;
		$status_url = '';
	}
	echo '
	<script>
		var count_link = '.$count_link.';
		var number = '.$number.';
		var list_number = '.$number.';
		var keyword = "'.$keyword.'";
		var category = "'.$category.'";
		var status = "'.$status.'";
		var popup_height = get_popup_height();
		$(document).ready(function(){
			if(keyword != "thereisnokeyword"){//키워드가 입력되어 있는 경우
				$("input[name=list_search_word]").val(keyword);
			}
			if(category=="thereisnocategory"){$("select[name=list_search_category] option:eq(0)").attr("selected", "selected");}
			else {$("select[name=list_search_category]").val(category);}
			var keyword_before = keyword;
			var category_before = category;
			if(count_link==0){$(".list_show:eq(0)").append(\'<input id="list_number_set" type="text" name="list_number_set" value="" maxlength="2" tabindex="" title="목록 갯수"/>\');} // 목록갯수 설정
			$("#list_number_set").val('.$number.'); 
			var list_number_set_before = $("#list_number_set").val();
			$("#list_number_set").blur(function(){
				if(!$("#list_number_set").val()){alert("'.$number_min.' 이상의 숫자만 가능합니다"); $("#list_number_set").val(list_number_set_before);}
				else if(isNumber($("#list_number_set").val())==false){ alert("숫자만 입력 가능합니다"); $("#list_number_set").val(list_number_set_before);}
				else{
					var number = $("#list_number_set").val();
					if(number == list_number){//변화없을때는 로딩하지 않음
					} else if(number < '.$number_min.'){
						alert("'.$number_min.' 이상의 숫자만 가능합니다");
						$("#list_number_set").val(list_number_set_before);
					} else if(number >= '.$number_min.'){
						location.href = url + "number="+number+"'.$status_url.'";
					}
				}
			});
			enterAndBlur("#list_number_set");
			$("#list_search_word_button").click(function(){
				if("'.$page_type.'" != "all" && user_num==0){alert("로그인 후 이용해주세요");}
				else {
					var keyword = $("input[name=list_search_word]").val();
					var category = $("select[name=list_search_category] > option:selected").val();
					if(keyword && (keyword_before!=keyword || category_before!=category)){//새로운 검색내용인 경우
						if(table_name=="sale"){//거래에서 검색할 경우
							location.href = url + "keyword="+keyword+"&category="+category+"'.$number_url.$status_url.'&selling_type=" + selling_type;
						} else if(table_name=="writing"){//뉴스에서 검색할 경우
							location.href = url + "keyword="+keyword+"&category="+category+"'.$number_url.$status_url.'&news_type="+news_type;
						} else if(table_name=="photo"){//갤러리에서 검색할 경우
							location.href = url + "keyword="+keyword+"&category="+category+"'.$number_url.$status_url.'&gallery_type="+gallery_type;
						} else if(table_name=="club_group"){
							location.href = url + "count_start="+count_start + "&keyword="+keyword+"&category="+category;
						} else {
							location.href = url + "keyword="+keyword+"&category="+category+"'.$number_url.$status_url.'";
						}
					} else if(!keyword){//키워드가 없을 때
						alert("검색어를 입력해주세요");
					}
				}
			});
			$("input[name=\"list_search_word\"]").keyup(function(){//엔터키를 쳤을때
				if(event.keyCode==13){
					$("#list_search_word_button").click();
				}
			});
			if(keyword_before != "thereisnokeyword"){//검색어가 있을때 커서를 검색창으로 이동
				document.getElementById("list_search_word").select();
			}
			if(keyword != "thereisnokeyword"){//검색어가 있을때 취소 버튼을 보이게 함
				$("#list_search_word_cancel").css("display", "inline");
				$("#list_search_word_cancel").click(function(){
					if(table_name=="writing"){location.href = url + "news_type="+news_type+"'.$number_url.'";}
					else if(table_name=="photo"){location.href = url + "gallery_type="+gallery_type+"'.$number_url.'";}
					else if(table_name=="sale"){location.href = url + "selling_type="+selling_type+"'.$number_url.'";}
					else{location.href = url+"'.$number_url.$status_url.'";}
				});
			}
			$("#list_search_tip").click(function(){
				window.open("list_search_tip.php?type="+table_name, "list_search_tip", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
			});
		});
	</script>
	';
?>