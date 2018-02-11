<?php
$data = array();
	if( (isset($_POST['name']) && $_POST['name'] != "") && (isset($_POST['pass']) && $_POST['pass'] != "") ) {	
		session_start();
		include "dbconfig.php";
		// prevent sql injections/ clear user invalid inputs
		$username = trim($_POST['name']);
		$username = strip_tags($username);
		$username = htmlspecialchars($username);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
			
		$password = hash('sha256', $pass); // password hashing using SHA256
		$query = "SELECT * FROM users WHERE userName='".$username."'";
		$result= mysqli_query($connect, $query);
		$row= mysqli_fetch_array($result);
		$count = mysqli_num_rows($result); // if uname/pass correct it returns must be 1 row
		
		if( $count == 1 && $row['userPass']==$password ) {
			$data["success"] = true;
			$_SESSION['user'] = $row['userId'];
		} else {
			$data["success"] = false;
		}	
	}
	else {
		header('HTTP/1.1 403 Forbidden');
		die("<h1>Нямате директен достъп до тази страница.</h1>");
	}
echo json_encode($data);
?>
