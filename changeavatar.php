<?php 		 
			include "dbconfig.php";
			session_start();
			$data = array();
			$data["success"] = true;
			$data["imageError"] = "";
			$data["image"] = "";
			$data["query"] = false;
			$image = "";
			if(isset($_FILES['image']) && isset($_SESSION['user'])){
				
				function getMimeType($file){
					if($file){
						$finfo = finfo_open();
						$fileinfo = finfo_file($finfo, $file, FILEINFO_MIME_TYPE);
						finfo_close($finfo);
						return $fileinfo;
					}
				}
				
				$filename = $_FILES['image']['name'];
				$file_tmp = $_FILES['image']['tmp_name'];
				$file_size = $_FILES['image']['size'];
				$file_type = getMimeType($file_tmp);
				$validextensions = array("jpeg", "jpg", "gif", "png");
				$fileext = explode('.', $filename);
				$extension = end($fileext);
				//$file = "/new1/uploads/".$filename;
				if(!$filename){
					$data["success"] = false;
					$data["imageError"] = "Няма избран файл. Моля избере файл от горе.";
				}
				else {
					if($file_size > 5242880){
						$data["success"] = false;
						$data["imageError"] = "Размерът на снимката не трябва да надвишава 5 MB.";
					}
					else if((($file_type != 'image/jpeg') || ($file_type != 'image/jpg') || ($file_type != 'image/gif') || ($file_type != 'image/png')) && !in_array($extension, $validextensions)){
						$data["success"] = false;
						$data["imageError"] = "Това файлово разширение не е позволено.";
					}
				}
				//$r1 = mt_rand(10000, 70000);
				$newfilename = uniqid('', true).".".$extension;
				if( $data["success"] == true ){
					//delete current file from folder
					$current_user = mysqli_query($connect, "select * from users where userId = '".$_SESSION['user']."'");
					while($user_info = mysqli_fetch_array($current_user)){
						$user_avatar = $user_info['photo'];
						unlink("D:/xampp/htdocs/new1/uploads/".$user_avatar);
					}
					//if(file_exists($file)){
						move_uploaded_file($file_tmp, "D:/xampp/htdocs/new1/uploads/".$newfilename);
						$q = mysqli_query($connect, "update users set photo='".$newfilename."' where userId='".$_SESSION['user']."'");
						$image = $newfilename;

					/*} else {
						move_uploaded_file($file_tmp, "D:/xampp/htdocs/new1/uploads/".$filename);
						$q = mysqli_query($connect, "update users set photo='".$file."' where userId='".$_SESSION['user']."'");
						$image = $file;
					}*/
					if($q){
						$data["query"] = true;
						$data["image"] = "/new1/uploads/".$image;
					}	
				}
			
			}
			else{
				die("<h1>Нямате директен достъп до тази страница.</h1>");
			}
			
			echo json_encode($data);
?>