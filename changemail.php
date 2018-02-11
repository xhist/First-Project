<?php 
			include "dbconfig.php";
			session_start();
			$data = array();
			$data["success"] = true;
			$data["query"] = false;
			$data["emailError"] = "";
			$data["email"] = "";
			function test_input($input){
				$input = trim($input);
				$input = strip_tags($input);
				$input = htmlspecialchars($input);
				return $input;
			}
			if((isset($_POST['email'])) && (isset($_SESSION['user']))){
				
				$email = test_input($_POST['email']);
				if( !filter_var($email, FILTER_VALIDATE_EMAIL)){
					$data["success"] = false;
					$data["emailError"] = "Посоченият от вас имейл адрес е невалиден.";
					//header("Location: settings.php#changeemail");
				}
				
				if(empty($email)){
					$data["success"] = false;
					$data["emailError"] = "Необходимо е да добавите вашият нов имейл адрес.";
					//header("Location: settings.php#changeemail");
				}
				$query = "SELECT userEmail FROM users WHERE userEmail='".$email."' and userId <> '".$_SESSION['user']."'";
				$result = mysqli_query($connect, $query);
				$count = mysqli_num_rows($result);
				
				$userresult = mysqli_query($connect, "select * from users where userId='".$_SESSION['user']."'");
				$userfetch = mysqli_fetch_array($userresult);
				$useremail = $userfetch['userEmail'];
				if($count != 0){
					$data["success"] = false;
					$data["emailError"] = "Посоченият от вас имейл адрес вече е зает.";
				}
				
				if($data["success"] == true){		
					$q3 = mysqli_query($connect, "update users set userEmail='$email' where userId = '".$_SESSION['user']."'");
						if($q3){
							$data["query"] = true;
							$data["email"] = $email;
							}
				}
				
			}
			else {
				die("<h1>Нямате директен достъп до тази страница.</h1>");
			}
			echo json_encode($data);
?>