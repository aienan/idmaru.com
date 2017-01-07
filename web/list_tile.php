<?php
	$number_min = 20;//number의 최소 갯수
	$number_default = 50;//number의 기본값
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
	// 윗 부분은 list.php에서 사용되는 변수
	if(isset($_REQUEST["count_start"])){
		$count_start = $_REQUEST["count_start"];
		$count_start_url = '&count_start='.$count_start;
	} else if(!isset($_REQUEST["count_start"])){
		$count_start = 1;
		$count_start_url = '';
	}
	echo '
			var number = '.$number.';
			var status = "'.$status.'";
			var list_start_number = '.$count_start.';
			var keyword = "'.$keyword.'";
			var category = "'.$category.'";
			if(keyword != "thereisnokeyword"){//키워드가 입력되어 있는 경우
				$("input[name=list_search_word]").val(keyword);
			}
			if(category=="thereisnocategory"){$("select[name=list_search_category] option:eq(0)").attr("selected", "selected");}
			else {$("select[name=list_search_category]").val(category);}
			var count_start = list_start_number - 1;//php에서는 0이 처음 시작 번호다
			var height_total = $("#"+type_name+"_article_area").height();
			var width_total = 0;
			var popup_height = get_popup_height();
			$("#list_start_number_set").val('.$count_start.');//글 갯수 설정
			var list_start_number_set_before = $("#list_start_number_set").val();
			$("#list_start_number_set").blur(function(){
				if(!$("#list_start_number_set").val()){alert("1이상의 정수만 가능합니다"); $("#list_start_number_set").val(list_start_number_set_before);}
				else if(isNumber($("#list_start_number_set").val())==false){alert("숫자만 입력 가능합니다"); $("#list_start_number_set").val(list_start_number_set_before);}
				else{
					var count_start_new = parseInt($("#list_start_number_set").val());
					if(count_start_new<=0){
						alert("1이상의 정수만 가능합니다"); $("#list_start_number_set").val(list_start_number_set_before);
					} else {
						if(count_start_new == list_start_number){//변화없을때는 로딩하지 않음
						} else{
							if(type_name=="news"){url_new = url + "news_type=" + news_type + "&";}
							else if(type_name=="gallery"){url_new = url + "gallery_type=" + gallery_type + "&";}
							else if(type_name=="market"){url_new = url + "selling_type=" + selling_type + "&";}
							location.href = url_new + "count_start="+count_start_new;
						}
					}
				}
			});
			enterAndBlur("#list_start_number_set");
			var keyword_before = keyword;
			var category_before = category;
			$("#list_search_word_button").click(function(){
				var keyword = $("input[name=list_search_word]").val();
				var category = $("select[name=list_search_category] > option:selected").val();
				if(keyword && (keyword_before!=keyword || category_before!=category)){//새로운 검색내용인 경우
					if(type_name=="news"){
						location.href = url_all + "keyword="+keyword+"&category="+category+"&news_type="+news_type;
					} else if(type_name=="gallery"){
						location.href = url_all + "keyword="+keyword+"&category="+category+"&gallery_type="+gallery_type;
					} else if(type_name=="market"){
						location.href = url_all + "keyword="+keyword+"&category="+category+"&selling_type="+selling_type;
					} else if(type_name=="event") {
						location.href = url_all + "keyword="+keyword+"&category="+category+"&status="+status;
					}
				} else if(!keyword){//키워드가 없을 때
					alert("검색어를 입력해주세요");
				}
			});
			$("input[name=\"list_search_word\"]").keyup(function(){//엔터키를 쳤을때
				if(event.keyCode==13){
					$("#list_search_word_button").click();
				}
			});
			if(keyword_before != "thereisnokeyword"){
				document.getElementById("list_search_word").select();
			}
			if(keyword != "thereisnokeyword"){//검색어가 있을때 취소 버튼을 보이게 함
				$("#list_search_word_cancel").css("display", "inline");
				$("#list_search_word_cancel").click(function(){
					if(type_name=="news"){location.href = url_all + "news_type="+news_type;}
					else if(type_name=="gallery"){location.href = url_all + "gallery_type="+gallery_type;}
					else if(type_name=="market"){location.href = url_all + "selling_type="+selling_type;}
					else {location.href = url_all;}
				});
			}
			$("#list_search_tip").click(function(){
				window.open("list_search_tip.php?type="+type_name, "list_search_tip", "width=770,height=600,resizable=yes,scrollbars=yes,location=no");
			});
	';
?>