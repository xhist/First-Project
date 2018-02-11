<?php

	session_start();
	
	
	if (isset($_GET['logout'])) {
		unset($_SESSION['user']);
		session_unset();
		session_destroy();
		//header("Location: ".$_SERVER['HTTP_REFERER']);
		header("Location: /new1");
		exit;
	}
?>