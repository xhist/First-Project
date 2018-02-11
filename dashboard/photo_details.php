<?php 
	include_once "dbconfig.php";
	
	function test_input($field){
		$field = trim($field);
		$field = strip_tags($field);
		$field = htmlspecialchars($field);
		return $field;
	}
	
	if(isset($_POST['image_id']) && $_POST['image_id'] != ""){
		$image_id = test_input($_POST['image_id']);
		$image_id = mysqli_real_escape_string($connect, $image_id);
		$output = '';
		$query = "select * from images where id = '$image_id'";
		$result = mysqli_query($connect, $query);// or die("Error: ".mysqli_error($connect));
		//$row = mysqli_fetch_array($result);
		while($row = mysqli_fetch_array($result)){
			$output = '<form method="post" autocomplete="off" id="photo_update_form" enctype="multipart/form-data">
			<div class="form-group"><label class="control-label">Файл:</label><img class="img-responsive" src="/new1/uploads/'.$row['file_name'].'" /></div>
			<div class="form-group"><label class="control-label">Избери нов файл:</label><button type="button" class="btn btn-info new_file_button"><span class="glyphicon glyphicon-open"></span>&nbsp;Избери..</button>
			<input class="new_files" name="chosen_file" style="display:none;" type="file" />
			<span class="new_file" style="color:black; word-wrap: break-word; word-break:break-all;"></span></br>
			<span style="color:red;" class="new_fileError"></span></div>
			<div class="form-group"><label class="control-label">Заглавие на снимката:</label><input class="form-control" type="text" placeholder="Име на снимката.." id="new_file_name" value="'.$row['file_title'].'" name="file_name"/>
			<span style="color:red;" class="file_titleError"></span></div>
			<input type="hidden" id="case_id" value="'.$row['post_id'].'" name="case_id" /><input type="hidden" id="image_id" value="'.$row['id'].'" name="image_id"/><button type="submit" class="btn btn-default" id="photo_update"><span class="glyphicon glyphicon-saved"></span>&nbsp;Промени</button>
			</form>';
		}
		
		echo $output;
		//echo json_encode($row);
		//echo $image_id;
	}

?>