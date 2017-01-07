<?php
	header("Cache-Control: public, must-revalidate");
	header("Cache-Control: max-age=10800"); // 3시간
	header("ETag:20130320f");
	session_start();
	if(isset($_SESSION['user_num'])){ $user_num = $_SESSION['user_num'];}//user_num이 세션에 있을때
	else if(!isset($_SESSION['user_num'])){$_SESSION['user_num']=0; $user_num = 0;}//user_num이 세션에 없을때
	if(isset($_SESSION['user_name'])){ $user_name = $_SESSION['user_name'];}//user_name이 세션에 있을때
	else if(!isset($_SESSION['user_name'])){$_SESSION['user_name']="Guest"; $user_name = "Guest";}//user_name이 세션에 없을때
	spl_autoload_register(function($class_name){include 'class/'.$class_name.'.php';});
?>