<?php
	session_start();
	include_once "dbconfig.php";
	$data = array();
	$data["success"] = true;
	$data["query"] = false;
	$data["passwordError"] = "";
	$data["newpasswordError"] = "";
	$data["confirmpasswordError"] = "";
	function test_input($input){
		$input = trim($input);
		$input = strip_tags($input);
		$input = htmlspecialchars($input);
		return $input;
	}
	if((isset($_POST['password'])) && (isset($_POST['newpassword'])) && (isset($_POST['confirmpassword']))){
				$password = test_input($_POST['password']);
				
				$newpassword = test_input($_POST['newpassword']);

				$confirmnewpassword = test_input($_POST['confirmpassword']);
				
				$query = mysqli_query($connect, "select userPass from users where userId='".$_SESSION['user']."'");
				$row = mysqli_fetch_array($query);
				$rowpass = $row['userPass'];
					
					
					if(strlen($password) > 0)/*(strlen($password) > 0 && $password != $rowpass)*/{
					$password = hash('sha256', $password);
						if($password != $rowpass){
							$data["success"] = false;
							$data["passwordError"]= "Това не е вашата настояща парола.";
						}	
					}
					else if(empty($password)){
					$data["success"] = false;
					$data["passwordError"] = "Моля напишете вашата настояща парола.";
					}
					if(empty($newpassword)){
					$data["success"] = false;
					$data["newpasswordError"] = "Моля напишете вашата нова парола.";
					}
					else if(strlen($newpassword) > 0 && strlen($newpassword) < 6){
					$data["success"] = false;
					$data["newpasswordError"] = "Вашата нова парола трябва да се състои от поне 6 символа.";
					}
					if(empty($confirmnewpassword)){
					$data["success"] = false;
					$data["confirmpasswordError"] = "Моля потвърдете вашата нова парола.";
					}
					else if(strlen($confirmnewpassword) > 0 && $confirmnewpassword != $newpassword){
					$data["success"] = false;
					$data["confirmpasswordError"] = "Паролите не съвпадат. Опитайте пак.";
					}
					if($data["success"] == true){
					$newpassword = hash('sha256', $newpassword);
					$q = mysqli_query($connect, "update users set userPass = '$newpassword' where userId='".$_SESSION['user']."'");
						if($q){
							$data["query"] = true;
						}
						
					}
	}
	else {
		die("<h1>Нямате директен достъп до тази страница.</h1>");
	}
	echo json_encode($data);
?>