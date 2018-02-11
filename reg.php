<?php 
include "dbconfig.php";
$data = array();
$data["success"] = true;
$data["username"] = "";
$data["firstname"] = "";
$data["lastname"] = "";
$data["email"] = "";
$data["password"] = "";

function test_input($input){
	$input = trim($input);
	$input = strip_tags($input);
	$input = htmlspecialchars($input);
	return $input;
}
if((isset($_POST['name'])) && (isset($_POST['firstname'])) && (isset($_POST['lastname'])) && (isset($_POST['email'])) && (isset($_POST['pass']))){
$name = test_input($_POST['name']);
$firstname = test_input($_POST['firstname']);
$lastname = test_input($_POST['lastname']);
$email = test_input($_POST['email']);
$pass = test_input($_POST['pass']);

		if (empty($name)) {
			$data["success"] = false;
			$data["username"] = "Моля напишете вашето потребителско име.";
		} else if (strlen($name) < 3) {
			$data["success"] = false;
			$data["username"] = "Вашето потребителско име трябва да се състои от поне 3 символа.";
		} /*else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
			$data["success"] = false;
			$data["username"] = "Name must contain alphabets and space.";
		}*/
		else {
			$query = "select userName from users where userName='".$name."'";
			$result = mysqli_query($connect, $query);
			$nameval = mysqli_num_rows($result);
			if($nameval == 1){
				$data["success"] = false;
				$data["username"] = "Това потребителско име вече е заето. Опитайте с ново потребителско име.";
			}
		}
		if(empty($firstname)){ //firstname validation
			$data["success"] = false;
			$data["firstname"] = "Моля напишете вашето име.";
		}
		if(empty($lastname)){ //lastname validation
			$data["success"] = false;
			$data["lastname"] = "Моля напишете вашата парола.";
		}
		//basic email validation
		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$data["success"] = false;
			$data["email"] = "Моля напишете валиден имейл адрес.";
		} else {
			// check email exist or not
			$query = "SELECT userEmail FROM users WHERE userEmail='".$email."'";
			$result = mysqli_query($connect, $query);
			$count = mysqli_num_rows($result);
			if($count!=0){
				$data["success"] = false;
				$data["email"] = "Посоченият имейл адрес вече е зает.";
			}
		}
		// password validation
		if (empty($pass)){
			$data["success"] = false;
			$data["password"] = "Моля напишете вашата парола.";
		} else if(strlen($pass) < 6) {
			$data["success"] = false;
			$data["password"] = "Вашата парола трябва да се състои от поне 6 символа.";
		}
	if($data["success"] == true){
		// password encrypt using SHA256();
		$password = hash('sha256', $pass);
		
		// if there's no error, continue to signup
		$capitalln = ucfirst($lastname);
		$capitalfn = ucfirst($firstname);
		$image = "default.gif";
		$query = "INSERT INTO users(userName,firstname, lastname, userEmail,userPass, photo, level) VALUES('$name', '$capitalfn', '$capitalln', '$email','$password', '$image', '1')";
		$res = mysqli_query($connect, $query);
	}
}
else {
	die("<h1>Нямате директен достъп до тази страница.</h1>");
}
		//echo var_dump($_POST);
		echo json_encode($data);
		
?>