<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
	<link type="text/css" rel="stylesheet" href="../css/idmaru.css" />
	<![if !IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_nie.css" /><![endif]>
	<!--[if IE]><link type="text/css" rel="stylesheet" href="../css/idmaru_ie.css" /><![endif]-->
<?php include 'idmaru_mobile_css.php';?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="../plugin/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="../plugin/jquery.form.js"></script>
	<script type="text/javascript" src="../js/idmaru.js"></script>
<?php
	include 'declare.php';
	$type=$_REQUEST["type"];
?>
	<script>
		$(document).ready(function () {
		});
	</script>
</head>
<body class="popup_body">
	<div class="popup_top"><div class="popup_margin"><img src="../image/list_pineB.png" style="position:relative; top:1px;"/> 검색 Tip</div></div>
	<span class="red font9 basicmargin normal"> * 검색 방법은 게시판별로 다릅니다.</span>
	<div id="bodyarea_write">
		
<?php
	if($type=="news"){
		echo '
			<div class="description">※ 뉴스 검색시 띄어쓰기를 기준으로 하는 어절 전체 혹은 어절의 앞 세글자부터 검색이 가능합니다.</div><div class="desc_cont"><div><span class="desc_title">(본문내용)</span> 이드마루에 오신 여러분을 환영합니다.</div><div class="desc_keyword"><span class="desc_title">▶ 검색 가능한 단어 => </span>이드마, 이드마루, 이드마루에, 오신, 여러분, 여러분을, 환영합, 환영합니, 환영합니다</div><div class="desc_keyword"><span class="desc_title">▶ 검색 불가능한 단어 => </span>이, 이드, 드마, 드마루, 드마루에, 마루, 마루에, 여러, 러분, 러분을, 환영, 합니다, 영합니다, ...</div></div>
			<div class="description">※ 뉴스 검색시 댓글에 씌어진 내용은 검색되지 않습니다.</div>
		';
		// <div class="description">※ 뉴스 검색시 댓글에 씌어진 내용도 검색 가능합니다. 단, 댓글은 띄어쓰기를 기준으로 하는 어절 단위로만 검색 가능합니다.</div><div class="desc_cont"><div><span class="desc_title">(댓글내용)</span> 이드마루에 오신 여러분을 환영합니다.</div><div class="desc_keyword"><span class="desc_title">▶ 검색 가능한 단어 => </span>이드마루에, 오신, 여러분을, 환영합니다</div><div class="desc_keyword"><span class="desc_title">▶ 검색 불가능한 단어 => </span>이, 이드, 이드마, 이드마루, 이드마루에, 드마, 드마루, 드마루에, 마루, 오, 여러, 여러분, 러분을, 환영, 환영합니, 영합니다, ...</div></div>
	} else if($type=="gallery" || $type=="photo"){
		echo '
			<div class="description">※ 사진 검색시 띄어쓰기를 기준으로 하는 어절 단위로만 검색 가능합니다.</div><div class="desc_cont"><div><span class="desc_title">(본문내용)</span> 이드마루에 오신 여러분을 환영합니다.</div><div class="desc_keyword"><span class="desc_title">▶ 검색 가능한 단어 => </span>이드마루에, 오신, 여러분을, 환영합니다</div><div class="desc_keyword"><span class="desc_title">▶ 검색 불가능한 단어 => </span>이, 이드, 이드마, 이드마루, 드마, 드마루, 드마루에, 마루, 오, 여러, 여러분, 러분을, 환영, 환영합니, 영합니다, ...</div></div>
			<div class="description">※ 사진 검색시 댓글에 씌어진 내용은 검색되지 않습니다.</div>
		';
	} else if($type=="sale"){
		echo '
			<div class="description">※ 물건 검색시 띄어쓰기를 기준으로 하는 어절 전체 혹은 어절의 앞 두글자부터 검색이 가능합니다.</div><div class="desc_cont"><div><span class="desc_title">(본문내용)</span> 이드마루에 오신 여러분을 환영합니다.</div><div class="desc_keyword"><span class="desc_title">▶ 검색 가능한 단어 => </span>이드, 이드마, 이드마루, 이드마루에, 오신, 여러, 여러분, 여러분을, 환영, 환영합, 환영합니, 환영합니다</div><div class="desc_keyword"><span class="desc_title">▶ 검색 불가능한 단어 => </span>이, 드마, 드마루, 드마루에, 마루, 마루에, 오, 러분, 러분을, 환, 영합니, 영합니다, 합니, 합니다 ...</div></div>
			<div class="description">※ 물건 검색시 댓글에 씌어진 내용은 검색되지 않습니다.</div>
		';
	} else if($type=="event" || $type=="club_event"){
		echo '
			<div class="description">※ 이벤트 검색시 띄어쓰기를 기준으로 하는 어절 단위로만 검색 가능합니다.</div><div class="desc_cont"><div><span class="desc_title">(본문내용)</span> 이드마루에 오신 여러분을 환영합니다.</div><div class="desc_keyword"><span class="desc_title">▶ 검색 가능한 단어 => </span>이드마루에, 오신, 여러분을, 환영합니다</div><div class="desc_keyword"><span class="desc_title">▶ 검색 불가능한 단어 => </span>이, 이드, 이드마, 이드마루, 드마, 드마루, 드마루에, 마루, 오, 여러, 여러분, 러분을, 환영, 환영합니, 영합니다, ...</div></div>
			<div class="description">※ 이벤트 검색시 댓글에 씌어진 내용은 검색되지 않습니다.</div>
		';
	} else if($type=="guest_private"){
		echo '
			<div class="description">※ 방명록 검색시 띄어쓰기를 기준으로 하는 어절 단위로만 검색 가능합니다.</div><div class="desc_cont"><div><span class="desc_title">(본문내용)</span> 이드마루에 오신 여러분을 환영합니다.</div><div class="desc_keyword"><span class="desc_title">▶ 검색 가능한 단어 => </span>이드마루에, 오신, 여러분을, 환영합니다</div><div class="desc_keyword"><span class="desc_title">▶ 검색 불가능한 단어 => </span>이, 이드, 이드마, 이드마루, 드마, 드마루, 드마루에, 마루, 오, 여러, 여러분, 러분을, 환영, 환영합니, 영합니다, ...</div></div>
		';
	} else if($type=="group"){
		echo '
			<div class="description">※ 모임 검색시 띄어쓰기를 기준으로 하는 어절 단위로만 검색 가능합니다.</div><div class="desc_cont"><div><span class="desc_title">(본문내용)</span> 이드마루에 오신 여러분을 환영합니다.</div><div class="desc_keyword"><span class="desc_title">▶ 검색 가능한 단어 => </span>이드마루에, 오신, 여러분을, 환영합니다</div><div class="desc_keyword"><span class="desc_title">▶ 검색 불가능한 단어 => </span>이, 이드, 이드마, 이드마루, 드마, 드마루, 드마루에, 마루, 오, 여러, 여러분, 러분을, 환영, 환영합니, 영합니다, ...</div></div>
			<div class="description">※ 모임 검색시 댓글에 씌어진 내용은 검색되지 않습니다.</div>
		';
	} else if($type=="about_question"){
		echo '
			<div class="description">※ 문의하기 검색시 띄어쓰기를 기준으로 하는 어절 단위로만 검색 가능합니다.</div><div class="desc_cont"><div><span class="desc_title">(본문내용)</span> 이드마루에 오신 여러분을 환영합니다.</div><div class="desc_keyword"><span class="desc_title">▶ 검색 가능한 단어 => </span>이드마루에, 오신, 여러분을, 환영합니다</div><div class="desc_keyword"><span class="desc_title">▶ 검색 불가능한 단어 => </span>이, 이드, 이드마, 이드마루, 드마, 드마루, 드마루에, 마루, 오, 여러, 여러분, 러분을, 환영, 환영합니, 영합니다, ...</div></div>
			<div class="description">※ 문의하기 검색시 댓글에 씌어진 내용은 검색되지 않습니다.</div>
		';
		//<div class="description">※ 문의하기 검색시 댓글에 씌어진 내용도 검색 가능합니다. 댓글 검색도 띄어쓰기를 기준으로 하는 어절 단위로만 검색 가능합니다.</div><div class="desc_cont"><div><span class="desc_title">(댓글내용)</span> 이드마루에 오신 여러분을 환영합니다.</div><div class="desc_keyword"><span class="desc_title">▶ 검색 가능한 단어 => </span>이드마루에, 오신, 여러분을, 환영합니다</div><div class="desc_keyword"><span class="desc_title">▶ 검색 불가능한 단어 => </span>이, 이드, 이드마, 이드마루, 이드마루에, 드마, 드마루, 드마루에, 마루, 오, 여러, 여러분, 러분을, 환영, 환영합니, 영합니다, ...</div></div>
	} else if($type=="writing"){
		echo '
			<div class="description">※ 글쓰기 검색시 띄어쓰기를 기준으로 하는 어절 전체 혹은 어절의 앞 세글자부터 검색이 가능합니다.</div><div class="desc_cont"><div><span class="desc_title">(본문내용)</span> 이드마루에 오신 여러분을 환영합니다.</div><div class="desc_keyword"><span class="desc_title">▶ 검색 가능한 단어 => </span>이드마, 이드마루, 이드마루에, 오신, 여러분, 여러분을, 환영합, 환영합니, 환영합니다</div><div class="desc_keyword"><span class="desc_title">▶ 검색 불가능한 단어 => </span>이, 이드, 드마, 드마루, 드마루에, 마루, 마루에, 여러, 러분, 러분을, 환영, 합니다, 영합니다, ...</div></div>
			<div class="description">※ 글쓰기 검색시 댓글에 씌어진 내용은 검색되지 않습니다.</div>
		';
	} else if($type=="club_group_writing"){
		echo '
			<div class="description">※ 모임의 글쓰기 검색시 띄어쓰기를 기준으로 하는 어절 단위로만 검색 가능합니다.</div><div class="desc_cont"><div><span class="desc_title">(본문내용)</span> 이드마루에 오신 여러분을 환영합니다.</div><div class="desc_keyword"><span class="desc_title">▶ 검색 가능한 단어 => </span>이드마루에, 오신, 여러분을, 환영합니다</div><div class="desc_keyword"><span class="desc_title">▶ 검색 불가능한 단어 => </span>이, 이드, 이드마, 이드마루, 드마, 드마루, 드마루에, 마루, 오, 여러, 여러분, 러분을, 환영, 환영합니, 영합니다, ...</div></div>
			<div class="description">※ 모임의 글쓰기 검색시 댓글에 씌어진 내용은 검색되지 않습니다.</div>
		';
	}
?>
		
	</div>
	<div id="temp_target"></div>
</body>
</html>