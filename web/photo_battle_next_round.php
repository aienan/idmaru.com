<?php
	include 'header.php';
	include 'declare_php.php';
	$type = $_REQUEST["type"];
	$count_win = $_REQUEST["count_win"];
	$count_lose = $_REQUEST["count_lose"];
	$winner_advantage = 10;
	$sql1 = "SELECT * FROM photo_battle_score WHERE photo_type='$type' AND count=$count_win AND user_num=$user_num";//이긴 것 검색
	$sql_query1 = mysqli_query($conn, $sql1);
	$count1 = mysqli_num_rows($sql_query1);
	if($count1){//이긴 것의 예전 기록이 있을경우
		$sql_fetch_array1 = mysqli_fetch_array($sql_query1);
		$score_winner = $sql_fetch_array1["score"];
	}
	$sql2 = "SELECT * FROM photo_battle_score WHERE photo_type='$type' AND count=$count_lose AND user_num=$user_num";//진 것 검색
	$sql_query2 = mysqli_query($conn, $sql2);
	$count2 = mysqli_num_rows($sql_query2);
	if($count2){//진 것의 예전 기록이 있을경우
		$sql_fetch_array2 = mysqli_fetch_array($sql_query2);
		$score_loser = $sql_fetch_array2["score"];
	}
	if(!$count1 && !$count2){//둘 다 점수가 없을경우
		$new_score_winner = 1001;
		$new_score_loser = 999;
		$sql3 = "INSERT INTO photo_battle_score (photo_type, count, user_num, score) VALUES ('$type', $count_win, $user_num, $new_score_winner)";
		mysqli_query($conn, $sql3);
		$sql4 = "INSERT INTO photo_battle_score (photo_type, count, user_num, score) VALUES ('$type', $count_lose, $user_num, $new_score_loser)";
		mysqli_query($conn, $sql4);
	} else if($count1 && !$count2){//이긴 것이 점수가 있고 진 것이 점수가 없을경우
		if($score_winner>=1000){//이긴 것의 점수가 1000 이상일 때
			$new_score_winner = $score_winner+1;
			$new_score_loser = 999;
		} else {//이긴 것의 점수가 1000 미만일 때
			$new_score_winner = $score_winner + (int)((1000 - $score_winner) / $winner_advantage + 1);
			$new_score_loser = 1000 - (int)((1000 - $score_winner) / $winner_advantage + 1);
		}
		$sql3 = "UPDATE photo_battle_score SET score=$new_score_winner WHERE photo_type='$type' AND count=$count_win AND user_num=$user_num";
		mysqli_query($conn, $sql3);
		$sql4 = "INSERT INTO photo_battle_score (photo_type, count, user_num, score) VALUES ('$type', $count_lose, $user_num, $new_score_loser)";
		mysqli_query($conn, $sql4);
	} else if(!$count1 && $count2){// 이긴 것이 점수가 없고 진 것이 점수가 있을경우
		if($score_loser >= 1000){//진 것의 점수가 1000 이상일 때
			$new_score_winner = 1000 + (int)(($score_loser - 1000) / $winner_advantage + 1);
			$new_score_loser = 1000 - (int)(($score_loser - 1000) / $winner_advantage + 1);
		} else {//진 것의 점수가 1000 미만일 때
			$new_score_winner = 1001;
			$new_score_loser = $score_loser - 1;
		}
		$sql3 = "INSERT INTO photo_battle_score (photo_type, count, user_num, score) VALUES ('$type', $count_win, $user_num, $new_score_winner)";
		mysqli_query($conn, $sql3);
		$sql4 = "UPDATE photo_battle_score SET score=$new_score_loser WHERE photo_type='$type' AND count=$count_lose AND user_num=$user_num";
		mysqli_query($conn, $sql4);
	} else {//둘 다 점수가 있을경우
		if($score_winner >= $score_loser){//이긴 것이 점수가 더 클 경우
			$new_score_winner = $score_winner + 1;
			$new_score_loser = $score_loser - 1;
		} else {//이긴 것이 점수가 더 작을 경우
			$new_score_winner = $score_winner + (int)(($score_loser - $score_winner) / $winner_advantage + 1);
			$new_score_loser = $score_loser - (int)(($score_loser - $score_winner) / $winner_advantage + 1);
		}
		$sql3 = "UPDATE photo_battle_score SET score=$new_score_winner WHERE photo_type='$type' AND count=$count_win AND user_num=$user_num";
		mysqli_query($conn, $sql3);
		$sql4 = "UPDATE photo_battle_score SET score=$new_score_loser WHERE photo_type='$type' AND count=$count_lose AND user_num=$user_num";
		mysqli_query($conn, $sql4);
	}
	
?>