<?php 
	session_start();
	if(isset($_POST['url'])){
		if(!isset($_SESSION['url'])){
			$url = $_POST['url'];
			$_SESSION['url'] = $url;
		}
	}
?>