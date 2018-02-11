<?php 
	session_start();
	include_once "dbconfig.php";
	if(isset($_POST['postid']) && $_POST['postid'] != '' && isset($_SESSION['user'])){
		$pid = strip_tags($_POST['postid']);
		$result = mysqli_query($connect, "insert into favorites(pid, userid) values('$pid', '".$_SESSION['user']."')");
		echo "Успещно добавихте този случай към Вашите любими.";
	}
?>