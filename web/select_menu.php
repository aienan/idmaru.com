<?php
	$idmaru_user_num = 1;
	$select_category_writing = '
		<nav class="select_category">
			<div id="news_type_all" class="select_category_item" onclick="writingTypeSelect(\'all\')">전체</div>
			<div id="news_type_humor" class="select_category_item" onclick="writingTypeSelect(\'humor\')">유머</div>
			<div id="news_type_music" class="select_category_item" onclick="writingTypeSelect(\'music\')">음악</div>
			<div id="news_type_sport" class="select_category_item" onclick="writingTypeSelect(\'sport\')">스포츠</div>
			<div id="news_type_stock" class="select_category_item" onclick="writingTypeSelect(\'stock\')">주식</div>
			<div id="news_type_computer" class="select_category_item" onclick="writingTypeSelect(\'computer\')">컴퓨터</div>
			<div id="news_type_info" class="select_category_item" onclick="writingTypeSelect(\'info\')">정보</div>
			<div id="news_type_debate" class="select_category_item" onclick="writingTypeSelect(\'debate\')">토론</div>
			<div id="news_type_etc" class="select_category_item" onclick="writingTypeSelect(\'etc\')">일상</div>
		</nav>
	';
	$select_category_writing_mod = '
		<option selected value="">선택</option><option value="0">일상</option><option value="1">유머</option><option value="4">음악</option><option value="5">스포츠</option><option value="6">주식</option><option value="7">컴퓨터</option><option value="2">정보</option><option value="3">토론</option>
	';
	$select_category_gallery = '
		<nav class="select_category">
			<div id="gallery_type_all" class="select_category_item" onclick="photoTypeSelect(\'all\')">전체</div>
			<div id="gallery_type_common" class="select_category_item" onclick="photoTypeSelect(\'common\')">일반</div>
			<div id="gallery_type_celeb" class="select_category_item" onclick="photoTypeSelect(\'celeb\')">연예인</div>
			<div id="gallery_type_stylish" class="select_category_item" onclick="photoTypeSelect(\'stylish\')">얼짱</div>
			<div id="gallery_type_humor" class="select_category_item" onclick="photoTypeSelect(\'humor\')">유머</div>
			<div id="gallery_type_unusual" class="select_category_item" onclick="photoTypeSelect(\'unusual\')">엽기</div>
			<div id="gallery_type_fashion" class="select_category_item" onclick="photoTypeSelect(\'fashion\')">패션</div>
			<div id="gallery_type_nature" class="select_category_item" onclick="photoTypeSelect(\'nature\')">자연</div>
			<div id="gallery_type_animal" class="select_category_item" onclick="photoTypeSelect(\'animal\')">동물</div>
			<div id="gallery_type_thing" class="select_category_item" onclick="photoTypeSelect(\'thing\')">물건</div>
		</nav>
	';
	$select_gallery_type_write = '
		<h6>사진분류 : <select id="gallery_type" name="gallery_type"><option selected value="">선택</option><option value="0">일반</option><option value="1">연예인</option><option value="7">얼짱</option><option value="2">유머</option><option value="3">엽기</option><option value="8">패션</option><option value="4">자연</option><option value="5">동물</option><option value="6">물건</option></select></h6>
	';
	$select_option_year_event_start = '
		<option selected value="0">선택</option><option value="2012"> 2012 </option><option value="2013"> 2013 </option><option value="2014"> 2014 </option>
	';
	$select_option_year_event_end = '
		<option selected value="9999">선택</option><option value="2013"> 2013 </option><option value="2014"> 2014 </option><option value="2015"> 2015 </option>
	';
	$select_option_year = '
		<option selected value="">선택</option><option value="2013"> 2013 </option><option value="2012"> 2012 </option><option value="2011"> 2011 </option><option value="2010"> 2010 </option><option value="2009"> 2009 </option><option value="2008"> 2008 </option><option value="2007"> 2007 </option><option value="2006"> 2006 </option><option value="2005"> 2005 </option><option value="2004"> 2004 </option><option value="2003"> 2003 </option><option value="2002"> 2002 </option><option value="2001"> 2001 </option><option value="2000"> 2000 </option><option value="1999"> 1999 </option><option value="1998"> 1998 </option><option value="1997"> 1997 </option><option value="1996"> 1996 </option><option value="1995"> 1995 </option><option value="1994"> 1994 </option><option value="1993"> 1993 </option><option value="1992"> 1992 </option><option value="1991"> 1991 </option><option value="1990"> 1990 </option><option value="1989"> 1989 </option><option value="1988"> 1988 </option><option value="1987"> 1987 </option><option value="1986"> 1986 </option><option value="1985"> 1985 </option><option value="1984"> 1984 </option><option value="1983"> 1983 </option><option value="1982"> 1982 </option><option value="1981"> 1981 </option><option value="1980"> 1980 </option><option value="1979"> 1979 </option><option value="1978"> 1978 </option><option value="1977"> 1977 </option><option value="1976"> 1976 </option><option value="1975"> 1975 </option><option value="1974"> 1974 </option><option value="1973"> 1973 </option><option value="1972"> 1972 </option><option value="1971"> 1971 </option><option value="1970"> 1970 </option><option value="1969"> 1969 </option><option value="1968"> 1968 </option><option value="1967"> 1967 </option><option value="1966"> 1966 </option><option value="1965"> 1965 </option><option value="1964"> 1964 </option><option value="1963"> 1963 </option><option value="1962"> 1962 </option><option value="1961"> 1961 </option><option value="1960"> 1960 </option><option value="1959"> 1959 </option><option value="1958"> 1958 </option><option value="1957"> 1957 </option><option value="1956"> 1956 </option><option value="1955"> 1955 </option><option value="1954"> 1954 </option><option value="1953"> 1953 </option><option value="1952"> 1952 </option><option value="1951"> 1951 </option><option value="1950"> 1950 </option><option value="1949"> 1949 </option><option value="1948"> 1948 </option><option value="1947"> 1947 </option><option value="1946"> 1946 </option><option value="1945"> 1945 </option><option value="1944"> 1944 </option><option value="1943"> 1943 </option><option value="1942"> 1942 </option><option value="1941"> 1941 </option><option value="1940"> 1940 </option><option value="1939"> 1939 </option><option value="1938"> 1938 </option><option value="1937"> 1937 </option><option value="1936"> 1936 </option><option value="1935"> 1935 </option><option value="1934"> 1934 </option><option value="1933"> 1933 </option><option value="1932"> 1932 </option><option value="1931"> 1931 </option><option value="1930"> 1930 </option><option value="1929"> 1929 </option><option value="1928"> 1928 </option><option value="1927"> 1927 </option><option value="1926"> 1926 </option><option value="1925"> 1925 </option><option value="1924"> 1924 </option><option value="1923"> 1923 </option><option value="1922"> 1922 </option><option value="1921"> 1921 </option><option value="1920"> 1920 </option><option value="1919"> 1919 </option><option value="1918"> 1918 </option><option value="1917"> 1917 </option><option value="1916"> 1916 </option><option value="1915"> 1915 </option><option value="1914"> 1914 </option><option value="1913"> 1913 </option><option value="1912"> 1912 </option><option value="1911"> 1911 </option><option value="1910"> 1910 </option><option value="1909"> 1909 </option><option value="1908"> 1908 </option><option value="1907"> 1907 </option><option value="1906"> 1906 </option><option value="1905"> 1905 </option><option value="1904"> 1904 </option><option value="1903"> 1903 </option><option value="1902"> 1902 </option><option value="1901"> 1901 </option><option value="1900"> 1900 </option>
	';
	$select_option_month = '
		<option selected value="">선택</option><option value="01"> 1 </option><option value="02"> 2 </option><option value="03"> 3 </option><option value="04"> 4 </option><option value="05"> 5 </option><option value="06"> 6 </option><option value="07"> 7 </option><option value="08"> 8 </option><option value="09"> 9 </option><option value="10"> 10 </option><option value="11"> 11 </option><option value="12"> 12 </option>
	';
	if(isset($table_name) && isset($page_name)){
	$add_photo_block = '
		<div class="relative" style="height:25px;">
			<div id="add_photo_box"><a href="add_photo.php?table_name='.$table_name.'&page_name='.$page_name.'" target="add_photo_iframe"><div id="add_photo" class="button_blue2" onclick="addPhoto()">사진추가</div></a><span id="add_photo_desc" class="absolute font9 bold" style="left:75px; top:3px;"></span></div>
			<div id="add_photo_submit_box" style="display:none;"><div id="add_photo_submit" class="button_blue2" onclick="addPhotoSubmit()">사진등록</div><span class="absolute font9 bold red" style="left:75px; top:3px;">※ "파일 추가"를 눌러서 사진을 추가한 후, 왼쪽의 사진등록 버튼을 눌러주세요.</span></div>
		</div>
		<iframe name="add_photo_iframe" width="705" height="330" style="display:none;"></iframe>
	';
	}
	$select_option_selling_type = '
		<option selected value="">선택</option><option value="">-----------</option><option value="1">게임</option><option value="2">도서</option><option value="3">모바일</option><option value="4">미용</option><option value="5">부동산</option><option value="6">산업용품</option><option value="7">상품권</option><option value="8">생활용품</option><option value="9">스포츠</option><option value="10">여행</option><option value="11">영상기기</option><option value="12">예술</option><option value="13">음악</option><option value="14">의류패션</option><option value="15">차량용품</option><option value="16">카메라</option><option value="17">컴퓨터</option><option value="">-----------</option><option value="18">기타용품</option>
	';
	$email_top = '
<html>
<head>
</head>
<body>
	<div style="width:680px; font-family:돋움, dotum;">
		<a href="http://www.idmaru.com"><div><img src="http://www.idmaru.com/image/page_title_idmaru.png" style="margin:0 0 0 15px;"/></div></a>
		<div style="height:5px; background-color:#377EB6;"></div>
		<div style="padding:20px; min-height:300px; font-size:10pt; color:#666666;">
	';
	$email_bottom = '
		</div>
		<a href="http://www.idmaru.com"><img src="http://www.idmaru.com/image/idmaru_email_bottom.jpg"/></a>
	</div>
	<div id="temp_target"></div>
</body>
</html>
	';
?>