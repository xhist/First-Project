<?php 
include_once "dbconfig.php";
session_start();

function test_input($field){
	$field = trim($field);
	$field = strip_tags($field);
	$field = htmlspecialchars($field);
	return $field;
}

function getMimeType($file){
	if($file){
		$finfo = finfo_open();
		$fileinfo = finfo_file($finfo, $file, FILEINFO_MIME_TYPE);
		finfo_close($finfo);
		return $fileinfo;
	}
}

if(isset($_SESSION['user']) && $_SESSION['user'] != '' && isset($_POST['image_id']) && $_POST['image_id'] != '' && isset($_POST['case_id']) && $_POST['case_id'] != '' && isset($_POST['file_name']) && isset($_FILES['chosen_file'])){
	$user_credentials = mysqli_query($connect, "select * from users where userId = '".$_SESSION['user']."'");
	$user_check = mysqli_fetch_array($user_credentials);
	$user_level = $user_check['level'];
	if($user_level == 2){
		$data = array();
		$data['success'] = true;
		$data['chosen_fileError'] = "";
		$data['file_nameError'] = "";
		$data['output'] = "";
		$output = '';
		$image_id = test_input($_POST['image_id']);
		$file_name = test_input($_POST['file_name']);
		$chosen_file_tmp = $_FILES['chosen_file']['tmp_name'];
		$chosen_file = $_FILES['chosen_file']['name'];
		$chosen_file_type = getMimeType($_FILES['chosen_file']['tmp_name']);
		$file_type_validation = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png');
		$file_extension_validation = array('jpg', 'png', 'gif', 'jpeg');
		$file_explode = explode('.', $chosen_file);
		$file_extension = end($file_explode);
		$new_file = uniqid('', true).'.'.$file_extension;
		
		//data check
		if($chosen_file == ""){
			$data['chosen_fileError'] = "Моля, посочете файл, с който искате да обновите текущия.";
			$data['success'] = false;
		}
		else if(!in_array($file_extension, $file_extension_validation)){
			$data['chosen_fileError'] = "Избраният от Вас файл е с грешно разширение.";
			$data['success'] = false;
		}
		else if(!in_array($chosen_file_type, $file_type_validation)){
			$data['chosen_fileError'] = "Грешен тип на файла.";
			$data['success'] = false;
		}
		
		if(empty($file_name)){
			$data['file_nameError'] = "Моля, изберете заглавие на снимката.";
			$data['success'] = false;
		}
		else if(strlen($file_name) < 5){
			$data['file_nameError'] = "Заглавието на снимката трябва да се състои от поне 5 символа.";
			$data['success'] = false;
		}
		
		if($data['success'] == true){
			$current_image = mysqli_query($connect, "select * from images where id='".$image_id."'");
			while($image_info = mysqli_fetch_array($current_image)){
				$image_name = $image_info['file_name'];
				unlink('D:/xampp/htdocs/new1/uploads'.$image_name);
			}
			move_uploaded_file($chosen_file_tmp, 'D:/xampp/htdocs/new1/uploads/'.$new_file);
			$file_to_update = mysqli_query($connect, "update images set file_name = '$new_file', file_title = '$file_name' where id = '".$image_id."'");
			
			$all_files_for_case = mysqli_query($connect, "select * from images where post_id = '".$_POST['case_id']."' order by id desc");
			while($row = mysqli_fetch_array($all_files_for_case)){
				$output .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 image_divs" style="margin-top:20px;">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:10px; padding-top:10px; padding-right:10px;">
				<img class="img-responsive" src="/new1/uploads/'.$row['file_name'].'" style="width:100%;" />
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center" style="margin-top:15px; margin-bottom:15px;"><a rel="popover" data-toggle="popover" title="Детайли за снимката" data-placement="bottom" class="btn btn-primary btn-responsive update_photo" id="'.$row['id'].'" >Промени</a></div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-center" style="margin-top:15px; margin-bottom:15px;"><a class="btn btn-danger btn-responsive delete_photo" id="'.$row['id'].'">Изтрий</a></div>
				</div>
				</div>';
			}
			$data['output'] = $output;
		}
	echo json_encode($data);
	}
}
	
?>