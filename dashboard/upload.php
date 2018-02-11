<?php
	include_once "dbconfig.php";
	
	function test_input($field){
		$field = trim($field);
		$field = strip_tags($field);
		$field = htmlspecialchars($field);
		return $field;
	}
	function getMimeType($file){
		$finfo = finfo_open();
		$fileinfo = finfo_file($finfo, $file, FILEINFO_MIME_TYPE);
		finfo_close($finfo);
		return $fileinfo;
	}
	if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['category']) && isset($_POST['caption']) && isset($_FILES['file'])){
		$current = array();
		$errors = array();
		$capterrors = array();
		$fileerrors = array();
		
		$current["success"] = true;
		$current['titleError'] = "";
		$current['descError'] = "";
		$current["errors"] = "";
		$current["caperrors"] = "";
		$current["fileerrors"] = "";
		
		$message = '';
		$output = '';
		
		
		$title = test_input($_POST['title']);
		$description = test_input($_POST['description']);
		$category = test_input($_POST['category']);
		
		$title = mysqli_real_escape_string($connect, $title);
		$description = mysqli_real_escape_string($connect, $description);
		$category = mysqli_real_escape_string($connect, $category);
		
		
		

		
		$textarray = $_POST['caption'];
		$filenames = $_FILES['file']['name'];
		//$filesizes = $_FILES['file']['size'];
		$filetypes = $_FILES["file"]["type"];
		$file_tmp = $_FILES['file']['tmp_name'];
     
		if($title == ""){
			$current['success'] = false;
			$current['titleError'] = "Моля добави заглавие.";
		}
		else if(strlen($title) < 10){
			$current['success'] = false;
			$current['titleError'] = "Заглавието трябва да се състои от поне 10 символа.";
		}
		
		if($description == ""){
			$current['success'] = false;
			$current['descError'] = "Моля добавете описание/инструкции към случая.";
		}
		else if(strlen($description) < 10){
			$current['success'] = false;
			$current['descError'] = "Описанието/инструкциите към случая трябва да се състои от поне 10 символа.";
		}
	 
		$valid = true;
		$secondvalid = true;
	foreach($filenames as $key=>$value){
		 
		 
		 if(!$value){
			 $valid = false;
			 $fileerrors[$key] = "Няма избран файл."; 
			 $current["success"] = false;
			 $secondvalid = false;
		 }
		 else{
			$fileerrors[$key] = ""; 
		 }
	 }
	foreach($textarray as $key=>$value){
		 $value = test_input($value);
		 $value = mysqli_real_escape_string($connect, $value);
		 
		 if($value == ""){
			 $valid = false;
			 $capterrors[$key] = "Моля добавете име на снимката."; 
			 $current["success"] = false;
			 $secondvalid = false;
		 }
		 else if(strlen($value) < 5){
			 $valid = false;
			 $capterrors[$key] = "Името трябва да се състои от поне 5 символа.";
			 $current["success"] = false;
			 $secondvalid = false;
		 }
		 else{
			$capterrors[$key] = ""; 
		 }
	 }
	
	 $valid_types = array("image/jpeg", "image/jpg", "image/png", "image/gif");
	 $valid_extensions = array("jpeg", "jpg", "gif", "png");
	for($i = 0; $i<count($filenames); $i++){
		   $filename = $filenames[$i];
		   //$filecaption = $textarray[$i];
		   $filetype = $filetypes[$i];
		   $file_tmpname = $file_tmp[$i];
		   
           $ext = explode(".", $filename);
		   $extension = end($ext);
		   if(!$filename){
			   $secondvalid = false;
		   }
		   if($secondvalid == true){
				if(!in_array($extension, $valid_extensions)){
					$valid = false;
					$errors[] = "{$filename} е с грешно файлово разширение {$extension}.";
					$current["success"] = false;
				}/*else if(!in_array(getMimeType($filename), $valid_types)){
					$valid = false;
					$errors[] = "{$filename} е с грешен файлов тип ".getMimeType($filename);
					$current["success"] = false;
				}*/
		   }    
     }
	 
	 
	if($current['success'] == true){ 
		if($_POST["case_id"] != '')  
				{  
					$query = "UPDATE blog   
					SET header='$title',   
					description='$description',
					cid='$category'
					WHERE id='".$_POST["case_id"]."'";  
					$message = 'Данните са променени.';  
				}  
		else  
				{  
					$query = "INSERT INTO blog(id, header, description, cid)  
					VALUES('', '$title', '$description', '$category')  
					";  
					$message = 'Данните бяха добавени.';  
				}
			$bigquery = mysqli_query($connect, $query);
			
		for($i = 0; $i<count($filenames); $i++){
			//$capterrors = (object)$capterrors;
			//$fileerrors = (object)$fileerrors;
			$filename = $filenames[$i];
			$filecaption = $textarray[$i];
			$filetype = $filetypes[$i];
			$file_tmpname = $file_tmp[$i];
			$ext = explode(".", $filename);
			$extension = end($ext);
			$newfilename = uniqid('', true).".".$extension;
			move_uploaded_file($file_tmpname, "D:/xampp/htdocs/new1/uploads/".$newfilename);
			if($_POST['case_id'] != ''){
				$caseid = test_input($_POST['case_id']);
				$caseid = mysqli_real_escape_string($connect, $caseid);
				$file_query = mysqli_query($connect, "insert into images(id, file_name, file_title, post_id) values('', '$newfilename', '$filecaption', '$caseid')");
			}
			else{
				$select = mysqli_query($connect, "select * from blog order by id desc limit 1");
				$row = mysqli_fetch_array($select);
				$id = $row['id'];
				$file_query = mysqli_query($connect, "insert into images(id, file_name, file_title, post_id) values('', '$newfilename', '$filecaption', '$id')");
			}
		}
		if($file_query)  
			{  
				$output .= '<label class="text-success">' . $message . '</label>';  
				$select_query = "select * from blog order by id desc";  
				$result = mysqli_query($connect, $select_query);//or die("Error: ". mysqli_error($connect));  
				$output .= '  
                <table class="table table-bordered">  
                     <tr>  
                          <th width="55%">Заглавие</th>  
                          <th width="15%">Редактиране</th>  
                          <th width="15%">Разглеждане</th>
						  <th width="15%">Изтриване</th>
                     </tr>  
				';  
				while($row = mysqli_fetch_array($result))  
				{  
                $output .= '  
                     <tr>  
                          <td>'.$row["header"].'</td>  
                                    <td><button name="edit" id="'.$row["id"].'" class="btn btn-warning btn-sm edit_data"><span class="glyphicon glyphicon-edit"></span>&nbsp;Редактирай</button></td>  
                                    <td><button name="view" id="'.$row["id"].'" class="btn btn-info btn-sm view_data"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Разгледай</button></td>
									<td><button name="delete" id="'.$row["id"].'" class="btn btn-danger btn-sm delete_data"><span class="glyphicon glyphicon-trash"></span>&nbsp;Изтрий</button></td>  
                     </tr>  
                ';  
				}  
				$output .= '</table>';
			}
		
    }
	$current['output'] = $output; 
	$capterrors = (object)$capterrors;
	$fileerrors = (object)$fileerrors;
	$current["caperrors"] = $capterrors;
	$current["fileerrors"] = $fileerrors;
	$current["errors"] = $errors;
	//$timeend = microtime(true);
	//$current["time"] = $timeend - $timestart." sec";
    echo json_encode($current);
	}
	
	else if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['category'])){
		$current = array();
		$current['success'] = true;
		$current['titleError'] = "";
		$current['descError'] = "";
		$message = '';
		$output = '';
		
		
		$title = test_input($_POST['title']);
		$description = test_input($_POST['description']);
		$category = test_input($_POST['category']);
		
		$title = mysqli_real_escape_string($connect, $title);
		$description = mysqli_real_escape_string($connect, $description);
		$category = mysqli_real_escape_string($connect, $category);
		
		if($title == ""){
			$current['success'] = false;
			$current['titleError'] = "Моля добави заглавие.";
		}
		else if(strlen($title) < 10){
			$current['success'] = false;
			$current['titleError'] = "Заглавието трябва да се състои от поне 10 символа.";
		}
		
		if($description == ""){
			$current['success'] = false;
			$current['descError'] = "Моля добавете описание/инструкции към случая.";
		}
		else if(strlen($description) < 10){
			$current['success'] = false;
			$current['descError'] = "Описанието/инструкциите към случая трябва да се състои от поне 10 символа.";
		}
		
		if($current['success'] == true){
			if($_POST["case_id"] != '')  
				{  
					$query = "UPDATE blog   
					SET header='$title',   
					description='$description',
					cid='$category'
					WHERE id='".$_POST["case_id"]."'";  
					$message = 'Данните са променени.';  
				}  
			else  
				{  
					$query = "INSERT INTO blog(id, header, description, cid)  
					VALUES('', '$title', '$description', '$category')  
					";  
					$message = 'Данните бяха добавени.';  
				}
			$bigquery = mysqli_query($connect, $query);
			if($bigquery)  
			{  
				$output .= '<label class="text-success">' . $message . '</label>';  
				$select_query = "SELECT * FROM blog ORDER BY id DESC";  
				$result = mysqli_query($connect, $select_query);  
				$output .= '  
                <table class="table table-bordered">  
                     <tr>  
                          <th width="55%">Заглавие</th>  
                          <th width="15%">Редактиране</th>  
                          <th width="15%">Разглеждане</th>
						  <th width="15%">Изтриване</th>
                     </tr>  
				';  
				while($row = mysqli_fetch_array($result))  
				{  
                $output .= '  
                     <tr>  
                          <td>'.$row["header"].'</td>  
                                    <td><button name="edit" id="'.$row["id"].'" class="btn btn-warning btn-sm edit_data"><span class="glyphicon glyphicon-edit"></span>&nbsp;Редактирай</button></td>  
                                    <td><button name="view" id="'.$row["id"].'" class="btn btn-info btn-sm view_data"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Разгледай</button></td>
									<td><button name="delete" id="'.$row["id"].'" class="btn btn-danger btn-sm delete_data"><span class="glyphicon glyphicon-trash"></span>&nbsp;Изтрий</button></td>  
                     </tr>  
                ';  
				}  
				$output .= '</table>';
			}
		}
		$current['output'] = $output;
		echo json_encode($current);
	}
	else {
		die("<h1>You are not allowed to access this page directly.</h1>");
	}
?>