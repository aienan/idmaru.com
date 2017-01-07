<?php include 'header.php';?>
<!DOCTYPE HTML>
<html>
<head>
	<?php include 'meta_tag.php';?>
	<meta name="Keywords" content="" />
	<meta name="Description" content="모두가 함께 만들어가는 생각" />
	<title>idMaru-이상형 월드컵</title>
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
	$url = "photo_battle.php?";
	$ad_fixbar_cond = "photo_battle";
	$ad_pop_cond = "photo_battle";
	$ad_side_cond = "photo_battle";
	include 'declare.php';
	include 'personal.php';
	$battle_round_total = 8; // 16장의 사진 대결
	$type = $_REQUEST["type"];
	$sql1 = "SELECT COUNT(*) AS count_all FROM photo_battle_type WHERE photo_type='$type'";//해당 type의 사진갯수 체크
	$sql_query1 = mysqli_query($conn, $sql1);
	$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
	$count_all = $sql_fetch_array1["count_all"];
	if($count_all >= 16){$battle_round_total = 16;}
	else if($count_all >= 8){$battle_round_total = 8;}
	else if($count_all >= 4){$battle_round_total = 4;}
	else {$battle_round_total = 2;}
	if($count_all < $battle_round_total){
		echo '<script>alert("경기 가능 최소 사진수는 '.$battle_round_total.'장 입니다"); location.href="photo_battle.php";</script>';
	} else {
		$count_arr_temp = array();
		for($i=0; $i < $battle_round_total; $i++){// 사진 갯수만큼 번호 배열을 만든다
			$count = rand(0, $count_all - 1);
			do{
				$in_array = 0;
				for($j=0; $j < count($count_arr_temp); $j++){
					if($count_arr_temp[$j]==$count){$count = rand(0, $count_all - 1); $in_array = 1; break;}
				}
			} while($in_array==1);
			$count_arr_temp[] = $count;
		}
		$sql2 = "SELECT count FROM photo_battle_type WHERE photo_type='$type'";
		$sql_query2 = mysqli_query($conn, $sql2);
		echo '<script>var total_array = new Array(); var count_arr_prev = new Array(); var count_arr_next = new Array();';
		for($j=0; $j < $battle_round_total; $j++){
			mysqli_data_seek($sql_query2, $count_arr_temp[$j]);
			$row = mysqli_fetch_row($sql_query2);
			echo 'count_arr_prev['.$j.'] = '.$row[0].';';//16개의 대결 사진 번호 배열을 만든다
		}
		echo 'total_array[0] = count_arr_prev;</script>';
	}
?>
	<script>
		var url = "<?php echo $url;?>";
		var table_name = "photo_battle";
		var type = "<?php echo $type;?>";
		var battle_round_total = <?php echo $battle_round_total;?>;
		$(document).ready(function () {
			blueStyle();
			menuPhotoBattle();
			$("#photo_battle_type").html(type);
			var battle_round_step = 1; // 첫 라운드 설정 (1=16강, 2=8강, 3=4강, 4=결승)
			var battle_round_count = 1; // 해당 라운드에서 몇번째 대결인지 설정
			var count1_num = battle_round_count * 2 - 2;
			var count2_num = battle_round_count * 2 - 1;
			var count1 = count_arr_prev[count1_num];
			var count2 = count_arr_prev[count2_num];
			$("#photo_battle_round").html('<img src="../image/battle_'+battle_round_total+'round.png"/>');
			$("#battle_start").click(function(){
				$.ajax({//맨 처음 라운드를 보여준다
					url:'photo_battle_ing_recall.php',
					data: {type:type, battle_round_total:battle_round_total, battle_round_step:battle_round_step, battle_round_count:battle_round_count, count1:count1, count2:count2},
					success: function(getdata){
						$("#battle_start_box").hide();
						$("#photo_battle_area").append(getdata);
						$("#photo_battle_round").show("bounce", {}, 800, function(){setTimeout(function(){$("#photo_battle_round").fadeOut();}, 600 );} );
					}
				});
			});
			$("#ing_again").click(function(){location.reload();});
			$("#ing_stop").click(function(){location.href="photo_battle.php";});
		});
		function next_round(count_win, count_lose, battle_round_step_next, battle_round_count_next){//결과처리후 다음 라운드로 넘어간다
			$("#photo_battle_container").css("display", "none");
			$("#photo_battle_stage").after('<div id="loading_more" class="loading48x48" style="left:340px;"></div>');
			var battle_round_total = <?php echo $battle_round_total;?>;
			$.ajax({//선택 결과를 DB 점수에 반영한다
				url:'photo_battle_next_round.php',
				data: {type:type, count_win:count_win, count_lose:count_lose},
				success: function(getdata){
				}
			});
			count_arr_next[count_arr_next.length] = count_win;
			battle_round_count_next = battle_round_count_next + 1; // 다음 대결로 넘어간다 (1대결->2대결)
			var battle_round_count_total = battle_round_total / Math.pow(2, battle_round_step_next); // 현재 라운드에 있는 총 대결수 (16강이면 8대결)
			var go_next_round = 0; // 다음 라운드로 넘어가는지를 나타냄
			if( battle_round_count_total >= battle_round_count_next){//아직 다음 스텝으로 넘어가지 않아도 될 때
			} else {//다음 스텝으로 넘어갈 때
				go_next_round = 1;
				count_arr_prev = count_arr_next;
				total_array[total_array.length] = count_arr_prev;
				count_arr_next = new Array();
				battle_round_step_next = battle_round_step_next + 1;
				battle_round_count_next = 1;
				$("#photo_battle_round").html('<img src="../image/battle_'+battle_round_count_total+'round.png"/>'); // 라운드 사진을 다음걸로 바꿔준다
			}
			if(count_arr_prev.length > 1){ // 맨 마지막 선택이 아닐 경우
				var count1_num = battle_round_count_next * 2 - 2;
				var count2_num = battle_round_count_next * 2 - 1;
				var count1 = count_arr_prev[count1_num];
				var count2 = count_arr_prev[count2_num];
				$.ajax({ // 다음 라운드로 넘어간다
					url:'photo_battle_ing_recall.php',
					data: {type:type, battle_round_total:battle_round_total, battle_round_step:battle_round_step_next, battle_round_count:battle_round_count_next, count1:count1, count2:count2},
					success: function(getdata){
						$("#photo_battle_area").html(getdata);
						if(go_next_round==1){ // 다음 라운드로 넘어갈 때
							$("#photo_battle_round").show("bounce", {}, 800, function(){setTimeout(function(){$("#photo_battle_round").fadeOut();}, 600 );} );
						}
					}
				});
			}else {//맨 마지막 선택이었을 경우, 결과창을 보여준다
				$.ajax({//다음 라운드로 넘어간다
					url:'photo_battle_result.php',
					data: {total_array:total_array, type:type},
					success: function(getdata){
						$("#photo_battle_area").html(getdata);
					}
				});
			}
		}
		function random_select(count1, count2, battle_round_step_next, battle_round_count_next){//결과처리후 다음 라운드로 넘어간다
			var left_or_right = Math.floor( ( Math.random() * 10 ) % 2 );
			if(left_or_right==0){next_round(count1, count2, battle_round_step_next, battle_round_count_next);}
			else if(left_or_right==1){next_round(count2, count1, battle_round_step_next, battle_round_count_next);}
		}
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
				<div id="photo_battle_alarm" class="font9 bold c_FF8383">※ 결과창이 나올때까지 게임을 진행해주세요. ^^</div>
				<div class="relative" style="margin:10px 0 0 0;">
					<img id="ing_again" class="pointer" src="../image/photo_battle_again.png" style="margin:0 0 0 10px;" title="다시하기"/>
					<img id="ing_stop" class="pointer" src="../image/photo_battle_stop.png" style="margin:0 0 0 10px;" title="그만하기"/>
				</div>
				<div id="photo_battle_type" class="relative bold center c_0776CD font12" style="margin:0px 0 0 0;"></div>
				<div class="relative"><div id="photo_battle_round" class="absolute zindex2" style="left:183px; top:50px; display:none;"></div></div>
				<div id="battle_start_box" class="relative" style="height:320px;">
					<img id="battle_start" src="../image/battle_start.png" class="absolute pointer" style="left:275px; top:50px;" title="대결 시작"/>
				</div>
				<div id="photo_battle_area" class="relative"></div>
				<div class="font8 bold" style="margin:40px 0 0 0; color:#FF8383;">* 새로고침을 누르면 선택하신 정보가 지워지므로 주의바랍니다.</div>
				<div style="margin:30px 0 0 0;"><?php include 'ad_textA.php';?></div>
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